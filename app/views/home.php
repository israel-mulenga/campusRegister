<?php

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

require_once __DIR__ ."/../../templates/components/header.php";
require_once __DIR__ ."/../helpers/Validator.php";

?>

<!-- Espacement pour le menu fixe -->
    <div class="container main-content-container" style="margin-top: 80px;"></div> 

    <!-- ZONE DE AFFICHAGE DYNAMIQUE (MILIEU DE PAGE)                                      -->
    <?php
    switch($page) {
        
        // --- CAS 1 : PAGE DE PRÉ-INSCRIPTION (Formulaire) ---
        case 'pre-inscription':
            if (file_exists('app/views/inscription/formulaire.php')) {
                include 'app/views/inscription/formulaire.php';
            } else {
                echo "<div class='container my-5 alert alert-danger'>Erreur : Le fichier <strong>formulaire.php</strong> est introuvable dans app/views/.</div>";
            }
            break;

        // --- CAS 2 : PAGE DE SUIVI D'INSCRIPTION (Nouveau module) ---
        case 'suivi-inscription':
            if (file_exists('app/views/inscription/suivi.php')) {
                include 'app/views/inscription/suivi.php';
            } else {
                echo "<div class='container my-5 alert alert-danger'>Erreur : Le fichier <strong>suivi-inscription.php</strong> est introuvable dans app/views/.</div>";
            }
            break;

        case 'admin-dashboard':
            if (file_exists('app/controllers/AdminController.php')) {
                require_once 'app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->dashboard();
            }
            exit(); // Bloque l'exécution du reste de la page d'accueil
            break;

        // --- CAS PAR DÉFAUT : ACCUEIL (Carrousel, Facultés, Actus...) ---
        case 'home':
        default:
            ?>
            <!-- Carrousel d'accueil -->
            <div id="myCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" style="margin-bottom: 30px; min-height: 400px; background-color: #e9ecef;">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                </div>
                <div class="carousel-inner" role="listbox" style="min-height: 400px;">
                    <div class="carousel-item active">
                        <img src="public/images/69e0b3a7514a1.webp" alt="Bannière principale" width="1920" height="400" style="width:100%; height: 400px; object-fit: cover;">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>
            </div>

            <div class="container">
                <!-- Bloc Facultés -->
                <div class="row mb-5 mt-4">
                    <div class="col-12 text-center mb-4">
                         <h2 style="color: #003366; font-weight: 700; text-transform: uppercase; position: relative; display: inline-block; padding-bottom: 15px;">
                            Nos Facultés
                            <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 60px; height: 4px; background-color: #ffc107;"></span>
                        </h2>
                    </div>
                    
                    <div class="col-md-3 col-sm-6 mb-4">
                        <a href="index.php?page=actualites&faculte=4" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 card-hover-effect text-center py-4" style="transition: all 0.3s;">
                                <div class="card-body">
                                    <div class="icon-box bg-light text-primary mx-auto mb-3" style="width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; color: #003366 !important;">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <h6 class="card-title text-dark fw-bold">Gestion et Ingénierie Financières</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-md-3 col-sm-6 mb-4">
                        <a href="index.php?page=actualites&faculte=5" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 card-hover-effect text-center py-4" style="transition: all 0.3s;">
                                <div class="card-body">
                                    <div class="icon-box bg-light text-primary mx-auto mb-3" style="width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; color: #003366 !important;">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <h6 class="card-title text-dark fw-bold">Science de l'homme et de la Société</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-md-3 col-sm-6 mb-4">
                        <a href="index.php?page=actualites&faculte=1" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 card-hover-effect text-center py-4" style="transition: all 0.3s;">
                                <div class="card-body">
                                    <div class="icon-box bg-light text-primary mx-auto mb-3" style="width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; color: #003366 !important;">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <h6 class="card-title text-dark fw-bold">Sciences Informatiques</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-md-3 col-sm-6 mb-4">
                        <a href="index.php?page=actualites&faculte=6" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 card-hover-effect text-center py-4" style="transition: all 0.3s;">
                                <div class="card-body">
                                    <div class="icon-box bg-light text-primary mx-auto mb-3" style="width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; color: #003366 !important;">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <h6 class="card-title text-dark fw-bold">Théologie</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Bloc Actualités & Documents Événements -->
                <div class="row">
                    <div class="col-lg-8">
                        <h3 class="mb-4" style="border-left: 5px solid #ffc107; padding-left: 15px; color: #003366; font-weight: bold;">
                            Actualités récentes 
                            <small class="pull-right" style="font-size: 0.6em; margin-top: 5px;"><a href="index.php?page=actualites" class="text-muted">Voir toutes <i class="fas fa-arrow-right"></i></a></small>
                        </h3>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <img src="public/images/angl-pub.webp" class="card-img-top" alt="DEUXIEME JOURNEE SCIENTIFIQUE 16 MAI 2026" style="height: 200px; width: 100%; object-fit: cover; background-color: #f8f9fa;" loading="lazy">
                                    <div class="card-body">
                                        <h5 class="card-title">DEUXIEME JOURNEE SCIENTIFIQUE 16 MAI 2026</h5>
                                        <p class="card-text"><small class="text-muted"><i class="fas fa-calendar-alt"></i> 18/05/2026</small></p>
                                        <p class="card-text">Le samedi 16 mai, deuxième journée de ces assises, la grande salle du Theologicum était bien remplie...</p>
                                        <a href="index.php?page=article&id=104" class="btn btn-primary">Lire la suite</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <img src="public/images/angl-pub2.webp" class="card-img-top" alt="PREMIER DES JOURNEES SCIENTIFIQUES" style="height: 200px; width: 100%; object-fit: cover; background-color: #f8f9fa;" loading="lazy">
                                    <div class="card-body">
                                        <h5 class="card-title">PREMIER DES JOURNEES SCIENTIFIQUES DE LA FACULTE D...</h5>
                                        <p class="card-text"><small class="text-muted"><i class="fas fa-calendar-alt"></i> 16/05/2026</small></p>
                                        <p class="card-text">Première journée (Prière d’ouverture : 14 : 25) Mot du recteur UDBL : -Rappel des précédentes jo...</p>
                                        <a href="index.php?page=article&id=103" class="btn btn-primary">Lire la suite</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <img src="public/images/angl-pub3.webp" class="card-img-top" alt="CLOTURE DE LA FORMATION" style="height: 200px; width: 100%; object-fit: cover; background-color: #f8f9fa;" loading="lazy">
                                    <div class="card-body">
                                        <h5 class="card-title">CLOTURE DE LA DEUXIEME FORMATION NUMERIQUE GRATUIT...</h5>
                                        <p class="card-text"><small class="text-muted"><i class="fas fa-calendar-alt"></i> 09/05/2026</small></p>
                                        <p class="card-text">L’Université Don Bosco de Lubumbashi (UDBL) est fière d’annoncer la clôture de sa deuxième formation...</p>
                                        <a href="index.php?page=article&id=102" class="btn btn-primary">Lire la suite</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <img src="public/images/angl-pub4.webp" class="card-img-top" alt="11ÈME ASSEMBLÉE GÉNÉRALE" style="height: 200px; width: 100%; object-fit: cover; background-color: #f8f9fa;" loading="lazy">
                                    <div class="card-body">
                                        <h5 class="card-title">11ÈME ASSEMBLÉE GÉNÉRALE DE L’ASUNICACO</h5>
                                        <p class="card-text"><small class="text-muted"><i class="fas fa-calendar-alt"></i> 30/04/2026</small></p>
                                        <p class="card-text">L’Association des Universités et Instituts Supérieurs Catholiques du Congo (ASUNICACO) a tenu sa 11è...</p>
                                        <a href="index.php?page=article&id=97" class="btn btn-primary">Lire la suite</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <img src="public/images/angl-pub6.webp" class="card-img-top" alt="SALON DE L'EDUCATION" style="height: 200px; width: 100%; object-fit: cover; background-color: #f8f9fa;" loading="lazy">
                                    <div class="card-body">
                                        <h5 class="card-title">PARTICIPATION DE L’UDBL AU SALON DE L’ÉDUCATION (S...</h5>
                                        <p class="card-text"><small class="text-muted"><i class="fas fa-calendar-alt"></i> 24/04/2026</small></p>
                                        <p class="card-text">L’Université Don Bosco de Lubumbashi (UDBL) a participé avec dynamisme à la première édition du Salo...</p>
                                        <a href="index.php?page=article&id=96" class="btn btn-primary">Lire la suite</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <img src="public/images/angl-pub5.webp" class="card-img-top" alt="VISITE ACADEMIQUE" style="height: 200px; width: 100%; object-fit: cover; background-color: #f8f9fa;" loading="lazy">
                                    <div class="card-body">
                                        <h5 class="card-title">RENFORCEMENT DES LIENS ACADEMIQUES : VISITE A ASSA...</h5>
                                        <p class="card-text"><small class="text-muted"><i class="fas fa-calendar-alt"></i> 09/04/2026</small></p>
                                        <p class="card-text">Les membres du Comité de Gestion et le référent IUS ont eu l’honneur de visiter ASSAM Don Bosco Univ...</p>
                                        <a href="index.php?page=article&id=94" class="btn btn-primary">Lire la suite</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Barre Latérale Droite -->
                    <div class="col-lg-4">
                        <div class="panel panel-default" style="border-top: 3px solid #003366; background: #fff; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom:20px;">
                            <div class="panel-heading" style="background-color: #fff; color: #003366; border-bottom: 1px solid #eee; padding: 10px 15px;">
                                <h3 class="panel-title" style="font-weight: bold; margin:0; font-size:16px;"><i class="fas fa-calendar-alt text-warning"></i> Événements à venir</h3>
                            </div>
                            <div class="list-group list-group-flush">
                                <div class="list-group-item">Aucun événement à venir.</div>
                                <a href="index.php?page=events" class="list-group-item text-center text-white" style="background-color: #003366; border-color: #003366;">Voir tous les événements</a>
                            </div>
                        </div>

                        <div class="panel panel-default" style="border-top: 3px solid #07ff51; background: #fff; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <div class="panel-heading" style="background-color: #fff; color: #003366; border-bottom: 1px solid #eee; padding: 10px 15px;">
                                <h3 class="panel-title" style="font-weight: bold; margin:0; font-size:16px;"><i class="fas fa-file-download text-warning"></i> Documents Utiles</h3>
                            </div>
                            <div class="list-group list-group-flush">
                                <a href="javascript:void(0);" class="list-group-item list-group-item-action" onclick="openDocModal('https://view.officeapps.live.com/op/embed.aspx?src=public/assets/uploads/documents/69e0a6afbc19b_SituationDiplmesESIS.xlsx', 'Diplomes disponibles - ESISALAMA')">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="d-flex align-items-center" style="overflow: hidden;">
                                            <i class="fas fa-file-excel text-success fa-2x" style="width: 40px;"></i>
                                            <div>
                                                <h5 class="list-group-item-heading" style="font-size: 14px; font-weight: bold; margin-bottom: 2px; color:#333;">Diplomes disponibles - ESISALAMA</h5>
                                                <p class="list-group-item-text text-muted small mb-0">Autre</p>
                                            </div>
                                        </div>
                                        <small class="text-primary" style="white-space: nowrap; margin-left: 10px;"><i class="fas fa-eye"></i> Consulter</small>
                                    </div>
                                </a>
                                
                                <a href="public/assets/uploads/documents/6985e5851b375_Calendrier_25-26.pdf" class="list-group-item list-group-item-action" target="_blank" download>
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="d-flex align-items-center" style="overflow: hidden;">
                                            <i class="fas fa-file-pdf text-danger fa-2x" style="width: 40px;"></i>
                                            <div>
                                                <h5 class="list-group-item-heading" style="font-size: 14px; font-weight: bold; margin-bottom: 2px; color:#333;">Calendrier academique 2025-2026</h5>
                                                <p class="list-group-item-text text-muted small mb-0">Calendrier</p>
                                            </div>
                                        </div>
                                        <small class="text-primary" style="white-space: nowrap; margin-left: 10px;"><i class="fas fa-download"></i> Télécharger</small>
                                    </div>
                                </a>
                                
                                <a href="public/assets/uploads/documents/6985e26777923_GuidedelEtudiant_V_1_025.pdf" class="list-group-item list-group-item-action" target="_blank" download>
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="d-flex align-items-center" style="overflow: hidden;">
                                            <i class="fas fa-file-pdf text-danger fa-2x" style="width: 40px;"></i>
                                            <div>
                                                <h5 class="list-group-item-heading" style="font-size: 14px; font-weight: bold; margin-bottom: 2px; color:#333;">Règlement d’ordre intérieur « POUR ÉTUDIANT »</h5>
                                                <p class="list-group-item-text text-muted small mb-0">Règlement</p>
                                            </div>
                                        </div>
                                        <small class="text-primary" style="white-space: nowrap; margin-left: 10px;"><i class="fas fa-download"></i> Télécharger</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mot du Recteur -->
                <div class="row mb-5 mt-5 reveal">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm" style="background-color: #f8f9fa; border-left: 5px solid #003366 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="public/images/logo_udbl.png" class="img-fluid rounded-circle shadow bg-white" alt="Le Recteur" style="width: 180px; height: 180px; object-fit: cover; padding: 5px;" loading="lazy">
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body p-4">
                                        <h3 class="card-title mb-3" style="color: #003366; font-weight: bold;">Le Mot du Recteur</h3>
                                        <p class="card-text lead" style="font-style: italic; color: #555; font-size: 1.1rem;">"Bienvenue à l'Université Don Bosco de Lubumbashi. Notre institution s'engage à former non seulement des experts compétents, mais aussi des citoyens responsables et porteurs de valeurs humaines. Ensemble, construisons l'avenir avec excellence et intégrité."</p>
                                        <div class="text-end mt-4">
                                            <h5 class="mb-0 fw-bold" style="color: #003366;">Père Jean-Luc Vande Kerkhove</h5>
                                            <small class="text-muted text-uppercase" style="letter-spacing: 1px;">Recteur de l'UDBL</small>
                                            <div class="mt-2" style="font-family: 'Brush Script MT', cursive; font-size: 1.8em; color: #003366;">J.L. Vande Kerkhove</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination Accueil -->
                <div class="row text-center mb-5">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item active"><a class="page-link" href="index.php?page=home&p=1">1</a></li>
                            <li class="page-item"><a class="page-link" href="index.php?page=home&p=2">2</a></li>
                            <li class="page-item"><a class="page-link" href="index.php?page=home&p=3">3</a></li>
                            <li class="page-item"><a class="page-link" href="index.php?page=home&p=4">4</a></li>
                            <li class="page-item"><a class="page-link" href="index.php?page=home&p=5">5</a></li>
                            <li class="page-item"><a class="page-link" href="index.php?page=home&p=6">6</a></li>
                            <li class="page-item"><a class="page-link" href="index.php?page=home&p=7">7</a></li>
                            <li class="page-item"><a class="page-link" href="index.php?page=home&p=8">8</a></li>
                        </ul>
                    </nav>
                </div>
            </div> 
            <?php
            break;
    }
    ?>

    <!-- Modale de prévisualisation des documents -->
    <div class="modal fade" id="docPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 90%; max-width: 1000px; height: 90vh; margin: 5vh auto;">
            <div class="modal-content" style="height: 100%;">
                <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h5 class="modal-title" id="docPreviewTitle" style="margin:0; font-weight:bold;">Consultation du document</h5>
                    <button type="button" class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="background:transparent; border:none; font-size:1.5rem; cursor:pointer;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="height: calc(100% - 56px); padding: 0;">
                    <iframe id="docPreviewIframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>

<?php

require_once __DIR__ ."/../../templates/components/footer.php";

?>