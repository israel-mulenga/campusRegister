<?php

require_once __DIR__ . '/Model.php';

class Admin extends Model {
    protected $table = "administrateur";

    public function save(array $data) {
        // Hash the password before saving
        $passwordHash = password_hash($data['mot_de_passe_hash'], PASSWORD_BCRYPT);

        $query = "INSERT INTO " . $this->table . " (nom, email, mot_de_passe_hash, derniere_connexion) VALUES (:nom, :email, :mot_de_passe_hash, now())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'nom' => $data['nom'],
            'email' => $data['email'],
            'mot_de_passe_hash' => $passwordHash
        ]);
    }

    public function authenticate(string $email, string $password): ?array {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->$db->prepare($query);
        $stmt->execute(['email' => $email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['mot_de_passe_hash'])) {
            $this->$db->prepare("UPDATE " . $this->table . " SET derniere_connexion = NOW() WHERE id = ?")
               ->execute([$admin['id']]);
            return $admin;
        }
        return null;
    }

    public function update($id, array $data) {
        // Hash the password if it's being updated
        $passwordHash = isset($data['mot_de_passe_hash']) ? password_hash($data['mot_de_passe_hash'], PASSWORD_BCRYPT) : null;

        $query = "UPDATE " . $this->table . " SET nom = :nom, email = :email" . ($passwordHash ? ", mot_de_passe_hash = :mot_de_passe_hash" : "") . ", derniere_connexion = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $params = [
            'id' => $id,
            'nom' => $data['nom'],
            'email' => $data['email']
        ];

        if ($passwordHash) {
            $params['mot_de_passe_hash'] = $passwordHash;
        }

        return $stmt->execute($params);
    }

    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
}
