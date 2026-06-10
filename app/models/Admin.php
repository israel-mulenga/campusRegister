<?php

require_once __DIR__ . '/Model.php';

class Admin extends Model {
    protected static $table = "administrateur";

    public static function authenticate(string $email, string $password): ?array {
        $db = self::getDb();
        $query = "SELECT * FROM administrateur WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->execute(['email' => $email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['mot_de_passe_hash'])) {
            $db->prepare("UPDATE administrateur SET derniere_connexion = NOW() WHERE id = ?")
               ->execute([$admin['id']]);
            return $admin;
        }
        return null;
    }

    public static function findByEmail(string $email): ?array {
        $db = self::getDb();
        $stmt = $db->prepare("SELECT * FROM administrateur WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}
