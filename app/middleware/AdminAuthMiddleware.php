<?php

/**
 * Middleware de protection des pages admin
 * Vérifie que l'utilisateur est authentifié en tant qu'admin
 */
class AdminAuthMiddleware
{
    /**
     * Initialiser les paramètres de session sécurisée
     */
    public static function initSecureSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.httponly', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.use_strict_mode', 1);
            $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 1 : 0;
            ini_set('session.cookie_secure', $secure);
            ini_set('session.cookie_samesite', 'Strict');
            session_start();
        }
    }

    /**
     * Protéger les pages admin
     */
    public static function protect()
    {
        self::initSecureSession();

        if (!isset($_SESSION['admin_id'], $_SESSION['admin_token'])) {
            $_SESSION['error'] = 'Authentification requise';
            header('Location: ?page=admin&action=login');
            exit;
        }

        if (!isset($_SESSION['admin_ip']) || ($_SERVER['REMOTE_ADDR'] ?? '') !== $_SESSION['admin_ip']) {
            session_destroy();
            $_SESSION['error'] = 'Session invalide - Reconnexion requise';
            header('Location: ?page=admin&action=login');
            exit;
        }

        if (!isset($_SESSION['admin_user_agent']) || ($_SERVER['HTTP_USER_AGENT'] ?? '') !== $_SESSION['admin_user_agent']) {
            session_destroy();
            $_SESSION['error'] = 'Session invalide - Reconnexion requise';
            header('Location: ?page=admin&action=login');
            exit;
        }

        if (!isset($_SESSION['admin_login_time']) || (time() - $_SESSION['admin_login_time']) > 3600) {
            session_destroy();
            $_SESSION['error'] = 'Votre session a expiré';
            header('Location: ?page=admin&action=login');
            exit;
        }

        return true;
    }
}

