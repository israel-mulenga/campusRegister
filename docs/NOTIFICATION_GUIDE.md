# Guide d'Implémentation du Système de Notifications (Back-end)  => Jiresse

Ce document détaille les spécifications techniques pour le développement du module de Notifications (Email/SMS) de la plateforme UDBL. Ce module sert à notifier les candidats de l'évolution de leur dossier et à en garder une trace en base de données. 
## 1. Structure des Fichiers à Créer

les fichiers de gestion des notifications doivent être placés dans les dossiers suivants :
* **Modèle :** `app/models/Notification.php` (Hérite de `Model`) // C'est deja
* **Contrôleur :** `app/controllers/NotificationController.php`
---
## 2. Le Modèle : `app/models/Notification.php`
```php
// Ajoute cette methode dans la classe Notification sans rien modifier d'autre ni supprimer.
/** 
* Récupère l'historique des notifications envoyées à un candidat spécifique 
*/ 
public function findByCandidat($id_candidat) { 
	$query = "SELECT * FROM " . $this->table . " WHERE id_candidat = :id_candidat ORDER BY date_envoi DESC"; 
	$stmt = $this->db->prepare($query); 
	$stmt->execute(['id_candidat' => $id_candidat]); 
	return $stmt->fetchAll(); 
}

```

## 3. Le Contrôleur : `app/controllers/NotificationController.php`

Ce contrôleur contient la logique d'envoi effectif. Dans le cadre de l'architecture MVC de l'UDBL, il expose des méthodes statiques ou instanciables que **Dinovic** (Inscription) et **Divine** (Admin) pourront appeler directement depuis leurs propres contrôleurs lorsqu'un événement survient.

```php
<?php
// app/controllers/NotificationController.php

require_once __DIR__ . '/../models/Notification.php';

class NotificationController { 
	private $notificationModel; 
	
	public function __construct() { 
		$this->notificationModel = new Notification(); 
	}
	
	/** 
	* Déclenche l'envoi d'un Email de confirmation d'inscription (Appelé par InscriptionController) 
	* @param array $candidat Données du candidat (id, nom, prenom, email, token) 
	*/ 
	public function envoyerConfirmationInscription(array $candidat) // a implementer
	
	/** 
	* Déclenche l'envoi d'un SMS ou Email lors du changement de statut (Appelé par AdminController) 
	* @param array $candidat Données du candidat 
	* @param string $nouveauStatut Le nouveau statut validé (dossier_complet, admis, refuse) 
	*/
	public function envoyerChangementStatut(array $candidat, $nouveauStatut) // a implementer
```

