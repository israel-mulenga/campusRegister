-- 1. Création de la base de données
CREATE DATABASE IF NOT EXISTS campusdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE campusdb;

-- ==========================================
-- 2. Création des tables (Ordre respectant les dépendances)
-- ==========================================

-- Table 1 : Les Filières (Indépendante)
CREATE TABLE filiere (
    id INT AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    conditions TEXT,
    places_max INT,
    CONSTRAINT pk_filieres PRIMARY KEY (id)
) ENGINE=InnoDB;

-- Table 2 : Les Administrateurs (Indépendante)
CREATE TABLE admin (
    id INT AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    CONSTRAINT pk_administrateurs PRIMARY KEY (id),
    CONSTRAINT uq_admin_email UNIQUE (email)
) ENGINE=InnoDB;

-- Table 3 : Les Candidats (Dépend des filières)
CREATE TABLE candidat (
    id INT AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telephone VARCHAR(20),
    idFiliere INT,
    status ENUM('en_attente', 'dossier_complet', 'admis', 'refuse') DEFAULT 'en_attente',
    token VARCHAR(64) NOT NULL,
    numeroDossier VARCHAR(20) NOT NULL,
    dateCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_candidats PRIMARY KEY (id),
    CONSTRAINT uq_candidat_email UNIQUE (email),
    CONSTRAINT uq_candidat_token UNIQUE (token),
    CONSTRAINT fk_candidats_filieres FOREIGN KEY (idFiliere) 
        REFERENCES filiere(id) 
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- Table 4 : Les Notifications (Dépend des candidats)
CREATE TABLE notification (
    id INT AUTO_INCREMENT,
    idCandidat INT NOT NULL,
    canal ENUM('email', 'sms') NOT NULL,
    contenu TEXT NOT NULL,
    dateEnvoi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('envoye', 'echoue') DEFAULT 'envoye',
    CONSTRAINT pk_notifications PRIMARY KEY (id),
    CONSTRAINT fk_notifications_candidats FOREIGN KEY (idCandidat) 
        REFERENCES candidat(id) 
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table 5 : Le Chatbot FAQ (Indépendante)
CREATE TABLE chatbot_faq (
    id INT AUTO_INCREMENT,
    motCle VARCHAR(200) NOT NULL,
    reponse TEXT NOT NULL,
    categorie VARCHAR(50),
    dateCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_chatbot_faq PRIMARY KEY (id)
) ENGINE=InnoDB;