<?php
/**
 * Contrôleur Général : AdminController
 * Rôle : Gestion globale de l'UDBL (Inscriptions, Actualités, Documents, Événements)
 * Note : Utilisation de $_SESSION pour rendre le changement de statut persistant et automatique.
 */

class AdminController {
    
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Point d'entrée unique de l'administration
     */
    public function dashboard() {
        $message_success = "";
        $message_error = "";

        // --- 1. INITIALISATION DES DONNÉES EN SESSION POUR LE TEST (AUTOMATIQUE ET PERSISTANT) ---
        if (!isset($_SESSION['candidats_db'])) {
            $_SESSION['candidats_db'] = [
                [
                    'id' => 1, 
                    'reference' => 'UDBL-2026-XYZ', 
                    'nom' => 'KABANGE', 
                    'postnom' => 'MWAMBA', 
                    'prenom' => 'Idris',
                    'sexe' => 'M',
                    'nationalite' => 'Congolaise (RDC)',
                    'telephone' => '+243 812 345 678',
                    'email' => 'idris.kabange@example.com',
                    'faculte' => 'Sciences Informatiques',
                    'ecole_provenance' => 'Institut Tuendelee',
                    'option_secondaire' => 'Commerciale et Administrative',
                    'pourcentage' => '72%',
                    'annee_diplome' => '2025',
                    'statut' => 'En attente',
                    'document_type' => 'Diplôme d\'État / Attestation de réussite',
                    'document_url' => 'public/uploads/diplome_kabange.pdf'
                ],
                [
                    'id' => 2, 
                    'reference' => 'UDBL-2026-ABC', 
                    'nom' => 'ILUNGA', 
                    'postnom' => 'BANZA', 
                    'prenom' => 'Marie',
                    'sexe' => 'F',
                    'nationalite' => 'Congolaise (RDC)',
                    'telephone' => '+243 997 654 321',
                    'email' => 'marie.ilunga@example.com',
                    'faculte' => 'Gestion et Ingénierie Financières',
                    'ecole_provenance' => 'Lycée Kiwele',
                    'option_secondaire' => 'Sciences Commerciales',
                    'pourcentage' => '68%',
                    'annee_diplome' => '2024',
                    'statut' => 'Incomplet',
                    'document_type' => 'Bordereau de Versement des Frais d\'inscription',
                    'document_url' => 'public/uploads/bordereau_ilunga.jpg'
                ],
                [
                    'id' => 3, 
                    'reference' => 'UDBL-2026-KTS', 
                    'nom' => 'MWAMBA', 
                    'postnom' => 'KABULO', 
                    'prenom' => 'Jonathan',
                    'sexe' => 'M',
                    'nationalite' => 'Congolaise (RDC)',
                    'telephone' => '+243 824 555 111',
                    'email' => 'jonathan.mwamba@example.com',
                    'faculte' => 'Sciences Informatiques',
                    'ecole_provenance' => 'Collège Imara',
                    'option_secondaire' => 'Bio-Chimie',
                    'pourcentage' => '75%',
                    'annee_diplome' => '2025',
                    'statut' => 'En attente',
                    'document_type' => 'Diplôme d\'État',
                    'document_url' => 'public/uploads/diplome_jonathan.pdf'
                ]
            ];
        }

        // --- 2. INTERCEPTION ET ENREGISTREMENT EN TEMPS RÉEL DU CHANGEMENT DE STATUT ---
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_general'])) {
            switch ($_POST['action_general']) {
                case 'update_status':
                    $id = isset($_POST['id_dossier']) ? intval($_POST['id_dossier']) : 0;
                    $statut = htmlspecialchars($_POST['statut']);
                    
                    // On parcourt et on modifie DIRECTEMENT dans la SESSION de simulation
                    foreach ($_SESSION['candidats_db'] as $key => $candidat) {
                        if ($candidat['id'] === $id) {
                            $_SESSION['candidats_db'][$key]['statut'] = $statut;
                            $message_success = "Le statut de <strong>" . $candidat['nom'] . " " . $candidat['prenom'] . "</strong> a été modifié en [<strong>" . $statut . "</strong>] avec succès !";
                            break;
                        }
                    }
                    break;

                case 'add_article':
                    $message_success = "L'actualité a été publiée avec succès sur la page d'accueil !";
                    break;
                case 'add_doc':
                    $message_success = "Le document utile a été téléversé et est disponible au téléchargement.";
                    break;
            }
        }

