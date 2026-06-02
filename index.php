<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config/session.php';
startSecureSession();

require_once 'config/database.php';
require_once 'app/models/Model.php';

if (file_exists(__DIR__ . '/app/controllers/CandidatController.php')) {
    require_once __DIR__ . '/app/controllers/CandidatController.php';
}
if (file_exists(__DIR__ . '/app/controllers/ChatbotController.php')) {
    require_once __DIR__ . '/app/controllers/ChatbotController.php';
}
if (file_exists(__DIR__ . '/app/controllers/AdminController.php')) {
    require_once __DIR__ . '/app/controllers/AdminController.php';
}

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';

switch ($url) {
    case 'home' :
        if (file_exists(__DIR__ . '/app/views/home.php')) {
            require_once __DIR__ . '/app/views/home.php';
        } else {
            echo "<h1>Bienvenue sur le Portail d'Inscription en Ligne de l'Université</h1>
                  <p>Cette page d'accueil est en cours de développement. Veuillez revenir plus tard pour découvrir les fonctionnalités du portail.</p>";
        }
        break;

    case 'inscription' :
        if (class_exists('CandidatController')) {
            $controller = new CandidatController();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->store();
            } else {
                $controller->index();
            }
        } else {
            echo "Erreur : CandidatController (Dinovic) n'est pas encore integré.";
        }
        break;

    case 'suivi-dossier' :
        // suivi du status du dossier du candidat
        if (class_exists('CandidatController')) {
            $controller = new CandidatController();
            $controller->show();
        } else {
            echo "Erreur : CandidatController (Dinovic) n'est pas encore integré.";
        }
        break;

    case 'chatbot-api' :
        // Endpoint AJAX reçoit les requêtes du chatbot en JSON et retourne les réponses en JSON
        if (class_exists('ChatbotController')) {
            $controller = new ChatbotController();
            $controller->handleRequest();
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => "ChatbotController (Jiresse) non disponible."]);
        }
        break;

    // Espace Administrateur
    case 'admin-login' :
        if (class_exists('AdminController')) {
            $controller = new AdminController();
            $controller->login();
        }
        break;

    case 'admin-dashboard' :
        if (class_exists('AdminController')) {
            $controller = new AdminController();
            $controller->dashboard();
        }
        break;

    case 'admin-candidats' :
        if (class_exists('AdminController')) {
            $controller = new AdminController();
            $controller->manageCandidats();
        }
        break;

    case 'admin-logout' :
        if (class_exists('AdminController')) {
            $controller = new AdminController();
            $controller->logout();
        }
        break;

    default:
        http_response_code(404);
        echo "<h1>404 - Page non trouvée</h1>";
        break;

}