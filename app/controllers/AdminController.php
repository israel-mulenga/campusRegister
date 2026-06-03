<?php

namespace App\Controllers;

require_once __DIR__ . '/../models/Admin.php';
use App\Middleware\AdminAuthMiddleware;

// Ensure middleware is loaded
if (!class_exists('App\\Middleware\\AdminAuthMiddleware')) {
    require_once __DIR__ . '/../middleware/AdminAuthMiddleware.php';
}

class AdminController
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new \Admin();
    }

    /**
     * Affiche la page de connexion admin
     */
    public function login()
    {
        AdminAuthMiddleware::initSecureSession();

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

            // Chercher admin avec email dans la table admin
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
     * Crée un nouvel admin
     */
    public function register()
    {
        AdminAuthMiddleware::initSecureSession();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Veuillez remplir tous les champs.';
                header('Location: ?page=admin&action=register');
                exit;
            }

            // Le contrôleur appelle la méthode save() du modèle (qui gère les 3 champs et le hash du mot de passe)
            $success = $this->adminModel->save([
                'username' => $username,
                'email' => $email,
                'password' => $password
            ]);

            if ($success) {
                $_SESSION['success'] = 'Administrateur créé avec succès.';
                header('Location: ?page=admin&action=login');
                exit;
            } else {
                $_SESSION['error'] = 'Erreur lors de la création de l\'administrateur.';
                header('Location: ?page=admin&action=register');
                exit;
            }
        }

        return;
    }

    /**
     * Déconnecte l'admin
     */
    public function logout()
    {
        AdminAuthMiddleware::initSecureSession();

        foreach (['admin_id', 'admin_email', 'admin_username', 'admin_token', 'admin_login_time', 'admin_ip', 'admin_user_agent'] as $k) {
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
        AdminAuthMiddleware::protect();
        
        // Retourner des statistiques basiques
        return [
            'total_admins' => 0,
            'total_candidats' => 0,
            'message' => 'Bienvenue au dashboard admin'
        ];
    }

    /**
     * Affiche la liste des candidats
     */
    public function listeCandidats()
    {
        AdminAuthMiddleware::protect();

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Placeholder: retourner une structure vide
        return [
            'candidats' => [],
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => 0,
                'total_pages' => 1,
            ],
            'filters' => [],
            'filieres' => [],
        ];
    }

    /**
     * Met à jour le statut d'un candidat et déclenche une notification
     */
    public function updateStatut()
    {
        AdminAuthMiddleware::protect();

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

        // Placeholder pour mise à jour du statut
        $this->createNotification(
            $candidatId,
            'statut_change',
            "Statut changé à '$statut'",
            $commentaire,
            $_SESSION['admin_id'] ?? null
        );

        return ['success' => 'Statut mis à jour et notification envoyée'];
    }

    /**
     * Crée une notification pour un candidat
     */
    private function createNotification($candidatId, $type, $titre, $message = '', $createdBy = null)
    {
        try {
            // Placeholder: créer une notification
            // À implémenter selon les besoins
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
        AdminAuthMiddleware::createSecureSession($admin);

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    /**
     * Vérifie si l'admin est authentifié
     */
    public function isAuthenticated()
    {
        AdminAuthMiddleware::initSecureSession();

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
