<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none fw-bold">Accueil</a></li>
            <li class="breadcrumb-item active fw-bold text-secondary" aria-current="page">Pré-inscription</li>
        </ol>
    </nav>
</div>

<div class="container my-5">
    
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
                <i class="fas fa-university me-2"></i>3. Choix Faculté
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
                        <label class="form-label fw-bold text-secondary small">Nom Complet <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-sm" id="input-nom" name="nom" placeholder="ex. MONINGA KINDJI Caleb" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Nationalité <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-sm" id="input-nationalite" name="nationalite" placeholder="ex. Congolaise" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Date de Naissance <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-lg border-2 shadow-sm" id="input-date_naiss" name="date_naiss" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Genre <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4 mt-2">
                            <div class="form-check">
                                <input type="radio" class="form-check-input border-2" name="genre" id="genreM" value="M" checked>
                                <label class="form-check-label fw-semibold" for="genreM">Masculin (M)</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input border-2" name="genre" id="genreF" value="F">
                                <label class="form-check-label fw-semibold" for="genreF">Féminin (F)</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Lieu de Naissance <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-sm" id="input-lieu_naiss" name="lieu_naiss" placeholder="ex. Lubumbashi" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Adresse E-mail <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-lg border-2 shadow-sm" id="input-email" name="email" placeholder="ex. calebk@gmail.com" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Numéro de Téléphone <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control form-control-lg border-2 shadow-sm" id="input-telephone" name="telephone" placeholder="ex. +243822287472" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Photo d'Identité / Passeport <span class="text-danger">*</span></label>
                        <input type="file" class="form-control form-control-lg border-2 shadow-sm" name="photo_passport" accept="image/*" required>
                    </div>
                </div>
            </div>

            <!-- ÉTAPE 2 : PARCOURS ÉDUCATIF -->
            <div class="form-step-content d-none text-start" id="step-2">
                <div class="alert alert-warning border-start border-4 shadow-sm mb-4 d-flex align-items-center gap-3">
                    <i class="fas fa-info-circle fa-lg text-warning"></i>
                    <div><strong>Attention :</strong> Le choix du niveau d'études influence directement les horaires de cours disponibles à l'étape suivante.</div>
                </div>
                
                <div class="mb-5" style="max-width: 400px;">
                    <label class="form-label fw-bold text-dark small">Niveau d'études sollicité <span class="text-danger">*</span></label>
                    <select id="selectNiveauAcademique" name="niveau_etude" class="form-select form-select-lg border-primary border-2 shadow-sm fw-bold text-primary" required>
                        <option value="">-- Sélectionnez votre niveau --</option>
                        <option value="licence">Premier Cycle (Licence L1)</option>
                        <option value="master">Second Cycle (Master M1)</option>
                    </select>
                </div>

                <!-- Bloc Licence -->
                <div id="bloc-filiere-licence" class="d-none">
                    <h4 class="h6 text-primary border-bottom pb-2 mb-4 fw-bold text-uppercase"><i class="fas fa-scroll me-2"></i>Cursus Humanités & Diplôme d'État</h4>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">École / Institut d'origine</label>
                            <input type="text" class="form-control form-control-lg border-2 shadow-sm" id="input-lic_ecole" name="lic_ecole" placeholder="Ex: Institut Technique Salama">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">Scan du Diplôme d'État (PDF/JPG)</label>
                            <input type="file" class="form-control form-control-lg border-2 shadow-sm" name="lic_diplome_file">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">Option suivie aux Humanités</label>
                            <input type="text" class="form-control form-control-lg border-2 shadow-sm" id="input-lic_option" name="lic_option" placeholder="Ex: Commerciale & Gestion, Math-Physique">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary small">Année d'obtention</label>
                            <input type="number" class="form-control form-control-lg border-2 shadow-sm" id="input-lic_annee" name="lic_annee" placeholder="2025">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary small">Pourcentage obtenu (%)</label>
                            <input type="text" class="form-control form-control-lg border-2 shadow-sm" id="input-lic_pourcentage" name="lic_pourcentage" placeholder="Ex: 68%">
                        </div>
                    </div>
                </div>

                <!-- Bloc Master -->
                <div id="bloc-filiere-master" class="d-none">
                    <h4 class="h6 text-primary border-bottom pb-2 mb-4 fw-bold text-uppercase"><i class="fas fa-user-graduate me-2"></i>Cursus Universitaire Précédent</h4>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">Université / Institution d'origine</label>
                            <input type="text" class="form-control form-control-lg border-2 shadow-sm" id="input-mast_uni" name="mast_uni" placeholder="Ex: UNILU, UDBL, Kinshasa...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">Scan du Diplôme de Licence LMD / Graduat (PDF)</label>
                            <input type="file" class="form-control form-control-lg border-2 shadow-sm" name="mast_diplome_file">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">Faculté / Département d'origine</label>
                            <input type="text" class="form-control form-control-lg border-2 shadow-sm" id="input-mast_fac" name="mast_fac" placeholder="Ex: Sciences Informatiques">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">Mention obtenue</label>
                            <input type="text" class="form-control form-control-lg border-2 shadow-sm" id="input-mast_mention" name="mast_mention" placeholder="Ex: Distinction, Satisfaction">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ÉTAPE 3 : CHOIX DE FACULTÉ & VACATION INTELLIGENTE -->
            <div class="form-step-content d-none text-start" id="step-3">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Faculté sollicitée <span class="text-danger">*</span></label>
                        <select id="selectFaculte" name="faculte_choix" class="form-select form-select-lg border-2 shadow-sm" required>
                            <option value="">-- Choisissez une faculté --</option>
                            <option value="Sciences Informatique">Sciences Informatique</option>
                            <option value="Gestion et Ingénierie">Gestion et Ingénierie</option>
                            <option value="Science de l'Homme & de la Société">Science de l'Homme & de la Société</option>
                            <option value="Théologie">Théologie</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">Vacation horaire disponible <span class="text-danger">*</span></label>
                        <select id="selectVacation" name="vacation" class="form-select form-select-lg border-primary border-2 shadow-sm fw-bold text-primary" required>
                            <!-- Les options seront injectées dynamiquement par JavaScript -->
                        </select>
                        <div id="vacation-helper-text" class="form-text text-muted mt-2 small"></div>
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
                                <strong>Nationalité :</strong> <span id="recap-nationalite" class="text-muted"></span><br>
                                <strong>Date de Naissance :</strong> <span id="recap-date_naiss" class="text-muted"></span><br>
                                <strong>Genre :</strong> <span id="recap-genre" class="text-muted"></span><br>
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
                                <span class="fw-bold small"><i class="fas fa-graduation-cap me-2 text-warning"></i> 2. Niveau & Cursus</span>
                                <button type="button" class="btn btn-xs btn-outline-warning btn-sm py-0 fw-bold btn-edit-step" data-target-step="2">Modifier</button>
                            </div>
                            <div class="card-body p-3 small lh-lg">
                                <strong>Niveau d'étude demandé :</strong> <span id="recap-niveau" class="text-primary fw-bold"></span>
                                <hr class="my-2">
                                <div id="recap-details-cursus"></div>
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
                                <div><strong>Faculté choisie :</strong> <span id="recap-faculte" class="text-success fw-bold fs-6"></span></div>
                                <div><strong>Vacation / Modalité de cours :</strong> <span id="recap-vacation" class="badge bg-primary fs-6 fw-bold"></span></div>
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
    
    const selectNiveau = document.getElementById('selectNiveauAcademique');
    const selectFaculte = document.getElementById('selectFaculte');
    const selectVacation = document.getElementById('selectVacation');
    const vacationHelperText = document.getElementById('vacation-helper-text');

    // === GESTION DE LA LOGIQUE DYNAMIQUE DES HORAIRES (LICENCE vs MASTER) ===
    function adapterOptionsVacation() {
        const niveau = selectNiveau.value;
        const faculte = selectFaculte.value;

        // Vider le menu déroulant
        selectVacation.innerHTML = "";

        if (!niveau) {
            selectVacation.innerHTML = '<option value="">-- En attente du niveau d\'étude --</option>';
            vacationHelperText.innerText = "";
            return;
        }

        if (niveau === 'licence') {
            // Règle 1 : En Licence, les cours se donnent obligatoirement le matin
            selectVacation.innerHTML = '<option value="Jour (Matinée)" selected>Jour (Matinée)</option>';
            vacationHelperText.innerHTML = '<i class="fas fa-info-circle text-primary"></i> À l\'UDBL, tous les enseignements de premier cycle (Licence) se déroulent obligatoirement en présentiel en matinée.';
        } else if (niveau === 'master') {
            if (faculte === 'Sciences Informatiques') {
                // Règle 2 : Master Informatique -> Cours en Ligne
                selectVacation.innerHTML = '<option value="En Ligne (Distanciel)" selected>En Ligne (Distanciel)</option>';
                vacationHelperText.innerHTML = '<i class="fas fa-wifi text-success"></i> La filière Master en Sciences Informatiques est dispensée de manière moderne via notre plateforme de e-learning.';
            } else {
                // Règle 3 : Les autres masters (Cours du soir / Professionnel)
                selectVacation.innerHTML = `
                    <option value="Soir (Professionnels / Présentiel)">Soir (Professionnels / Présentiel)</option>
                    <option value="Hybride (Mixte)">Hybride (Présentiel / Distanciel)</option>
                `;
                vacationHelperText.innerHTML = '<i class="fas fa-clock text-warning"></i> Enseignements aménagés pour les professionnels (horaires du soir ou format mixte).';
            }
        }
    }

    // Écouteurs pour recalculer la vacation
    selectNiveau.addEventListener('change', adapterOptionsVacation);
    selectFaculte.addEventListener('change', adapterOptionsVacation);

    // === SYSTÈME DE NAVIGATION ENTRE LES ÉTAPES ===
    function updateFormUI(step) {
        let stepInt = parseInt(step);
        
        // Bloquer la suite s'il n'y a pas de niveau sélectionné à l'étape 2
        if (stepInt >= 3 && (!selectNiveau.value || selectNiveau.value === "")) {
            alert("Veuillez d'abord sélectionner votre niveau d'études (Licence ou Master) à l'étape 2 !");
            updateFormUI(2);
            return;
        }

        currentStep = stepInt;

        // Activation des boutons du menu supérieur
        document.getElementById('tab-step-3').disabled = (!selectNiveau.value);
        document.getElementById('tab-step-4').disabled = (!selectNiveau.value);

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
        document.getElementById('recap-nationalite').innerText = document.getElementById('input-nationalite').value || 'Non renseigné';
        document.getElementById('recap-date_naiss').innerText = document.getElementById('input-date_naiss').value || 'Non renseigné';
        document.getElementById('recap-lieu_naiss').innerText = document.getElementById('input-lieu_naiss').value || 'Non renseigné';
        document.getElementById('recap-email').innerText = document.getElementById('input-email').value || 'Non renseigné';
        document.getElementById('recap-telephone').innerText = document.getElementById('input-telephone').value || 'Non renseigné';
        
        const genreSelectionne = document.querySelector('input[name="genre"]:checked');
        document.getElementById('recap-genre').innerText = genreSelectionne ? (genreSelectionne.value === 'M' ? 'Masculin' : 'Féminin') : 'Non renseigné';

        const niveau = selectNiveau.value;
        const divDetails = document.getElementById('recap-details-cursus');
        
        if(niveau === 'licence') {
            document.getElementById('recap-niveau').innerText = "Premier Cycle (Licence L1)";
            divDetails.innerHTML = `
                <strong>École d'origine :</strong> ${document.getElementById('input-lic_ecole').value || 'N/A'}<br>
                <strong>Option suivie :</strong> ${document.getElementById('input-lic_option').value || 'N/A'}<br>
                <strong>Année d'obtention :</strong> ${document.getElementById('input-lic_annee').value || 'N/A'}<br>
                <strong>Pourcentage :</strong> ${document.getElementById('input-lic_pourcentage').value || 'N/A'}`;
        } else if(niveau === 'master') {
            document.getElementById('recap-niveau').innerText = "Second Cycle (Master M1)";
            divDetails.innerHTML = `
                <strong>Université d'origine :</strong> ${document.getElementById('input-mast_uni').value || 'N/A'}<br>
                <strong>Faculté d'origine :</strong> ${document.getElementById('input-mast_fac').value || 'N/A'}<br>
                <strong>Mention obtenue :</strong> ${document.getElementById('input-mast_mention').value || 'N/A'}`;
        }

        document.getElementById('recap-faculte').innerText = selectFaculte.options[selectFaculte.selectedIndex].text || 'Non sélectionné';
        document.getElementById('recap-vacation').innerText = selectVacation.value || 'Non sélectionné';
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

    // Gestion de l'affichage des sections de formulaires Licence / Master
    const blocLicence = document.getElementById('bloc-filiere-licence');
    const blocMaster = document.getElementById('bloc-filiere-master');

    selectNiveau.addEventListener('change', function() {
        if (this.value === 'licence') {
            blocLicence.classList.remove('d-none');
            blocMaster.classList.add('d-none');
        } else if (this.value === 'master') {
            blocLicence.classList.add('d-none');
            blocMaster.classList.remove('d-none');
        } else {
            blocLicence.classList.add('d-none');
            blocMaster.classList.add('d-none');
        }
    });

    // Initialisation
    adapterOptionsVacation();
});
</script>