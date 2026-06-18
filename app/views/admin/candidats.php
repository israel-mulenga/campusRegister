<?php
$pageTitle = 'Candidats';
$pageIcon  = 'users';
require __DIR__ . '/_layout.php';
$statLabel = ['en_attente'=>'En attente','dossier_complet'=>'Dossier complet','admis'=>'Admis','refuse'=>'Refusé'];
$success = flash('success');
?>

<?php if ($success): ?>
    <div class="alert alert-success border-0 border-start border-success border-3 py-2">
        <i class="fas fa-check me-2"></i><?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<!-- Filtres -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="GET" action="" class="row g-2 align-items-end">
            <input type="hidden" name="url" value="admin/candidats">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="🔍 Nom, prénom, email, N° dossier…" value="<?= htmlspecialchars($filters['search']) ?>">
            </div>
            <div class="col-md-3">
                <select name="statut" class="form-select form-select-sm">
                    <option value="">Tous les statuts</option>
                    <?php foreach ($statLabel as $k=>$v): ?>
                        <option value="<?= $k ?>" <?= $filters['statut']===$k?'selected':'' ?>><?= $v ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="filiere" class="form-select form-select-sm">
                    <option value="">Toutes les filières</option>
                    <?php foreach ($filieres as $f): ?>
                        <option value="<?= $f['id'] ?>" <?= $filters['filiere']==$f['id']?'selected':'' ?>><?= htmlspecialchars($f['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-sm btn-primary w-100"><i class="fas fa-filter me-1"></i>Filtrer</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold text-muted">
            <i class="fas fa-list me-2 text-warning"></i>
            <?= $result['total'] ?> candidat<?= $result['total']>1?'s':'' ?> trouvé<?= $result['total']>1?'s':'' ?>
        </h6>
        <a href="index.php?url=admin/export-csv" class="btn btn-sm btn-outline-success">
            <i class="fas fa-download me-1"></i>CSV
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>N° Dossier</th><th>Nom & Prénom</th><th>Email</th><th>Filière</th><th>Statut</th><th>Date</th><th class="text-center">Action</th></tr>
            </thead>
            <tbody>
            <?php foreach ($result['data'] as $c): ?>
                <tr>
                    <td><code class="small text-primary"><?= htmlspecialchars($c['numero_dossier']) ?></code></td>
                    <td class="fw-semibold"><?= htmlspecialchars($c['nom'].' '.$c['prenom']) ?></td>
                    <td class="text-muted small"><?= htmlspecialchars($c['email']) ?></td>
                    <td><?= htmlspecialchars($c['filiere_nom'] ?? '—') ?></td>
                    <td><span class="badge-statut badge-<?= $c['statut'] ?>"><?= $statLabel[$c['statut']] ?? $c['statut'] ?></span></td>
                    <td class="text-muted small"><?= date('d/m/Y', strtotime($c['date_creation'])) ?></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalStatut<?= $c['id'] ?>">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
                <!-- Modal changement statut -->
                <div class="modal fade" id="modalStatut<?= $c['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-primary text-white border-0 py-2">
                                <h6 class="modal-title mb-0"><i class="fas fa-edit me-2"></i>Changer le statut</h6>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body pb-0">
                                <p class="small text-muted mb-2">Candidat : <strong><?= htmlspecialchars($c['nom'].' '.$c['prenom']) ?></strong></p>
                                <form method="POST" action="index.php?url=admin/candidats/statut">
                                    <?= csrfField() ?>
                                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                    <select name="statut" class="form-select form-select-sm mb-3">
                                        <?php foreach ($statLabel as $k=>$v): ?>
                                            <option value="<?= $k ?>" <?= $c['statut']===$k?'selected':'' ?>><?= $v ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="d-grid mb-2">
                                        <button class="btn btn-sm btn-primary"><i class="fas fa-save me-1"></i>Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <?php if ($result['pages'] > 1): ?>
    <div class="card-footer bg-white border-0 py-2">
        <nav><ul class="pagination pagination-sm mb-0 justify-content-center">
            <?php for ($p=1; $p<=$result['pages']; $p++): ?>
                <li class="page-item <?= $p===$result['current']?'active':'' ?>">
                    <a class="page-link" href="?url=admin/candidats&page=<?= $p ?>&search=<?= urlencode($filters['search']) ?>&statut=<?= $filters['statut'] ?>&filiere=<?= $filters['filiere'] ?>"><?= $p ?></a>
                </li>
            <?php endfor; ?>
        </ul></nav>
    </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/_layout_end.php'; ?>
