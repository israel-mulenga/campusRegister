<?php

namespace App\Controllers;

use App\Models\Admin;

class AdminController
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new Admin();
    }

    /**
     * Affiche la page de connexion admin
     */
    public function login()
    {
        \AdminAuthMiddleware::initSecureSession();

        if ($this->isAuthenticated()) {
            header('Location: ?page=admin&action=dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Veuillez remplir tous les champs.';
                header('Location: ?page=admin&action=login');
                exit;
            }

            $admin = $this->adminModel->findByEmail($email);

            if ($admin && password_verify($password, $admin['password'])) {
                $this->createSecureSession($admin);
                header('Location: ?page=admin&action=dashboard');
                exit;
            }

            $_SESSION['error'] = 'Email ou mot de passe incorrect.';
            header('Location: ?page=admin&action=login');
            exit;
        }

        return;
    }

    /**
     * Déconnecte l'admin
     */
    public function logout()
    {
        \AdminAuthMiddleware::initSecureSession();

        foreach (['admin_id', 'admin_email', 'admin_nom', 'admin_prenom', 'admin_token', 'admin_login_time', 'admin_ip', 'admin_user_agent'] as $k) {
            if (isset($_SESSION[$k])) {
                unset($_SESSION[$k]);
            }
        }

        session_regenerate_id(true);
        session_destroy();

        header('Location: ?page=admin&action=login');
        exit;
    }

    /**
     * Affiche le tableau de bord admin
     */
    public function dashboard()
    {
        \AdminAuthMiddleware::protect();
        return $this->adminModel->getStatistics();
    }

    /**
     * Affiche la liste des candidats
     */
    public function listeCandidats()
    {
        \AdminAuthMiddleware::protect();

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $filters = [
            'filiere_id' => isset($_GET['filiere_id']) ? (int) $_GET['filiere_id'] : null,
            'statut' => trim($_GET['statut'] ?? ''),
            'search' => trim($_GET['search'] ?? ''),
        ];

        $candidats = $this->adminModel->getCandidats($limit, $offset, $filters);
        $totalCandidats = $this->adminModel->countCandidats($filters);
        $totalPages = $totalCandidats > 0 ? (int) ceil($totalCandidats / $limit) : 1;

        return [
            'candidats' => $candidats,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $totalCandidats,
                'total_pages' => $totalPages,
            ],
            'filters' => $filters,
            'filieres' => $this->adminModel->getFiliereOptions(),
        ];
    }

    /**
     * Met à jour le statut d'un candidat et déclenche une notification
     */
    public function updateStatut()
    {
        \AdminAuthMiddleware::protect();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['error' => 'Méthode non autorisée'];
        }

        $candidatId = isset($_POST['candidat_id']) ? (int) $_POST['candidat_id'] : 0;
        $statut = trim($_POST['statut'] ?? '');
        $commentaire = trim($_POST['commentaire'] ?? '');

        if ($candidatId <= 0 || empty($statut)) {
            return ['error' => 'Données invalides'];
        }

        $statutsValides = ['En attente', 'Admis', 'Refusé'];
        if (!in_array($statut, $statutsValides, true)) {
            return ['error' => 'Statut invalide'];
        }

        $candidat = $this->adminModel->getCandidatById($candidatId);
        if (!$candidat) {
            return ['error' => 'Candidat non trouvé'];
        }

        $ancienStatut = $candidat['statut'] ?? 'Non défini';

        $success = $this->adminModel->updateCandidatStatut($candidatId, $statut);

        if ($success) {
            $this->createNotification(
                $candidatId,
                'statut_change',
                "Statut changé de '$ancienStatut' à '$statut'",
                $commentaire,
                $_SESSION['admin_id'] ?? null
            );

            return ['success' => 'Statut mis à jour et notification envoyée'];
        }

        return ['error' => 'Erreur lors de la mise à jour du statut'];
    }

    /**
     * Crée une notification pour un candidat
     */
    private function createNotification($candidatId, $type, $titre, $message = '', $createdBy = null)
    {
        try {
            $notification = [
                'candidat_id' => $candidatId,
                'type' => $type,
                'titre' => $titre,
                'message' => $message,
                'created_by' => $createdBy,
                'created_at' => date('Y-m-d H:i:s'),
                'est_lue' => false,
            ];

            if (method_exists($this->adminModel, 'createNotification')) {
                $this->adminModel->createNotification($notification);
            }

            return true;
        } catch (\Exception $e) {
            error_log('Erreur création notification: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Crée une session sécurisée pour l'admin
     */
    private function createSecureSession(array $admin)
    {
        \AdminAuthMiddleware::initSecureSession();
        session_regenerate_id(true);

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_nom'] = $admin['nom'] ?? '';
        $_SESSION['admin_prenom'] = $admin['prenom'] ?? '';
        $_SESSION['admin_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['admin_login_time'] = time();
        $_SESSION['admin_ip'] = $_SERVER['REMOTE_ADDR'] ?? '';
        $_SESSION['admin_user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
    }

    /**
     * Vérifie si l'admin est authentifié
     */
    public function isAuthenticated()
    {
        \AdminAuthMiddleware::initSecureSession();

        if (!isset($_SESSION['admin_id'], $_SESSION['admin_token'], $_SESSION['admin_login_time'])) {
            return false;
        }

        if (($_SERVER['REMOTE_ADDR'] ?? '') !== ($_SESSION['admin_ip'] ?? '')) {
            return false;
        }

        if (($_SERVER['HTTP_USER_AGENT'] ?? '') !== ($_SESSION['admin_user_agent'] ?? '')) {
            return false;
        }

        if (time() - $_SESSION['admin_login_time'] > 3600) {
            return false;
        }

        return true;
    }

    /**
     * Valide un token CSRF si nécessaire
     */
    public function validateCsrfToken($token)
    {
        if (empty($token) || !isset($_SESSION['csrf_token'])) {
            return false;
        }

        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
