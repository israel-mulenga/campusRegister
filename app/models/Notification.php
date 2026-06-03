<?php

require_once __DIR__ . '/Model.php';

class Notification extends Model {
    protected $table = 'notification';

    public function save(array $data) {
        $query = "INSERT INTO " . $this->table . " (idCandidat, canal, contenu, dateEnvoi, statut) VALUES (:idCandidat, :canal, :contenu, NOW(), :statut)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'idCandidat' => $data['idCandidat'],
            'canal' => $data['canal'],
            'contenu' => $data['contenu'],
            'status' => $data['status']
        ]);
    }

    public function update($id, array $data) {
        $query = "UPDATE " . $this->table . " SET idCandidat = :idCandidat, canal = :canal, contenu = :contenu, dateEnvoi = NOW(), statut = :statut WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'id' => $id,
            'idCandidat' => $data['idCandidat'],
            'canal' => $data['canal'],
            'contenu' => $data['contenu'],
            'status' => $data['status']
        ]);
    }
}