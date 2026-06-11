<?php

// Autoload PHPMailer (inclus manuellement sans Composer)
require_once __DIR__ . '/../../vendor/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../../vendor/PHPMailer/SMTP.php';
require_once __DIR__ . '/../../vendor/PHPMailer/Exception.php';
require_once __DIR__ . '/../models/Notification.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class NotificationService {

    private static function mailer(): PHPMailer {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USERNAME;
        $mail->Password   = MAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = MAIL_PORT;
        $mail->CharSet    = 'UTF-8';
        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        return $mail;
    }

    public static function sendConfirmation(array $candidat): bool {
        $sujet  = "✅ Confirmation de pré-inscription – UDBL 2026";
        $corps  = self::templateConfirmation($candidat);
        return self::send($candidat['email'], $candidat['nom'] . ' ' . $candidat['prenom'], $sujet, $corps, $candidat['id']);
    }

    public static function sendStatusUpdate(array $candidat, string $nouveauStatut): bool {
        $labels = [
            'dossier_complet' => '📋 Votre dossier est complet – UDBL',
            'admis'           => '🎉 Félicitations ! Vous êtes admis(e) à l\'UDBL',
            'refuse'          => 'ℹ️ Résultat de votre candidature – UDBL',
        ];
        $sujet = $labels[$nouveauStatut] ?? 'Mise à jour de votre dossier – UDBL';
        $corps = self::templateStatus($candidat, $nouveauStatut);
        return self::send($candidat['email'], $candidat['nom'] . ' ' . $candidat['prenom'], $sujet, $corps, $candidat['id']);
    }

    public static function sendBulk(array $candidats, string $sujet, string $message): int {
        $count = 0;
        foreach ($candidats as $c) {
            $corps = self::templateCustom($c, $message);
            if (self::send($c['email'], $c['nom'] . ' ' . $c['prenom'], $sujet, $corps, $c['id'])) {
                $count++;
            }
            usleep(100000); // 100ms entre chaque envoi
        }
        return $count;
    }

    private static function send(string $to, string $toName, string $subject, string $body, int $candidatId): bool {
        try {
            $mail = self::mailer();
            $mail->addAddress($to, $toName);
            $mail->Subject  = $subject;
            $mail->isHTML(true);
            $mail->Body     = $body;
            $mail->AltBody  = strip_tags($body);
            $mail->send();
            Notification::create($candidatId, 'email', $subject . ' — envoyé à ' . $to, 'envoye');
            return true;
        } catch (Exception $e) {
            Notification::create($candidatId, 'email', $subject . ' — ÉCHEC: ' . $e->getMessage(), 'echoue');
            error_log("Mail Error [{$to}]: " . $e->getMessage());
            return false;
        }
    }

    // ── Templates HTML ────────────────────────────────────────
    private static function header(): string {
        return '<!DOCTYPE html><html><head><meta charset="utf-8"><style>
            body{font-family:Segoe UI,Arial,sans-serif;background:#f4f6fb;margin:0;padding:0}
            .wrap{max-width:600px;margin:30px auto;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.1)}
            .hdr{background:linear-gradient(135deg,#1F3864,#2E74B5);padding:30px;text-align:center}
            .hdr h1{color:#fff;margin:0;font-size:22px;letter-spacing:1px}
            .hdr p{color:#a8c4e0;margin:6px 0 0;font-size:13px}
            .body{padding:32px 36px;color:#333;line-height:1.7}
            .box{background:#f0f6ff;border-left:4px solid #2E74B5;padding:14px 18px;border-radius:4px;margin:18px 0}
            .btn{display:inline-block;background:#2E74B5;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:bold;margin:16px 0}
            .ftr{background:#f9f9f9;padding:16px 36px;text-align:center;font-size:12px;color:#888;border-top:1px solid #eee}
        </style></head><body><div class="wrap"><div class="hdr">
        <h1>🎓 Université Don Bosco de Lubumbashi</h1>
        <p>Plateforme de Pré-inscription 2026</p></div><div class="body">';
    }

    private static function footer(): string {
        return '</div><div class="ftr">
        Université Don Bosco de Lubumbashi (UDBL) — Avenue Don Bosco, Lubumbashi, Haut-Katanga, RDC<br>
        <a href="mailto:info@udbl.ac.cd">info@udbl.ac.cd</a> | +243 810 000 000
        </div></div></body></html>';
    }

    private static function templateConfirmation(array $c): string {
        $url_suivi = rtrim(APP_URL, '/') . '/index.php?url=suivi-dossier';
        return self::header() . "
        <p>Bonjour <strong>{$c['nom']} {$c['prenom']}</strong>,</p>
        <p>Nous avons bien reçu votre pré-inscription à l'Université Don Bosco de Lubumbashi pour l'année académique 2025-2026. 🎉</p>
        <div class='box'>
            <strong>📄 Numéro de dossier :</strong> {$c['numero_dossier']}<br>
            <strong>🔑 Token de suivi :</strong> <code>{$c['token']}</code><br>
            <strong>📅 Date de soumission :</strong> " . date('d/m/Y à H:i') . "<br>
            <strong>📊 Statut actuel :</strong> En attente de traitement
        </div>
        <p><strong>Gardez précieusement ce token</strong> — il vous servira à consulter l'état de votre dossier à tout moment.</p>
        <a class='btn' href='{$url_suivi}'>Suivre mon dossier</a>
        <p>Notre équipe traitera votre dossier dans les meilleurs délais. Vous recevrez une notification à chaque étape du processus.</p>
        <p>Cordialement,<br><strong>L'équipe d'admission – UDBL</strong></p>
        " . self::footer();
    }

    private static function templateStatus(array $c, string $statut): string {
        $messages = [
            'dossier_complet' => [
                'titre' => '📋 Votre dossier est complet !',
                'corps' => "Toutes vos informations ont été vérifiées. Votre dossier est maintenant complet et sera soumis à la commission d'admission. Vous serez notifié(e) dès que la décision sera prise."
            ],
            'admis' => [
                'titre' => '🎉 Félicitations ! Vous êtes admis(e) !',
                'corps' => "Nous avons le plaisir de vous informer que votre candidature a été acceptée par la commission d'admission de l'UDBL. <br><br>Veuillez vous présenter au bureau des admissions dans les <strong>10 jours</strong> avec les originaux de vos documents pour finaliser votre inscription."
            ],
            'refuse' => [
                'titre' => 'ℹ️ Résultat de votre candidature',
                'corps' => "Après examen de votre dossier, nous regrettons de vous informer que votre candidature n'a pas été retenue cette année. <br><br>Nous vous encourageons à contacter l'administration pour connaître les voies de recours disponibles ou vous représenter lors de la prochaine session."
            ],
        ];
        $msg = $messages[$statut] ?? ['titre' => 'Mise à jour de votre dossier', 'corps' => 'Votre dossier a été mis à jour.'];
        $url_suivi = rtrim(APP_URL, '/') . '/index.php?url=suivi-dossier';

        return self::header() . "
        <p>Bonjour <strong>{$c['nom']} {$c['prenom']}</strong>,</p>
        <h2 style='color:#1F3864'>{$msg['titre']}</h2>
        <div class='box'>
            <strong>📄 Dossier :</strong> {$c['numero_dossier']}<br>
            <strong>📊 Nouveau statut :</strong> " . self::statutLabel($statut) . "
        </div>
        <p>{$msg['corps']}</p>
        <a class='btn' href='{$url_suivi}'>Suivre mon dossier</a>
        <p>Cordialement,<br><strong>L'équipe d'admission – UDBL</strong></p>
        " . self::footer();
    }

    private static function templateCustom(array $c, string $message): string {
        $url_suivi = rtrim(APP_URL, '/') . '/index.php?url=suivi-dossier';
        return self::header() . "
        <p>Bonjour <strong>{$c['nom']} {$c['prenom']}</strong>,</p>
        <p>" . nl2br(htmlspecialchars($message)) . "</p>
        <div class='box'><strong>Dossier :</strong> {$c['numero_dossier']}</div>
        <a class='btn' href='{$url_suivi}'>Suivre mon dossier</a>
        <p>Cordialement,<br><strong>L'équipe d'admission – UDBL</strong></p>
        " . self::footer();
    }

    private static function statutLabel(string $s): string {
        return match($s) {
            'en_attente'      => '<span style="color:#e67e22">⏳ En attente</span>',
            'dossier_complet' => '<span style="color:#2980b9">📋 Dossier complet</span>',
            'admis'           => '<span style="color:#27ae60">✅ Admis(e)</span>',
            'refuse'          => '<span style="color:#e74c3c">❌ Refusé(e)</span>',
            default           => $s
        };
    }
}