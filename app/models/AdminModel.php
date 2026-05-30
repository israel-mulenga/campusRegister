<?php

class AdminModel
{
    private $conn;
    private $table = 'admins';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Récupérer un admin par email
     */
    public function getAdminByEmail($email)
    {
        $query = "SELECT id, email, name, password_hash FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Mettre à jour le token de session d'un admin
     */
    public function updateAdminToken($admin_id, $token)
    {
        $query = "UPDATE " . $this->table . " SET session_token = :token, last_login = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $admin_id);
        $stmt->bindParam(':token', $token);
        return $stmt->execute();
    }

    /**
     * Vérifier le token de session d'un admin
     */
    public function verifyAdminToken($admin_id, $token)
    {
        $query = "SELECT id FROM " . $this->table . " WHERE id = :id AND session_token = :token LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $admin_id);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /**
     * Enregistrer une tentative de connexion échouée
     */
    public function logFailedAttempt($email, $ip)
    {
        $query = "INSERT INTO failed_login_attempts (email, ip_address, attempted_at) VALUES (:email, :ip, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':ip', $ip);
        return $stmt->execute();
    }

    /**
     * Compter le nombre total de candidats
     */
    public function countCandidats()
    {
        $query = "SELECT COUNT(*) as total FROM candidats";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    /**
     * Compter les candidats par statut
     */
    public function countCandidatsByStatus($status)
    {
        $query = "SELECT COUNT(*) as total FROM candidats WHERE status = :status";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    /**
     * Récupérer la liste des candidats avec pagination
     */
    public function getCandidatsList($offset = 0, $limit = 10)
    {
        $query = "SELECT id, name, email, status, created_at FROM candidats ORDER BY created_at DESC LIMIT :offset, :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Mettre à jour le statut d'un candidat
     */
    public function updateCandidatStatus($candidat_id, $status)
    {
        $query = "UPDATE candidats SET status = :status, updated_at = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $candidat_id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    /**
     * Obtenir les détails d'un candidat
     */
    public function getCandidatDetails($candidat_id)
    {
        $query = "SELECT * FROM candidats WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $candidat_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Créer un nouvel admin (pour l'installation initiale)
     * Utilise password_hash() pour sécuriser le mot de passe
     */
    public function createAdmin($email, $name, $password)
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $query = "INSERT INTO " . $this->table . " (email, name, password_hash, created_at) VALUES (:email, :name, :password_hash, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password_hash', $passwordHash);
        return $stmt->execute();
    }
}
?>
