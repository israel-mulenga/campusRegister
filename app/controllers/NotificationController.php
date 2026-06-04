<?php

require_once __DIR__ . '/../models/Notification.php';

class NotificationController {
    private $notificationModel;

    public function __construct() {
        $this->notificationModel = new Notification();
    }

    public function envoyerConfirmationInscription(array $candidat) {
        if (empty($candidat['id']) || empty($candidat['nom']) || empty($candidat['prenom'])) {
            return false;
        }

        $canal = !empty($candidat['email']) ? 'email' : 'sms';
        $message = sprintf(
            'Bonjour %s %s, votre inscription a bien été reçue. Votre numéro de dossier est %s.',
            $candidat['prenom'],
            $candidat['nom'],
            $candidat['numeroDossier'] ?? 'N/A'
        );

        return $this->notificationModel->save([
            'idCandidat' => $candidat['id'],
            'canal' => $canal,
            'contenu' => $message,
            'status' => 'envoye'
        ]);
    }

    public function envoyerChangementStatut(array $candidat, $nouveauStatut) {
        if (empty($candidat['id']) || empty($candidat['nom']) || empty($candidat['prenom'])) {
            return false;
        }

        $libelles = [
            'dossier_complet' => 'Votre dossier est désormais complet.',
            'admis' => 'Félicitations, vous êtes admis.',
            'refuse' => 'Nous regrettons de vous informer que votre dossier est refusé.',
            'en_attente' => 'Votre dossier est toujours en attente de traitement.'
        ];

        $messageStatut = $libelles[$nouveauStatut] ?? 'Le statut de votre dossier a changé.';
        $canal = !empty($candidat['email']) ? 'email' : 'sms';
        $message = sprintf(
            'Bonjour %s %s, %s',
            $candidat['prenom'],
            $candidat['nom'],
            $messageStatut
        );

        return $this->notificationModel->save([
            'idCandidat' => $candidat['id'],
            'canal' => $canal,
            'contenu' => $message,
            'status' => 'envoye'
        ]);
    }
}
