<?php
$pageTitle = "Confirmation — UDBL 2026";
require __DIR__ . '/../../../templates/components/header.php';
?>

<style>
    @keyframes popIn { from { transform: scale(.4); opacity:0; } to { transform: scale(1); opacity:1; } }
    @keyframes fadeUp { from { transform: translateY(20px); opacity:0; } to { transform: translateY(0); opacity:1; } }
    .confirm-hero { background: linear-gradient(135deg,#003366 0%,#0055a5 100%); padding: 3rem 1rem 4rem; text-align: center; }
    .confirm-icon { width: 90px; height: 90px; background: #fff; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
        font-size: 2.5rem; margin-bottom: 1rem; box-shadow: 0 8px 30px rgba(0,0,0,.2); animation: popIn .5s cubic-bezier(.34,1.56,.64,1) both; }
    .confirm-hero h1 { color:#fff; font-size:1.6rem; font-weight:700; margin-bottom:.4rem; animation: fadeUp .4s .1s both; }
    .confirm-hero p { color:rgba(255,255,255,.8); font-size:.95rem; animation: fadeUp .4s .2s both; }
    .confirm-card { background:#fff; border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,.08); overflow:hidden; animation: fadeUp .4s .3s both; }
    .info-row { display:flex; align-items:center; padding:.8rem 1rem; border-bottom:1px solid #f0f0f0; gap:.8rem; }
    .info-row:last-child { border-bottom:none; }
    .info-label { font-size:.72rem; text-transform:uppercase; color:#888; font-weight:700; letter-spacing:.5px; min-width:120px; flex-shrink:0; }
    .info-val { font-weight:600; color:#1a1a2e; font-size:.9rem; }
    .token-badge { background:#e8f0fe; color:#003366; font-family:monospace; font-size:.95rem; padding:.3rem .8rem; border-radius:8px; font-weight:700; user-select:all; cursor:pointer; }
    .step-item-confirm { display:flex; gap:.8rem; align-items:flex-start; padding:.7rem 0; border-bottom:1px solid #f5f5f5; }
    .step-item-confirm:last-child { border-bottom:none; }
    .step-num { width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;flex-shrink:0; }
    .btn-suivi { background:#003366; color:#fff; border:none; padding:.7rem 1.5rem; border-radius:10px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:.5rem; transition:.2s; }
    .btn-suivi:hover { background:#002244; color:#fff; }
    .btn-home { background:#f0f2f5; color:#444; border:none; padding:.7rem 1.5rem; border-radius:10px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:.5rem; transition:.2s; }
    .btn-home:hover { background:#e0e3e8; color:#333; }
    .copy-hint { font-size:.65rem; color:#aaa; margin-top:2px; }
</style>

<!-- Hero -->
<div class="confirm-hero">
    <div class="confirm-icon">✅</div>
    <h1>Candidature soumise avec succès !</h1>
    <p>Votre dossier a bien été enregistré. Conservez les informations ci-dessous précieusement.</p>
</div>

<div class="container" style="max-width:640px;margin-top:-2rem;padding-bottom:3rem;">

    <!-- Carte dossier -->
    <div class="confirm-card mb-3">
        <div style="background:#f8f9ff;padding:1rem 1.2rem;border-bottom:1px solid #eef;">
            <div style="font-size:.7rem;color:#888;text-transform:uppercase;font-weight:700;letter-spacing:.5px">📋 Détails de votre dossier</div>
        </div>
        <div class="info-row">
            <span class="info-label">N° Dossier</span>
            <span class="token-badge" onclick="copyText(this, '<?= e($candidat['numero_dossier']) ?>')"><?= e($candidat['numero_dossier']) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Token de suivi</span>
            <div>
                <span class="token-badge" onclick="copyText(this, '<?= e($candidat['token']) ?>')"><?= e($candidat['token']) ?></span>
                <div class="copy-hint">Cliquez pour copier</div>
            </div>
        </div>
        <div class="info-row">
            <span class="info-label">Nom complet</span>
            <span class="info-val"><?= e($candidat['nom'].' '.$candidat['prenom']) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-val"><?= e($candidat['email']) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Filière</span>
            <span class="info-val"><?= e($candidat['filiere_nom'] ?? '—') ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Statut</span>
            <span style="background:#fff8e1;color:#7d5a00;padding:.2rem .7rem;border-radius:20px;font-size:.78rem;font-weight:600">⏳ En attente</span>
        </div>
        <div class="info-row">
            <span class="info-label">Date de dépôt</span>
            <span class="info-val"><?= date('d/m/Y à H:i') ?></span>
        </div>
    </div>

    <!-- Alerte token -->
    <div style="background:#fff3cd;border-left:4px solid #ffc107;border-radius:10px;padding:1rem 1.2rem;margin-bottom:1rem;display:flex;gap:.8rem;align-items:flex-start;">
        <span style="font-size:1.2rem">⚠️</span>
        <div style="font-size:.88rem">
            <strong>Important :</strong> Votre token <code style="background:#ffe;padding:1px 6px;border-radius:4px"><?= e($candidat['token']) ?></code>
            a été envoyé à <strong><?= e($candidat['email']) ?></strong>. Vérifiez vos spams si vous ne le recevez pas.
        </div>
    </div>

    <!-- Prochaines étapes -->
    <div class="confirm-card mb-3">
        <div style="background:#f8f9ff;padding:1rem 1.2rem;border-bottom:1px solid #eef;">
            <div style="font-size:.7rem;color:#888;text-transform:uppercase;font-weight:700;letter-spacing:.5px">📌 Prochaines étapes</div>
        </div>
        <div style="padding:.8rem 1.2rem;">
            <?php foreach ([
                ['#e8f0fe','#003366','1','📧','Vérifiez votre email', 'Un email de confirmation avec votre numéro de dossier et votre token a été envoyé à '.$candidat['email'].'.'],
                ['#fff3cd','#7d5a00','2','⏳','Traitement du dossier', 'Notre équipe administrative examinera votre candidature dans les meilleurs délais.'],
                ['#e8f5e9','#0a3622','3','🔔','Notification de décision', 'Vous recevrez un email dès que votre dossier sera traité : admis, complet ou en attente.'],
                ['#fce4ec','#880e4f','4','🏫','Finalisation en présentiel', 'En cas d\'admission, présentez-vous au bureau des admissions avec vos documents originaux.'],
            ] as [$bg,$txt,$n,$icon,$titre,$desc]): ?>
            <div class="step-item-confirm">
                <div class="step-num" style="background:<?= $bg ?>;color:<?= $txt ?>"><?= $n ?></div>
                <div style="font-size:.88rem">
                    <strong><?= $icon ?> <?= $titre ?></strong><br>
                    <span style="color:#666"><?= $desc ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Boutons -->
    <div style="display:flex;gap:.8rem;flex-wrap:wrap;">
        <a href="<?= APP_URL ?>/index.php?url=suivi-dossier" class="btn-suivi">
            <i class="fas fa-search"></i> Suivre mon dossier
        </a>
        <a href="<?= APP_URL ?>/index.php" class="btn-home">
            <i class="fas fa-home"></i> Retour à l'accueil
        </a>
    </div>
</div>

<script>
function copyText(el, text) {
    navigator.clipboard.writeText(text).then(() => {
        const orig = el.textContent;
        el.textContent = '✅ Copié !';
        el.style.background = '#d1e7dd';
        setTimeout(() => { el.textContent = orig; el.style.background = ''; }, 1500);
    });
}
</script>

<?php require __DIR__ . '/../../../templates/components/footer.php'; ?>
