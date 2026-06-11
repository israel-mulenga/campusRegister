<?php
$pageTitle = 'Tableau de bord';
$pageIcon  = 'tachometer-alt';
require __DIR__ . '/_layout.php';

// Couleurs statuts
$statutColors = [
    'en_attente'      => ['bg'=>'#fff3cd','txt'=>'#7d5a00','icon'=>'clock'],
    'dossier_complet' => ['bg'=>'#cfe2ff','txt'=>'#084298','icon'=>'folder-open'],
    'admis'           => ['bg'=>'#d1e7dd','txt'=>'#0a3622','icon'=>'check-circle'],
    'refuse'          => ['bg'=>'#f8d7da','txt'=>'#58151c','icon'=>'times-circle'],
];
$statLabel = ['en_attente'=>'En attente','dossier_complet'=>'Dossier complet','admis'=>'Admis','refuse'=>'Refusé'];

// Construire tableau statuts indexé
$byStatut = [];
foreach ($statsStatut as $s) $byStatut[$s['statut']] = (int)$s['nb'];
?>

<!-- ── Cartes stats ─────────────────────────────────── -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card bg-white">
            <div class="icon" style="background:#e8eef8;color:#003366"><i class="fas fa-users"></i></div>
            <div><div class="value"><?= $total ?></div><div class="label">Total candidats</div></div>
        </div>
    </div>
    <?php foreach (['en_attente','dossier_complet','admis','refuse'] as $s): ?>
    <div class="col-6 col-lg-3">
        <div class="stat-card bg-white">
            <div class="icon" style="background:<?= $statutColors[$s]['bg'] ?>;color:<?= $statutColors[$s]['txt'] ?>">
                <i class="fas fa-<?= $statutColors[$s]['icon'] ?>"></i>
            </div>
            <div>
                <div class="value" style="color:<?= $statutColors[$s]['txt'] ?>"><?= $byStatut[$s] ?? 0 ?></div>
                <div class="label"><?= $statLabel[$s] ?></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- ── Graphiques ──────────────────────────────────── -->
<div class="row g-3 mb-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold text-muted"><i class="fas fa-chart-line me-2 text-warning"></i>Inscriptions des 14 derniers jours</h6>
            </div>
            <div class="card-body">
                <canvas id="chartActivity" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold text-muted"><i class="fas fa-chart-pie me-2 text-warning"></i>Répartition par filière</h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="chartFiliere" height="180"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- ── Derniers candidats ─────────────────────────── -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold text-muted"><i class="fas fa-user-clock me-2 text-warning"></i>Dernières inscriptions</h6>
        <a href="index.php?url=admin/candidats" class="btn btn-sm btn-outline-primary">Voir tout</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>N° Dossier</th><th>Nom & Prénom</th><th>Filière</th><th>Statut</th><th>Date</th></tr>
                </thead>
                <tbody>
                <?php foreach ($recentCandidats as $c): ?>
                    <tr>
                        <td><code class="small"><?= htmlspecialchars($c['numero_dossier']) ?></code></td>
                        <td class="fw-semibold"><?= htmlspecialchars($c['nom'].' '.$c['prenom']) ?></td>
                        <td><?= htmlspecialchars($c['filiere_nom'] ?? '—') ?></td>
                        <td><span class="badge-statut badge-<?= $c['statut'] ?>"><?= $statLabel[$c['statut']] ?? $c['statut'] ?></span></td>
                        <td class="text-muted small"><?= date('d/m/Y', strtotime($c['date_creation'])) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Graphique activité
const actData = <?= json_encode(array_column($activity, 'nb')) ?>;
const actLabels = <?= json_encode(array_map(fn($r)=>date('d/m',strtotime($r['jour'])),$activity)) ?>;
new Chart(document.getElementById('chartActivity'), {
    type:'line',
    data:{ labels:actLabels, datasets:[{ label:'Inscriptions', data:actData,
        borderColor:'#003366', backgroundColor:'rgba(0,51,102,.08)', fill:true, tension:.4, pointBackgroundColor:'#ffc107' }] },
    options:{ plugins:{legend:{display:false}}, scales:{ y:{beginAtZero:true,ticks:{precision:0}} } }
});
// Graphique filières
const filData = <?= json_encode(array_column($statsFiliere,'nb_candidats')) ?>;
const filLabels = <?= json_encode(array_column($statsFiliere,'nom')) ?>;
new Chart(document.getElementById('chartFiliere'), {
    type:'doughnut',
    data:{ labels:filLabels, datasets:[{ data:filData,
        backgroundColor:['#003366','#0055a5','#ffc107','#28a745','#dc3545','#6f42c1'], borderWidth:2 }] },
    options:{ plugins:{ legend:{ position:'bottom', labels:{ font:{size:11}, boxWidth:12 } } }, cutout:'60%' }
});
</script>

<?php require __DIR__ . '/_layout_end.php'; ?>
