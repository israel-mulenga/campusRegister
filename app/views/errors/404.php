<?php // app/views/errors/404.php ?>
<!DOCTYPE html>
<html lang="fr"><head><meta charset="UTF-8"><title>Page introuvable — UDBL</title>
<link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css"></head>
<body style="display:flex;align-items:center;justify-content:center;min-height:100vh;text-align:center">
<div>
  <div style="font-size:5rem">🔍</div>
  <h1 style="font-size:4rem;color:var(--primary)">404</h1>
  <h2>Page introuvable</h2>
  <p class="text-muted">La page que vous cherchez n'existe pas ou a été déplacée.</p>
  <a href="<?= APP_URL ?>/" class="btn btn-primary mt-3">🏠 Retour à l'accueil</a>
</div>
</body></html>
