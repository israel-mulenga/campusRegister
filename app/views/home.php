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
