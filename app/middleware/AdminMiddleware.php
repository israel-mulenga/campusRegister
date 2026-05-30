<?php

namespace App\Middleware;

use App\Controllers\AdminController;

class AdminMiddleware
{
    /**
     * Middleware de protection des pages admin
     * Vérifie que l'utilisateur est authentifié et est un admin
     */
    public static function protect()
    {
        // Démarrer la session si elle n'est pas active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Créer une instance du contrôleur admin
        $adminController = new AdminController();

        // Vérifier l'authentification
        if (!$adminController->isAuthenticated()) {
            $_SESSION['error'] = 'Accès refusé. Veuillez vous connecter.';
            header('Location: ?page=admin&action=login');
            exit;
        }

        // La session est valide
        return true;
    }

    /**
     * Middleware pour vérifier le token CSRF
     */
    public static function verifyCsrfToken($token)
    {
        $adminController = new AdminController();

        if (!$adminController->validateCsrfToken($token)) {
            $_SESSION['error'] = 'Erreur de sécurité : token invalide.';
            http_response_code(403);
            exit;
        }

        return true;
    }

    /**
     * Middleware pour vérifier l'authentification sur chaque requête
     * Peut être appelé au début de chaque page admin
     */
    public static function validateSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier que la session existe
        if (!isset($_SESSION['admin'])) {
            throw new \Exception('Session admin non trouvée');
        }

        // Vérifier que l'IP n'a pas changé
        if ($_SERVER['REMOTE_ADDR'] !== $_SESSION['ip_address']) {
            session_unset();
            session_destroy();
            throw new \Exception('Adresse IP invalide');
        }

        // Vérifier que l'User-Agent n'a pas changé
        if ($_SERVER['HTTP_USER_AGENT'] !== $_SESSION['user_agent']) {
            session_unset();
            session_destroy();
            throw new \Exception('User-Agent invalide');
        }

        // Vérifier le timeout
        $timeout = 3600; // 1 heure
        if (time() - $_SESSION['login_time'] > $timeout) {
            session_unset();
            session_destroy();
            throw new \Exception('Session expirée');
        }

        // Mettre à jour le timestamp pour éviter l'expiration pendant l'activité
        $_SESSION['login_time'] = time();

        return true;
    }

    /**
     * Récupère le token CSRF pour l'inclure dans les formulaires
     */
    public static function getCsrfToken()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * Génère un champ CSRF caché pour les formulaires
     */
    public static function getCsrfField()
    {
        $token = self::getCsrfToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }
}
