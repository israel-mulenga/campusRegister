<?php

require_once __DIR__ . '/Model.php';

class Notification extends Model {
    protected static $table = 'notification';

    public static function create(int $id_candidat, string $canal, string $contenu, string $statut = 'envoye'): bool {
        $db = self::getDb();
        $stmt = $db->prepare("INSERT INTO notification (id_candidat, canal, contenu, statut) VALUES (?,?,?,?)");
        return $stmt->execute([$id_candidat, $canal, $contenu, $statut]);
    }

    public static function forCandidat(int $id_candidat): array {
        return self::findBy('id_candidat', $id_candidat, 'date_envoi DESC');
    }

    public static function recentAll(int $limit = 50): array {
        $db = self::getDb();
        $stmt = $db->prepare(
            "SELECT n.* FROM notification n ORDER BY n.date_envoi DESC LIMIT ?"
        );
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
