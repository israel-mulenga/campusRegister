<?php
/**
 * Fichier : app/views/candidat/inscription.php
 * Rôle : Formulaire de pré-inscription UDBL
 */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pré-inscription - UDBL</title>
</head>

<body>

<main>

    <!-- HEADER -->
    <section>
        <div>
            <h1>Formulaire de Pré-inscription</h1>
            <p>
                Remplissez toutes les informations pour soumettre votre candidature
                • Année académique 2026-2027
            </p>
        </div>
    </section>

    <!-- ONGLETS -->
    <section>
        <button class="tab-btn active-tab" id="tab1" type="button">Info Personnelles</button>
        <button class="tab-btn" id="tab2" type="button">Parcours académique</button>
        <button class="tab-btn" id="tab3" type="button">Choix de la faculté</button>
        <button class="tab-btn" id="tab4" type="button">Confirmation</button>
    </section>

    <!-- FORMULAIRE -->
    <form action="/inscription/store" method="POST" enctype="multipart/form-data">

        <!-- ETAPE 1 -->
        <div class="step" id="step1">
            <div>
                <label for="photo">Importer une photo</label>
                <input type="file" id="photo" name="photo" accept="image/*">
            </div>

            <div>
                <div>
                    <label>Nom</label>
                    <input type="text" name="nom" required placeholder="ex. MONINGA KINDJI Caleb">
                </div>
                <div>
                    <label>Nationalité</label>
                    <input type="text" name="nationalite" required placeholder="ex. congolaise">
                </div>
                <div>
                    <label>Date de Naissance</label>
                    <input type="date" name="date_naissance" required>
                </div>
                <div>
                    <label>Genre</label>
                    <div>
                        <label><input type="radio" name="genre" value="M"> Masculin</label>
                        <label><input type="radio" name="genre" value="F"> Féminin</label>
                    </div>
                </div>
                <div>
                    <label>Lieu de Naissance</label>
                    <input type="text" name="lieu_naissance" required placeholder="ex. Lubumbashi">
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="ex. caleb@gmail.com">
                </div>
            </div>
        </div>

        <!-- ETAPE 2 -->
<div class="step" id="step2">

    <!-- Choix du niveau -->
    <div>
        <label>Niveau d'inscription</label>
        <div>
            <label><input type="radio" name="niveau" value="licence" id="licence"> Licence</label>
            <label><input type="radio" name="niveau" value="master" id="master"> Master</label>
        </div>
    </div>

    <!-- Bloc Licence -->
    <div id="bloc-licence" style="display:none;">
        <h3>Vous avez choisi l’inscription en Licence</h3>

        <div>
            <label>Nom Établissement d'origine</label>
            <input type="text" name="etablissement_origine_licence">
        </div>

        <div>
            <label>Pays/Ville Établissement</label>
            <input type="text" name="ville_etablissement_licence">
        </div>

        <div>
            <label>Option/Section</label>
            <input type="text" name="option_licence">
        </div>

        <div>
            <label>Diplôme d’État ou Autre</label>
            <input type="text" name="diplome_etat">
        </div>

        <div>
            <label>Année d’obtention du diplôme</label>
            <input type="number" name="annee_diplome_licence">
        </div>

        <div>
            <label>Pourcentage/Mention</label>
            <input type="text" name="pourcentage_licence">
        </div>

        <div>
            <label>Distinction</label>
            <input type="text" name="distinction_licence">
        </div>
    </div>

    <!-- Bloc Master -->
    <div id="bloc-master" style="display:none;">
        <h3>Vous avez choisi l’inscription en Master</h3>

        <div>
            <label>Université d'origine</label>
            <input type="text" name="universite_origine_master">
        </div>

        <div>
            <label>Pays/Ville Université</label>
            <input type="text" name="ville_universite_master">
        </div>

        <div>
            <label>Faculté ou Département</label>
            <input type="text" name="faculte_master">
        </div>

        <div>
            <label>Filière/Domaine d’étude</label>
            <input type="text" name="filiere_master">
        </div>

        <div>
            <label>Diplôme de Licence</label>
            <input type="text" name="diplome_master">
        </div>

        <div>
            <label>Année d’obtention du diplôme</label>
            <input type="number" name="annee_diplome_master">
        </div>

        <div>
            <label>Pourcentage/Mention</label>
            <input type="text" name="pourcentage_master">
        </div>

        <div>
            <label>Distinction</label>
            <input type="text" name="distinction_master">
        </div>
    </div>

