<?php

require_once __DIR__ . '/Model.php';

class Notification extends Model {
    protected $table = 'notification';

    public function save(array $data) {
        $query = "INSERT INTO " . $this->table . " (idCandidat, canal, contenu, dateEnvoi, status) VALUES (:idCandidat, :canal, :contenu, NOW(), :status)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'idCandidat' => $data['idCandidat'],
            'canal' => $data['canal'],
            'contenu' => $data['contenu'],
            'status' => $data['status']
        ]);
    }

    public function update($id, array $data) {
        $query = "UPDATE " . $this->table . " SET idCandidat = :idCandidat, canal = :canal, contenu = :contenu, dateEnvoi = NOW(), status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'id' => $id,
            'idCandidat' => $data['idCandidat'],
            'canal' => $data['canal'],
            'contenu' => $data['contenu'],
            'status' => $data['status']
        ]);
    }

    public function findByCandidat($id_candidat) {
        $query = "SELECT * FROM " . $this->table . " WHERE idCandidat = :idCandidat ORDER BY dateEnvoi DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['idCandidat' => $id_candidat]);
        return $stmt->fetchAll();
    }
}