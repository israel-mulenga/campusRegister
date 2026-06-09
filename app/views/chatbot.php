
<div class="chatbot-overlay" id="chatbotOverlay"></div>

<div class="chatbot-window" id="chatbotWindow">
    <div class="chatbot-header">
        <div class="chatbot-header-info">
            <div class="chatbot-profile-circle">
                <img src="public/images/robot-avatar.png" alt="Assistant" onerror="this.src='https://cdn-icons-png.flaticon.com/512/4712/4712139.png'">
            </div>
            <div class="chatbot-status-text">
                <h4>Assistant UDBL</h4>
                <p><span class="status-dot"></span> En ligne · Répond instantanément</p>
            </div>
        </div>
        <button class="chatbot-close-btn" id="closeChatbot">&times;</button>
    </div>

    <div class="chatbot-body" id="chatbotBody">
        <div class="message system-msg">
            Bonjour ! Comment puis-je vous aider aujourd'hui concernant votre pré-inscription ou nos facultés ?
        </div>
    </div>

    <div class="chatbot-footer">
        <form id="chatbotForm" class="chatbot-input-container">
            <input type="text" placeholder="Entrez votre message..." id="chatbotInput" autocomplete="off">
            <button type="submit" class="chatbot-send-btn">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<a href="#" class="chatbot-floating-btn" id="chatbotBtn" title="Discutez avec notre assistant">
    <img src="public/images/robot-avatar.png" alt="Robot" onerror="this.src='https://cdn-icons-png.flaticon.com/512/4712/4712139.png'">
</a>

<script>
(function() {
    function initChat() {
        const btn = document.getElementById('chatbotBtn');
        const win = document.getElementById('chatbotWindow');
        const overlay = document.getElementById('chatbotOverlay');
        const close = document.getElementById('closeChatbot');
        const form = document.getElementById('chatbotForm');
        const input = document.getElementById('chatbotInput');
        const body = document.getElementById('chatbotBody');
        
        // Éléments de l'arrière-plan à flouter
        const targets = document.querySelectorAll('nav, #myCarousel, .container, footer');

        if (!btn || !win || !overlay) return;

        // --- GESTION INTERFACE (OUVERTURE / FERMETURE) ---
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            win.classList.add('active');
            overlay.classList.add('active');
            btn.style.display = 'none';

            targets.forEach(el => {
                if (el) {
                    el.style.transition = 'filter 0.3s ease';
                    el.style.filter = 'blur(5px) grayscale(15%)';
                    el.style.pointerEvents = 'none';
                }
            });
        });

        function handleClose() {
            win.classList.remove('active');
            overlay.classList.remove('active');
            btn.style.display = 'flex';

            targets.forEach(el => {
                if (el) {
                    el.style.filter = 'none';
                    el.style.pointerEvents = 'auto';
                }
            });
        }

        if (close) close.addEventListener('click', handleClose);
        if (overlay) overlay.addEventListener('click', handleClose);


        // --- GESTION DES MESSAGES (API / FETCH) ---
        if (form && input && body) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                const question = input.value.trim();
                if (!question) return;

                // 1. Ajouter la bulle de l'utilisateur dans la discussion
                const userDiv = document.createElement('div');
                userDiv.className = 'message user-msg';
                userDiv.textContent = question;
                body.appendChild(userDiv);

                // Réinitialiser le champ de texte et scroller vers le bas
                input.value = '';
                body.scrollTop = body.scrollHeight;

                // 2. Ajouter une bulle de chargement temporaire pour le robot
                const loadingDiv = document.createElement('div');
                loadingDiv.className = 'message loading-msg';
                loadingDiv.textContent = 'Assistant écrit...';
                body.appendChild(loadingDiv);
                body.scrollTop = body.scrollHeight;

                // 3. Appel Ajax vers votre API
                fetch('/chatbot-api', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ question: question })
                })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    // Supprimer l'indicateur de chargement
                    loadingDiv.remove();

                    // Créer la bulle de réponse du robot
                    const replyDiv = document.createElement('div');
                    replyDiv.className = 'message system-msg';

                    if (data.success) {
                        replyDiv.textContent = data.answer;
                    } else {
                        replyDiv.textContent = data.message || 'Impossible de récupérer la réponse.';
                    }

                    body.appendChild(replyDiv);
                    body.scrollTop = body.scrollHeight;
                })
                .catch(function () {
                    loadingDiv.remove();
                    
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'message system-msg';
                    errorDiv.style.color = '#dc3545';
                    errorDiv.textContent = 'Erreur lors de la connexion au chatbot. Réessayez plus tard.';
                    
                    body.appendChild(errorDiv);
                    body.scrollTop = body.scrollHeight;
                });
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initChat);
    } else {
        initChat();
    }
})();
</script>