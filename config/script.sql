-- ============================================================
--  UDBL Pré-inscription Platform — Base de données
--  Université Don Bosco de Lubumbashi
-- ============================================================

CREATE DATABASE IF NOT EXISTS udbl_preinscription
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE udbl_preinscription;

-- ── Table 1 : filiere ────────────────────────────────────────
CREATE TABLE IF NOT EXISTS filiere (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nom         VARCHAR(100) NOT NULL,
  description TEXT,
  conditions  TEXT,
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
  lieu_rigine    VARCHAR(150),
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
CREATE INDEX idx_email    ON candidat(email);
CREATE INDEX idx_token    ON candidat(token);
CREATE INDEX idx_statut   ON candidat(statut);
CREATE INDEX idx_filiere  ON candidat(id_filiere);
CREATE INDEX idx_mot_cle  ON chatbot_faq(mot_cle(50));

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
INSERT INTO filiere (nom, description, conditions, places_max) VALUES
('Génie Logiciel',
 'Formation en développement logiciel, algorithmique et systèmes d\'information.',
 'Diplôme d\'État avec mention en mathématiques ou sciences. Test d\'aptitude requis.',
 60),
('Sciences de Gestion',
 'Formation en management, comptabilité, finance et économie d\'entreprise.',
 'Diplôme d\'État toutes sections. Entretien de motivation.',
 80),
('Droit',
 'Formation juridique générale incluant le droit congolais, civil et commercial.',
 'Diplôme d\'État toutes sections. Bonne expression écrite requise.',
 100),
('Sciences de l\'Éducation',
 'Formation des enseignants et cadres pédagogiques pour l\'enseignement supérieur.',
 'Diplôme d\'État. Expérience en enseignement appréciée.',
 70),
('Médecine Vétérinaire',
 'Formation en santé animale, médecine vétérinaire et production animale.',
 'Diplôme d\'État avec mention en biologie ou sciences naturelles.',
 40),
('Architecture',
 'Formation en conception architecturale, urbanisme et construction.',
 'Diplôme d\'État. Aptitudes en dessin technique requises.',
 45);

-- ── SEEDS : FAQ chatbot ───────────────────────────────────────
INSERT INTO chatbot_faq (mot_cle, reponse, categorie) VALUES
('filiere filieres formation formations disponible disponibles',
 'L\'UDBL propose 6 filières : Génie Logiciel, Sciences de Gestion, Droit, Sciences de l\'Éducation, Médecine Vétérinaire et Architecture. Consultez la page d\'accueil pour les détails de chaque filière.',
 'filières'),
('inscription inscrire comment démarche',
 'Pour vous inscrire, cliquez sur le bouton "Commencer ma pré-inscription" sur la page d\'accueil. Remplissez le formulaire avec vos informations personnelles et académiques, choisissez votre filière et soumettez votre dossier.',
 'inscription'),
('document documents dossier pièce pièces fournir apporter',
 'Votre dossier de pré-inscription en ligne ne nécessite que vos informations personnelles et académiques. Pour la validation finale, vous devrez apporter : copie du Diplôme d\'État, acte de naissance, 2 photos passeport et le reçu du frais d\'inscription.',
 'documents'),
('frais coût combien prix montant',
 'Les frais de pré-inscription s\'élèvent à 5 000 FC (ou équivalent en USD). Les frais complets d\'inscription seront communiqués lors de la confirmation de votre admission. Contactez l\'administration pour les détails.',
 'frais'),
('date délai calendrier quand début ouverture fermeture',
 'Les pré-inscriptions sont ouvertes du 1er juin au 31 août 2026. Les résultats d\'admission seront communiqués à partir du 15 septembre 2026. La rentrée académique est prévue pour octobre 2026.',
 'dates'),
('contact téléphone adresse email mail joindre appeler',
 'Vous pouvez contacter l\'UDBL au : Téléphone : +243 810 000 000 | Email : info@udbl.ac.cd | Adresse : Avenue Don Bosco, Lubumbashi, Province du Haut-Katanga, RDC.',
 'contact'),
('condition conditions admission accepté refusé critère',
 'Chaque filière a ses propres conditions d\'admission. En général : être titulaire du Diplôme d\'État (ou équivalent), avoir une bonne moyenne générale. Certaines filières exigent des mentions spécifiques. Consultez les détails de chaque filière.',
 'admission'),
('statut dossier état suivre suivi voir consulter résultat',
 'Pour consulter l\'état de votre dossier, rendez-vous dans la section "Suivre mon dossier" et entrez votre adresse email ainsi que le token reçu par email lors de votre pré-inscription.',
 'suivi'),
('token code reçu perdu retrouver',
 'Votre token vous a été envoyé par email lors de votre pré-inscription. Vérifiez votre boîte de réception (et les spams). Si vous ne le retrouvez pas, contactez l\'administration avec votre adresse email et votre nom complet.',
 'suivi'),
('délai réponse attente combien temps résultat',
 'Après soumission de votre dossier de pré-inscription, vous recevrez une confirmation par email immédiatement. La réponse définitive d\'admission sera communiquée à partir du 15 septembre 2026.',
 'délais'),
('génie logiciel informatique programmation développement',
 'La filière Génie Logiciel forme des ingénieurs en développement logiciel, algorithmique, bases de données et systèmes d\'information. Durée : 3 ans (Licence). Capacité : 60 étudiants. Conditions : Diplôme d\'État avec mention en maths ou sciences.',
 'filières'),
('gestion comptabilité management finance économie',
 'La filière Sciences de Gestion couvre le management, la comptabilité, la finance et l\'économie. Durée : 3 ans. Capacité : 80 étudiants. Ouverte à toutes les sections du Diplôme d\'État.',
 'filières'),
('droit juridique avocat juge loi',
 'La filière Droit dispense une formation juridique complète incluant le droit congolais, civil, commercial et international. Durée : 3 ans. Capacité : 100 étudiants.',
 'filières'),
('médecine santé vétérinaire animal',
 'La filière Médecine Vétérinaire forme des spécialistes en santé animale. Durée : 3 ans. Capacité : 40 étudiants. Requiert le Diplôme d\'État avec mention en biologie.',
 'filières'),
('architecture bâtiment construction urbanisme dessin',
 'La filière Architecture forme des architectes et urbanistes. Durée : 3 ans. Capacité : 45 étudiants. Des aptitudes en dessin technique sont requises.',
 'filières'),
('éducation enseignement pédagogie professeur enseignant',
 'La filière Sciences de l\'Éducation prépare les futurs enseignants et cadres pédagogiques. Durée : 3 ans. Capacité : 70 étudiants.',
 'filières'),
('udbl université don bosco lubumbashi',
 'L\'Université Don Bosco de Lubumbashi (UDBL) est une institution universitaire salésienne au cœur du Haut-Katanga, en RDC. Elle offre des formations de qualité dans un environnement humain et chrétien. Fondée dans l\'esprit de Don Bosco, elle accompagne chaque étudiant dans son développement académique et personnel.',
 'général'),
('horaire heure ouverture bureau administration',
 'Le bureau des admissions de l\'UDBL est ouvert du lundi au vendredi de 8h00 à 16h00 et le samedi de 8h00 à 12h00. Adresse : Avenue Don Bosco, Lubumbashi.',
 'contact'),
('bonjour salut hello bjr bonsoir',
 'Bonjour ! Bienvenue sur l\'assistant virtuel de l\'UDBL. Je suis là pour répondre à vos questions sur les filières, les inscriptions, les conditions d\'admission et plus encore. Comment puis-je vous aider ?',
 'général'),
('merci remercie au revoir bye',
 'De rien ! N\'hésitez pas à revenir si vous avez d\'autres questions. L\'équipe de l\'UDBL est là pour vous accompagner dans votre projet académique. Bonne continuation !',
 'général');

-- ── SEEDS : admin par défaut (MDP: Admin2026!) ────────────────
-- Hash généré avec password_hash('Admin2026!', PASSWORD_DEFAULT)
INSERT INTO administrateur (nom, email, mot_de_passe_hash, role) VALUES
('Admin2026', 'admin@udbl.ac.cd',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
 'super_admin');

-- NOTE: Le hash ci-dessus correspond au mot de passe 'password'
-- Pour utiliser 'Admin2026!', exécutez ce PHP une fois :
-- echo password_hash('Admin2026!', PASSWORD_DEFAULT);
-- Puis mettez à jour : UPDATE administrateurs SET mot_de_passe_hash='...' WHERE email='admin@udbl.ac.cd';