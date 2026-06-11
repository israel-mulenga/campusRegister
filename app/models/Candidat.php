<?php

require_once __DIR__ . '/Model.php';

class Candidat extends Model {
    protected static $table = 'candidat';

    public static function save(array $data): int {
        $db = self::getDb();
        $query = "INSERT INTO candidat (nom, prenom, email, telephone, date_naissance, lieu_rigine, dernier_diplome, etablissement, id_filiere, statut, token, numero_dossier)
                  VALUES (:nom, :prenom, :email, :telephone, :date_naissance, :lieu_rigine, :dernier_diplome, :etablissement, :id_filiere, :statut, :token, :numero_dossier)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'nom'             => $data['nom']             ?? null,
            'prenom'          => $data['prenom']           ?? null,
            'email'           => $data['email']            ?? null,
            'telephone'       => $data['telephone']        ?? null,
            'date_naissance'  => $data['date_naissance']   ?? null,
            'lieu_rigine'     => $data['lieu_origine']     ?? null,
            'dernier_diplome' => $data['dernier_diplome']  ?? null,
            'etablissement'   => $data['etablissement']    ?? null,
            'id_filiere'      => $data['id_filiere']       ?? null,
            'statut'          => $data['statut']           ?? 'en_attente',
            'token'           => $data['token']            ?? null,
            'numero_dossier'  => $data['numero_dossier']   ?? null,
        ]);
        return (int)$db->lastInsertId();
    }

    public static function update(int $id, array $data): bool {
        $db   = self::getDb();
        $sets = [];
        $params = [];
        foreach ($data as $col => $val) {
            $sets[]       = "$col = :$col";
            $params[$col] = $val;
        }
        $params['id'] = $id;
        $stmt = $db->prepare("UPDATE candidat SET " . implode(', ', $sets) . " WHERE id = :id");
        return $stmt->execute($params);
    }

    public static function findByToken(string $token): ?array {
        $db   = self::getDb();
        $stmt = $db->prepare(
            "SELECT c.*, f.nom AS filiere_nom
             FROM candidat c
             LEFT JOIN filiere f ON c.id_filiere = f.id
             WHERE c.token = :token"
        );
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function findByEmail(string $email): ?array {
        $db   = self::getDb();
        $stmt = $db->prepare("SELECT * FROM candidat WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function findByEmailAndToken(string $email, string $token): ?array {
        $db   = self::getDb();
        $stmt = $db->prepare(
            "SELECT c.*, f.nom AS filiere_nom
             FROM candidat c
             LEFT JOIN filiere f ON c.id_filiere = f.id
             WHERE c.email = :email AND c.token = :token"
        );
        $stmt->execute(['email' => $email, 'token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function updateStatut(int $id, string $statut): bool {
        $db   = self::getDb();
        $stmt = $db->prepare("UPDATE candidat SET statut = :statut WHERE id = :id");
        return $stmt->execute(['statut' => $statut, 'id' => $id]);
    }

    public static function findWithFiliere(int $id): ?array {
        $db   = self::getDb();
        $stmt = $db->prepare(
            "SELECT c.*, f.nom AS filiere_nom
             FROM candidat c
             LEFT JOIN filiere f ON c.id_filiere = f.id
             WHERE c.id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
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
        $db       = self::getDb();

        $s = $db->prepare("SELECT COUNT(*) FROM candidat c $whereSQL");
        $s->execute($params);
        $total = (int)$s->fetchColumn();

        $stmt = $db->prepare(
            "SELECT c.*, f.nom AS filiere_nom
             FROM candidat c
             LEFT JOIN filiere f ON c.id_filiere = f.id
             $whereSQL
             ORDER BY c.date_creation DESC
             LIMIT ? OFFSET ?"
        );
        $stmt->execute(array_merge($params, [$perPage, $offset]));

        return [
            'data'    => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total'   => $total,
            'pages'   => (int)ceil($total / $perPage),
            'current' => $page,
        ];
    }

    public static function statsParFiliere(): array {
        $db = self::getDb();
        return $db->query("SELECT * FROM vue_stats_filieres ORDER BY nb_candidats DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function statsParStatut(): array {
        $db = self::getDb();
        return $db->query("SELECT * FROM vue_stats_statuts")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function recentActivity(int $days = 14): array {
        $db   = self::getDb();
        $stmt = $db->prepare(
            "SELECT DATE(date_creation) AS jour, COUNT(*) AS nb
             FROM candidat
             WHERE date_creation >= DATE_SUB(NOW(), INTERVAL ? DAY)
             GROUP BY DATE(date_creation)
             ORDER BY jour ASC"
        );
        $stmt->execute([$days]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByFilters(array $filters = []): array {
        $where  = [];
        $params = [];
        if (!empty($filters['statut'])) {
            $where[]  = "statut = ?";
            $params[] = $filters['statut'];
        }
        if (!empty($filters['id_filiere'])) {
            $where[]  = "id_filiere = ?";
            $params[] = $filters['id_filiere'];
        }
        $whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $db       = self::getDb();
        $stmt     = $db->prepare("SELECT * FROM candidat $whereSQL");
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countTotal(): int {
        return (int)self::getDb()->query("SELECT COUNT(*) FROM candidat")->fetchColumn();
    }
}
