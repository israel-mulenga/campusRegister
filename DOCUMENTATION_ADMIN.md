# AdminController.php - Documentation Complète

## Vue d'ensemble

L'AdminController implémente un système d'authentification sécurisé avec les fonctionnalités suivantes :
- **Login** avec password_verify()
- **Logout** avec destruction sécurisée de session
- **Dashboard** avec statistiques
- **Gestion des candidats** avec pagination
- **Mise à jour du statut** des candidats
- **Middleware de protection** pour les pages admin

---

## 1. Schéma de Base de Données

### Table `admins`
```sql
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    session_token VARCHAR(64),
    last_login DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Table `candidats`
```sql
CREATE TABLE candidats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    status VARCHAR(50) DEFAULT 'en_attente',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Table `failed_login_attempts` (optionnelle, pour l'audit)
```sql
CREATE TABLE failed_login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255),
    ip_address VARCHAR(45),
    attempted_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

---

## 2. Installation et Configuration

### Étape 1 : Créer l'administrateur initial

```php
<?php
require_once 'config/database.php';
require_once 'app/models/AdminModel.php';

$adminModel = new AdminModel($db);

// Créer un admin avec email/password
$adminModel->createAdmin(
    'admin@example.com',
    'Admin Dupont',
    'your_secure_password_here'
);

echo "Admin créé avec succès!";
?>
```

### Étape 2 : Configuration de index.php

```php
<?php
session_start();

require_once 'config/database.php';
require_once 'app/middleware/AdminAuthMiddleware.php';
require_once 'app/controllers/AdminController.php';

// Initialiser la session sécurisée
AdminAuthMiddleware::initSecureSession();

// Router simple
$action = $_GET['action'] ?? 'dashboard';
$adminController = new AdminController($db);

// Protéger toutes les routes admin sauf login
if ($action !== 'login' && $action !== 'logout') {
    AdminAuthMiddleware::protect();
}

// Dispatcher
switch ($action) {
    case 'login':
        $adminController->login();
        break;
    case 'logout':
        $adminController->logout();
        break;
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
        header('Location: ?action=dashboard');
        exit;
}
?>
```

---

## 3. Fonctionnalités de Sécurité

### 3.1. Authentification avec password_verify()

```php
// Le mot de passe est haché avec bcrypt (cost 12)
$passwordHash = password_hash('password', PASSWORD_BCRYPT, ['cost' => 12]);

// Vérification lors de la connexion
if (password_verify($password, $admin['password_hash'])) {
    // Authentification réussie
}
```

### 3.2. Session Sécurisée

La session inclut :
- **admin_id** : ID de l'administrateur
- **admin_token** : Token aléatoire (32 octets)
- **admin_ip** : Adresse IP de la session
- **admin_user_agent** : User-Agent du navigateur
- **admin_login_time** : Timestamp de connexion
- **csrf_token** : Token CSRF pour les formulaires

### 3.3. Protections Implémentées

| Protection | Détail |
|-----------|--------|
| **IP Binding** | Vérifie que l'IP n'a pas changé |
| **User-Agent Binding** | Vérifie que le User-Agent est constant |
| **Session Timeout** | Expiration après 1 heure d'inactivité |
| **CSRF Token** | Token aléatoire pour chaque session |
| **HTTPOnly Cookies** | Pas d'accès JavaScript aux cookies |
| **Secure Cookies** | HTTPS seulement (en production) |
| **SameSite** | Protection contre les attaques CSRF |

---

## 4. Utilisation des Méthodes

### 4.1. Login

```php
// Affiche le formulaire de connexion
// Accepte POST avec email et password
// Utilise password_verify() pour vérifier les identifiants
$adminController->login();
```

### 4.2. Logout

```php
// Déconnecte l'admin
// Détruit la session
// Supprime le token en base de données
$adminController->logout();
```

### 4.3. Dashboard

```php
// Affiche les statistiques
// - Total candidats
// - Candidats en attente
// - Candidats approuvés
// - Candidats rejetés
$adminController->dashboard();
```

### 4.4. Liste des Candidats

```php
// Affiche la liste des candidats avec pagination
// URL: ?action=listeCandidats&page=1
// Limite: 10 par page par défaut
$adminController->listeCandidats();
```

### 4.5. Mise à Jour du Statut

```php
// Mettre à jour le statut d'un candidat
// POST: candidat_id, status (en_attente|approuvé|rejeté)
$adminController->updateStatut();
```

---

## 5. Middleware AdminAuthMiddleware

### 5.1. Protéger une Page

```php
// Au début de chaque page admin
AdminAuthMiddleware::protect();

// La page ne s'affiche que si l'admin est authentifié
// Sinon redirige vers login
```

### 5.2. Valider le CSRF

```php
// Dans un formulaire POST
if (!AdminAuthMiddleware::validateCsrfToken()) {
    die('Token CSRF invalide');
}
```

### 5.3. Récupérer le Token CSRF

```php
// Dans un formulaire HTML
<input type="hidden" name="csrf_token" 
       value="<?php echo AdminAuthMiddleware::generateCsrfToken(); ?>">

// Ou utiliser la fonction helper
<?php echo AdminAuthMiddleware::getCsrfField(); ?>
```

### 5.4. Enregistrer une Action (Audit)

```php
// Enregistrer les actions pour l'audit
AdminAuthMiddleware::logAction('update_candidat', 'ID candidat: 5, ancien statut: en_attente, nouveau statut: approuvé');
```

---

## 6. Gestion des Erreurs

Les erreurs sont stockées dans `$_SESSION['error']` et affichées dans les vues.

### Erreurs Courantes

| Erreur | Cause |
|--------|-------|
| "Email ou mot de passe incorrect" | Identifiants invalides |
| "Session invalide" | Token expiré ou modifié |
| "Adresse IP modifiée" | Détection de vol de session |
| "Session expirée" | Inactivité > 1 heure |
| "Erreur de sécurité : token invalide" | Token CSRF incorrect |

---

## 7. Fichiers Log

Les actions admin sont enregistrées dans : `/logs/admin_actions.log`

Format JSON :
```json
{
  "admin_id": 1,
  "action": "update_candidat",
  "details": "Statut changé de en_attente à approuvé",
  "ip_address": "192.168.1.100",
  "timestamp": "2024-05-29 14:30:45",
  "user_agent": "Mozilla/5.0..."
}
```

---

## 8. Bonnes Pratiques

✅ Toujours utiliser `password_verify()` pour comparer les mots de passe  
✅ Ne jamais stocker les mots de passe en clair  
✅ Utiliser HTTPS en production  
✅ Changer le mot de passe par défaut immédiatement  
✅ Vérifier les logs d'authentification régulièrement  
✅ Mettre en place une limitation de tentatives de connexion  
✅ Utiliser le middleware sur TOUTES les routes admin  

---

## 9. Exemples d'Utilisation

### Créer un formulaire de connexion

```html
<form method="POST" action="?action=login">
    <input type="email" name="email" required>
    <input type="password" name="password" required>
    <button type="submit">Se connecter</button>
</form>
```

### Ajouter un bouton de déconnexion

```html
<form method="POST" action="?action=logout">
    <button type="submit">Déconnexion</button>
</form>
```

### Vérifier si l'admin est connecté

```php
if (AdminController::isAdminLoggedIn()) {
    $admin = AdminController::getAdminInfo();
    echo "Bienvenue " . $admin['name'];
}
```

---

## 10. Dépannage

### La page de connexion affiche une erreur de base de données

Vérifier la configuration dans `config/database.php` :
- Host correct (localhost par défaut)
- Nom de la base de données
- Identifiants MySQL

### La session expire trop rapidement

Modifier la durée d'expiration dans `AdminAuthMiddleware.php` :
```php
$sessionTimeout = 3600; // Modifier cette valeur (en secondes)
```

### Je me fais rediriger vers login même après connexion

Probable vol de session détecté. Vérifier :
- Que vous utilisez le même navigateur
- Que votre adresse IP ne change pas
- Que vous utilisez HTTP ou HTTPS (pas les deux)

---

## Conclusion

Ce système AdminController offre une protection robuste contre les attaques courantes :
- Injection SQL (requêtes préparées)
- Bruteforce (logging des tentatives)
- Vol de session (IP + User-Agent + Token)
- CSRF (token unique)
- XSS (htmlspecialchars)

Pour toute question, consultez la documentation du code ou les commentaires dans les fichiers.
