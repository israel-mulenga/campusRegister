<?php

require_once __DIR__ . '/Model.php';

class Filiere extends Model {
    protected static $table = 'filiere';

    public function save(array $data): bool {
        try {
            $db = static::getDb();
            $query = "INSERT INTO " . static::$table . " (nom, description, conditions, place_max) VALUES (:nom, :description, :conditions, :place_max)";
            $stmt = $db->prepare($query);
            return $stmt->execute([
                'nom' => $data['nom'],
                'description' => $data['description'],
                'conditions' => $data['conditions'],
                'place_max' => $data['place_max']
            ]);
        } catch (\PDOException $e) {
            error_log('Filiere::save failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(int $id, array $data): bool {
        try {
            $db = static::getDb();
            $query = "UPDATE " . static::$table . " SET nom = :nom, description = :description, conditionAcces = :conditionAcces, placeMax = :placeMax WHERE id = :id";
            $stmt = $db->prepare($query);
            return $stmt->execute([
                'id' => $id,
                'nom' => $data['nom'],
                'description' => $data['description'],
                'conditions' => $data['conditions'],
                'place_max' => $data['place_max']
            ]);
        } catch (\PDOException $e) {
            error_log('Filiere::update(' . $id . ') failed: ' . $e->getMessage());
            throw $e;
        }
    }
}