<?php

require_once __DIR__ . '/../../config/database.php';

abstract class Model {
    protected static $db;
    protected static $table;

    public function __construct() {
        if (static::$db === null) {
            static::$db = DatabaseConfig::getConnection();
        }
    }

    protected static function getDb() {
        if (static::$db === null) {
            static::$db = DatabaseConfig::getConnection();
        }
        return static::$db;
    }

    public static function findAll(): array {
        $db = static::getDb();
        $query = "SELECT * FROM " . static::$table . " ORDER BY id DESC";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function findById($id): ?array {
        $db = self::getDb();
        $query = "SELECT * FROM " . static::$table . " WHERE id = :id";
        $stmt = self::$db->prepare($query);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? $row : null;
    }

    public static function count(): int {
        $db = self::getDb();
        $query = "SELECT COUNT(*) as count FROM " . static::$table;
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public static function deleteById($id): bool {
        $db = self::getDb();
        $query = "DELETE FROM " . static::$table . " WHERE id = :id";
        $stmt = self::$db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
    
}