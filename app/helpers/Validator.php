<?php

class Validator {
    private $errors = [];

    /**
     * Valide un tableau de données selon des règles de validation
     * @param array $data Les données à valider
     * @param array $rules Les règles de validation (ex: ['email' => 'required|email', 'password' => 'required|min:6'])
     * @return array|bool Retourne true si les données sont valides, sinon un tableau d'erreurs
     */
    public function validate(array $data, array $rules) {
        foreach ($rules as $field => $ruleString) {
            $rulesArray = explode('|', $ruleString);
            $value = isset($data[$field]) ? trim($data[$field]) : null;

            foreach ($rulesArray as $rule) {
                if ($rule === 'required' && (empty($value) && $value !== '0')) {
                    $this->errors[$field][] = "Le champ {$field} est obligatoire.";
                }

                if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field][] = "L'adresse email n'est pas valide.";
                }

                if (strpos($rule, 'min:') === 0) {
                    $minLength = (int) substr($rule, 4);
                    if (!empty($value) && strlen($value) < $minLength) {
                        $this->errors[$field][] = "Le champ {$field} doit contenir au moins {$minLength} caractères.";
                    }
                }
            }
        }

        return empty($this->errors) ? true : $this->errors;
    }

    /**
     * Netoie les données d'entrée pour éviter les attaques XSS
     * @param string $data Les données à nettoyer
     * @return string Les données nettoyées
     */
    public static function sanitize($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    function redirect(string $path): void {
        header('Location: ' . APP_URL . $path);
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
}