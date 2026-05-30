<?php
// Front controller minimal pour tests locaux
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Charger manuellement les classes (sans autoload)
require_once __DIR__ . '/app/middleware/AdminAuthMiddleware.php';
require_once __DIR__ . '/app/controllers/AdminController.php';
require_once __DIR__ . '/app/models/Admin.php';


$page = $_GET['page'] ?? null;
$action = $_GET['action'] ?? null;

if ($page === 'admin') {
	\AdminAuthMiddleware::initSecureSession();
	$ctrl = new \App\Controllers\AdminController();

	switch ($action) {
		case 'login':
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$ctrl->login();
				// login() redirige en cas de succès ou d'erreur
				break;
			}

			require_once __DIR__ . '/app/views/admin/login.php';
			break;

		case 'logout':
			$ctrl->logout();
			break;

		case 'dashboard':
			$result = $ctrl->dashboard();
			$totalCandidats = $result['total_candidats'] ?? 0;
			$candidatsEnAttente = $result['candidats_en_attente'] ?? 0;
			$candidatsApprouves = $result['candidats_approuves'] ?? 0;
			$candidatsRejetes = $result['candidats_rejetes'] ?? 0;
			require_once __DIR__ . '/app/views/admin/dashboard.php';
			break;

		case 'listeCandidats':
			$result = $ctrl->listeCandidats();
			$candidats = $result['candidats'] ?? [];
			$page = $result['pagination']['page'] ?? 1;
			$totalPages = $result['pagination']['total_pages'] ?? 1;
			$totalCandidats = $result['pagination']['total'] ?? 0;
			require_once __DIR__ . '/app/views/admin/listeCandidats.php';
			break;

		case 'updateStatut':
			$result = $ctrl->updateStatut();
			if (isset($result['success'])) {
				$_SESSION['success'] = $result['success'];
			} elseif (isset($result['error'])) {
				$_SESSION['error'] = $result['error'];
			}
			header('Location: ?page=admin&action=listeCandidats');
			exit;
			break;

		default:
			header('Location: ?page=admin&action=login');
			exit;
	}
	exit;
}

// Page par défaut
echo "Application campusRegister-main: spécifier ?page=admin&action=... pour tester.";
