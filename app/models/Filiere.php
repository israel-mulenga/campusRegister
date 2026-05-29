<?php

require_once __DIR__ . '/Model.php';

class Filiere extends Model {
    protected $table = 'filiere';

    public function save(array $data) {
        $query = "INSERT INTO " . $this->table . " (nom, description, conditionAcces, placeMax) VALUES (:nom, :description, :conditionAcces, :placeMax)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'nom' => $data['nom'],
            'description' => $data['description'],
            'conditionAcces' => $data['conditionAcces'],
            'placeMax' => $data['placeMax']
        ]);
    }

    public function update($id, array $data) {
        $query = "UPDATE " . $this->table . " SET nom = :nom, description = :description, conditionAcces = :conditionAcces, placeMax = :placeMax WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'id' => $id,
            'nom' => $data['nom'],
            'description' => $data['description'],
            'conditionAcces' => $data['conditionAcces'],
            'placeMax' => $data['placeMax']
        ]);
    }
}