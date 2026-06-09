<?php
/**
 * Middleware : AdminAuthMiddleware
 * Rôle : Sécuriser l'accès au panneau d'administration
 */

class AdminAuthMiddleware {
    
    /**
     * Vérifie si l'utilisateur a le droit d'accéder à l'administration
     */
    public static function checkAuth() {
        // 1. Démarrer la session si elle ne l'est pas déjà
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // 2. CORRECTION/SIMULATION : Si vous n'avez pas encore de système de connexion complet,
        // on peut simuler une session admin active pour vos tests.
        // À remplacer plus tard par : if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin')
        
        $_SESSION['is_admin'] = true; // Ligne temporaire pour vos tests locaux

        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
            // Si pas admin, on bloque et on redirige vers l'accueil ou le login
            header("Location: index.php?page=home");
            exit();
        }
    }
}