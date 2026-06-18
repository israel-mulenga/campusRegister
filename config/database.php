<?php

class DatabaseConfig {
    private static $conn = null;

    private static function pdoOptions(): array {
        return [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }

    public static function getConnection() {
        if (self::$conn === null) {
            try {
                $databaseUrl = getenv('DATABASE_URL');
                if ($databaseUrl) {
                    // Netlify Database — managed PostgreSQL
                    $parsed = parse_url($databaseUrl);
                    $host   = $parsed['host'];
                    $port   = $parsed['port'] ?? 5432;
                    $dbname = ltrim($parsed['path'], '/');
                    $user   = urldecode($parsed['user']);
                    $pass   = urldecode($parsed['pass']);

                    self::$conn = new PDO(
                        "pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require",
                        $user,
                        $pass,
                        self::pdoOptions()
                    );
                } else {
                    // Local development — MySQL
                    self::$conn = new PDO(
                        "mysql:host=localhost;dbname=CAMPUSREGISTER_DB;charset=utf8mb4",
                        "CAMPUS_USER",
                        "1234",
                        self::pdoOptions()
                    );
                }
            } catch (PDOException $exception) {
                die("Erreur de connexion : " . $exception->getMessage());
            }
        }
        return self::$conn;
    }

    public static function getDriver(): string {
        return getenv('DATABASE_URL') ? 'pgsql' : 'mysql';
    }
}
