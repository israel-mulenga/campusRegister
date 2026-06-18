<?php

class DatabaseConfig {
    private static $conn = null;

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
                        [
                            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::ATTR_EMULATE_PREPARES   => false,
                        ]
                    );
                } else {
                    // Local development — MySQL (credentials from environment)
                    $dbHost = getenv('DB_HOST') ?: 'localhost';
                    $dbName = getenv('DB_NAME') ?: 'CAMPUSREGISTER_DB';
                    $dbUser = getenv('DB_USER') ?: '';
                    $dbPass = getenv('DB_PASS') ?: '';

                    self::$conn = new PDO(
                        "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
                        $dbUser,
                        $dbPass,
                        [
                            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::ATTR_EMULATE_PREPARES   => false,
                        ]
                    );
                }
            } catch (PDOException $exception) {
                error_log("DB connection error: " . $exception->getMessage());
                die("Erreur de connexion à la base de données.");
            }
        }
        return self::$conn;
    }

    public static function getDriver(): string {
        return getenv('DATABASE_URL') ? 'pgsql' : 'mysql';
    }
}
