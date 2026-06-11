<?php
// Layout partiel — inclus en haut de chaque vue admin
// Variables attendues : $pageTitle (string)
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Admin') ?> — UDBL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        :root { --udbl-blue: #003366; --udbl-gold: #ffc107; }
        body { background: #f0f2f5; font-size: .9rem; }

        /* ── Sidebar ── */
        #sidebar { width: 240px; min-height: 100vh; background: var(--udbl-blue); position: fixed; top: 0; left: 0; z-index: 1000; display: flex; flex-direction: column; }
        #sidebar .brand { padding: 1.2rem 1rem; border-bottom: 1px solid rgba(255,255,255,.1); display: flex; align-items: center; gap: .6rem; }
        #sidebar .brand img { width: 38px; }
        #sidebar .brand span { color: #fff; font-weight: 700; font-size: 1rem; }
        #sidebar .brand small { color: var(--udbl-gold); font-size: .65rem; display: block; font-weight: 600; }
        #sidebar nav { padding: 1rem 0; flex: 1; }
        #sidebar .nav-label { color: rgba(255,255,255,.35); font-size: .65rem; font-weight: 700; letter-spacing: 1px; padding: .8rem 1.2rem .3rem; text-transform: uppercase; }
        #sidebar a.nav-item { display: flex; align-items: center; gap: .7rem; padding: .6rem 1.2rem; color: rgba(255,255,255,.75); text-decoration: none; border-radius: 0; transition: all .2s; font-weight: 500; }
        #sidebar a.nav-item:hover, #sidebar a.nav-item.active { background: rgba(255,255,255,.1); color: #fff; border-left: 3px solid var(--udbl-gold); padding-left: calc(1.2rem - 3px); }
        #sidebar a.nav-item i { width: 18px; text-align: center; }
        #sidebar .sidebar-footer { padding: 1rem 1.2rem; border-top: 1px solid rgba(255,255,255,.1); }
        #sidebar .sidebar-footer .admin-name { color: #fff; font-weight: 600; font-size: .85rem; }
        #sidebar .sidebar-footer .admin-role { color: var(--udbl-gold); font-size: .7rem; text-transform: uppercase; }

        /* ── Main ── */
        #main { margin-left: 240px; min-height: 100vh; }
        .topbar { background: #fff; padding: .75rem 1.5rem; border-bottom: 1px solid #e0e0e0; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 999; }
        .topbar h5 { margin: 0; color: var(--udbl-blue); font-weight: 700; }
        .page-content { padding: 1.5rem; }

        /* ── Cards stats ── */
        .stat-card { border: none; border-radius: 12px; padding: 1.2rem 1.4rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,.07); }
        .stat-card .icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
        .stat-card .value { font-size: 1.8rem; font-weight: 700; line-height: 1; }
        .stat-card .label { font-size: .75rem; color: #777; font-weight: 500; text-transform: uppercase; letter-spacing: .5px; }

        /* ── Table ── */
        .table th { font-size: .75rem; text-transform: uppercase; letter-spacing: .5px; color: #555; border-top: none; }
        .badge-statut { padding: .3em .7em; border-radius: 20px; font-size: .72rem; font-weight: 600; }
        .badge-en_attente { background: #fff3cd; color: #7d5a00; }
        .badge-dossier_complet { background: #cfe2ff; color: #084298; }
        .badge-admis { background: #d1e7dd; color: #0a3622; }
        .badge-refuse { background: #f8d7da; color: #58151c; }

        @media(max-width:768px) { #sidebar { display: none; } #main { margin-left: 0; } }
    </style>
</head>
<body>

<!-- ══ SIDEBAR ══════════════════════════════════════════════ -->
<div id="sidebar">
    <div class="brand">
        <img src="public/images/LOGO-UDBL1.webp" alt="UDBL">
        <div><span>UDBL Admin</span><small>Pré-inscription</small></div>
    </div>
    <nav>
        <div class="nav-label">Principal</div>
        <a href="index.php?url=admin/dashboard" class="nav-item <?= ($pageTitle==='Tableau de bord')?'active':'' ?>">
            <i class="fas fa-tachometer-alt"></i> Tableau de bord
        </a>
        <a href="index.php?url=admin/candidats" class="nav-item <?= ($pageTitle==='Candidats')?'active':'' ?>">
            <i class="fas fa-users"></i> Candidats
        </a>
        <div class="nav-label">Outils</div>
        <a href="index.php?url=admin/notifications" class="nav-item <?= ($pageTitle==='Notifications')?'active':'' ?>">
            <i class="fas fa-bell"></i> Notifications
        </a>
        <a href="index.php?url=admin/chatbot" class="nav-item <?= ($pageTitle==='Chatbot FAQ')?'active':'' ?>">
            <i class="fas fa-robot"></i> Chatbot FAQ
        </a>
        <a href="index.php?url=admin/export-csv" class="nav-item">
            <i class="fas fa-file-csv"></i> Exporter CSV
        </a>
        <div class="nav-label">Site</div>
        <a href="index.php" class="nav-item" target="_blank">
            <i class="fas fa-globe"></i> Voir le site
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="admin-name"><i class="fas fa-user-circle me-1"></i><?= htmlspecialchars($_SESSION['admin_nom'] ?? 'Admin') ?></div>
        <div class="admin-role"><?= htmlspecialchars($_SESSION['admin_role'] ?? 'admin') ?></div>
        <a href="index.php?url=admin/logout" class="btn btn-sm btn-outline-warning mt-2 w-100">
            <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
        </a>
    </div>
</div>

<!-- ══ MAIN ══════════════════════════════════════════════════ -->
<div id="main">
    <div class="topbar">
        <h5><i class="fas fa-<?= $pageIcon ?? 'circle' ?> me-2 text-warning"></i><?= htmlspecialchars($pageTitle ?? '') ?></h5>
        <span class="text-muted small"><?= date('d/m/Y H:i') ?></span>
    </div>
    <div class="page-content">
