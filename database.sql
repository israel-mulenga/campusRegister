-- ── CampusRegister DB — MySQL local development setup ────────────────────────
-- Run this file as a MySQL user with CREATE privileges, e.g.:
--   mysql -u root -p < database.sql
-- Then grant access:
--   CREATE USER IF NOT EXISTS 'CAMPUS_USER'@'localhost' IDENTIFIED BY '1234';
--   GRANT ALL PRIVILEGES ON CAMPUSREGISTER_DB.* TO 'CAMPUS_USER'@'localhost';
--   FLUSH PRIVILEGES;

CREATE DATABASE IF NOT EXISTS CAMPUSREGISTER_DB
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE CAMPUSREGISTER_DB;

-- ── Table 1 : filiere ────────────────────────────────────────
CREATE TABLE IF NOT EXISTS filiere (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nom         VARCHAR(100) NOT NULL,
  description TEXT,
  conditions  TEXT,
  nom_faculte ENUM('Sciences Informatiques','Théologie','Science de l\'homme et de la societé','Gestion et Ingénierie Financière') DEFAULT 'Sciences Informatiques',
  places_max  INT DEFAULT 50
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── Table 2 : candidat ───────────────────────────────────────
CREATE TABLE IF NOT EXISTS candidat (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  nom             VARCHAR(100) NOT NULL,
  prenom          VARCHAR(100) NOT NULL,
  email           VARCHAR(150) NOT NULL UNIQUE,
  telephone       VARCHAR(20),
  date_naissance  DATE,
  lieu_origine    VARCHAR(150),
  dernier_diplome VARCHAR(100),
  etablissement   VARCHAR(150),
  id_filiere      INT,
  statut          ENUM('en_attente','dossier_complet','admis','refuse') DEFAULT 'en_attente',
  token           VARCHAR(64) UNIQUE,
  numero_dossier  VARCHAR(20) UNIQUE,
  date_creation   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_filiere) REFERENCES filiere(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── Table 3 : notification ───────────────────────────────────
CREATE TABLE IF NOT EXISTS notification (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  id_candidat INT NOT NULL,
  canal       ENUM('email','sms') DEFAULT 'email',
  contenu     TEXT,
  date_envoi  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  statut      ENUM('envoye','echoue') DEFAULT 'envoye',
  FOREIGN KEY (id_candidat) REFERENCES candidat(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── Table 4 : chatbot_faq ─────────────────────────────────────
CREATE TABLE IF NOT EXISTS chatbot_faq (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  mot_cle       VARCHAR(200) NOT NULL,
  reponse       TEXT NOT NULL,
  categorie     VARCHAR(50),
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── Table 5 : administrateur ─────────────────────────────────
CREATE TABLE IF NOT EXISTS administrateur (
  id                 INT AUTO_INCREMENT PRIMARY KEY,
  nom                VARCHAR(100),
  email              VARCHAR(150) NOT NULL UNIQUE,
  mot_de_passe_hash  VARCHAR(255) NOT NULL,
  role               VARCHAR(50) DEFAULT 'admin',
  derniere_connexion TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── INDEX ─────────────────────────────────────────────────────
CREATE INDEX idx_email   ON candidat(email);
CREATE INDEX idx_token   ON candidat(token);
CREATE INDEX idx_statut  ON candidat(statut);
CREATE INDEX idx_filiere ON candidat(id_filiere);
CREATE INDEX idx_mot_cle ON chatbot_faq(mot_cle(50));

-- ── VUES ──────────────────────────────────────────────────────
CREATE OR REPLACE VIEW vue_stats_filieres AS
  SELECT f.nom, COUNT(c.id) AS nb_candidats
  FROM filiere f
  LEFT JOIN candidat c ON c.id_filiere = f.id
  GROUP BY f.id, f.nom;

CREATE OR REPLACE VIEW vue_stats_statuts AS
  SELECT statut, COUNT(*) AS nb
  FROM candidat
  GROUP BY statut;

-- ── SEEDS : filières UDBL ─────────────────────────────────────
INSERT INTO filiere (nom, description, conditions, nom_faculte, places_max) VALUES
('Génie Logiciel',
 'Formation en développement logiciel, algorithmique et systèmes d\'information.',
 'Diplôme d\'État avec mention en mathématiques ou sciences. Test d\'aptitude requis.',
 'Sciences Informatiques', 60),
('Sciences de Gestion',
 'Formation en management, comptabilité, finance et économie d\'entreprise.',
 'Diplôme d\'État toutes sections. Entretien de motivation.',
 'Gestion et Ingénierie Financière', 80),
('Droit',
 'Formation juridique générale incluant le droit congolais, civil et commercial.',
 'Diplôme d\'État toutes sections. Bonne expression écrite requise.',
 'Science de l\'homme et de la societé', 100),
('Sciences de l\'Éducation',
 'Formation des enseignants et cadres pédagogiques pour l\'enseignement supérieur.',
 'Diplôme d\'État. Expérience en enseignement appréciée.',
 'Science de l\'homme et de la societé', 70),
('Médecine Vétérinaire',
 'Formation en santé animale, médecine vétérinaire et production animale.',
 'Diplôme d\'État avec mention en biologie ou sciences naturelles.',
 'Science de l\'homme et de la societé', 40),
('Architecture',
 'Formation en conception architecturale, urbanisme et construction.',
 'Diplôme d\'État. Aptitudes en dessin technique requises.',
 'Science de l\'homme et de la societé', 45);

-- ── SEEDS : FAQ chatbot ───────────────────────────────────────
INSERT INTO chatbot_faq (mot_cle, reponse, categorie) VALUES
('filiere filieres formation formations disponible disponibles',
 'L\'UDBL propose 6 filières : Génie Logiciel, Sciences de Gestion, Droit, Sciences de l\'Éducation, Médecine Vétérinaire et Architecture.',
 'filières'),
('inscription inscrire comment démarche',
 'Pour vous inscrire, cliquez sur le bouton "Commencer ma pré-inscription" sur la page d\'accueil.',
 'inscription'),
('document documents dossier pièce pièces fournir apporter',
 'Vous devrez apporter : copie du Diplôme d\'État, acte de naissance, 2 photos passeport et le reçu du frais d\'inscription.',
 'documents'),
('frais coût combien prix montant',
 'Les frais de pré-inscription s\'élèvent à 5 000 FC. Contactez l\'administration pour les détails.',
 'frais'),
('date délai calendrier quand début ouverture fermeture',
 'Pré-inscriptions : 1er juin au 31 août 2026. Résultats : à partir du 15 septembre 2026.',
 'dates'),
('contact téléphone adresse email mail joindre appeler',
 'Téléphone : +243 810 000 000 | Email : info@udbl.ac.cd | Adresse : Avenue Don Bosco, Lubumbashi.',
 'contact'),
('condition conditions admission accepté refusé critère',
 'Chaque filière a ses propres conditions d\'admission. En général : Diplôme d\'État requis.',
 'admission'),
('statut dossier état suivre suivi voir consulter résultat',
 'Rendez-vous dans "Suivre mon dossier" avec votre email et votre token.',
 'suivi'),
('token code reçu perdu retrouver',
 'Votre token a été envoyé par email. Vérifiez votre boîte de réception et les spams.',
 'suivi'),
('délai réponse attente combien temps résultat',
 'Réponse définitive d\'admission à partir du 15 septembre 2026.',
 'délais'),
('génie logiciel informatique programmation développement',
 'Génie Logiciel : 3 ans, 60 étudiants. Diplôme d\'État avec mention en maths ou sciences.',
 'filières'),
('gestion comptabilité management finance économie',
 'Sciences de Gestion : 3 ans, 80 étudiants. Toutes sections du Diplôme d\'État.',
 'filières'),
('droit juridique avocat juge loi',
 'Droit : 3 ans, 100 étudiants. Formation juridique complète.',
 'filières'),
('médecine santé vétérinaire animal',
 'Médecine Vétérinaire : 3 ans, 40 étudiants. Mention biologie requise.',
 'filières'),
('architecture bâtiment construction urbanisme dessin',
 'Architecture : 3 ans, 45 étudiants. Aptitudes en dessin technique requises.',
 'filières'),
('éducation enseignement pédagogie professeur enseignant',
 'Sciences de l\'Éducation : 3 ans, 70 étudiants.',
 'filières'),
('udbl université don bosco lubumbashi',
 'L\'UDBL est une institution universitaire salésienne à Lubumbashi, RDC.',
 'général'),
('horaire heure ouverture bureau administration',
 'Bureau des admissions : lun–ven 8h–16h, sam 8h–12h.',
 'contact'),
('bonjour salut hello bjr bonsoir',
 'Bonjour ! Bienvenue sur l\'assistant virtuel de l\'UDBL. Comment puis-je vous aider ?',
 'général'),
('merci remercie au revoir bye',
 'De rien ! N\'hésitez pas à revenir. Bonne continuation !',
 'général');

-- ── SEED : super_admin (MDP: Admin2026!) ─────────────────────
INSERT INTO administrateur (nom, email, mot_de_passe_hash, role) VALUES
('Admin2026', 'admin@udbl.ac.cd',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
 'super_admin');
