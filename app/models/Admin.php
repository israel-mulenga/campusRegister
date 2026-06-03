<?php

require_once __DIR__ . '/Model.php';

class Admin extends Model {
    protected $table = "admin";

    public function save(array $data) {
        // Hash the password before saving
        $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

        $query = "INSERT INTO " . $this->table . " (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $passwordHash
        ]);
    }

    public function update($id, array $data) {
        // Hash the password if it's being updated
        $passwordHash = isset($data['password']) ? password_hash($data['password'], PASSWORD_BCRYPT) : null;

        $query = "UPDATE " . $this->table . " SET username = :username, email = :email" . ($passwordHash ? ", password = :password" : "") . " WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $params = [
            'id' => $id,
            'username' => $data['username'],
            'email' => $data['email']
        ];

        if ($passwordHash) {
            $params['password'] = $passwordHash;
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
