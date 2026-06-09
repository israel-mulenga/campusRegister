<?php

require_once __DIR__ ."../models/Candidat.php";
require_once __DIR__ ."../models/Filiere.php";
require_once __DIR__ ."../../config/database.php";

class InscriptionController {

    public function index(): void {
        $filieres = Filiere::findAll();
        $errors   = flash('errors') ? json_decode(flash('errors'), true) : [];
        $old      = flash('old')    ? json_decode(flash('old'), true)    : [];
        require __DIR__ . '/../views/inscription/formulaire.php';
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('/inscription'); }

        $data   = $_POST;
        $errors = [];

        // ── Validation ────────────────────────────────────────
        $required = ['nom','prenom','email','id_filiere'];
        foreach ($required as $field) {
            if (empty(trim($data[$field] ?? ''))) {
                $errors[$field] = 'Ce champ est obligatoire.';
            }
        }
        if (empty($errors['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Adresse email invalide.';
        }
        if (empty($errors['email']) && Candidat::findByEmail($data['email'])) {
            $errors['email'] = 'Cette adresse email est déjà enregistrée.';
        }
        if (!empty($data['telephone']) && !preg_match('/^(\+243|0)[0-9]{9}$/', preg_replace('/\s/','',$data['telephone']))) {
            $errors['telephone'] = 'Format invalide. Ex: +243810000000 ou 0810000000';
        }

        if ($errors) {
            flash('errors', json_encode($errors));
            flash('old',    json_encode($data));
            redirect('/inscription');
        }

        // ── Sauvegarde ────────────────────────────────────────
        $token = generateToken(16);
        $id    = Candidat::create([
            'nom'             => sanitize($data['nom']),
            'prenom'          => sanitize($data['prenom']),
            'email'           => strtolower(trim($data['email'])),
            'telephone'       => sanitize($data['telephone'] ?? ''),
            'date_naissance'  => $data['date_naissance'] ?? null,
            'lieu_origine'    => sanitize($data['lieu_origine'] ?? ''),
            'dernier_diplome' => sanitize($data['dernier_diplome'] ?? ''),
            'etablissement'   => sanitize($data['etablissement'] ?? ''),
            'id_filiere'      => (int)$data['id_filiere'],
            'token'           => $token,
            'numero_dossier'  => generateNumeroDossier($id ?? 0),
        ]);

        // Mettre à jour le numéro de dossier avec l'ID réel
        $db = DatabaseConfig::getConnection();
        $db->prepare("UPDATE candidat SET numero_dossier = ? WHERE id = ?")
           ->execute([generateNumeroDossier($id), $id]);

        $candidat = Candidat::findWithFiliere($id);

        // ── Notification email ────────────────────────────────
        try {
            NotificationService::sendConfirmation($candidat);
        } catch (\Throwable $e) {
            error_log("Notification error: " . $e->getMessage());
        }

        $_SESSION['confirmation_candidat'] = $candidat;
        redirect('/inscription/confirmation');
    }

    public function confirmation(): void {
        $candidat = $_SESSION['confirmation_candidat'] ?? null;
        if (!$candidat) { redirect('/inscription'); }
        require __DIR__ . '/../views/inscription/confirmation.php';
    }

    public function suivi(): void {
        $candidat      = null;
        $notifications = [];
        $error         = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = strtolower(trim($_POST['email'] ?? ''));
            $token = trim($_POST['token'] ?? '');

            if ($email && $token) {
                $candidat = Candidat::findByEmailAndToken($email, $token);
                if ($candidat) {
                    $notifications = Notification::forCandidat($candidat['id']);
                } else {
                    $error = 'Aucun dossier trouvé avec ces identifiants. Vérifiez votre email et votre token.';
                }
            } else {
                $error = 'Veuillez renseigner votre email et votre token.';
            }
        }
        require __DIR__ . '/../views/inscription/suivi.php';
    }
}