        // On extrait les candidats mis à jour pour l'affichage de la page
        $candidats = $_SESSION['candidats_db'];

        // Données des compteurs fixes
        $stats = [
            'total_inscriptions' => count($candidats),
            'total_articles' => 6,
            'total_docs' => 3
        ];

        $articles = [
            ['id' => 104, 'titre' => 'DEUXIEME JOURNEE SCIENTIFIQUE 16 MAI 2026', 'date' => '18/05/2026'],
            ['id' => 103, 'titre' => 'PREMIER DES JOURNEES SCIENTIFIQUES DE LA FACULTE...', 'date' => '16/05/2026'],
            ['id' => 102, 'titre' => 'CLOTURE DE LA DEUXIEME FORMATION NUMERIQUE...', 'date' => '09/05/2026']
        ];

        // --- EN-TÊTE ET CODE HTML INTÉGRÉ DIRECTEMENT ---
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Direction Générale - Administration UDBL</title>
            
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            
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
            
            <?php if (!empty($message_success)): ?>
                <div class="alert alert-success shadow border-0 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo $message_success; ?>
                </div>
            <?php endif; ?>

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

            <div class="tab-content bg-white p-4 shadow-sm rounded border">
                
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
                                    
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-dark fw-bold px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCandidat<?php echo $cand['id']; ?>">
                                            <i class="fas fa-folder-open me-1 text-warning"></i> Vérifier le dossier
                                        </button>
                                    </td>

                                    <td>
                                        <span class="badge <?php echo ($cand['statut'] == 'Validé') ? 'bg-success' : (($cand['statut'] == 'Incomplet') ? 'bg-warning text-dark' : (($cand['statut'] == 'En attente') ? 'bg-secondary' : 'bg-danger')); ?>">
                                            <?php echo $cand['statut']; ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <form action="index.php?page=admin-dashboard" method="POST" class="d-inline-flex gap-2">
                                            <input type="hidden" name="action_general" value="update_status">
                                            <input type="hidden" name="id_dossier" value="<?php echo $cand['id']; ?>">
                                            <select name="statut" class="form-select form-select-sm" style="width:120px;" required>
                                                <option value="En attente" <?php if($cand['statut'] == 'En attente') echo 'selected'; ?>>En attente</option>
                                                <option value="Validé" <?php if($cand['statut'] == 'Validé') echo 'selected'; ?>>Valider</option>
                                                <option value="Incomplet" <?php if($cand['statut'] == 'Incomplet') echo 'selected'; ?>>Incomplet</option>
                                                <option value="Rejeté" <?php if($cand['statut'] == 'Rejeté') echo 'selected'; ?>>Rejeter</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm text-white bg-udbl-primary"><i class="fas fa-save"></i></button>
                                        </form>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalCandidat<?php echo $cand['id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-udbl-primary text-white">
                                                <h5 class="modal-title fw-bold"><i class="fas fa-id-card me-2"></i>Détails du Formulaire d'Inscription (<?php echo $cand['reference']; ?>)</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row g-4">
                                                    
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
                                                    
                                                    <div class="col-md-6">
                                                        <h6 class="text-uppercase fw-bold text-udbl-primary mb-3 border-bottom pb-1"><i class="fas fa-graduation-cap me-1"></i> Parcours d'Études</h6>
                                                        <p class="mb-2"><strong>Faculté Sollicitée :</strong> <span class="badge bg-primary"><?php echo $cand['faculte']; ?></span></p>
                                                        <p class="mb-2"><strong>École de provenance :</strong> <?php echo $cand['ecole_provenance']; ?></p>
                                                        <p class="mb-2"><strong>Option suivie au secondaire :</strong> <?php echo $cand['option_secondaire']; ?></p>
                                                        <p class="mb-2"><strong>Pourcentage Exétat :</strong> <strong class="text-success"><?php echo $cand['pourcentage']; ?></strong></p>
                                                        <p class="mb-2"><strong>Année d'obtention :</strong> <?php echo $cand['annee_diplome']; ?></p>
                                                    </div>

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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    }
}