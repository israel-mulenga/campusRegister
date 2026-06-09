(function () {
  const BASE = window.APP_URL || '';
  let isOpen = false;

  const toggle = document.getElementById('chatbot-toggle');
  const win    = document.getElementById('chatbot-window');
  const overlay= document.getElementById('chatbotOverlay');
  const msgs   = document.getElementById('chatbot-messages');
  const input  = document.getElementById('chatbot-input');
  const sendBtn= document.getElementById('chatbot-send');
  const closeBtn=document.getElementById('chatbot-close');

  if (!toggle || !win) {
    console.warn('Chatbot init: missing elements', { toggle: !!toggle, win: !!win, overlay: !!overlay });
    return;
  }

  console.debug('Chatbot init:', { toggle: !!toggle, win: !!win, overlay: !!overlay, input: !!input, sendBtn: !!sendBtn, closeBtn: !!closeBtn });

  function now() {
    return new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
  }

  function appendMsg(text, type = 'bot') {
    const div = document.createElement('div');
    div.className = `msg ${type}`;
    div.innerHTML = `
      <div class="msg-bubble">${text.replace(/\n/g, '<br>')}</div>
      <div class="msg-time">${now()}</div>`;
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
    return div;
  }

  function showTyping() {
    const div = document.createElement('div');
    div.className = 'msg bot';
    div.id = 'typing-indicator';
    div.innerHTML = `<div class="typing-indicator">
      <div class="typing-dot"></div>
      <div class="typing-dot"></div>
      <div class="typing-dot"></div>
    </div>`;
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
  }

  function hideTyping() {
    const t = document.getElementById('typing-indicator');
    if (t) t.remove();
  }

  async function sendMessage(text) {
    if (!text.trim()) return;
    input.value = '';
    appendMsg(text, 'user');
    showTyping();
    sendBtn.disabled = true;

    try {
      const res  = await fetch('index.php?url=chatbot-api', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ question: text }),
      });
      const data = await res.json();
      hideTyping();
      appendMsg(data.response || 'Désolé, une erreur est survenue.', 'bot');
    } catch (e) {
      hideTyping();
      appendMsg("Une erreur de connexion est survenue. Veuillez réessayer.", 'bot');
    } finally {
      sendBtn.disabled = false;
      input.focus();
    }
  }

  // Suggestions rapides
  const suggestions = [
    'Quelles filières sont disponibles ?',
    'Comment s\'inscrire ?',
    'Quelles sont les dates ?',
    'Quels documents fournir ?',
    'Comment contacter l\'UDBL ?',
  ];

  function buildSuggestions() {
    const bar = document.getElementById('chatbot-suggestions');
    if (!bar) return;
    suggestions.forEach(s => {
      const btn = document.createElement('button');
      btn.textContent = s;
      btn.onclick = () => sendMessage(s);
      bar.appendChild(btn);
    });
  }

  // Events
  toggle.addEventListener('click', (ev) => {
    console.debug('chatbot toggle clicked, isOpen:', isOpen);
    isOpen = !isOpen;
    // Use the same class name as the CSS (.active) so the window becomes visible
    win.classList.toggle('active', isOpen);
    if (overlay) overlay.classList.toggle('active', isOpen);
    // Don't replace the button innerHTML (preserve the avatar image). Toggle a state class instead.
    toggle.classList.toggle('open', isOpen);
    toggle.setAttribute('aria-pressed', isOpen ? 'true' : 'false');
    if (isOpen) {
      if (input) input.focus();
      // Remove notification dot if present
      const dot = toggle.querySelector('.notif-dot');
      if (dot) dot.remove();
    }
  });

  closeBtn?.addEventListener('click', () => {
    isOpen = false;
    win.classList.remove('active');
    toggle.classList.remove('open');
    toggle.setAttribute('aria-pressed', 'false');
  });

  // Clicking on overlay closes the chatbot
  overlay?.addEventListener('click', () => {
    isOpen = false;
    win.classList.remove('active');
    overlay.classList.remove('active');
    toggle.classList.remove('open');
    toggle.setAttribute('aria-pressed', 'false');
  });

  sendBtn.onclick = () => sendMessage(input.value);

  input.addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      sendMessage(input.value);
    }
  });

  buildSuggestions();
})();
