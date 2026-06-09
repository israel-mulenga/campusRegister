<?php

require_once __DIR__ . '/Model.php';

class Candidat extends Model {
    protected $table = 'candidat';

    public function save(array $data): int {
        $query = "INSERT INTO " . $this->table . " (nom, prenom, email, telephone, date_naissance, lieu_origine, dossier_diplome, etablissement, id_filiere, statut, token, numero_dossier) VALUES (:nom, :prenom, :email, :telephone, :date_naissance, :lieu_origine, :dossier_diplome, :etablissement, :id_filiere, :statut, :token, :numero_dossier)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
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
        return (int)$this->db->lastInsertId();
    }

    public function update($id, array $data): bool {
        $query = "UPDATE " . $this->table . " SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, date_naissance = :date_naissance, lieu_origine = :lieu_origine, dossier_diplome = :dossier_diplome, etablissement = :etablissement, id_filiere = :id_filiere, statut = :statut, token = :token, numero_dossier = :numero_dossier WHERE id = :id";
        $stmt = $this->db->prepare($query);
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
        $query = "  SELECT c.*, f.nom as filiere_nom               
                    FROM candidat c
                    LEFT JOIN filiere f ON c.id_filiere = f.id
                    WHERE c.token = :token";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['token' => $token]);
        $row = $stmt->fetch();
        return $row ? $row : null;
    }

    public function findByEmail(string $email): ?array {
        $query = "SELECT * FROM candidats WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        return $row ? $row : null;
    }

    public function findByEmailAndToken(string $email, string $token): ?array {
        $query = "SELECT c.*, f.nom as filiere_nom
            FROM candidat c
            LEFT JOIN filiere f ON c.id_filiere = f.id
            WHERE c.email = :email AND c.token = :token";
        $stmt->execute(['email' => $email, 'token' => $token]);
        $row = $stmt->fetch();
        return $row ? $row : null;
    }

    public function updateStatut(int $id, string $statut): bool {
        $query = "UPDATE candidat SET statut = :statut WHERE id = :id";
        $stmt = $this->db->prepare($query);
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
        $countSQL = "SELECT COUNT(*) FROM candidats c $whereSQL";
        $s = $this->$db->prepare($countSQL);
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
        $stmt = $this->$db->prepare($sql);
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
        $query = "SELECT * FROM vue_stats_filieres ORDER BY nb_candidats DESC";
        $stmt = $this->$db->query($query);
        return $stmt->fetchAll();
    }

    public function statsParStatut(): array {
        $query = "SELECT * FROM vue_stats_statuts";
        $stmt = $this->$db->query($query);
        return $stmt->fetchAll();
    }

    public function recentActivity(int $days = 7): array {
        $query = "SELECT DATE(date_creation) as jour, COUNT(*) as nb
            FROM candidats
            WHERE date_creation >= DATE_SUB(NOW(), INTERVAL ? DAY)
            GROUP BY DATE(date_creation)
            ORDER BY jour ASC";
        $stmt = $this->$db->prepare($query);
        $stmt->execute([$days]);
        return $stmt->fetchAll();
    }

    public function findWithFiliere(int $id): ?array {
        $query = "SELECT c.*, f.nom as filiere_nom
            FROM candidats c
            LEFT JOIN filieres f ON c.id_filiere = f.id
            WHERE c.id = ?";
        $stmt = $this->$db->prepare($query);
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
        $stmt = $this->$db->prepare("SELECT * FROM candidats $whereSQL");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}