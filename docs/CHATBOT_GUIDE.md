## 1. Structure des Fichiers à Créer (Jiresse)

les fichiers du chatbot doivent être placés dans les dossiers suivants :
- **Modèle :** `app/models/ChatbotFAQ.php` (Hérite de `Model`)
-  **Controleur :** `app/controllers/ChatbotController.php` 
---
## 2. Le Modèle : `app/models/ChatbotFAQ.php` 

Ce modèle interagit exclusivement avec la table `chatbot_faq` de la base de données. Il hérite de la classe de base `Model` et implémente les méthodes obligatoires.
```php
<?php
// app/models/ChatbotFAQ.php

require_once __DIR__ . '/Model.php';

class ChatbotFAQ extends Model { 
	protected $table = "chatbot_faq"; 

	/** 
	* Récupère toutes les questions/réponses pour l'algorithme de correspondance 
	*/ 
	public function getAllKeywords(); // a implenter
	
	/** 
	* Insère une nouvelle entrée FAQ (Requis par le contrat de la classe Model) 
	*/ 
	public function save(array $data) // a implenter
	
	/** 
	* Met à jour une entrée FAQ (Requis par le contrat de la classe Model) 
	*/ 
	public function update($id, array $data) // a implenter

}
```

## Le Contrôleur : `app/controllers/ChatbotController.php` 

Ce contrôleur est appelé directement par la route `chatbot-api` définie dans le routeur principal (`index.php`). Il reçoit la question de l'utilisateur, exécute l'algorithme de tokenisation et retourne une réponse JSON propre.

```php
<?php 
// app/controllers/ChatbotController.php 
require_once __DIR__ . '/../models/ChatbotFAQ.php';
class ChatbotController {
	private $faqModel;
	
	public function __construct() {
		$this->faqModel = new ChatbotFAQ(); 
	}
	
	/** 
	* Point d'entrée principal pour l'API du Chatbot 
	*/
	public function handleRequest() // a implementer
	
	/** 
	* Algorithme de traitement de texte et calcul de score 
	*/
	private function analyzeQuestion($question) // a implementer
```

## NB: 

Le model ChatbotFaq doit obligatoirement respecter la table dans la base de données :
```sql
-- Table 5 : Le Chatbot FAQ (Indépendante)

CREATE TABLE chatbot_faq (
	id INT AUTO_INCREMENT,
	motCle VARCHAR(200) NOT NULL,
	reponse TEXT NOT NULL,
	categorie VARCHAR(50),
	dateCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT pk_chatbot_faq PRIMARY KEY (id)
) ENGINE=InnoDB;
```
