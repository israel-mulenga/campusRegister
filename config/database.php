<?php
// Vous devez tous creer un fichier nommer database.php qui aura le code ci-dessous.
// mais avec les informations de votre base de données en local.

class DatabaseConfig {
    private static $host = "localhost";
    private static $db_name = "CAMPUSREGISTER_DB";
    private static $username = "CAMPUS_USER";
    private static $password = "1234";
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