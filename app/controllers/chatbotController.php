<?php

function sanitize(string $value): string {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
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

class ChatbotController {
    public function respond(): void {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['response' => 'Méthode non autorisée.']);
            return;
        }

        $body     = json_decode(file_get_contents('php://input'), true);
        $question = trim($body['question'] ?? '');

        if (strlen($question) < 2) {
            echo json_encode(['response' => 'Veuillez poser une question.']);
            return;
        }

        $response = ChatbotFaq::search($question);
        if (!$response) {
            $response = "Je n'ai pas trouvé de réponse à votre question. \n\nPour une aide personnalisée, contactez-nous :\n info@udbl.ac.cd\n📞 +243 990 200 112\n Lun-Ven 8h-16h | Sam 8h-12h";
        }

        echo json_encode(['response' => $response]);
    }
}
