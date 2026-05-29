<?php

require_once __DIR__ . '/Model.php';

class Candidat extends Model {
    protected $table = 'candidat';

    public function save(array $data) {
        $query = "INSERT INTO " . $this->table . " (nom, prenom, email, telephone, idFiliere, status, token, numeroDossier, dateCreation) VALUES (:nom, :prenom, :email, :telephone, :idFiliere, :status, :token, :numeroDossier, NOW())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'idFiliere' => $data['idFiliere'],
            'status' => $data['status'],
            'token' => $data['token'],
            'numeroDossier' => $data['numeroDossier']
        ]);
    }

    public function update($id, array $data) {
        $query = "UPDATE " . $this->table . " SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, idFiliere = :idFiliere, status = :status, token = :token, numeroDossier = :numeroDossier WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'id' => $id,
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'idFiliere' => $data['idFiliere'],
            'status' => $data['status'],
            'token' => $data['token'],
            'numeroDossier' => $data['numeroDossier']
        ]);
    }
}