<?php

require_once __DIR__ . '/Model.php';

class Notification extends Model {
    protected static $table = 'notification';

    public function save(int $id_candidat, string $canal, string $contenu, string $statut = 'envoye'): void {
        $query = "INSERT INTO " . $this->table . " (id_candidat, canal, contenu, statut) VALUES (:id_candidat, :canal, :contenu, :statut)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id_candidat' => $data['id_candidat'],
            'canal' => $data['canal'],
            'contenu' => $data['contenu'],
            'statut' => $data['statut']
        ]);
    }

    public function forCandidat(int $id_candidat): array {
        $query = "SELECT * FROM " . $this->table . " WHERE id_candidat = :id_candidat ORDER BY date_envoi DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id_candidat' => $id_candidat]);
        return $stmt->fetchAll();
    }

    public function recentAll(int $limit = 50): array {
        $query = "SELECT n.*, c.nom, c.prenom, c.email
            FROM notification n
            JOIN candidats c ON n.id_candidat = c.id
            ORDER BY n.date_envoi DESC
            LIMIT ?";
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}