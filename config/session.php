<?php
/**
 * Configuration des Cookies de session pour renforcer la sécurité
 */
function startSecureSession() {

    if (session_status() === PHP_SESSION_NONE) {

        $cookieHost = $_SERVER['HTTP_HOST'] ?? '';
        $cookieHost = preg_replace('/:\d+$/', '', $cookieHost);

        $cookieParams = [
            'lifetime' => 3600,
            'path' => '/',
            'secure' => isset($_SERVER['HTTPS']),
            'httponly' => true,
            'samesite' => 'Strict'
        ];

        if ($cookieHost !== '') {
            $cookieParams['domain'] = $cookieHost;
        }

        session_set_cookie_params($cookieParams);

        session_start();
    }

    if (!isset($_SESSION['last_regeneration'])){
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    } elseif (time() - $_SESSION['last_regeneration'] > 1800) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}