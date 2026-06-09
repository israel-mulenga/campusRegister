<button id="chatbot-toggle" class="chatbot-floating-btn" title="Assistant UDBL">
    <img src="public/images/robot-avatar.png" alt="Assistant" onerror="this.src='https://cdn-icons-png.flaticon.com/512/4712/4712139.png'">
    <span class="notif-dot"></span>
</button>
<div class="chatbot-overlay" id="chatbotOverlay"></div>

<div class="chatbot-window" id="chatbot-window">
    <div class="chatbot-header">
        <div class="chatbot-header-info">
            <div class="chatbot-profile-circle">
                <img src="public/images/robot-avatar.png" alt="Assistant" onerror="this.src='https://cdn-icons-png.flaticon.com/512/4712/4712139.png'">
            </div>
            <div class="chatbot-status-text">
                <h4>Assistant UDBL</h4>
                <p><span class="status-dot">Disponible 24h/24 — 7j/7</span></p>
            </div>
        </div>
        <button class="chatbot-close" id="chatbot-close">&times;</button>
    </div>

    <div class="chatbot-body" id="chatbotBody">
        <div class="message system-msg">
            Bonjour ! Comment puis-je vous aider aujourd'hui concernant votre pré-inscription ou nos facultés ?
        </div>
    </div>

    <div class="chatbot-messages" id="chatbot-messages">
        <div class="msg bot">
            <div class="msg-bubble">Bonjour ! 👋 Je suis l'assistant virtuel de l'UDBL. Je peux répondre à vos questions sur les filières, les inscriptions, les conditions d'admission et plus encore.<br><br>Comment puis-je vous aider ?</div>
        </div>
    </div>
    <div class="chatbot-suggestions" id="chatbot-suggestions"></div>
        <div class="chatbot-input-area">
        <input type="text" id="chatbot-input" placeholder="Posez votre question..." maxlength="300">
        <button class="chatbot-send" id="chatbot-send">➤</button>
    </div>
</div>