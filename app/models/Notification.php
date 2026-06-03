<?php
class Notification extends Model {
    protected static string $table = 'notifications';

    public static function create(int $id_candidat, string $canal, string $contenu, string $statut = 'envoye'): void {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO notifications (id_candidat, canal, contenu, statut) VALUES (?,?,?,?)");
        $stmt->execute([$id_candidat, $canal, $contenu, $statut]);
    }

    public static function forCandidat(int $id_candidat): array {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM notifications WHERE id_candidat = ? ORDER BY date_envoi DESC");
        $stmt->execute([$id_candidat]);
        return $stmt->fetchAll();
    }

    public static function recentAll(int $limit = 50): array {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT n.*, c.nom, c.prenom, c.email
            FROM notifications n
            JOIN candidats c ON n.id_candidat = c.id
            ORDER BY n.date_envoi DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}
