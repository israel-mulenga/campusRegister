<?php
// Vous devez tous creer un fichier nommer database.php qui aura le code ci-dessous.
// mais avec les informations de votre base de données en local.

class Database {
    private static $host = "localhost";
    private static $db_name = "VOTRE_NOM_DE_BDD";
    private static $username = "VOTRE_UTILISATEUR";
    private static $password = "VOTRE_MOT_DE_PASSE";
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8",
                    self::$username,
                    self::$password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $exception) {
                die("Erreur de connexion : " . $exception->getMessage());
            }
        }
        return self::$conn;
    }
}