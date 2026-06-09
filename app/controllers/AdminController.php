<?php

require_once __DIR__ ."../models/Admin.php";
require_once __DIR__ ."../helpers/Validator.php";
require_once __DIR__ ."../models/Filiere.php";

class AdminController {

    public function loginPage(): void {
        if (isAdminLoggedIn()) { redirect('/admin/dashboard'); }
        $error = flash('login_error');
        require __DIR__ . '/../views/admin/login.php';
    }

    public function loginPost(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('/admin/login'); }
        $email = trim($_POST['email'] ?? '');
        $mdp   = $_POST['password'] ?? '';
        $admin = Admin::authenticate($email, $mdp);

        if ($admin) {
            $_SESSION['admin_id']   = $admin['id'];
            $_SESSION['admin_nom']  = $admin['nom'];
            $_SESSION['admin_role'] = $admin['role'];
            redirect('/admin/dashboard');
        } else {
            flash('login_error', 'Email ou mot de passe incorrect.');
            redirect('/admin/login');
        }
    }

    public function logout(): void {
        session_destroy();
        redirect('/admin/login');
    }

    public function dashboard(): void {
        requireAdmin();
        $total          = Candidat::count();
        $statsFiliere   = Candidat::statsParFiliere();
        $statsStatut    = Candidat::statsParStatut();
        $activity       = Candidat::recentActivity(14);
        $recentCandidats = (Candidat::paginate(1, 5))['data'];
        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function candidats(): void {
        requireAdmin();
        $page     = max(1, (int)($_GET['page'] ?? 1));
        $filters  = [
            'search'  => $_GET['search']  ?? '',
            'statut'  => $_GET['statut']  ?? '',
            'filiere' => $_GET['filiere'] ?? '',
        ];
        $result   = Candidat::paginate($page, ITEMS_PER_PAGE, $filters);
        $filieres = Filiere::findAll();
        require __DIR__ . '/../views/admin/candidats.php';
    }

    public function updateStatut(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('/admin/candidats'); }

        $id     = (int)($_POST['id'] ?? 0);
        $statut = $_POST['statut'] ?? '';
        $valides = ['en_attente','dossier_complet','admis','refuse'];

        if ($id && in_array($statut, $valides)) {
            Candidat::updateStatut($id, $statut);
            $candidat = Candidat::findWithFiliere($id);
            if ($candidat && $statut !== 'en_attente') {
                try { NotificationService::sendStatusUpdate($candidat, $statut); }
                catch (\Throwable $e) { error_log($e->getMessage()); }
            }
            flash('success', 'Statut mis à jour avec succès.');
        }
        redirect('/admin/candidats');
    }

    public function notifications(): void {
        requireAdmin();
        $filieres  = Filiere::findAll();
        $historique = Notification::recentAll(100);
        $success   = flash('notif_success');
        require __DIR__ . '/../views/admin/notifications.php';
    }

    public function sendNotification(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('/admin/notifications'); }

        $sujet   = sanitize($_POST['sujet'] ?? '');
        $message = sanitize($_POST['message'] ?? '');
        $groupe  = $_POST['groupe'] ?? 'tous';

        if (!$sujet || !$message) {
            flash('notif_success', 'Erreur : sujet et message obligatoires.');
            redirect('/admin/notifications');
        }

        $filters = [];
        if ($groupe !== 'tous') {
            if (str_starts_with($groupe, 'statut_')) {
                $filters['statut'] = str_replace('statut_', '', $groupe);
            } elseif (str_starts_with($groupe, 'filiere_')) {
                $filters['id_filiere'] = (int)str_replace('filiere_', '', $groupe);
            }
        }

        $candidats = Candidat::getByFilters($filters);
        $count = NotificationService::sendBulk($candidats, $sujet, $message);
        flash('notif_success', "✅ Email envoyé à $count candidat(s).");
        redirect('/admin/notifications');
    }

    public function chatbot(): void {
        requireAdmin();
        $faqs    = ChatbotFaq::getAllKeywords();
        $success = flash('faq_success');
        require __DIR__ . '/../views/admin/chatbot.php';
    }

    public function addFaq(): void {
        requireAdmin();
        $mot_cle   = sanitize($_POST['mot_cle'] ?? '');
        $reponse   = sanitize($_POST['reponse'] ?? '');
        $categorie = sanitize($_POST['categorie'] ?? 'général');
        if ($mot_cle && $reponse) {
            ChatbotFaq::save($mot_cle, $reponse, $categorie);
            flash('faq_success', 'Entrée ajoutée avec succès.');
        }
        redirect('/admin/chatbot');
    }

    public function updateFaq(): void {
        requireAdmin();
        $id        = (int)($_POST['id'] ?? 0);
        $mot_cle   = sanitize($_POST['mot_cle'] ?? '');
        $reponse   = sanitize($_POST['reponse'] ?? '');
        $categorie = sanitize($_POST['categorie'] ?? 'général');
        if ($id && $mot_cle && $reponse) {
            ChatbotFaq::update($id, $mot_cle, $reponse, $categorie);
            flash('faq_success', 'Entrée modifiée avec succès.');
        }
        redirect('/admin/chatbot');
    }

    public function deleteFaq(): void {
        requireAdmin();
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            ChatbotFaq::delete($id);
            flash('faq_success', 'Entrée supprimée.');
        }
        redirect('/admin/chatbot');
    }

    public function exportCsv(): void {
        requireAdmin();
        $candidats = Candidat::paginate(1, 99999)['data'];
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="candidats_udbl_' . date('Ymd') . '.csv"');
        $f = fopen('php://output', 'w');
        fprintf($f, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8
        fputcsv($f, ['N° Dossier','Nom','Prénom','Email','Téléphone','Filière','Statut','Date']);
        foreach ($candidats as $c) {
            fputcsv($f, [$c['numero_dossier'],$c['nom'],$c['prenom'],$c['email'],
                         $c['telephone'],$c['filiere_nom'],$c['statut'],$c['date_creation']]);
        }
        fclose($f);
        exit;
    }
}

