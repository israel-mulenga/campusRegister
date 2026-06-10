<?php

require_once __DIR__ . '/Model.php';

class Notification extends Model {
    protected static $table = 'notification';

    public static function create(int $id_candidat, string $canal, string $contenu, string $statut = 'envoye'): bool {
        $db = self::getDb();
        $query = "INSERT INTO " . static::$table . " (id_candidat, canal, contenu, statut) VALUES (:id_candidat, :canal, :contenu, :statut)";
        $stmt = $db->prepare($query);
        return $stmt->execute([
            'id_candidat' => $id_candidat,
            'canal' => $canal,
            'contenu' => $contenu,
            'statut' => $statut
        ]);
    }

    public function forCandidat(int $id_candidat): array {
        $db = self::getDb();
        $query = "SELECT * FROM " . static::$table . " WHERE id_candidat = :id_candidat ORDER BY date_envoi DESC";
        $stmt = $db->prepare($query);
        $stmt->execute(['id_candidat' => $id_candidat]);
        return $stmt->fetchAll();
    }

    public function recentAll(int $limit = 50): array {
        $db = self::getDb();
        $query = "SELECT n.*, c.nom, c.prenom, c.email
            FROM notification n
            JOIN candidats c ON n.id_candidat = c.id
            ORDER BY n.date_envoi DESC
            LIMIT ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}