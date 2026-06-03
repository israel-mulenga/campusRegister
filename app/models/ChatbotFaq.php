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

class ChatbotFaq extends Model {
    protected static string $table = 'chatbot_faq';

    public static function getAll(): array {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM chatbot_faq ORDER BY categorie, mot_cle");
        return $stmt->fetchAll();
    }

    public static function create(string $mot_cle, string $reponse, string $categorie): bool {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO chatbot_faq (mot_cle, reponse, categorie) VALUES (?,?,?)");
        return $stmt->execute([$mot_cle, $reponse, $categorie]);
    }

    public static function update(int $id, string $mot_cle, string $reponse, string $categorie): bool {
        $db = getDB();
        $stmt = $db->prepare("UPDATE chatbot_faq SET mot_cle=?, reponse=?, categorie=? WHERE id=?");
        return $stmt->execute([$mot_cle, $reponse, $categorie, $id]);
    }

    public static function search(string $question): ?string {
        $db       = getDB();
        $question = strtolower(trim($question));
        $question = preg_replace('/[^a-zA-ZÀ-ÿ\s]/u', ' ', $question);
        $mots     = array_filter(explode(' ', $question), fn($m) => strlen($m) > 2);

        if (empty($mots)) {
            return null;
        }

        $stopwords = ['les','des','une','que','qui','est','sur','par','pour','dans','avec','cette','sont','vous','nous','mais','aussi','plus','très','bien','tout','pas','oui','non','mon','ton','son','mes','tes','ses'];
        $mots = array_diff($mots, $stopwords);

        if (empty($mots)) {
            return null;
        }

        $rows     = $db->query("SELECT * FROM chatbot_faq")->fetchAll();
        $best     = null;
        $bestScore = 0;

        foreach ($rows as $row) {
            $keywords = strtolower($row['mot_cle']);
            $score    = 0;
            foreach ($mots as $mot) {
                if (str_contains($keywords, $mot)) {
                    $score++;
                }
            }
            $ratio = count($mots) > 0 ? $score / count($mots) : 0;
            if ($ratio > $bestScore) {
                $bestScore = $ratio;
                $best      = $row['reponse'];
            }
        }

        return $bestScore >= 0.3 ? $best : null;
    }
}