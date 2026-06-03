<?php

namespace App\Middleware;

class AdminAuthMiddleware {
    private const SESSION_TIMEOUT = 3600;
    private const TOKEN_LENGTH = 32;

    public static function initSecureSession() {
        if (session_status() === PHP_SESSION_NONE) {
            startSecureSession();
        }

        if (!isset($_SESSION['session_initiated'])) {
            session_regenerate_id(true);
            $_SESSION['session_initiated'] = time();
        }
    }

    public static function protect() {
        self::initSecureSession();

        if (!self::isAuthenticated()) {
            header('Location: ?page=admin&action=login');
            exit;
        }

        if (self::hasSessionTimedOut()) {
            self::destroySession();
            $_SESSION['error'] = 'Votre session a expiré. Veuillez vous reconnecter.';
            header('Location: ?page=admin&action=login');
            exit;
        }

        if (!self::validateToken()) {
            self::destroySession();
            $_SESSION['error'] = 'Token de session invalide.';
            header('Location: ?page=admin&action=login');
            exit;
        }

        $_SESSION['admin_last_activity'] = time();
    }

    public static function isAuthenticated() {
        self::initSecureSession();
        return isset($_SESSION['admin_id']) && isset($_SESSION['admin_token']);
    }

    public static function createSecureSession(array $admin) {
        self::initSecureSession();

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_username'] = $admin['username'] ?? '';
        $_SESSION['admin_token'] = bin2hex(random_bytes(self::TOKEN_LENGTH));
        $_SESSION['admin_login_time'] = time();
        $_SESSION['admin_last_activity'] = time();
        $_SESSION['admin_ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['admin_user_agent'] = $_SERVER['HTTP_USER_AGENT'];

        session_regenerate_id(true);
    }

    private static function hasSessionTimedOut() {
        if (!isset($_SESSION['admin_last_activity'])) {
            return true;
        }

        return (time() - $_SESSION['admin_last_activity']) > self::SESSION_TIMEOUT;
    }

    private static function validateToken() {
        if (!isset($_SESSION['admin_token'])) {
            return false;
        }

        if ($_SESSION['admin_ip'] !== $_SERVER['REMOTE_ADDR']) {
            return false;
        }

        if ($_SESSION['admin_user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
            return false;
        }

        return true;
    }

    private static function destroySession() {
        self::initSecureSession();
        session_destroy();
        session_unset();
    }
}
