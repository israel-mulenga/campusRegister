<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Université Don Bosco de Lubumbashi</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

    <!-- Header basé sur la maquette UDBL -->
    <header>
        <nav class="container">
            <div class="logo">
                <img src="/public/images/logo_udbl.png" alt="UDBL">
            </div>
            <ul>
                <li><a href="/">Accueil</a></li>
                <li><a href="#">Facultés</a></li>
                <li><a href="#">Formation</a></li>
                <li><a href="#">Recherche</a></li>
                <li><a href="#">A propos</a></li>
                <li><a href="/inscription" class="btn-inscription">Inscription</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Section Hero -->
        <section id="hero">
            <h1>Bienvenue à l'UDBL</h1>
            <p>Préparez votre avenir au sein de notre institution d'excellence en République Démocratique du Congo.</p>
            <a href="/inscription" class="cta-button">Commencer ma pré-inscription</a>
        </section>

        <!-- Section Filières -->
        <section id="filieres" class="container">
            <h2>Nos Facultés</h2>
            <div class="grid-filieres">
                <article class="card">
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
                    <a href="/inscription">S'inscrire en Génie Logiciel</a>
                </article>

                <article class="card">
                    <h3>Gestion et Ingénierie Financière</h3>
                    <p>Formation orientée vers la finance, la gestion d'entreprise et l'analyse économique.</p>
                    <a href="/inscription">S'inscrire en Finance</a>
                </article>

                <article class="card">
                    <h3>Sciences de l'Homme et de la Société</h3>
                    <p>Étude des relations humaines, sociales et du développement communautaire.</p>
                    <a href="/inscription">S'inscrire en Sciences Sociales</a>
                </article>

                <article class="card">
                    <h3>Théologie</h3>
                    <p>Formation biblique, théologique et pastorale pour le service de l'Église et de la société.</p>
                    <a href="/inscription">S'inscrire en Théologie</a>
                </article>
            </div>
        </section>
    </main>

    <!-- Bouton flottant du chatbot -->
    <button id="chatbot-toggle" class="chatbot-button">💬</button>

    <!-- Fenêtre du chatbot -->
    <div id="chatbot-window" class="chatbot-overlay">
        <div class="chatbot-header">
            <h2>Chatbot d'information</h2>
            <button id="chatbot-close" class="close-button">✖</button>
        </div>
        <div class="chatbot-body">
            <div id="chatbot-messages" class="messages">
                <!-- Messages du chatbot apparaîtront ici -->
            </div>
            <form id="chatbot-form" class="chatbot-form">
                <input id="chatbot-question" name="question" type="text" placeholder="Entrez votre question..." />
                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>

    <script src="/public/js/chatbot.js"></script>
</body>
</html>
