<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Encodage pour éviter les symboles inappropriés sur les accents -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Université Don Bosco de Lubumbashi</title>
    <!-- Lien vers le CSS de Caleb (M7) -->
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

    <!-- Header basé sur la maquette UDBL -->
    <header style="background-color: #1F3864; color: white; padding: 10px 0;">
        <nav class="container" style="display: flex; justify-content: space-around; align-items: center;">
            <div class="logo">
                <img src="/public/images/logo_udbl.png" alt="Logo UDBL" style="height: 50px;">
            </div>
            <ul style="display: flex; list-style: none; gap: 20px;">
                <li><a href="/" style="color: white; text-decoration: none;">Accueil</a></li>
                <li><a href="#" style="color: white; text-decoration: none;">Facultés</a></li>
                <li><a href="#" style="color: white; text-decoration: none;">Formation</a></li>
                <li><a href="#" style="color: white; text-decoration: none;">Recherche</a></li>
                <li><a href="#" style="color: white; text-decoration: none;">A propos</a></li>
                <li><a href="/inscription" style="background-color: #2E75B5; padding: 10px; border-radius: 5px; color: white; text-decoration: none;">Inscription</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Section Hero : Présentation UDBL -->
        <section id="hero" style="text-align: center; padding: 60px 20px; background-color: #f8f9fa;">
            <h1 style="color: #1F3864;">Bienvenue à l'UDBL</h1>
            <p style="font-size: 1.2em; margin-bottom: 30px;">Préparez votre avenir au sein de notre institution d'excellence en République Démocratique du Congo.</p>
            <!-- Bouton CTA "Commencer ma pré-inscription" -->
            <a href="/inscription" class="cta-button" style="background-color: #1F3864; color: white; padding: 15px 30px; text-decoration: none; font-weight: bold; border-radius: 6px;">
                Commencer ma pré-inscription
            </a>
        </section>

        <section id="chatbot" style="background-color: #ffffff; padding: 40px 20px; margin: 0 auto; max-width: 900px; box-shadow: 0 0 12px rgba(0,0,0,0.05); border-radius: 12px;">
            <h2 style="text-align: center; color: #1F3864; margin-bottom: 20px;">Chatbot d'information</h2>
            <p style="text-align: center; color: #333; margin-bottom: 20px;">Posez une question sur l'inscription, les filières ou le suivi de dossier.</p>
            <form id="chatbot-form" style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: center;">
                <input id="chatbot-question" name="question" type="text" placeholder="Entrez votre question ici..." style="flex:1 1 300px; padding: 12px; border: 1px solid #ccc; border-radius: 8px;" />
                <button type="submit" style="background-color: #1F3864; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer;">Poser la question</button>
            </form>
            <div id="chatbot-response" style="margin-top: 20px; min-height: 60px; padding: 16px; background: #f4f7fb; border-radius: 8px; border: 1px solid #d9e2ef; color: #1f3864;"></div>
        </section>

        <!-- Section Filières : Cartes visuelles -->
        <section id="filieres" class="container" style="padding: 50px 20px;">
            <h2 style="text-align: center; color: #1F3864; margin-bottom: 40px;">Nos Facultes</h2>
            <div class="grid-filieres" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                
                <!-- Carte Filière 1 -->
                <article class="card" style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
                    <h3>Sciences Informatiques</h3>
                    <p>Formation dans les technologies numériques et le développement informatique.</p>
                    <a href="/inscription" style="color: #2E75B5; font-weight: bold;">S'inscrire en Génie Logiciel</a>
                </article>

                <!-- Carte Filière 2 -->
                <article class="card" style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
                    <h3>Gestion et Ingénierie Financière</h3>
                    <p>Formation orientée vers la finance, la gestion d'entreprise et l'analyse économique.</p>
                    <a href="/inscription" style="color: #2E75B5; font-weight: bold;">S'inscrire en Finance</a>
                </article>

                <!-- Carte Filière 3 -->
                <article class="card" style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
                    <h3>Sciences de l'Homme et de la Société</h3>
                    <p>Étude des relations humaines, sociales et du développement communautaire.</p>
                    <a href="/inscription" style="color: #2E75B5; font-weight: bold;">S'inscrire en Sciences Sociales</a>
                </article>

                 <!-- Carte Filière 4 -->
                <article class="card" style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
                     <h3>Theologie</h3>
                     <p>Formation biblique, théologique et pastorale pour le service de l'Église et de la société.</p>
                     <a href="/inscription" style="color: #2E75B5; font-weight: bold;">S'inscrire en Theologie</a>
                </article>

            </div>
        </section>
    </main>

    <!-- Footer basé sur la maquette 
    <footer style="background-color: #1F3864; color: white; padding: 40px 20px; margin-top: 50px;">
        <div class="container" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <div>
                <h4>COORDONNÉES</h4>
                <p>Lubumbashi, Haut-Katanga, RDC</p>
                <p>+(243) 822 267 472</p>
                <p>info@udbl.ac.cd</p>
            </div>
            <div>
                <h4>LIENS UTILES</h4>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#" style="color: white;">Filières</a></li>
                    <li><a href="#" style="color: white;">Actualités</a></li>
                    <li><a href="/suivi" style="color: white;">Suivre mon dossier</a></li>
                </ul>
            </div>
            <div>
                <h4>SUIVEZ-NOUS</h4>
                <p>Restez connecté pour ne rien manquer des actualités de l'UDBL.</p>
            </div>
        </div>
    </footer> -->

    <!-- Script pour le Chatbot de Caleb (M7) -->
    <script src="/public/js/chatbot.js"></script>
</body>
</html>