
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Direction Générale - Administration UDBL</title>
            
            <!-- Liaisons CSS CDN pour assurer un affichage parfait sans conflit de chemin -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            
            <!-- Rappel de vos fichiers locaux si présents -->
            <link rel="stylesheet" href="public/css/style.min.css">
            <link rel="stylesheet" href="public/css/custom.css">
            
            <style>
                body { background-color: #f8f9fa; font-family: sans-serif; padding-top: 90px; }
                .bg-udbl-primary { background-color: #003366 !important; }
                .text-udbl-primary { color: #003366 !important; }
                .border-udbl-warning { border-left: 5px solid #ffc107 !important; }
                .nav-tabs .nav-link.active {
                    background-color: #003366 !important;
                    color: #fff !important;
                    border-color: #003366 !important;
                }
                .nav-tabs .nav-link { color: #003366; font-weight: bold; }
                .table-align-middle td { vertical-align: middle; }
            </style>
        </head>
        <body>

        <!-- BARRE DE NAVIGATION ADMIN -->
        <nav class="navbar navbar-dark bg-udbl-primary fixed-top shadow">
            <div class="container-fluid px-4">
                <span class="navbar-brand d-flex align-items-center fw-bold" style="font-size: 1.25rem;">
                    <img src="public/images/LOGO-UDBL1.webp" alt="Logo" class="me-2" style="height: 40px; width: auto; onerror: this.style.display='none';">
                    UDBL - PANNEAU DE CONTROLE GLOBAL
                </span>
                <a href="index.php" class="btn btn-outline-light btn-sm fw-bold">
                    <i class="fas fa-globe me-1"></i> Quitter l'administration
                </a>
            </div>
        </nav>

        <div class="container">
            
            <!-- MESSAGES D'ALERTE -->
            <?php if (!empty($message_success)): ?>
                <div class="alert alert-success shadow border-0 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo $message_success; ?>
                </div>
            <?php endif; ?>

            <!-- COMPTEURS STATISTIQUES -->
            <div class="row g-3 mb-5">
                <div class="col-md-4">
                    <div class="card p-3 shadow-sm border-0 border-udbl-warning bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted text-uppercase fw-bold">Pré-inscriptions</small>
                                <h3 class="fw-bold text-udbl-primary mb-0"><?php echo $stats['total_inscriptions']; ?></h3>
                            </div>
                            <i class="fas fa-user-plus fa-2x text-muted opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 shadow-sm border-0 border-udbl-warning bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted text-uppercase fw-bold">Actualités en Ligne</small>
                                <h3 class="fw-bold text-udbl-primary mb-0"><?php echo $stats['total_articles']; ?></h3>
                            </div>
                            <i class="fas fa-newspaper fa-2x text-muted opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 shadow-sm border-0 border-udbl-warning bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted text-uppercase fw-bold">Documents Utiles</small>
                                <h3 class="fw-bold text-udbl-primary mb-0"><?php echo $stats['total_docs']; ?></h3>
                            </div>
                            <i class="fas fa-file-download fa-2x text-muted opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BLOC DES ONGLETS DE NAVIGATION GESTION -->
            <ul class="nav nav-tabs shadow-sm bg-white p-2 rounded mb-4" id="adminTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="tab-inscriptions" data-bs-toggle="tab" data-bs-target="#panel-inscriptions" type="button"><i class="fas fa-users me-2"></i> Inscriptions</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab-articles" data-bs-toggle="tab" data-bs-target="#panel-articles" type="button"><i class="fas fa-edit me-2"></i> Actualités</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab-documents" data-bs-toggle="tab" data-bs-target="#panel-documents" type="button"><i class="fas fa-file-invoice me-2"></i> Docs & Événements</button>
                </li>
            </ul>

            <!-- PANNEAUX DE CONTENU DES ONGLETS -->
            <div class="tab-content bg-white p-4 shadow-sm rounded border">
                
                <!-- GESTION DES PRE-INSCRIPTIONS -->
                <div class="tab-pane fade show active" id="panel-inscriptions">
                    <h4 class="fw-bold text-udbl-primary mb-4 border-bottom pb-2">Gestion et Statut des Candidats</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Référence</th>
                                    <th>Nom Complet</th>
                                    <th>Faculté</th>
                                    <th class="text-center">Dossier Formulaire</th>
                                    <th>Statut Actuel</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($candidats as $cand): ?>
                                <tr>
                                    <td><code class="fw-bold"><?php echo $cand['reference']; ?></code></td>
                                    <td class="fw-bold text-uppercase"><?php echo $cand['nom'] . " " . $cand['postnom'] . " " . $cand['prenom']; ?></td>
                                    <td><?php echo $cand['faculte']; ?></td>
                                    
                                    <!-- BOUTON VERIFIER : IMPORTANT POUR OUVRIR LE FORMULAIRE COMPLET -->
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-dark fw-bold px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCandidat<?php echo $cand['id']; ?>">
                                            <i class="fas fa-folder-open me-1 text-warning"></i> Vérifier le dossier
                                        </button>
                                    </td>

                                    <td>
                                        <span class="badge <?php echo ($cand['statut'] == 'Validé') ? 'bg-success' : (($cand['statut'] == 'Incomplet') ? 'bg-warning text-dark' : 'bg-danger'); ?>">
                                            <?php echo $cand['statut']; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <form action="index.php?page=admin-dashboard" method="POST" class="d-inline-flex gap-2">
                                            <input type="hidden" name="action_general" value="update_status">
                                            <input type="hidden" name="id_dossier" value="<?php echo $cand['id']; ?>">
                                            <select name="statut" class="form-select form-select-sm" style="width:120px;" required>
                                                <option value="Validé">Valider</option>
                                                <option value="Incomplet">Incomplet</option>
                                                <option value="Rejeté">Rejeter</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm text-white bg-udbl-primary"><i class="fas fa-save"></i></button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- BOÎTE MODALE CONTENANT TOUTES LES INFORMATIONS DU FORMULAIRE DE PRÉ-INSCRIPTION -->
                                <div class="modal fade" id="modalCandidat<?php echo $cand['id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-udbl-primary text-white">
                                                <h5 class="modal-title fw-bold"><i class="fas fa-id-card me-2"></i>Détails du Formulaire d'Inscription (<?php echo $cand['reference']; ?>)</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row g-4">
                                                    
                                                    <!-- INFORMATIONS PERSONNELLES -->
                                                    <div class="col-md-6 border-end">
                                                        <h6 class="text-uppercase fw-bold text-udbl-primary mb-3 border-bottom pb-1"><i class="fas fa-user me-1"></i> Données Personnelles & Contact</h6>
                                                        <p class="mb-2"><strong>Nom :</strong> <?php echo $cand['nom']; ?></p>
                                                        <p class="mb-2"><strong>Postnom :</strong> <?php echo $cand['postnom']; ?></p>
                                                        <p class="mb-2"><strong>Prénom :</strong> <?php echo $cand['prenom']; ?></p>
                                                        <p class="mb-2"><strong>Sexe :</strong> <?php echo $cand['sexe'] === 'M' ? 'Masculin' : 'Féminin'; ?></p>
                                                        <p class="mb-2"><strong>Nationalité :</strong> <?php echo $cand['nationalite']; ?></p>
                                                        <p class="mb-2"><strong>Téléphone :</strong> <?php echo $cand['telephone']; ?></p>
                                                        <p class="mb-2"><strong>E-mail :</strong> <?php echo $cand['email']; ?></p>
                                                    </div>
                                                    
                                                    <!-- CURRICULUM ACADÉMIQUE -->
                                                    <div class="col-md-6">
                                                        <h6 class="text-uppercase fw-bold text-udbl-primary mb-3 border-bottom pb-1"><i class="fas fa-graduation-cap me-1"></i> Parcours d'Études</h6>
                                                        <p class="mb-2"><strong>Faculté Sollicitée :</strong> <span class="badge bg-primary"><?php echo $cand['faculte']; ?></span></p>
                                                        <p class="mb-2"><strong>École de provenance :</strong> <?php echo $cand['ecole_provenance']; ?></p>
                                                        <p class="mb-2"><strong>Option suivie au secondaire :</strong> <?php echo $cand['option_secondaire']; ?></p>
                                                        <p class="mb-2"><strong>Pourcentage Exétat :</strong> <strong class="text-success"><?php echo $cand['pourcentage']; ?></strong></p>
                                                        <p class="mb-2"><strong>Année d'obtention :</strong> <?php echo $cand['annee_diplome']; ?></p>
                                                    </div>

                                                    <!-- VÉRIFICATION DU DOCUMENT SOUUMIS -->
                                                    <div class="col-12 mt-3 pt-3 border-top bg-light p-3 rounded">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h6 class="fw-bold mb-1 text-dark"><i class="fas fa-paperclip me-1 text-secondary"></i> Fichier justificatif associé :</h6>
                                                                <small class="text-muted">Type de document déposé : <?php echo $cand['document_type']; ?></small>
                                                            </div>
                                                            <a href="<?php echo $cand['document_url']; ?>" target="_blank" class="btn btn-primary fw-bold btn-sm">
                                                                <i class="fas fa-external-link-alt me-1"></i> Ouvrir / Inspecter le document
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-secondary fw-bold btn-sm" data-bs-dismiss="modal">Fermer la fiche</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- GESTION DES ACTUALITÉS -->
                <div class="tab-pane fade" id="panel-articles">
                    <div class="row">
                        <div class="col-lg-5 mb-4">
                            <h4 class="fw-bold text-udbl-primary mb-3">Ajouter un article (Accueil)</h4>
                            <form action="index.php?page=admin-dashboard" method="POST">
                                <input type="hidden" name="action_general" value="add_article">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Titre de l'événement / Actualité</label>
                                    <input type="text" class="form-control" required placeholder="Ex: DEUXIÈME JOURNÉE SCIENTIFIQUE">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Texte de l'article</label>
                                    <textarea class="form-control" rows="4" required placeholder="Description..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-warning text-dark fw-bold w-100">Publier l'actualité</button>
                            </form>
                        </div>
                        <div class="col-lg-7">
                            <h4 class="fw-bold text-udbl-primary mb-3">Flux d'actualités en ligne</h4>
                            <div class="list-group">
                                <?php foreach ($articles as $art): ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-bold small"><?php echo $art['titre']; ?></span><br>
                                            <small class="text-muted"><i class="fas fa-calendar-alt me-1"></i><?php echo $art['date']; ?></small>
                                        </div>
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GESTION DOCS ET EVENEMENTS -->
                <div class="tab-pane fade" id="panel-documents">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h4 class="fw-bold text-udbl-primary mb-3">Téléverser un Document</h4>
                            <form action="index.php?page=admin-dashboard" method="POST">
                                <input type="hidden" name="action_general" value="add_doc">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Intitulé du document</label>
                                    <input type="text" class="form-control" placeholder="Ex: Calendrier Académique" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Sélectionner le fichier</label>
                                    <input type="file" class="form-control" required>
                                </div>
                                <button type="submit" class="btn text-white bg-udbl-primary w-100 fw-bold">Mettre à disposition</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h4 class="fw-bold text-udbl-primary mb-3">Planifier un Événement</h4>
                            <form action="index.php?page=admin-dashboard" method="POST">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Nom de l'événement</label>
                                    <input type="text" class="form-control" placeholder="Ex: Remise des diplômes" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Date prévue</label>
                                    <input type="date" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-dark w-100 fw-bold">Inscrire au calendrier</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Script JS officiel Bootstrap 5 pour le fonctionnement natif des onglets et des modales (pop-up) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
