## 1. Structure des Fichiers à Créer ou Compléter (Dinhovic)

les fichiers suivants doivent être créés ou complétés : 

* **Modèle :** `app/models/Candidat.php` (Hérite de `Model`)  // existe deja
* **Contrôleur :** `app/controllers/InscriptionController.php` 
--- 
## 2. Le Modèle : `app/models/Candidat.php`
```php
C'est deja ne modifie rien
```

## 3. Le Contrôleur : `app/controllers/InscriptionController.php`

Ce contrôleur gère l'affichage du formulaire, la validation stricte des données soumises par le candidat, la génération du token sécurisé et l'affichage du statut de pré-inscription.

```php
<?php
	// app/controllers/InscriptionController.php 
	require_once __DIR__ . '/../models/Candidat.php'; 
	require_once __DIR__ . '/../models/Filiere.php'; 
	require_once __DIR__ . '/../Helpers/Validator.php';
	
	class InscriptionController { 
		private $candidatModel; 
		private $filiereModel; 
		private $validator; 
		
		public function __construct() { 
			$this->candidatModel = new Candidat(); 
			$this->filiereModel = new Filiere(); 
			$this->validator = new Validator(); 
		}
		
		/** 
		* Affiche le formulaire d'inscription (Méthode GET sur ?url=inscription) 
		*/
		public function index() { 
		// Récupérer la liste des filières disponibles pour alimenter le menu déroulant du formulaire 
			$filieres = $this->filiereModel->findAll();
			
			// Affichage de la vue (À interfacer avec Eddy M8 pour l'intégration des templates HTML/CSS) 
			echo "<h2>Formulaire de Pré-inscription UDBL</h2>"; 
			echo '<form method="POST" action="index.php?url=inscription">'; 
			echo ' <label>Nom :</label><br><input type="text" name="nom" required><br>'; 
			echo ' <label>Prénom :</label><br><input type="text" name="prenom" required><br>'; 
			echo ' <label>Email :</label><br><input type="email" name="email" required><br>'; 
			echo ' <label>Téléphone :</label><br><input type="text" name="telephone"><br>'; 
			echo ' <label>Filière choisie :</label><br><select name="id_filiere" required>';
			
			foreach ($filieres as $f) { 
				$nomFiliere = Validator::sanitize($f['nom']); 
				echo " <option value='{$f['id']}'>{$nomFiliere}</option>"; 
			}
			
			echo ' </select><br><br>'; 
			echo ' <button type="submit">Soumettre mon dossier</button>'; 
			echo '</form>';
		}
		
		/** 
		* Traite les données du formulaire et enregistre le candidat (Méthode POST sur ?url=inscription) 
		*/
		public function store() {
		$rules = [
			'nom' => 'required', 
			'prenom' => 'required', 
			'email' => 'required|email', 
			'idFiliere' => 'required'
		];
		
		$validation = $this->validator->validate($_POST, $rules);
		
		if ($validation === true) {
			// Génération d'un token cryptographique sécurisé unique pour le suivi du dossier 
			$tokenUnique = bin2hex(random_bytes(16));
			
			$data = [
				'nom' => $_POST['nom'], 
				'prenom' => $_POST['prenom'], 
				'email' => $_POST['email'], 
				'telephone' => $_POST['telephone'] ?? null, 
				'idFiliere' => $_POST['idFiliere'], 
				'token' => $tokenUnique
			];
			
			$success = $this->candidatModel->save($data);
			
			if ($success) {
				// IMPORTANT : Transmettre l'information au module de Jiresse (M5) pour l'envoi de la notification 
				echo "<h3>Inscription réussie !</h3>"; 
				echo "<p>Notez précieusement votre code de suivi unique : <strong>{$tokenUnique}</strong></p>"; 
				echo "<p><a href='index.php?url=suivi-dossier&token={$tokenUnique}'>Cliquez ici pour voir votre statut</a></p>";
			} else {
				echo "<p style='color:red;'>Erreur de validation. Veuillez vérifier vos informations.</p>";
			}
		}
		
		/** 
		* Permet au candidat de suivre le traitement de son dossier (?url=suivi-dossier&token=...) 
		*/
		public function show() {
			$token = isset($_GET['token']) ? trim($_GET['token']) : '';
			
			if (empty($token)) {
				echo "<h2>Suivi de dossier</h2>"; 
				echo '<form method="GET" action="index.php">'; 
				echo ' <input type="hidden" name="url" value="suivi-dossier">'; 
				echo ' <label>Entrez votre code de suivi (Token) :</label><br>'; 
				echo ' <input type="text" name="token" required style="width:300px;"><br><br>'; 
				echo ' <button type="submit">Rechercher mon dossier</button>'; 
				echo '</form>'; 
				return;
			}
			$candidat = $this->candidatModel->findByToken($token);
			
			if ($candidat) {
				// Protection XSS systématique lors de l'affichage des données
				$nom = Validator::sanitize($candidat['nom']); 
				$prenom = Validator::sanitize($candidat['prenom']); 
				$statut = Validator::sanitize($candidat['status']);
				
				echo "<h2>Statut du dossier de {$prenom} {$nom}</h2>";
				
				// Formatage visuel selon le ENUM de la base de données
				
				switch ($statut) { 
					case 'en_attente': 
						echo "<p>Statut actuel : <span style='color:orange; font-weight:bold;'>En attente de traitement</span></p>"; 
						break; 
					case 'dossier_complet': 
						echo "<p>Statut actuel : <span style='color:blue; font-weight:bold;'>Dossier complet (En cours d'examen)</span></p>"; 
						break; 
					case 'admis': 
						echo "<p style='color:green; font-weight:bold;'>Félicitations ! Vous êtes admis à l'UDBL.</p>"; 
						break; 
					case 'refuse': 
						echo "<p style='color:red; font-weight:bold;'>Dossier refusé. Veuillez contacter le service des admissions.</p>"; 
						break; 
					}
				} else { 
					echo "<p style='color:red;'>Code de suivi introuvable. Veuillez vérifier votre jeton.</p>"; 
					echo "<p><a href='index.php?url=suivi-dossier'>Réessayer</a></p>"; 
				}
			}
		}
	}
```

