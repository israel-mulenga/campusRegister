<?php
/**
 * Exemple d'intégration du système Admin
 * À adapter selon votre structure de projet
 */

// ============================================
// Configuration Initiale - À ajouter à index.php
// ============================================

// 1. Démarrer la session sécurisée
session_start();

// 2. Configuration de sécurité
ini_set('session.httponly', 1);           // Pas d'accès via JavaScript
ini_set('session.use_only_cookies', 1);   // Pas d'URL
ini_set('session.use_strict_mode', 1);    // Mode strict
ini_set('session.cookie_secure', 0);      // Mettre à 1 en HTTPS (production)
ini_set('session.cookie_samesite', 'Strict');

// 3. Charger les dépendances
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/middleware/AdminAuthMiddleware.php';
require_once __DIR__ . '/app/models/AdminModel.php';
require_once __DIR__ . '/app/controllers/AdminController.php';

// ============================================
// Router Simple pour l'Admin
// ============================================

$page = $_GET['page'] ?? 'public';
$action = $_GET['action'] ?? 'dashboard';

// Router pour les pages admin
if ($page === 'admin') {
    // Initialiser la session sécurisée
    AdminAuthMiddleware::initSecureSession();

    // Créer le contrôleur
    try {
        $adminController = new AdminController($db);

        // Les routes login et logout ne nécessitent pas d'authentification
        if ($action === 'login') {
            $adminController->login();
        } elseif ($action === 'logout') {
            $adminController->logout();
        } else {
            // Protéger les autres routes
            AdminAuthMiddleware::protect();

            // Dispatcher
            switch ($action) {
                case 'dashboard':
                    $adminController->dashboard();
                    break;
                case 'listeCandidats':
                    $adminController->listeCandidats();
                    break;
                case 'updateStatut':
                    $adminController->updateStatut();
                    break;
                default:
                    // Enregistrer l'action
                    AdminAuthMiddleware::logAction('admin_access', "Action inconnue: $action");
                    header('Location: ?page=admin&action=dashboard');
                    exit;
            }
        }
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        die('Erreur serveur: ' . htmlspecialchars($e->getMessage()));
    }
}

// Router pour les autres pages...
// À adapter selon votre structure

// ============================================
// Script d'Installation - À exécuter une seule fois
// ============================================

/**
 * Si vous avez besoin de créer un admin lors de l'installation,
 * Créez un fichier install.php avec ce contenu
 */

/*
<?php

require_once 'config/database.php';
require_once 'app/models/AdminModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Validations
    if (empty($email) || empty($name) || empty($password)) {
        $error = 'Tous les champs sont obligatoires';
    } elseif ($password !== $password_confirm) {
        $error = 'Les mots de passe ne correspondent pas';
    } elseif (strlen($password) < 8) {
        $error = 'Le mot de passe doit contenir au moins 8 caractères';
    } else {
        $adminModel = new AdminModel($db);
        if ($adminModel->createAdmin($email, $name, $password)) {
            $success = 'Admin créé avec succès! Vous pouvez maintenant vous connecter.';
        } else {
            $error = 'Erreur lors de la création de l\'admin (email existant?)';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Installation Admin</title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 50px auto; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #667eea; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; }
        .alert { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .alert-success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <h1>Installation Admin</h1>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="name">Nom complet</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirm">Confirmer le mot de passe</label>
            <input type="password" id="password_confirm" name="password_confirm" required>
        </div>

        <button type="submit">Créer l'admin</button>
    </form>
</body>
</html>
*/
