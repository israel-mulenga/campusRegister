<?php

require_once __DIR__ . '/../../config/database.php';

abstract class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = DatabaseConfig::getConnection();
    }

    public function findAll(): array {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById($id): ?array {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? $row : null;
    }

    public function count(): int {
        $query = "SELECT COUNT(*) as count FROM " . $this->table;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return (int)$stmt->fechColumn();
    }

    public function deleteById($id): bool {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
    
}