## 1. Structure des Fichiers à Créer (Divine)

les fichiers de l'espace admin doivent être placés dans les dossiers suivants :

* **Modèle :** `app/models/Admin.php` (Hérite de `Model`)      // C'est deja.
* **Contrôleur :** `app/controllers/AdminController.php`
---
## 2. Le Modèle : `app/models/Admin.php`

```php
C'est deja fait, Ne modifie rien.
```

## 3. Le Contrôleur : `app/controllers/AdminController.php`

Ce contrôleur gère la logique de connexion, la déconnexion, et la sécurisation des pages du tableau de bord. Il inclut une vérification stricte de la session pour empêcher les utilisateurs non authentifiés d'accéder aux données.

```php
<?php
	// app/controllers/AdminController.php
	require_once __DIR__ . '/../models/Admin.php';
	require_once __DIR__ . '/../models/Candidat.php'; // Pour afficher la liste des candidats
	require_once __DIR__ . '/../Helpers/Validator.php';
	
	class AdminController { 
		private $adminModel; 
		private $validator;
		 
		public function __construct() { 
			$this->adminModel = new Admin(); 
			$this->validator = new Validator(); 
		} 
		
		/** 
		* Vérifie si l'administrateur est connecté, sinon le redirige 
		*/ 
		private function checkAuth() { 
			if (!isset($_SESSION['admin_id'])) { 
				header('Location: index.php?url=admin-login'); 
				exit; 
			} 
		} 
		
		/** 
		* Gère la page de connexion et le traitement du formulaire de login 
		*/ 
		public function login() { 
			// Si déjà connecté, redirection vers le dashboard 
			if (isset($_SESSION['admin_id'])) { 
				header('Location: index.php?url=admin-dashboard'); 
				exit; 
			} 
			$erreur = null; 
			if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
				$rules = [ 'email' => 'required|email', 'password' => 'required' ]; 
				$validation = $this->validator->validate($_POST, $rules); 
				
				if ($validation === true) { 
					$email = $_POST['email']; 
					$password = $_POST['password']; 
					$admin = $this->adminModel->findByEmail($email); 
					
					// Vérification du mot de passe avec l'empreinte hachée en BD
					if ($admin && password_verify($password, $admin['mot_de_passe_hash'])) { 
					// Régénération de session par sécurité (anti-fixation) 
						session_regenerate_id(true); 
						$_SESSION['admin_id'] = $admin['id']; 
						$_SESSION['admin_nom'] = $admin['nom']; 
						header('Location: index.php?url=admin-dashboard'); 
						exit; 
					} 
					else { 
						$erreur = "Identifiants incorrects."; 
					} 
				} else { 
					$erreur = "Veuillez remplir correctement tous les champs."; 
				} 
			} 
			// Vue du formulaire de connexion (Interfaçage avec Acacia M9 pour l'intégration HTML) 
			echo "<h2>Connexion Administration UDBL</h2>"; 
			if ($erreur) echo "<p style='color:red;'>$erreur</p>"; 
			echo ' <form method="POST" action="index.php?url=admin-login">
			<label>Email :</label><br><input type="email" name="email" required>
			<br> <label>Mot de passe :</label><br><input type="password" name="password" required><br><br> 
			<button type="submit">Se connecter</button> </form>'; } 
		
		/** 
		* Page d'accueil du Tableau de Bord Admin 
		*/ 
		public function dashboard() { 
			$this->checkAuth(); 
			$nomAdmin = Validator::sanitize($_SESSION['admin_nom']); 
			echo "<h1>Tableau de bord de l'administration</h1>"; 
			echo "<p>Bienvenue, M./Mme <strong>{$nomAdmin}</strong> !</p>"; 
			echo "<ul> <li><a href='index.php?url=admin-candidats'>Consulter la liste des candidats</a></li> <li><a href='index.php?url=admin-logout'>Se déconnecter</a></li> </ul>"; 
		} 
		
		/** 
		* Liste complète des candidats pré-inscrits (Interfaçage avec Dinovic M4) 
		*/ 
		public function listeCandidats() { 
			$this->checkAuth(); 
			if (class_exists('Candidat')) { 
				$candidatModel = new Candidat(); 
				$candidats = $candidatModel->findAll(); 
				echo "<h2>Liste des Candidats Pré-inscrits</h2>"; 
				echo "<p><a href='index.php?url=admin-dashboard'><- Retour au Dashboard</a></p>"; 
				echo "<table border='1' cellpadding='10'>"; 
				echo "<tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Statut</th></tr>"; 
				foreach ($candidats as $c) { 
					// Protection XSS systématique à l'affichage via le Helper 
					$nom = Validator::sanitize($c['nom']); 
					$prenom = Validator::sanitize($c['prenom']); 
					$email = Validator::sanitize($c['email']); $statut = Validator::sanitize($c['statut']); 
					echo "<tr> <td>{$nom}</td> <td>{$prenom}</td> <td>{$email}</td> <td><strong>{$statut}</strong></td> </tr>"; 
				} 
				echo "</table>"; 
			
			} else { 
				echo "<p>Le modèle Candidat n'est pas encore accessible ou configuré.</p>"; 
			} 
		} 
		
		/** 
		* Déconnexion sécurisée et destruction de la session 
		*/ 
		public function logout() { 
			$_SESSION = array(); 
			if (ini_get("session_use_cookies")) { 
				$params = session_get_cookie_params(); 
				setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"] ); 
			} 
			session_destroy(); 
			
			header('Location: index.php?url=admin-login'); 
			exit; 
		} 
	}
```