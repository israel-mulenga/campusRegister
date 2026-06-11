<?php $pageTitle = "Confirmation — UDBL 2026"; ?>
<?php require __DIR__ . '/../../../templates/components/header.php'; ?>

<style>
  .confirmation-page {
    background: linear-gradient(135deg, #f8fafb 0%, #f0f4f8 100%);
    min-height: 100vh;
    padding: 40px 0;
  }
  .success-badge {
    display: inline-block;
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
    padding: 12px 24px;
    border-radius: 50px;
    font-weight: 600;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(34, 197, 94, 0.2);
  }
  .confirmation-header {
    text-align: center;
    margin-bottom: 40px;
  }
  .confirmation-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #003366;
    margin-bottom: 10px;
  }
  .info-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    margin-bottom: 24px;
    overflow: hidden;
    border-left: 5px solid #22c55e;
  }
  .info-card h3 {
    color: #003366;
    font-weight: 700;
    margin-bottom: 16px;
    padding: 16px 24px 8px;
  }
  .info-table {
    width: 100%;
    padding: 0 24px 24px;
  }
  .info-table tr {
    border-bottom: 1px solid #e5e7eb;
  }
  .info-table tr:last-child {
    border-bottom: none;
  }
  .info-table td {
    padding: 12px 0;
  }
  .info-table td:first-child {
    font-weight: 600;
    color: #003366;
    width: 40%;
  }
  .info-table code {
    background: #f0f6ff;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.95rem;
    color: #0d6efd;
    font-weight: 700;
    user-select: all;
    border: 1px solid #d0e4ff;
  }
  .warning-alert {
    background: #fef3c7;
    border: 1px solid #fcd34d;
    border-left: 4px solid #f59e0b;
    padding: 16px 20px;
    border-radius: 8px;
    margin-bottom: 24px;
  }
  .warning-alert strong {
    color: #92400e;
  }
  .steps-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 24px;
    margin-bottom: 24px;
  }
  .steps-card h3 {
    color: #003366;
    font-weight: 700;
    margin-bottom: 20px;
  }
  .step-row {
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
    align-items: flex-start;
  }
  .step-row:last-child {
    margin-bottom: 0;
  }
  .step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0d6efd 0%, #0551d0 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(13, 110, 253, 0.2);
  }
  .step-content strong {
    color: #003366;
    display: block;
    margin-bottom: 4px;
  }
  .step-content .text-muted {
    font-size: 0.95rem;
  }
  .action-buttons {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 32px;
  }
  .btn-success-custom {
    background: linear-gradient(135deg, #0d6efd 0%, #0551d0 100%);
    color: white;
    padding: 12px 28px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(13, 110, 253, 0.2);
    display: inline-block;
  }
  .btn-success-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    color: white;
    text-decoration: none;
  }
  .btn-secondary-custom {
    background: #f3f4f6;
    color: #003366;
    padding: 12px 28px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    border: 1px solid #e5e7eb;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-block;
  }
  .btn-secondary-custom:hover {
    background: #e5e7eb;
    transform: translateY(-2px);
    color: #003366;
    text-decoration: none;
  }
  @keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
  }
  .emoji-bounce {
    animation: bounce 1s infinite;
  }
</style>

<div class="confirmation-page">
  <div class="container-sm">
    <div class="confirmation-header">
      <div class="emoji-bounce" style="font-size: 5rem; margin-bottom: 20px;">🎉</div>
      <div class="success-badge">✓ Candidature reçue</div>
      <h1>Inscription soumise avec succès !</h1>
      <p class="text-muted" style="font-size: 1.05rem; color: #666;">Votre dossier a bien été enregistré. Conservez les informations ci-dessous.</p>
    </div>

    <div class="info-card">
      <h3>📄 Détails de votre dossier</h3>
      <table class="info-table">
        <?php foreach ([
          ['Numéro de dossier', $candidat['numero_dossier'], true],
          ['Token de suivi',    $candidat['token'],           true],
          ['Nom complet',       $candidat['nom'].' '.$candidat['prenom'], false],
          ['Email',             $candidat['email'],           false],
          ['Filière choisie',   $candidat['filiere_nom'] ?? '—', false],
          ['Statut',            '⏳ En attente de traitement', false],
          ['Date de dépôt',     date('d/m/Y à H:i'),          false],
        ] as [$label, $val, $highlight]): ?>
        <tr>
          <td><?= $label ?></td>
          <td>
            <?php if ($highlight): ?>
            <code><?= e($val) ?></code>
            <?php else: ?>
            <?= e($val) ?>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
    </div>

    <div class="warning-alert">
      <strong>⚠️ Important :</strong> Votre token de suivi (<code><?= e($candidat['token']) ?></code>) vous a été envoyé par email. Vous en aurez besoin pour suivre l'état de votre dossier. Vérifiez vos spams si vous ne le recevez pas.
    </div>

    <div class="steps-card">
      <h3>📋 Prochaines étapes</h3>
      <?php foreach ([
        ['1','📧','Vérifiez votre email','Un email de confirmation avec votre numéro de dossier et votre token a été envoyé à '.$candidat['email'].'.'],
        ['2','⏳','Traitement de votre dossier','Notre équipe examinera votre candidature dans les meilleurs délais.'],
        ['3','🔔','Notification de décision','Vous recevrez un email dès que votre dossier sera traité (admis, complet ou en attente).'],
        ['4','🏫','Finalisation en présentiel','En cas d\'admission, présentez-vous au bureau des admissions avec vos documents originaux.'],
      ] as [$n,$icon,$titre,$desc]): ?>
      <div class="step-row">
        <div class="step-number"><?= $n ?></div>
        <div class="step-content">
          <strong><?= $icon ?> <?= $titre ?></strong>
          <span class="text-muted"><?= $desc ?></span>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="action-buttons">
      <a href="<?= APP_URL ?>/?url=suivi-dossier" class="btn-success-custom">🔍 Suivre mon dossier</a>
      <a href="<?= APP_URL ?>/" class="btn-secondary-custom">🏠 Retour à l'accueil</a>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../../../templates/components/footer.php'; ?>