</div>


  <!-- ETAPE 3 -->
<div class="step" id="step3">
    <h2>Choisissez la faculté dans laquelle vous souhaitez vous inscrire</h2>

    <!-- Sciences Informatiques -->
    <div class="faculte-box">
        <h3>Sciences Informatiques</h3>
        <p>Formation dans les technologies numériques et le développement informatique.</p>

        <!-- Liste des filières -->
        <div>
            <label><input type="radio" name="filiere_informatique" value="administration"> Administration Système et Réseaux</label>
        </div>
        <div>
            <label><input type="radio" name="filiere_informatique" value="telecom"> Télécommunication et Réseaux</label>
        </div>
        <div>
            <label><input type="radio" name="filiere_informatique" value="genie_logiciel"> Génie Logiciel</label>
        </div>
        <div>
            <label><input type="radio" name="filiere_informatique" value="management_si"> Management des Systèmes d'Informations</label>
        </div>
        <div>
            <label><input type="radio" name="filiere_informatique" value="design_multimedia"> Design et Multimédias</label>
        </div>

        <button type="submit" name="faculte" value="informatique">Valider votre choix</button>
    </div>

    <!-- Exemple autres facultés (sans filières détaillées) -->
    <div class="faculte-box">
        <h3>Gestion et Ingénierie Financière</h3>
        <p>Formation orientée vers la finance, la gestion d’entreprise et analyse économique.</p>
        <button type="submit" name="faculte" value="gestion">Valider votre choix</button>
    </div>

    <div class="faculte-box">
        <h3>Sciences de l’Homme et de la Société</h3>
        <p>Étude des relations humaines, sociales et du développement communautaire.</p>
        <button type="submit" name="faculte" value="sciences_homme">Valider votre choix</button>
    </div>

    <div class="faculte-box">
        <h3>Théologie</h3>
        <p>Formation biblique, spirituelle et ministérielle.</p>
        <button type="submit" name="faculte" value="theologie">Valider votre choix</button>
    </div>
</div>


       <!-- ETAPE 4 -->
<div class="step" id="step4">
    <h2>Confirmation</h2>
    <p>Vérifiez vos informations avant de confirmer votre inscription.</p>

    <!-- Conteneur pour afficher les infos saisies -->
    <div class="confirmation-box">
        <!-- Ces <p> resteront vides par défaut et seront remplis par le backend -->
        <p id="confirm-nom"></p>
        <p id="confirm-niveau"></p>
        <p id="confirm-faculte"></p>
        <p id="confirm-etablissement"></p>
        <p id="confirm-annee"></p>
    </div>

    <!-- Bouton de confirmation -->
    <button type="submit">Confirmer votre inscription</button>
</div>


        <!-- NAVIGATION BAS -->
        <div>
            <button type="button" class="step-btn" id="btn1">1</button>
            <button type="button" class="step-btn" id="btn2">2</button>
            <button type="button" class="step-btn" id="btn3">3</button>
            <button type="button" class="step-btn" id="btn4">4</button>
        </div>

    </form>

</main>

<script>
function showStep(stepNumber) {
    document.querySelectorAll('.step').forEach(step => {
        step.style.display = 'none';
    });
    document.getElementById('step' + stepNumber).style.display = 'block';
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.step').forEach(step => {
        step.style.display = 'none';
    });
    document.getElementById('step1').style.display = 'block';
});

// navigation onglets du haut
document.getElementById('tab1').addEventListener('click', () => showStep(1));
document.getElementById('tab2').addEventListener('click', () => showStep(2));
document.getElementById('tab3').addEventListener('click', () => showStep(3));
document.getElementById('tab4').addEventListener('click', () => showStep(4));

// navigation boutons du bas
document.getElementById('btn1').addEventListener('click', () => showStep(1));
document.getElementById('btn2').addEventListener('click', () => showStep(2));
document.getElementById('btn3').addEventListener('click', () => showStep(3));
document.getElementById('btn4').addEventListener('click', () => showStep(4));

// logique Licence/Master
document.getElementById('licence').addEventListener('change', () => {
    document.getElementById('bloc-licence').style.display = 'block';
    document.getElementById('bloc-master').style.display = 'none';
});
document.getElementById('master').addEventListener('change', () => {
    document.getElementById('bloc-master').style.display = 'block';
    document.getElementById('bloc-licence').style.display = 'none';
});
</script>

</body>
</html>
