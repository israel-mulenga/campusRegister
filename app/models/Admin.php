<?php

namespace App\Models;

use PDO;

class Admin
{
    private $db;

    public function __construct()
    {
        $this->db = $this->getConnection();
    }

    /**
     * Obtient la connexion à la base de données
     */
    private function getConnection()
    {
        require_once dirname(dirname(__DIR__)) . '/config/database.php';
        return $db;
    }

    /**
     * Trouve un admin par email
     */
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare('SELECT * FROM admins WHERE email = :email LIMIT 1');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Trouve un admin par ID
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('SELECT id, email, nom, prenom FROM admins WHERE id = :id LIMIT 1');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouvel admin
     */
    public function create($email, $password, $nom, $prenom)
    {
        // Hash du mot de passe
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

        $stmt = $this->db->prepare(
            'INSERT INTO admins (email, password, nom, prenom, created_at) 
             VALUES (:email, :password, :nom, :prenom, NOW())'
        );

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Récupère les statistiques pour le dashboard
     */
    public function getStatistics()
    {
        $stats = [];

        // Total des candidats
        $stmt = $this->db->query('SELECT COUNT(*) as total FROM candidats');
        $stats['total_candidats'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Candidats en attente
        $stmt = $this->db->query('SELECT COUNT(*) as total FROM candidats WHERE statut = "En attente"');
        $stats['candidats_en_attente'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Candidats approuvés
        $stmt = $this->db->query('SELECT COUNT(*) as total FROM candidats WHERE statut = "Approuvé"');
        $stats['candidats_approuves'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Candidats rejetés
        $stmt = $this->db->query('SELECT COUNT(*) as total FROM candidats WHERE statut = "Rejeté"');
        $stats['candidats_rejetes'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        return $stats;
    }

    /**
     * Récupère la liste des candidats avec pagination
     */
    public function getCandidats($limit = 10, $offset = 0)
    {
        $stmt = $this->db->prepare(
            'SELECT id, nom, prenom, email, telephone, statut, created_at 
             FROM candidats 
             ORDER BY created_at DESC 
             LIMIT :limit OFFSET :offset'
        );

        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Compte le nombre total de candidats
     */
    public function countCandidats()
    {
        $stmt = $this->db->query('SELECT COUNT(*) as total FROM candidats');
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    /**
     * Met à jour le statut d'un candidat
     */
    public function updateCandidatStatut($candidatId, $statut)
    {
        $stmt = $this->db->prepare(
            'UPDATE candidats SET statut = :statut, updated_at = NOW() WHERE id = :id'
        );

        $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
        $stmt->bindParam(':id', $candidatId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Récupère un candidat par ID
     */
    public function getCandidatById($id)
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM candidats WHERE id = :id LIMIT 1'
        );

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
