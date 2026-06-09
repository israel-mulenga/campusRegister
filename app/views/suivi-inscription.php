<?php
// Simulation d'une base de données de test (À remplacer plus tard par vos requêtes SQL)
$message_erreur = "";
$candidat_trouve = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-suivi'])) {
    $num_dossier = trim(htmlspecialchars($_POST['num_dossier']));
    $email = trim(htmlspecialchars($_POST['email']));

    if (!empty($num_dossier) && !empty($email)) {
        
        // --- EXEMPLE DE BASE DE DONNÉES SIMULÉE ---
        // Dans la réalité, vous ferez une requête SQL : 
        // "SELECT * FROM pre_inscriptions WHERE reference = :ref AND email = :email"
        $mock_db = [
            [
                'reference' => 'UDBL-2026-XYZ',
                'email' => 'etudiant@example.com',
                'nom' => 'KABANGE',
                'prenom' => 'Idris',
                'faculte' => 'Sciences Informatiques',
                'statut' => 'Validé', // Statuts possibles : En attente, Validé, Rejeté, Incomplet
                'commentaire' => 'Votre dossier est complet. Veuillez passer au guichet académique pour le dépôt des pièces physiques.'
            ],
            [
                'reference' => 'UDBL-2026-ABC',
                'email' => 'candidate@example.com',
                'nom' => 'ILUNGA',
                'prenom' => 'Marie',
                'faculte' => 'Gestion et Ingénierie Financières',
                'statut' => 'Incomplet',
                'commentaire' => 'Il manque la photocopie certifiée de votre diplôme d\'État. Veuillez la téléverser à nouveau.'
            ]
        ];

        // Recherche du candidat dans notre simulation
        foreach ($mock_db as $candidat) {
            if (strtoupper($candidat['reference']) === strtoupper($num_dossier) && strtolower($candidat['email']) === strtolower($email)) {
                $candidat_trouve = $candidat;
                break;
            }
        }

        if (!$candidat_trouve) {
            $message_erreur = "Aucun dossier trouvé avec ces identifiants. Vérifiez votre numéro de dossier et votre e-mail.";
        }
    } else {
        $message_erreur = "Veuillez remplir tous les champs.";
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <!-- TITRE DU MODULE -->
            <div class="text-center mb-4">
                <h2 style="color: #003366; font-weight: bold; text-transform: uppercase;">
                    <i class="fas fa-search me-2"></i>Suivi de mon Inscription
                </h2>
                <p class="text-muted">Réservé exclusivement aux candidats ayant déjà soumis leur dossier de pré-inscription.</p>
                <hr style="width: 60px; height: 4px; background-color: #ffc107; margin: 10px auto; opacity: 1;">
            </div>

            <!-- AFFICHAGE DES ERREURS -->
            <?php if (!empty($message_erreur)): ?>
                <div class="alert alert-danger shadow-sm border-start border-danger border-3" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> <?php echo $message_erreur; ?>
                </div>
            <?php endif; ?>

            <!-- FORMULAIRE DE RECHERCHE (Visible si aucun candidat n'est encore trouvé) -->
            <?php if (!$candidat_trouve): ?>
                <div class="card shadow-sm border-0 p-4" style="background-color: #f8f9fa; border-top: 4px solid #003366 !important;">
                    <form action="index.php?page=suivi-inscription" method="POST">
                        
                        <div class="mb-3">
                            <label for="num_dossier" class="form-label fw-bold" style="color: #003366;">Numéro de dossier / Référence</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-id-card text-muted"></i></span>
                                <input type="text" class="form-control" id="num_dossier" name="num_dossier" placeholder="Ex: UDBL-2026-XYZ" required>
                            </div>
                            <small class="text-muted">Ce code vous a été attribué lors de la validation de votre pré-inscription.</small>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold" style="color: #003366;">Adresse E-mail</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="votre.email@exemple.com" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="btn-submit" value="1" class="btn text-white fw-bold py-2" style="background-color: #003366;">
                                <input type="hidden" name="btn-suivi" value="1">
                                <i class="fas fa-search me-1"></i> Vérifier le statut de mon dossier
                            </button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                
                <!-- AFFICHAGE DU RÉSULTAT DU SUIVI -->
                <div class="card shadow border-0 p-4 mb-4" style="background-color: #fff;">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3 text-dark">Dossier de : <?php echo $candidat_trouve['prenom'] . " " . $candidat_trouve['nom']; ?></h4>
                        <p class="mb-2"><strong>Filière demandée :</strong> <?php echo $candidat_trouve['faculte']; ?></p>
                        <p class="mb-4"><strong>Référence :</strong> <code class="fs-6"><?php echo $candidat_trouve['reference']; ?></code></p>
                        
                        <!-- GESTION DU BADGE DE STATUT -->
                        <div class="p-3 rounded-3 mb-4 d-flex align-items-center" style="
                            <?php 
                                if($candidat_trouve['statut'] == 'Validé') echo 'background-color: #d1e7dd; color: #0f5132;';
                                elseif($candidat_trouve['statut'] == 'Incomplet') echo 'background-color: #fff3cd; color: #664d03;';
                                else echo 'background-color: #f8d7da; color: #842029;';
                            ?>">
                            <div class="me-3 fs-3">
                                <?php 
                                    if($candidat_trouve['statut'] == 'Validé') echo '<i class="fas fa-check-circle"></i>';
                                    elseif($candidat_trouve['statut'] == 'Incomplet') echo '<i class="fas fa-exclamation-circle"></i>';
                                    else echo '<i class="fas fa-clock"></i>';
                                ?>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Statut actuel : <?php echo $candidat_trouve['statut']; ?></h5>
                                <small><?php echo $candidat_trouve['commentaire']; ?></small>
                            </div>
                        </div>

                        <!-- Bouton Retour -->
                        <div class="text-center">
                            <a href="index.php?page=suivi-inscription" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Faire une nouvelle recherche
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>