<?php

    require_once __DIR__ ."/../../config/app.php";

    /**
     * Netoie les données d'entrée pour éviter les attaques XSS
     * @param string $data Les données à nettoyer
     * @return string Les données nettoyées
     */
    function sanitize($data) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    function redirect(string $path): void {
        if (preg_match('/^https?:\/\//', $path)) {
            $location = $path;
        } elseif (str_starts_with($path, '/')) {
            if (preg_match('#^/(index\.php)?\?.*#', $path)) {
                $location = ltrim($path, '/');
            } else {
                $location = 'index.php?url=' . ltrim($path, '/');
            }
        } else {
            $location = $path;
        }
        header('Location: ' . $location);
        exit;
    }

    function isAdminLoggedIn(): bool {
        return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
    }

    function requireAdmin(): void {
        if (!isAdminLoggedIn()) {
            redirect('/admin/login');
        }
    }

    function generateToken(int $length = 32): string {
        return bin2hex(random_bytes($length));
    }

    function generateNumeroDossier(int $id): string {
        return 'UDBL-2026-' . str_pad($id, 4, '0', STR_PAD_LEFT);
    }

    function csrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = generateToken(16);
        }
        return $_SESSION['csrf_token'];
    }

    function csrfField(): string {
        return '<input type="hidden" name="csrf_token" value="' . csrfToken() . '">';
    }

    function verifyCsrf(): void {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            die('Requête invalide.');
        }
    }

    function e(mixed $val): string {
        return htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8');
    }

    function flash(string $key, string $message = ''): string {
        if ($message) {
            $_SESSION['flash'][$key] = $message;
            return '';
        }
        $msg = $_SESSION['flash'][$key] ?? '';
        unset($_SESSION['flash'][$key]);
        return $msg;
    }

    function requirePost(string $redirectTo): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect($redirectTo);
        }
    }

    function fullName(array $person): string {
        return trim(($person['nom'] ?? '') . ' ' . ($person['prenom'] ?? ''));
    }

    function renderPublicView(string $viewPath, array $vars = []): void {
        extract($vars);
        require __DIR__ . '/../../templates/components/header.php';
        require $viewPath;
        require __DIR__ . '/../../templates/components/footer.php';
    }