<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($page === 'pre-inscription') ? 'Pré-inscription - UDBL' : 'Accueil - UDBL'; ?></title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="public/css/style.min.css">
    <link rel="stylesheet" href="public/css/custom.css">
    <link rel="stylesheet" href="public/css/chatbot.css">
</head>
<body>

    <!-- MENU / HEADER (Reste visible sur toutes les pages)                                -->
    <nav class="navbar navbar-expand-md navbar-inverse navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="public/images/LOGO-UDBL1.webp" alt="Logo UDBL" class="navbar-brand-logo">
                UDBL
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-home me-1"></i> Accueil</a></li>
                    
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-university me-1"></i> Facultés <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?page=actualites&amp;faculte=1"><i class="fas fa-university me-1"></i> Faculté de Sciences Informatique</a></li>
                            <li><a class="dropdown-item" href="index.php?page=actualites&amp;faculte=4"><i class="fas fa-university me-1"></i> Faculté de Gestion et Ingénierie</a></li>
                            <li><a class="dropdown-item" href="index.php?page=actualites&amp;faculte=5"><i class="fas fa-university me-1"></i> Faculté de Science de l'Homme et de la Société</a></li>
                            <li><a class="dropdown-item" href="index.php?page=actualites&amp;faculte=6"><i class="fas fa-university me-1"></i> Faculté de Théologie</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-graduation-cap me-1"></i> Formation <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?page=horaires"><i class="fas fa-clock me-1"></i> Horaires</a></li>
                            <li><a class="dropdown-item" href="https://www.esisalama.net/elearning/"><i class="fas fa-chevron-right me-1"></i> E-Learning</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-microscope me-1"></i> Recherche <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?page=publications"><i class="fas fa-file-alt me-1"></i> PUBLICATIONS</a></li>
                            <li><a class="dropdown-item" href="index.php?page=biblioth-que"><i class="fas fa-book me-1"></i> Bibliothèque</a></li>
                            <li><a class="dropdown-item" href="https://biblio-theologicum.org/"><i class="fas fa-chevron-right me-1"></i> Catalogue</a></li>
                            <li><a class="dropdown-item" href="index.php?page=centre-d-excellence"><i class="fas fa-chevron-right me-1"></i> Centre d'Excellence</a></li>
                            <li><a class="dropdown-item" href="index.php?page=laboratoire"><i class="fas fa-flask me-1"></i> Laboratoire</a></li>
                            <li><a class="dropdown-item" href="index.php?page=journ-es-scientifiques"><i class="fas fa-chevron-right me-1"></i> Journées scientifiques</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item"><a class="nav-link" href="index.php?page=cellule-interne-d-assurance-qualit"><i class="fas fa-shield-alt me-1"></i> CIAQ</a></li>
                    
                    <!-- Onglet Pré-inscription (Actif si on est sur la page) -->
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-plus me-1"></i> Pre-inscription <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?url=inscription"><i class="fas fa-user-plus me-1"></i> Pré-inscription</a></li>
                            <li><a class="dropdown-item" href="index.php?url=suivi-dossier"><i class="fas fa-search me-2"></i> Suivi du dossier</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item"><a class="nav-link" href="index.php?page=a-propos-de-nous"><i class="fas fa-info-circle me-1"></i> A propos</a></li>
                </ul>
                
                <form class="d-flex" action="index.php" method="get">
                    <input type="hidden" name="page" value="search">
                    <input class="form-control me-2" type="search" name="q" placeholder="Rechercher..." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </nav>