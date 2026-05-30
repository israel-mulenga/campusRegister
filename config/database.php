<?php

/**
 * Configuration de la base de données
 * Tentative de connexion MySQL, sinon fallback SQLite local (utile pour tests)
 */

// Paramètres MySQL par défaut (à adapter en production)
$host = 'localhost';
$dbname = 'campus_register';
$username = 'root';
$password = '';

// Options PDO communes
$pdoOptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

// Essayer MySQL d'abord
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, $pdoOptions);

} catch (PDOException $e) {
    // Si échec MySQL, basculer vers SQLite local pour permettre les tests
    $sqliteFile = __DIR__ . '/../data/campus_register.sqlite';
    $sqliteDir = dirname($sqliteFile);

    if (!is_dir($sqliteDir)) {
        mkdir($sqliteDir, 0755, true);
    }

    try {
        $db = new PDO('sqlite:' . $sqliteFile);
        // Appliquer les mêmes options compatibles
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Créer les tables minimales si elles n'existent pas
        $db->exec(
            "CREATE TABLE IF NOT EXISTS admins (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                nom TEXT,
                prenom TEXT,
                created_at DATETIME
            );"
        );

        $db->exec(
            "CREATE TABLE IF NOT EXISTS candidats (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nom TEXT,
                prenom TEXT,
                email TEXT,
                telephone TEXT,
                statut TEXT DEFAULT 'En attente',
                created_at DATETIME,
                updated_at DATETIME
            );"
        );

        // Insérer un admin par défaut si aucun n'existe (email: admin@local / motdepasse: admin)
        $stmt = $db->query("SELECT COUNT(*) as cnt FROM admins");
        $cnt = ($stmt->fetch(PDO::FETCH_ASSOC)['cnt']) ?? 0;
        if ($cnt == 0) {
            $pwHash = password_hash('admin', PASSWORD_BCRYPT);
            $ins = $db->prepare("INSERT INTO admins (email,password,nom,prenom,created_at) VALUES (:email,:password,:nom,:prenom, datetime('now'))");
            $ins->execute([':email' => 'admin@local', ':password' => $pwHash, ':nom' => 'Admin', ':prenom' => 'Local']);
        }

    } catch (PDOException $e2) {
        // Si tout échoue, afficher l'erreur (utile en dev)
        die('Erreur de connexion à la base de données (MySQL & SQLite échoués) : ' . $e->getMessage() . ' // ' . $e2->getMessage());
    }
}

// $db est disponible pour les modèles
