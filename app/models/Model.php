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
        try {
            $db = static::getDb();
            $query = "SELECT * FROM " . static::$table . " ORDER BY id DESC";
            $stmt = $db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            error_log(static::$table . '::findAll failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function findById($id): ?array {
        try {
            $db = static::getDb();
            $query = "SELECT * FROM " . static::$table . " WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch();
            return $row ? $row : null;
        } catch (\PDOException $e) {
            error_log(static::$table . '::findById(' . $id . ') failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function count(): int {
        try {
            $db = static::getDb();
            $query = "SELECT COUNT(*) as count FROM " . static::$table;
            $stmt = $db->prepare($query);
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log(static::$table . '::count failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function deleteById($id): bool {
        try {
            $db = static::getDb();
            $query = "DELETE FROM " . static::$table . " WHERE id = :id";
            $stmt = $db->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (\PDOException $e) {
            error_log(static::$table . '::deleteById(' . $id . ') failed: ' . $e->getMessage());
            throw $e;
        }
    }
    
}