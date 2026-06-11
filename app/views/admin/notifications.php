<?php
$pageTitle = 'Notifications';
$pageIcon  = 'bell';
require __DIR__ . '/_layout.php';
?>

<?php if ($success): ?>
    <div class="alert alert-info border-0 border-start border-info border-3 py-2">
        <i class="fas fa-info-circle me-2"></i><?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<div class="row g-3">
    <!-- Formulaire envoi -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold text-muted"><i class="fas fa-paper-plane me-2 text-warning"></i>Envoyer un email groupé</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?url=admin/notifications/send">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Destinataires</label>
                        <select name="groupe" class="form-select form-select-sm">
                            <option value="tous">Tous les candidats</option>
                            <option value="statut_en_attente">En attente</option>
                            <option value="statut_dossier_complet">Dossier complet</option>
                            <option value="statut_admis">Admis</option>
                            <option value="statut_refuse">Refusés</option>
                            <?php foreach ($filieres as $f): ?>
                                <option value="filiere_<?= $f['id'] ?>">Filière : <?= htmlspecialchars($f['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Sujet</label>
                        <input type="text" name="sujet" class="form-control form-control-sm" placeholder="Objet du message" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Message</label>
                        <textarea name="message" class="form-control form-control-sm" rows="6" placeholder="Contenu du message…" required></textarea>
                    </div>
                    <button class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-paper-plane me-1"></i>Envoyer
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Historique -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold text-muted"><i class="fas fa-history me-2 text-warning"></i>Historique des envois</h6>
            </div>
            <div class="table-responsive" style="max-height:520px;overflow-y:auto;">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light sticky-top">
                        <tr><th>Candidat</th><th>Contenu</th><th>Statut</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                    <?php if (empty($historique)): ?>
                        <tr><td colspan="4" class="text-center text-muted py-4 small">Aucune notification envoyée.</td></tr>
                    <?php else: ?>
                        <?php foreach ($historique as $n): ?>
                        <tr>
                            <td class="small fw-semibold">#<?= $n['id_candidat'] ?></td>
                            <td class="small text-muted" style="max-width:220px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis"><?= htmlspecialchars($n['contenu']) ?></td>
                            <td>
                                <?php if ($n['statut']==='envoye'): ?>
                                    <span class="badge bg-success" style="font-size:.65rem">Envoyé</span>
                                <?php else: ?>
                                    <span class="badge bg-danger" style="font-size:.65rem">Échoué</span>
                                <?php endif; ?>
                            </td>
                            <td class="small text-muted"><?= date('d/m H:i', strtotime($n['date_envoi'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/_layout_end.php'; ?>
