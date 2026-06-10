<?php

require_once __DIR__ . '/Model.php';

class Candidat extends Model {
    protected static $table = 'candidat';

    public function save(array $data): int {
        $db = self::getDb();
        $query = "INSERT INTO " . static::$table . " (nom, prenom, email, telephone, date_naissance, lieu_rigine, dernier_diplome, etablissement, id_filiere, statut, token, numero_dossier) VALUES (:nom, :prenom, :email, :telephone, :date_naissance, :lieu_rigine, :dernier_diplome, :etablissement, :id_filiere, :statut, :token, :numero_dossier)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'nom' => $data['nom'] ?? null,
            'prenom' => $data['prenom'] ?? null,
            'email' => $data['email'] ?? null,
            'telephone' => $data['telephone'] ?? null,
            'date_naissance' => $data['date_naissance'] ?? null,
            'lieu_rigine' => $data['lieu_origine'] ?? null,
            'dernier_diplome' => $data['dernier_diplome'] ?? null,
            'etablissement' => $data['etablissement'] ?? null,
            'id_filiere' => $data['id_filiere'] ?? null,
            'statut' => $data['statut'] ?? 'en_attente',
            'token' => $data['token'] ?? null,
            'numero_dossier' => $data['numero_dossier'] ?? null
        ]);
        return (int)$db->lastInsertId();
    }

    public function update($id, array $data): bool {
        $db = self::getDb();
        $query = "UPDATE " . static::$table . " SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, date_naissance = :date_naissance, lieu_origine = :lieu_origine, dossier_diplome = :dossier_diplome, etablissement = :etablissement, id_filiere = :id_filiere, statut = :statut, token = :token, numero_dossier = :numero_dossier WHERE id = :id";
        $stmt = $db->prepare($query);
        return $stmt->execute([
            'id' => $id,
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'date_naissance' => $data['date_naissance'],
            'lieu_origine' => $data['lieu_origine'],
            'dossier_diplome' => $data['dossier_diplome'],
            'etablissement' => $data['etablissement'],
            'id_filiere' => $data['id_filiere'],
            'statut' => $data['statut'],
            'token' => $data['token'],
            'numero_dossier' => $data['numero_dossier']
        ]);
    }

    public function findByToken(string $token): ?array {
        $db = self::getDb();
        $query = "  SELECT c.*, f.nom as filiere_nom               
                    FROM candidat c
                    LEFT JOIN filiere f ON c.id_filiere = f.id
                    WHERE c.token = :token";
        $stmt = $db->prepare($query);
        $stmt->execute(['token' => $token]);
        $row = $stmt->fetch();
        return $row ? $row : null;
    }

    public function findByEmail(string $email): ?array {
        $db = self::getDb();
        $query = "SELECT * FROM candidat WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        return $row ? $row : null;
    }

    public function findByEmailAndToken(string $email, string $token): ?array {
        $db = self::getDb();
        $query = "SELECT c.*, f.nom as filiere_nom
            FROM candidat c
            LEFT JOIN filiere f ON c.id_filiere = f.id
            WHERE c.email = :email AND c.token = :token";
        $stmt = $db->prepare($query);
        $stmt->execute(['email' => $email, 'token' => $token]);
        $row = $stmt->fetch();
        return $row ? $row : null;
    }

    public function updateStatut(int $id, string $statut): bool {
        $db = self::getDb();
        $query = "UPDATE candidat SET statut = :statut WHERE id = :id";
        $stmt = $db->prepare($query);
        return $stmt->execute(['statut' => $statut, 'id' => $id]);
    }

    public static function paginate(int $page, int $perPage, array $filters = []): array {
        $offset = ($page - 1) * $perPage;
        $where  = [];
        $params = [];

        if (!empty($filters['search'])) {
            $where[]  = "(c.nom LIKE ? OR c.prenom LIKE ? OR c.email LIKE ? OR c.numero_dossier LIKE ?)";
            $s = '%' . $filters['search'] . '%';
            array_push($params, $s, $s, $s, $s);
        }
        if (!empty($filters['statut'])) {
            $where[]  = "c.statut = ?";
            $params[] = $filters['statut'];
        }
        if (!empty($filters['filiere'])) {
            $where[]  = "c.id_filiere = ?";
            $params[] = $filters['filiere'];
        }

        $whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $countSQL = "SELECT COUNT(*) FROM candidat c $whereSQL";
        $db = self::getDb();
        $s = $db->prepare($countSQL);
        $s->execute($params);
        $total = (int)$s->fetchColumn();

        $sql = "
            SELECT c.*, f.nom AS filiere_nom
            FROM candidat c
            LEFT JOIN filiere f ON c.id_filiere = f.id
            $whereSQL
            ORDER BY c.date_creation DESC
            LIMIT ? OFFSET ?
        ";
        $stmt = $db->prepare($sql);
        $allParams = array_merge($params, [$perPage, $offset]);
        $stmt->execute($allParams);

        return [
            'data'        => $stmt->fetchAll(),
            'total'       => $total,
            'pages'       => (int)ceil($total / $perPage),
            'current'     => $page,
        ];
    }

    public function statsParFiliere(): array {
        $db = self::getDb();
        $query = "SELECT * FROM vue_stats_filieres ORDER BY nb_candidats DESC";
        $stmt = $db->query($query);
        return $stmt->fetchAll();
    }

    public function statsParStatut(): array {
        $db = self::getDb();
        $query = "SELECT * FROM vue_stats_statuts";
        $stmt = $db->query($query);
        return $stmt->fetchAll();
    }

    public function recentActivity(int $days = 7): array {
        $db = self::getDb();
        $query = "SELECT DATE(date_creation) as jour, COUNT(*) as nb
            FROM candidat
            WHERE date_creation >= DATE_SUB(NOW(), INTERVAL ? DAY)
            GROUP BY DATE(date_creation)
            ORDER BY jour ASC";
        $stmt = $db->prepare($query);
        $stmt->execute([$days]);
        return $stmt->fetchAll();
    }

    public function findWithFiliere(int $id): ?array {
        $db = self::getDb();
        $query = "SELECT c.*, f.nom as filiere_nom
            FROM candidat c
            LEFT JOIN filiere f ON c.id_filiere = f.id
            WHERE c.id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? $row : null;
    }

    public function getByFilters(array $filters = []): array {
        $where  = [];
        $params = [];
        if (!empty($filters['statut'])) {
            $where[] = "statut = ?";
            $params[] = $filters['statut'];
        }
        if (!empty($filters['id_filiere'])) {
            $where[] = "id_filiere = ?";
            $params[] = $filters['id_filiere'];
        }
        $whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $db = self::getDb();
        $stmt = $db->prepare("SELECT * FROM candidat $whereSQL");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}