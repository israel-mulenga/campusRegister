<?php

namespace App\Controllers;

require_once __DIR__ . '/../models/Admin.php';
use App\Middleware\AdminAuthMiddleware;

// Ensure middleware is loaded
if (!class_exists('App\\Middleware\\AdminAuthMiddleware')) {
    require_once __DIR__ . '/../middleware/AdminAuthMiddleware.php';
}

class NotificationController
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new \Admin();
    }

    /**
     * Affiche la liste des notifications groupées
     */
    public function index()
    {
        AdminAuthMiddleware::protect();

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $filters = [
            'type' => trim($_GET['type'] ?? ''),
            'statut' => trim($_GET['statut'] ?? ''),
            'non_lues' => isset($_GET['non_lues']) ? 1 : 0,
        ];

        $notifications = $this->getNotifications($limit, $offset, $filters);
        $totalNotifications = $this->countNotifications($filters);
        $totalPages = $totalNotifications > 0 ? (int) ceil($totalNotifications / $limit) : 1;

        $groupedNotifications = $this->groupNotifications($notifications);
        $stats = $this->getNotificationStats();

        return [
            'notifications' => $groupedNotifications,
            'stats' => $stats,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $totalNotifications,
                'total_pages' => $totalPages,
            ],
            'filters' => $filters,
            'types' => $this->getNotificationTypes(),
        ];
    }

    /**
     * Récupère les notifications avec filtres
     */
    private function getNotifications($limit = 20, $offset = 0, array $filters = [])
    {
        $conditions = [];
        $params = [];

        if (!empty($filters['type'])) {
            $conditions[] = 'type = :type';
            $params[':type'] = $filters['type'];
        }

        if ($filters['non_lues'] ?? 0) {
            $conditions[] = 'est_lue = 0';
        }

        if (!empty($filters['statut'])) {
            $conditions[] = 'statut = :statut';
            $params[':statut'] = $filters['statut'];
        }

        $where = empty($conditions) ? '' : 'WHERE ' . implode(' AND ', $conditions);

        $sql = "SELECT n.*, c.nom, c.prenom, c.email, a.nom as admin_nom, a.prenom as admin_prenom
                FROM notifications n
                LEFT JOIN candidats c ON n.candidat_id = c.id
                LEFT JOIN admins a ON n.created_by = a.id
                $where
                ORDER BY n.created_at DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->adminModel->getDb()->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
        }

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Compte le nombre total de notifications avec filtres
     */
    private function countNotifications(array $filters = [])
    {
        $conditions = [];
        $params = [];

        if (!empty($filters['type'])) {
            $conditions[] = 'type = :type';
            $params[':type'] = $filters['type'];
        }

        if ($filters['non_lues'] ?? 0) {
            $conditions[] = 'est_lue = 0';
        }

        if (!empty($filters['statut'])) {
            $conditions[] = 'statut = :statut';
            $params[':statut'] = $filters['statut'];
        }

        $where = empty($conditions) ? '' : 'WHERE ' . implode(' AND ', $conditions);

        $sql = "SELECT COUNT(*) as total FROM notifications $where";

        $stmt = $this->adminModel->getDb()->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
        }

        $stmt->execute();

        return (int) $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
    }

    /**
     * Groupe les notifications par date et type
     */
    private function groupNotifications($notifications)
    {
        $grouped = [];

        foreach ($notifications as $notification) {
            $date = date('d/m/Y', strtotime($notification['created_at']));

            if (!isset($grouped[$date])) {
                $grouped[$date] = [];
            }

            if (!isset($grouped[$date][$notification['type']])) {
                $grouped[$date][$notification['type']] = [];
            }

            $grouped[$date][$notification['type']][] = $notification;
        }

        return $grouped;
    }

    /**
     * Récupère les statistiques des notifications
     */
    private function getNotificationStats()
    {
        $db = $this->adminModel->getDb();

        $total = $db->query('SELECT COUNT(*) as total FROM notifications')->fetch(\PDO::FETCH_ASSOC)['total'];
        $nonLues = $db->query('SELECT COUNT(*) as total FROM notifications WHERE est_lue = 0')->fetch(\PDO::FETCH_ASSOC)['total'];
        $statutChange = $db->query('SELECT COUNT(*) as total FROM notifications WHERE type = "statut_change"')->fetch(\PDO::FETCH_ASSOC)['total'];

        return [
            'total' => $total,
            'non_lues' => $nonLues,
            'statut_change' => $statutChange,
        ];
    }

    /**
     * Récupère les types de notifications disponibles
     */
    private function getNotificationTypes()
    {
        return [
            'statut_change' => 'Changement de statut',
            'dossier_complet' => 'Dossier complété',
            'alerte' => 'Alerte',
        ];
    }

    /**
     * Marque une notification comme lue
     */
    public function markAsRead()
    {
        AdminAuthMiddleware::protect();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['error' => 'Méthode non autorisée'];
        }

        $notificationId = isset($_POST['notification_id']) ? (int) $_POST['notification_id'] : 0;

        if ($notificationId <= 0) {
            return ['error' => 'ID de notification invalide'];
        }

        // Placeholder: marquer comme lue
        return ['success' => 'Notification marquée comme lue'];
    }

    /**
     * Marque toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        AdminAuthMiddleware::protect();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['error' => 'Méthode non autorisée'];
        }

        // Placeholder: marquer toutes comme lues
        return ['success' => 'Toutes les notifications sont marquées comme lues'];
    }

    /**
     * Supprime une notification
     */
    public function delete()
    {
        AdminAuthMiddleware::protect();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['error' => 'Méthode non autorisée'];
        }

        $notificationId = isset($_POST['notification_id']) ? (int) $_POST['notification_id'] : 0;

        if ($notificationId <= 0) {
            return ['error' => 'ID de notification invalide'];
        }

        // Placeholder: supprimer la notification
        return ['success' => 'Notification supprimée'];
    }

    /**
     * Récupère le nombre de notifications non lues (pour widget)
     */
    public function getUnreadCount()
    {
        AdminAuthMiddleware::protect();

        // Placeholder: retourner le compte
        return ['unread_count' => 0];
    }

    /**
     * Récupère les dernières notifications (pour widget)
     */
    public function getLatest()
    {
        AdminAuthMiddleware::protect();

        $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;

        $db = $this->adminModel->getDb();
        $stmt = $db->prepare(
            'SELECT n.*, c.nom, c.prenom
             FROM notifications n
             LEFT JOIN candidats c ON n.candidat_id = c.id
             WHERE est_lue = 0
             ORDER BY n.created_at DESC
             LIMIT :limit'
        );

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return [
            'latest' => $stmt->fetchAll(\PDO::FETCH_ASSOC),
        ];
    }
}
