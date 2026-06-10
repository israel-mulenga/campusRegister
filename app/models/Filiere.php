<?php

require_once __DIR__ . '/Model.php';

class Filiere extends Model {
    protected static $table = 'filiere';

    public function save(array $data): bool {
        $query = "INSERT INTO " . $this->table . " (nom, description, conditions, place_max) VALUES (:nom, :description, :conditions, :place_max)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'nom' => $data['nom'],
            'description' => $data['description'],
            'conditions' => $data['conditions'],
            'place_max' => $data['place_max']
        ]);
    }

    public function update(int $id, array $data): bool {
        $query = "UPDATE " . $this->table . " SET nom = :nom, description = :description, conditionAcces = :conditionAcces, placeMax = :placeMax WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'id' => $id,
            'nom' => $data['nom'],
            'description' => $data['description'],
            'conditions' => $data['conditions'],
            'place_max' => $data['place_max']
        ]);
    }
}