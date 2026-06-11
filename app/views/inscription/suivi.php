<?php
// ── Suivi de dossier — connecté à la BD via InscriptionController ──
$candidat_trouve = $candidat ?? null;
$message_erreur  = $error ?? null;

// Variables APP_URL disponibles via config/app.php chargé dans index.php

$statuts = [
    'en_attente'      => ['label'=>'En attente de traitement', 'color'=>'#ffc107','bg'=>'#fff8e1','icon'=>'clock',        'step'=>1],
    'dossier_complet' => ['label'=>'Dossier complet',          'color'=>'#0d6efd','bg'=>'#e8f0fe','icon'=>'folder-open',  'step'=>2],
    'admis'           => ['label'=>'Admis — Félicitations !',  'color'=>'#198754','bg'=>'#e8f5e9','icon'=>'check-circle', 'step'=>3],
    'refuse'          => ['label'=>'Dossier non retenu',       'color'=>'#dc3545','bg'=>'#fce8e8','icon'=>'times-circle', 'step'=>3],
];

?>

<div class="container my-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            <!-- Titre -->
            <div class="text-center mb-4">
                <h2 style="color:#003366;font-weight:700;text-transform:uppercase;">
                    <i class="fas fa-search me-2"></i>Suivi de mon Dossier
                </h2>
                <p class="text-muted">Entrez votre email et le token reçu lors de votre inscription.</p>
                <hr style="width:60px;height:4px;background:#ffc107;margin:10px auto;opacity:1;border:none;border-radius:2px;">
            </div>

            <!-- Erreur -->
            <?php if ($message_erreur): ?>
                <div class="alert alert-danger border-0 border-start border-danger border-3 shadow-sm">
                    <i class="fas fa-exclamation-triangle me-2"></i><?= htmlspecialchars($message_erreur) ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire -->
            <?php if (!$candidat_trouve): ?>
            <div class="card shadow-sm border-0" style="border-top:4px solid #003366!important;border-radius:12px;">
                <div class="card-body p-4">
                    <form method="POST" action="<?= APP_URL ?>/?url=suivi-dossier">
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="color:#003366">Adresse Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="votre.email@exemple.com" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold" style="color:#003366">Token de suivi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-key text-muted"></i></span>
                                <input type="text" name="token" class="form-control" placeholder="Token reçu par email" required>
                            </div>
                            <small class="text-muted">Ce token vous a été envoyé par email après votre pré-inscription.</small>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn fw-bold py-2" style="background:#003366;color:#fff;border-radius:8px;">
                                <i class="fas fa-search me-1"></i>Vérifier mon dossier
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Aide -->
            <div class="alert alert-light border mt-3 small">
                <i class="fas fa-info-circle text-primary me-2"></i>
                Vous n'avez pas reçu de token ? Vérifiez vos spams ou contactez-nous à <strong>infos@udbl.ac.cd</strong>.
            </div>

            <?php else:
                $s = $statuts[$candidat_trouve['statut']] ?? $statuts['en_attente'];
                $step = $s['step'];
            ?>

            <!-- Résultat -->
            <div class="card shadow border-0 mb-4" style="border-radius:12px;overflow:hidden;">
                <!-- Header carte candidat -->
                <div class="p-4 text-white" style="background:linear-gradient(135deg,#003366,#0055a5);">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:56px;height:56px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold"><?= htmlspecialchars($candidat_trouve['prenom'].' '.$candidat_trouve['nom']) ?></h5>
                            <small style="opacity:.8"><?= htmlspecialchars($candidat_trouve['filiere_nom'] ?? '—') ?></small>
                        </div>
                        <div class="ms-auto text-end">
                            <div style="font-size:.7rem;opacity:.7">N° DOSSIER</div>
                            <code style="font-size:.9rem;color:#ffc107"><?= htmlspecialchars($candidat_trouve['numero_dossier']) ?></code>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Barre de progression -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <?php
                            $steps = [1=>'Soumis',2=>'En cours',3=>($candidat_trouve['statut']==='refuse'?'Refusé':'Admis')];
                            foreach ($steps as $n=>$label):
                                $done = $step >= $n;
                            ?>
                            <div class="text-center" style="flex:1">
                                <div class="mx-auto mb-1 rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                    style="width:32px;height:32px;font-size:.8rem;
                                    background:<?= $done ? ($candidat_trouve['statut']==='refuse'&&$n===3?'#dc3545':'#003366') : '#e0e0e0' ?>;
                                    color:<?= $done ? '#fff' : '#999' ?>">
                                    <?= $n ?>
                                </div>
                                <div style="font-size:.7rem;color:<?= $done?'#003366':'#aaa' ?>;font-weight:<?= $done?'600':'400' ?>"><?= $label ?></div>
                            </div>
                            <?php if ($n < 3): ?>
                                <div style="flex:1;height:2px;margin-top:15px;background:<?= $step > $n ? '#003366' : '#e0e0e0' ?>"></div>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>

                    <!-- Badge statut -->
                    <div class="p-3 rounded-3 mb-4 d-flex align-items-center gap-3"
                        style="background:<?= $s['bg'] ?>;border-left:4px solid <?= $s['color'] ?>">
                        <i class="fas fa-<?= $s['icon'] ?> fa-2x" style="color:<?= $s['color'] ?>"></i>
                        <div>
                            <div class="fw-bold" style="color:<?= $s['color'] ?>"><?= $s['label'] ?></div>
                            <?php if ($candidat_trouve['statut'] === 'en_attente'): ?>
                                <small class="text-muted">Votre dossier est en cours d'examen par l'équipe administrative.</small>
                            <?php elseif ($candidat_trouve['statut'] === 'dossier_complet'): ?>
                                <small class="text-muted">Votre dossier est complet. La décision finale sera communiquée prochainement.</small>
                            <?php elseif ($candidat_trouve['statut'] === 'admis'): ?>
                                <small class="text-muted">Bienvenue à l'UDBL ! Présentez-vous au bureau des admissions avec vos pièces originales.</small>
                            <?php else: ?>
                                <small class="text-muted">Votre dossier n'a pas été retenu. Contactez l'administration pour plus d'informations.</small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Infos dossier -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="p-2 bg-light rounded small">
                                <div class="text-muted" style="font-size:.65rem;text-transform:uppercase;font-weight:600">Email</div>
                                <div><?= htmlspecialchars($candidat_trouve['email']) ?></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded small">
                                <div class="text-muted" style="font-size:.65rem;text-transform:uppercase;font-weight:600">Téléphone</div>
                                <div><?= htmlspecialchars($candidat_trouve['telephone'] ?? '—') ?></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded small">
                                <div class="text-muted" style="font-size:.65rem;text-transform:uppercase;font-weight:600">Dernier diplôme</div>
                                <div><?= htmlspecialchars($candidat_trouve['dernier_diplome'] ?? '—') ?></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded small">
                                <div class="text-muted" style="font-size:.65rem;text-transform:uppercase;font-weight:600">Date d'inscription</div>
                                <div><?= date('d/m/Y', strtotime($candidat_trouve['date_creation'])) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="<?= APP_URL ?>/?url=suivi-dossier" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Nouvelle recherche
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>
