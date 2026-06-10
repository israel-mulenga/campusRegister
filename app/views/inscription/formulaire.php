<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none fw-bold">Accueil</a></li>
            <li class="breadcrumb-item active fw-bold text-secondary" aria-current="page">Pré-inscription</li>
        </ol>
    </nav>
</div>

<div class="container my-5">
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger border-start border-4 shadow-sm mb-4">
            <h5 class="mb-2">Veuillez corriger les erreurs ci-dessous</h5>
            <?php foreach ($errors as $message): ?>
                <div class="small">• <?= e($message) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="card p-4 mb-4 shadow border-0 d-flex flex-row align-items-center gap-4 bg-white">
        <div class="bg-primary text-white p-3 rounded-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; min-width: 70px;">
            <i class="fas fa-user-plus fa-2x"></i>
        </div>
        <div>
            <h2 class="h4 mb-1 text-dark fw-bold text-uppercase">Formulaire de Pré-inscription</h2>
            <p class="text-muted mb-0 small">Année académique 2026-2027 · Remplissez soigneusement les étapes ci-dessous.</p>
        </div>
    </div>

    <div class="card shadow border-0 overflow-hidden bg-white mb-5">
        
        <!-- Onglets de progression -->
        <div class="nav nav-pills nav-justified bg-light p-2 border-bottom" id="inscriptionStepsTab" role="tablist">
            <button class="nav-link py-3 fw-bold active rounded-2 m-1" data-step="1" id="tab-step-1" type="button">
                <i class="fas fa-id-card me-2"></i>1. Infos Personnelles
            </button>
            <button class="nav-link py-3 fw-bold rounded-2 m-1 text-secondary" data-step="2" id="tab-step-2" type="button">
                <i class="fas fa-graduation-cap me-2"></i>2. Cursus Édu.
            </button>
            <button class="nav-link py-3 fw-bold rounded-2 m-1 text-secondary" data-step="3" id="tab-step-3" type="button" disabled>
                <i class="fas fa-university me-2"></i>3. Choix de Filière
            </button>
            <button class="nav-link py-3 fw-bold rounded-2 m-1 text-secondary" data-step="4" id="tab-step-4" type="button" disabled>
                <i class="fas fa-check-double me-2"></i>4. Récapitulatif & Fin
            </button>
        </div>

        <form action="index.php?url=inscription" method="POST" enctype="multipart/form-data" id="multiStepForm" class="p-4 p-md-5">
            
            <!-- ÉTAPE 1 : INFORMATIONS PERSONNELLES -->
            <div class="form-step-content text-start" id="step-1">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-sm" id="input-nom" name="nom" placeholder="ex. MONINGA" value="<?= e($old['nom'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Prénoms <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-sm" id="input-prenom" name="prenom" placeholder="ex. Caleb" value="<?= e($old['prenom'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Date de Naissance <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-lg border-2 shadow-sm" id="input-date_naissance" name="date_naissance" value="<?= e($old['date_naissance'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Lieu de Naissance <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-sm" id="input-lieu_origine" name="lieu_origine" placeholder="ex. Lubumbashi" value="<?= e($old['lieu_origine'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Adresse E-mail <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-lg border-2 shadow-sm" id="input-email" name="email" placeholder="ex. calebk@gmail.com" value="<?= e($old['email'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Numéro de Téléphone <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control form-control-lg border-2 shadow-sm" id="input-telephone" name="telephone" placeholder="ex. +243822287472" value="<?= e($old['telephone'] ?? '') ?>" required>
                    </div>
                </div>
            </div>

            <!-- ÉTAPE 2 : PARCOURS ÉDUCATIF -->
            <div class="form-step-content d-none text-start" id="step-2">
                <div class="alert alert-warning border-start border-4 shadow-sm mb-4 d-flex align-items-center gap-3">
                    <i class="fas fa-info-circle fa-lg text-warning"></i>
                    <div><strong>Attention :</strong> Renseignez votre établissement d'origine et votre dernier diplôme.</div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Établissement d'origine</label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-sm" id="input-etablissement" name="etablissement" placeholder="Ex: Institut Technique Salama" value="<?= e($old['etablissement'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Dernier diplôme</label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-sm" id="input-dernier_diplome" name="dernier_diplome" placeholder="Ex: Diplôme d'État, Licence LMD" value="<?= e($old['dernier_diplome'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <!-- ÉTAPE 3 : CHOIX DE FILIÈRE -->
            <div class="form-step-content d-none text-start" id="step-3">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Filière sollicitée <span class="text-danger">*</span></label>
                        <?php
                            $filieresParFaculte = [];
                            foreach ($filieres as $filiere) {
                                $faculte = $filiere['nom_faculte'] ?? 'Autres';
                                $filieresParFaculte[$faculte][] = $filiere;
                            }
                            $selectedFiliere = $old['id_filiere'] ?? '';
                        ?>
                        <select id="selectFaculte" name="id_filiere" class="form-select form-select-lg border-2 shadow-sm" required>
                            <option value="">-- Choisissez une filière --</option>
                            <?php foreach ($filieresParFaculte as $faculte => $filieresGroupe): ?>
                                <optgroup label="<?= htmlspecialchars($faculte, ENT_QUOTES, 'UTF-8') ?>">
                                    <?php foreach ($filieresGroupe as $filiere): ?>
                                        <option value="<?= (int)$filiere['id'] ?>" <?= ((string)$selectedFiliere === (string)$filiere['id']) ? 'selected' : '' ?>><?= htmlspecialchars($filiere['nom'], ENT_QUOTES, 'UTF-8') ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- ÉTAPE 4 : RÉCAPITULATIF AVANT VALIDATION -->
            <div class="form-step-content d-none text-start" id="step-4">
                <div class="alert alert-info border-start border-4 shadow-sm mb-4">
                    <i class="fas fa-eye me-2"></i> <strong>Vérification des informations :</strong> Si vous constatez une erreur, cliquez sur le bouton <span class="badge bg-warning text-dark">Modifier</span> correspondant pour effectuer les changements avant d'envoyer votre dossier.
                </div>

                <div class="row g-4">
                    <!-- Résumé Identité -->
                    <div class="col-md-6">
                        <div class="card h-100 border border-light shadow-sm bg-light">
                            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-2">
                                <span class="fw-bold small"><i class="fas fa-user me-2 text-warning"></i> 1. Identité & Contact</span>
                                <button type="button" class="btn btn-xs btn-outline-warning btn-sm py-0 fw-bold btn-edit-step" data-target-step="1">Modifier</button>
                            </div>
                            <div class="card-body p-3 small lh-lg">
                                <strong>Nom complet :</strong> <span id="recap-nom" class="text-muted"></span><br>
                                <strong>Date de Naissance :</strong> <span id="recap-date_naiss" class="text-muted"></span><br>
                                <strong>Lieu de Naissance :</strong> <span id="recap-lieu_naiss" class="text-muted"></span><br>
                                <strong>Adresse E-mail :</strong> <span id="recap-email" class="text-muted"></span><br>
                                <strong>Téléphone :</strong> <span id="recap-telephone" class="text-muted"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Résumé Scolaire -->
                    <div class="col-md-6">
                        <div class="card h-100 border border-light shadow-sm bg-light">
                            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-2">
                                <span class="fw-bold small"><i class="fas fa-graduation-cap me-2 text-warning"></i> 2. Cursus</span>
                                <button type="button" class="btn btn-xs btn-outline-warning btn-sm py-0 fw-bold btn-edit-step" data-target-step="2">Modifier</button>
                            </div>
                            <div class="card-body p-3 small lh-lg">
                                <strong>Établissement d'origine :</strong> <span id="recap-etablissement" class="text-primary fw-bold"></span>
                                <hr class="my-2">
                                <strong>Dernier diplôme :</strong> <span id="recap-dernier_diplome" class="text-primary fw-bold"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Résumé Faculté -->
                    <div class="col-12">
                        <div class="card border border-light shadow-sm bg-light">
                            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-2">
                                <span class="fw-bold small"><i class="fas fa-university me-2 text-warning"></i> 3. Choix d'Orientation UDBL</span>
                                <button type="button" class="btn btn-xs btn-outline-warning btn-sm py-0 fw-bold btn-edit-step" data-target-step="3">Modifier</button>
                            </div>
                            <div class="card-body p-3 small d-flex flex-column flex-md-row gap-4 justify-content-around">
                                <div><strong>Filière choisie :</strong> <span id="recap-faculte" class="text-success fw-bold fs-6"></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center py-5">
                    <h3 class="h5 fw-bold text-dark">Tout est correct ?</h3>
                    <p class="text-muted mx-auto mb-4 small" style="max-width: 550px;">
                        En validant, votre dossier d'inscription complet sera envoyé à l'administration académique.
                    </p>
                    <button type="submit" class="btn btn-success btn-lg px-5 fw-bold shadow">
                        <i class="fas fa-paper-plane me-2"></i> Confirmer et Envoyer ma Candidature
                    </button>
                </div>
            </div>

            <!-- Boutons de contrôle inférieurs -->
            <div class="d-flex justify-content-center align-items-center gap-2 mt-5 pt-4 border-top">
                <button type="button" class="btn btn-sm btn-outline-primary px-3 fw-bold invisible" id="btnStepPrev">
                    <i class="fas fa-arrow-left me-1"></i> Précédent
                </button>
                
                <div class="d-flex gap-2 mx-3">
                    <span class="badge bg-primary rounded-circle d-flex align-items-center justify-content-center dynamic-indicator" data-step="1" style="width:35px; height:35px; cursor:pointer; font-size:14px;">1</span>
                    <span class="badge bg-secondary rounded-circle d-flex align-items-center justify-content-center dynamic-indicator" data-step="2" style="width:35px; height:35px; cursor:pointer; font-size:14px;">2</span>
                    <span class="badge bg-secondary rounded-circle d-flex align-items-center justify-content-center dynamic-indicator" data-step="3" style="width:35px; height:35px; cursor:pointer; font-size:14px;">3</span>
                    <span class="badge bg-secondary rounded-circle d-flex align-items-center justify-content-center dynamic-indicator" data-step="4" style="width:35px; height:35px; cursor:pointer; font-size:14px;">4</span>
                </div>

                <button type="button" class="btn btn-sm btn-primary px-3 fw-bold" id="btnStepNext">
                    Suivant <i class="fas fa-arrow-right ms-1"></i>
                </button>
            </div>

        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentStep = 1;
    const totalSteps = 4;

    const tabs = document.querySelectorAll('#inscriptionStepsTab .nav-link');
    const indicators = document.querySelectorAll('.dynamic-indicator');
    const contents = document.querySelectorAll('.form-step-content');
    
    const btnNext = document.getElementById('btnStepNext');
    const btnPrev = document.getElementById('btnStepPrev');
    const selectFaculte = document.getElementById('selectFaculte');

    // === SYSTÈME DE NAVIGATION ENTRE LES ÉTAPES ===
    function updateFormUI(step) {
        let stepInt = parseInt(step);
        currentStep = stepInt;

        tabs.forEach(t => {
            t.classList.remove('active', 'btn-primary');
            t.classList.add('text-secondary');
            if(parseInt(t.getAttribute('data-step')) === currentStep) {
                t.classList.add('active');
                t.classList.remove('text-secondary');
            }
        });

        indicators.forEach(ind => {
            ind.classList.remove('bg-primary');
            ind.classList.add('bg-secondary');
            if(parseInt(ind.getAttribute('data-step')) === currentStep) {
                ind.classList.replace('bg-secondary', 'bg-primary');
            }
        });

        contents.forEach(c => {
            c.classList.add('d-none');
            if(parseInt(c.getAttribute('id').replace('step-', '')) === currentStep) {
                c.classList.remove('d-none');
            }
        });

        btnPrev.classList.toggle('invisible', currentStep === 1);
        btnNext.classList.toggle('invisible', currentStep === totalSteps);

        if(currentStep === 4) {
            genererRecapitulatif();
        }
    }

    // === COMPILATION DU RÉCAPITULATIF FINAL (ÉTAPE 4) ===
    function genererRecapitulatif() {
        document.getElementById('recap-nom').innerText = document.getElementById('input-nom').value || 'Non renseigné';
        document.getElementById('recap-date_naiss').innerText = document.getElementById('input-date_naissance').value || 'Non renseigné';
        document.getElementById('recap-lieu_naiss').innerText = document.getElementById('input-lieu_origine').value || 'Non renseigné';
        document.getElementById('recap-email').innerText = document.getElementById('input-email').value || 'Non renseigné';
        document.getElementById('recap-telephone').innerText = document.getElementById('input-telephone').value || 'Non renseigné';

        document.getElementById('recap-etablissement').innerText = document.getElementById('input-etablissement').value || 'N/A';
        document.getElementById('recap-dernier_diplome').innerText = document.getElementById('input-dernier_diplome').value || 'N/A';

        document.getElementById('recap-faculte').innerText = selectFaculte.options[selectFaculte.selectedIndex].text || 'Non sélectionné';
    }

    // Assignation des événements sur les contrôleurs
    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) { e.preventDefault(); if(!this.disabled) updateFormUI(this.getAttribute('data-step')); });
    });
    indicators.forEach(ind => {
        ind.addEventListener('click', function(e) { e.preventDefault(); updateFormUI(this.getAttribute('data-step')); });
    });

    btnNext.addEventListener('click', function() {
        if(currentStep < totalSteps) updateFormUI(currentStep + 1);
    });
    btnPrev.addEventListener('click', function() {
        if(currentStep > 1) updateFormUI(currentStep - 1);
    });

    // Retour instantané vers une étape avec le bouton "Modifier" du récapitulatif
    document.querySelectorAll('.btn-edit-step').forEach(btn => {
        btn.addEventListener('click', function() {
            updateFormUI(this.getAttribute('data-target-step'));
        });
    });

    // Initialisation
    updateFormUI(1);
});
</script>