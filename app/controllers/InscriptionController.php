<?php

require_once __DIR__ ."/../models/Candidat.php";
require_once __DIR__ ."/../models/Filiere.php";
require_once __DIR__ ."/../../config/database.php";
require_once __DIR__ ."/../helpers/Validator.php";
require_once __DIR__ ."/../services/NotificationService.php";

class InscriptionController {

    public function index(): void {
        $filieres = Filiere::findAll();
        $errorsRaw = flash('errors');
        $oldRaw    = flash('old');
        $errors   = $errorsRaw ? json_decode($errorsRaw, true) : [];
        $old      = $oldRaw    ? json_decode($oldRaw, true)    : [];
        $page     = 'pre-inscription';

        require __DIR__ . '/../../templates/components/header.php';
        require __DIR__ . '/../views/inscription/formulaire.php';
        require __DIR__ . '/../../templates/components/footer.php';
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('/?url=inscription'); }
        verifyCsrf();

        $data   = $_POST;
        $errors = [];

        $candidatModel = new Candidat();

        // ── Validation ────────────────────────────────────────
        $required = ['nom','prenom','email','id_filiere'];
        foreach ($required as $field) {
            if (empty(trim($data[$field] ?? ''))) {
                $errors[$field] = 'Ce champ est obligatoire.';
            }
        }
        if (empty($errors['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Adresse email invalide.';
        }
        if (empty($errors['email']) && $candidatModel->findByEmail($data['email'])) {
            $errors['email'] = 'Cette adresse email est déjà enregistrée.';
        }
        if (!empty($data['telephone']) && !preg_match('/^(\+243|0)[0-9]{9}$/', preg_replace('/\s/','',$data['telephone']))) {
            $errors['telephone'] = 'Format invalide. Ex: +243810000000 ou 0810000000';
        }

        if ($errors) {
            flash('errors', json_encode($errors));
            flash('old',    json_encode($data));
            redirect('/?url=inscription');
        }

        // ── Sauvegarde ────────────────────────────────────────
        $token = generateToken(16);
        $id    = $candidatModel->save([
            'nom'             => sanitize($data['nom']),
            'prenom'          => sanitize($data['prenom']),
            'email'           => strtolower(trim($data['email'])),
            'telephone'       => sanitize($data['telephone'] ?? ''),
            'date_naissance'  => (!empty($data['date_naissance']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['date_naissance'])) ? $data['date_naissance'] : null,
            'lieu_origine'    => sanitize($data['lieu_origine'] ?? ''),
            'dernier_diplome' => sanitize($data['dernier_diplome'] ?? ''),
            'etablissement'   => sanitize($data['etablissement'] ?? ''),
            'id_filiere'      => (int)$data['id_filiere'],
            'token'           => $token,
            'numero_dossier'  => generateNumeroDossier(0),
        ]);

        if (!$id) {
            error_log('Candidat save failed: ' . json_encode($data));
            flash('errors', json_encode(['general' => 'Une erreur est survenue lors de l’enregistrement.']));
            flash('old', json_encode($data));
            redirect('/?url=inscription');
        }

        // Mettre à jour le numéro de dossier avec l'ID réel
        $db = DatabaseConfig::getConnection();
        $db->prepare("UPDATE candidat SET numero_dossier = ? WHERE id = ?")
           ->execute([generateNumeroDossier($id), $id]);

        $candidat = $candidatModel->findWithFiliere($id);

        if (!$candidat) {
            error_log('Candidat findWithFiliere returned null for id: ' . $id);
            flash('errors', json_encode(['general' => 'Impossible de charger les informations de confirmation.']));
            flash('old', json_encode($data));
            redirect('/?url=inscription');
        }

        // ── Notification email ────────────────────────────────
        try {
            NotificationService::sendConfirmation($candidat);
        } catch (\Throwable $e) {
            error_log("Notification error: " . $e->getMessage());
        }

        $_SESSION['confirmation_candidat'] = $candidat;
        redirect('/?url=inscription/confirmation');
    }

    public function confirmation(): void {
        $candidat = $_SESSION['confirmation_candidat'] ?? null;
        if (!$candidat) { redirect('/?url=inscription'); }
        require __DIR__ . '/../views/inscription/confirmation.php';
    }

    public function suivi(): void {
        $candidat      = null;
        $notifications = [];
        $error         = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verifyCsrf();
            $email = strtolower(trim($_POST['email'] ?? ''));
            $token = trim($_POST['token'] ?? '');

            if ($email && $token) {
                $candidat = Candidat::findByEmailAndToken($email, $token);
                if ($candidat) {
                    $notifications = Notification::forCandidat($candidat['id']);
                } else {
                    $error = 'Aucun dossier trouvé avec ces identifiants. Vérifiez votre email et votre token.';
                }
            } else {
                $error = 'Veuillez renseigner votre email et votre token.';
            }
        }

        $page = 'suivi-inscription';
        require __DIR__ . '/../../templates/components/header.php';
        require __DIR__ . '/../views/inscription/suivi.php';
        require __DIR__ . '/../../templates/components/footer.php';
    }
}