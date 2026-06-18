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
                    if (!$parsed || empty($parsed['host']) || empty($parsed['path'])) {
                        error_log('DATABASE_URL is malformed: unable to parse required components');
                        throw new \RuntimeException('Database configuration error. Please check the DATABASE_URL.');
                    }
                    $host   = $parsed['host'];
                    $port   = $parsed['port'] ?? 5432;
                    $dbname = ltrim($parsed['path'], '/');
                    $user   = urldecode($parsed['user'] ?? '');
                    $pass   = urldecode($parsed['pass'] ?? '');

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
                    // Local development — MySQL
                    self::$conn = new PDO(
                        "mysql:host=localhost;dbname=CAMPUSREGISTER_DB;charset=utf8mb4",
                        "CAMPUS_USER",
                        "1234",
                        [
                            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::ATTR_EMULATE_PREPARES   => false,
                        ]
                    );
                }
            } catch (PDOException $exception) {
                error_log('Database connection failed: ' . $exception->getMessage());
                throw new \RuntimeException(
                    'Impossible de se connecter à la base de données. Veuillez réessayer plus tard.'
                );
            }
        }
        return self::$conn;
    }

    public static function getDriver(): string {
        return getenv('DATABASE_URL') ? 'pgsql' : 'mysql';
    }
}
