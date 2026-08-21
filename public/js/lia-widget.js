(function () {
    const toggleBtn = document.getElementById('liaToggle');
    const closeBtn = document.getElementById('liaClose');
    const panel = document.getElementById('liaPanel');
    const form = document.getElementById('liaForm');
    const input = document.getElementById('liaInput');
    const sendBtn = document.getElementById('liaSend');
    const messagesEl = document.getElementById('liaMessages');

    if (!toggleBtn || !panel || !form) return;

    const chatHistory = [];
    let greeted = false;

    function addMessage(role, text) {
        const bubble = document.createElement('div');
        bubble.className = 'lia-msg ' + (role === 'user' ? 'lia-msg--user' : 'lia-msg--bot');
        bubble.textContent = text;
        messagesEl.appendChild(bubble);
        messagesEl.scrollTop = messagesEl.scrollHeight;
        return bubble;
    }

    function togglePanel(show) {
        panel.classList.toggle('active', show);
        if (show && !greeted) {
            greeted = true;
            addMessage('bot', "Bonjour, je suis Lia, l'assistante virtuelle de Kopiao. Comment puis-je vous aider ?");
        }
        if (show) input.focus();
    }

    toggleBtn.addEventListener('click', () => togglePanel(!panel.classList.contains('active')));
    closeBtn?.addEventListener('click', () => togglePanel(false));

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;

        addMessage('user', message);
        input.value = '';
        input.disabled = true;
        sendBtn.disabled = true;

        const typing = document.createElement('div');
        typing.className = 'lia-msg lia-msg--typing';
        typing.textContent = 'Lia écrit…';
        messagesEl.appendChild(typing);
        messagesEl.scrollTop = messagesEl.scrollHeight;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch('/lia/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken || '',
            },
            body: JSON.stringify({ message, history: chatHistory.slice(-10) }),
        })
            .then(async (response) => {
                const data = await response.json().catch(() => ({}));
                if (!response.ok) {
                    throw new Error(data.message || 'Erreur du service.');
                }
                typing.remove();
                addMessage('bot', data.reply || "Désolée, je n'ai pas pu générer de réponse.");
                chatHistory.push({ role: 'user', content: message });
                chatHistory.push({ role: 'assistant', content: data.reply });
            })
            .catch(() => {
                typing.remove();
                addMessage('bot', 'Une erreur est survenue. Veuillez réessayer dans un instant.');
            })
            .finally(() => {
                input.disabled = false;
                sendBtn.disabled = false;
                input.focus();
            });
    });
})();
