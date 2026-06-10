<?php
$pageTitle = 'Chatbot FAQ';
$pageIcon  = 'robot';
require __DIR__ . '/_layout.php';
?>

<?php if ($success): ?>
    <div class="alert alert-success border-0 border-start border-success border-3 py-2">
        <i class="fas fa-check me-2"></i><?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<div class="row g-3">
    <!-- Ajouter une entrée -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold text-muted"><i class="fas fa-plus-circle me-2 text-warning"></i>Nouvelle entrée FAQ</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= APP_URL ?>/index.php?url=admin/chatbot/add">
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Mot(s)-clé(s)</label>
                        <input type="text" name="mot_cle" class="form-control form-control-sm" placeholder="ex: inscription inscrire comment" required>
                        <small class="text-muted">Séparez par des espaces</small>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Catégorie</label>
                        <input type="text" name="categorie" class="form-control form-control-sm" placeholder="ex: filières, frais, contact…" value="général">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Réponse</label>
                        <textarea name="reponse" class="form-control form-control-sm" rows="5" required></textarea>
                    </div>
                    <button class="btn btn-primary btn-sm w-100"><i class="fas fa-save me-1"></i>Ajouter</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Liste FAQ -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold text-muted"><i class="fas fa-list me-2 text-warning"></i><?= count($faqs) ?> entrée(s) dans la base</h6>
            </div>
            <div style="max-height:600px;overflow-y:auto;">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light sticky-top">
                        <tr><th style="width:30%">Mot(s)-clé(s)</th><th>Réponse</th><th style="width:90px">Catégorie</th><th class="text-center" style="width:80px">Actions</th></tr>
                    </thead>
                    <tbody>
                    <?php foreach ($faqs as $faq): ?>
                        <tr>
                            <td class="small"><code><?= htmlspecialchars(substr($faq['mot_cle'],0,60)) ?></code></td>
                            <td class="small text-muted" style="max-width:260px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis"><?= htmlspecialchars($faq['reponse']) ?></td>
                            <td><span class="badge bg-light text-dark border" style="font-size:.65rem"><?= htmlspecialchars($faq['categorie']) ?></span></td>
                            <td class="text-center">
                                <button class="btn btn-xs btn-outline-secondary py-0 px-1 me-1" data-bs-toggle="modal" data-bs-target="#editFaq<?= $faq['id'] ?>" title="Modifier"><i class="fas fa-edit fa-xs"></i></button>
                                <form method="POST" action="<?= APP_URL ?>/index.php?url=admin/chatbot/delete" class="d-inline" onsubmit="return confirm('Supprimer cette entrée ?')">
                                    <input type="hidden" name="id" value="<?= $faq['id'] ?>">
                                    <button class="btn btn-xs btn-outline-danger py-0 px-1" title="Supprimer"><i class="fas fa-trash fa-xs"></i></button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal édition -->
                        <div class="modal fade" id="editFaq<?= $faq['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-primary text-white border-0 py-2">
                                        <h6 class="modal-title mb-0">Modifier l'entrée</h6>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="<?= APP_URL ?>/index.php?url=admin/chatbot/update">
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $faq['id'] ?>">
                                            <div class="mb-2">
                                                <label class="form-label small fw-semibold">Mot(s)-clé(s)</label>
                                                <input type="text" name="mot_cle" class="form-control form-control-sm" value="<?= htmlspecialchars($faq['mot_cle']) ?>" required>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-semibold">Catégorie</label>
                                                <input type="text" name="categorie" class="form-control form-control-sm" value="<?= htmlspecialchars($faq['categorie']) ?>">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-semibold">Réponse</label>
                                                <textarea name="reponse" class="form-control form-control-sm" rows="4" required><?= htmlspecialchars($faq['reponse']) ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button class="btn btn-sm btn-primary"><i class="fas fa-save me-1"></i>Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/_layout_end.php'; ?>
