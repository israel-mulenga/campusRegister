<?php $pageTitle = "Confirmation — UDBL 2026"; ?>
<?php require __DIR__ . '/../../../templates/components/header.php'; ?>

<div style="background:#fff;border-bottom:1px solid var(--border);padding:12px 0;">
  <div class="container-sm">
    <div class="steps">
      <div class="step-item done"><div class="step-circle">✓</div><div class="step-label">Informations</div></div>
      <div class="step-item done"><div class="step-circle">✓</div><div class="step-label">Validation</div></div>
      <div class="step-item active"><div class="step-circle">3</div><div class="step-label">Confirmation</div></div>
    </div>
  </div>
</div>

<div class="container-sm" style="padding:48px 0 64px;">
  <div class="text-center mb-4">
    <div style="font-size:4rem;margin-bottom:16px">🎉</div>
    <h1>Candidature soumise avec succès !</h1>
    <p class="text-muted">Votre dossier a bien été enregistré. Conservez les informations ci-dessous précieusement.</p>
  </div>

  <div class="card mb-3" style="border-left:5px solid var(--success);">
    <h3 style="color:var(--success);margin-bottom:18px">📄 Détails de votre dossier</h3>
    <table style="width:100%;border-collapse:collapse;">
      <?php foreach ([
        ['Numéro de dossier', $candidat['numero_dossier'], true],
        ['Token de suivi',    $candidat['token'],           true],
        ['Nom complet',       $candidat['nom'].' '.$candidat['prenom'], false],
        ['Email',             $candidat['email'],           false],
        ['Filière choisie',   $candidat['filiere_nom'] ?? '—', false],
        ['Statut',            '⏳ En attente de traitement', false],
        ['Date de dépôt',     date('d/m/Y à H:i'),          false],
      ] as [$label, $val, $highlight]): ?>
      <tr style="border-bottom:1px solid var(--border)">
        <td style="padding:10px 8px;font-weight:600;color:var(--primary);width:40%"><?= $label ?></td>
        <td style="padding:10px 8px;">
          <?php if ($highlight): ?>
          <code style="background:#f0f6ff;padding:4px 10px;border-radius:6px;font-size:.95rem;color:var(--primary);font-weight:700;user-select:all"><?= e($val) ?></code>
          <?php else: ?>
          <?= e($val) ?>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>

  <div class="alert alert-warning">
    <span>⚠️</span>
    <div><strong>Important :</strong> Votre token de suivi (<code><?= e($candidat['token']) ?></code>) vous a été envoyé par email. Vous en aurez besoin pour suivre l'état de votre dossier. Vérifiez vos spams si vous ne le recevez pas.</div>
  </div>

  <div class="card mb-3">
    <h3 style="margin-bottom:16px">📋 Prochaines étapes</h3>
    <?php foreach ([
      ['1','📧','Vérifiez votre email','Un email de confirmation avec votre numéro de dossier et votre token a été envoyé à '.$candidat['email'].'.'],
      ['2','⏳','Traitement de votre dossier','Notre équipe examinera votre candidature dans les meilleurs délais.'],
      ['3','🔔','Notification de décision','Vous recevrez un email dès que votre dossier sera traité (admis, complet ou en attente).'],
      ['4','🏫','Finalisation en présentiel','En cas d\'admission, présentez-vous au bureau des admissions avec vos documents originaux.'],
    ] as [$n,$icon,$titre,$desc]): ?>
    <div class="d-flex gap-2 mb-2 align-center">
      <div style="width:34px;height:34px;border-radius:50%;background:var(--accent);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0"><?= $n ?></div>
      <div><strong><?= $icon ?> <?= $titre ?></strong><br><span class="text-muted text-small"><?= $desc ?></span></div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="d-flex gap-2 justify-between flex-wrap">
    <a href="<?= APP_URL ?>/inscription/suivi" class="btn btn-primary">🔍 Suivre mon dossier</a>
    <a href="<?= APP_URL ?>/" class="btn btn-secondary">🏠 Retour à l'accueil</a>
  </div>
</div>

<?php require __DIR__ . '/../../../templates/componentsfooter.php'; ?>
