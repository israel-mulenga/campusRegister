<?php

if (getenv('APP_ENV') === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
    ini_set('log_errors', 1);
}

require_once 'config/session.php';
startSecureSession();

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: strict-origin-when-cross-origin');

require_once 'config/database.php';
require_once 'config/app.php';
require_once 'app/helpers/Validator.php';
require_once 'app/models/Model.php';
require_once 'app/models/Candidat.php';
require_once 'app/models/Admin.php';
require_once 'app/models/Filiere.php';
require_once 'app/models/Notification.php';
require_once 'app/models/ChatbotFAQ.php';

if (file_exists(__DIR__ . '/app/controllers/InscriptionController.php'))
    require_once __DIR__ . '/app/controllers/InscriptionController.php';
if (file_exists(__DIR__ . '/app/controllers/ChatbotController.php'))
    require_once __DIR__ . '/app/controllers/ChatbotController.php';
if (file_exists(__DIR__ . '/app/controllers/AdminController.php'))
    require_once __DIR__ . '/app/controllers/AdminController.php';
if (file_exists(__DIR__ . '/app/services/NotificationService.php'))
    require_once __DIR__ . '/app/services/NotificationService.php';

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';

switch ($url) {

    // ── Public ──────────────────────────────────────────────
    case 'home':
        require_once __DIR__ . '/app/views/home.php';
        break;

    case 'inscription':
        $ctrl = new InscriptionController();
        ($_SERVER['REQUEST_METHOD'] === 'POST') ? $ctrl->store() : $ctrl->index();
        break;

    case 'inscription/confirmation':
        (new InscriptionController())->confirmation();
        break;

    case 'suivi-dossier':
        (new InscriptionController())->suivi();
        break;

    case 'chatbot-api':
        $ctrl = new ChatbotController();
        $ctrl->respond();
        break;

    // ── Admin ───────────────────────────────────────────────
    case 'admin/login':
        (new AdminController())->loginPage();
        break;

    case 'admin/login/post':
        (new AdminController())->loginPost();
        break;

    case 'admin/logout':
        (new AdminController())->logout();
        break;

    case 'admin/dashboard':
        (new AdminController())->dashboard();
        break;

    case 'admin/candidats':
        (new AdminController())->candidats();
        break;

    case 'admin/candidats/statut':
        (new AdminController())->updateStatut();
        break;

    case 'admin/notifications':
        (new AdminController())->notifications();
        break;

    case 'admin/notifications/send':
        (new AdminController())->sendNotification();
        break;

    case 'admin/chatbot':
        (new AdminController())->chatbot();
        break;

    case 'admin/chatbot/add':
        (new AdminController())->addFaq();
        break;

    case 'admin/chatbot/update':
        (new AdminController())->updateFaq();
        break;

    case 'admin/chatbot/delete':
        (new AdminController())->deleteFaq();
        break;

    case 'admin/export-csv':
        (new AdminController())->exportCsv();
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/app/views/errors/404.php';
        break;
}
