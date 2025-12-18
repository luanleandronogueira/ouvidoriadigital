(function(){
    // Variáveis de Configuração
    // **************** ATENÇÃO: AJUSTE O API_URL AQUI ****************
    const API_URL = 'http://localhost/it_ai/atricon.php'; 
    const TOKKEN = 'itsolit';
    const ID = '64';

    // Constantes para o Balão de Sugestão
    const SUGGESTION_CYCLE_MS = 30 * 1000; // Ciclo de 30 segundos
    const SUGGESTION_DISPLAY_MS = 8 * 1000; // Exibir por 8 segundos

    // Mapeamento dos Elementos HTML
    const openBtn = document.getElementById('openChat');
    const closeBtn = document.getElementById('closeChat');
    const panel = document.getElementById('chatPanel');
    const messages = document.getElementById('messages');
    const input = document.getElementById('inputPergunta');
    const sendBtn = document.getElementById('sendBtn');
    const suggestionBubble = document.getElementById('it-ai-suggestion-bubble');
    
    let suggestionInterval;

    // ----------------------------------------------------
    // FUNÇÕES DO CHAT PRINCIPAL
    // ----------------------------------------------------
    
    function hideSuggestionBubble() {
        if (suggestionBubble) {
            suggestionBubble.classList.remove('show');
            setTimeout(() => {
                suggestionBubble.style.display = 'none';
            }, 300);
        }
    }

    function openChat(){
        panel.classList.add('open');
        panel.setAttribute('aria-hidden','false');
        input.focus();
        messages.scrollTop = messages.scrollHeight;
        
        // Pausa e oculta o balão de sugestão se ele estiver ativo
        clearInterval(suggestionInterval);
        suggestionInterval = null;
        hideSuggestionBubble();
    }
    
    function closeChat(){
        panel.classList.remove('open');
        panel.setAttribute('aria-hidden','true');
        
        // Reinicia o ciclo de sugestão ao fechar o chat
        if (!suggestionInterval) {
            suggestionInterval = setInterval(showSuggestionBubble, SUGGESTION_CYCLE_MS);
        }
    }

    // ----------------------------------------------------
    // FUNÇÕES DO BALÃO DE SUGESTÃO
    // ----------------------------------------------------
    
    function showSuggestionBubble() {
        // Só mostra se o painel principal estiver FECHADO
        if (!panel.classList.contains('open') && suggestionBubble) {
            suggestionBubble.style.display = 'block';
            void suggestionBubble.offsetWidth; 
            suggestionBubble.classList.add('show');

            // Esconde após o tempo de exibição
            setTimeout(hideSuggestionBubble, SUGGESTION_DISPLAY_MS);
        }
    }

    // ----------------------------------------------------
    // FUNÇÕES DE MENSAGEM E LÓGICA
    // ----------------------------------------------------

    function appendMessage(text, who='ai'){
        const wrap = document.createElement('div');
        wrap.className = 'message ' + (who === 'user' ? 'user' : 'ai') + ' mb-0';
        
        const bubble = document.createElement('div');
        bubble.className = 'bubble';

        if (who === 'ai'){
            const avatar = document.createElement('div');
            avatar.className = 'avatar';
            avatar.setAttribute('aria-hidden', 'true');
            avatar.textContent = 'IA';
            wrap.appendChild(avatar);
            bubble.innerHTML = text;
        } else {
            bubble.innerHTML = text;
        }
        
        wrap.appendChild(bubble);
        messages.appendChild(wrap);
        messages.scrollTop = messages.scrollHeight;
        return bubble;
    }

    function setLoading(s){
        sendBtn.disabled = s;
        sendBtn.textContent = s ? 'Aguarde...' : 'Enviar';
        input.disabled = s;
    }

    function sleep(ms){ return new Promise(r => setTimeout(r, ms)); }

    async function typeText(el, text, speed = 16){
        el.classList.add('typing-cursor');
        el.textContent = '';
        
        let currentText = '';
        for (let i = 0; i < text.length; i++){
            const char = text[i];
            currentText += char;
            el.innerHTML = currentText;
            messages.scrollTop = messages.scrollHeight;
            await sleep(speed);
        }
        el.classList.remove('typing-cursor');
    }

    async function send(){
        const pergunta = input.value && input.value.trim();
        if (!pergunta) return;
        
        // 1. Mostra pergunta do usuário
        appendMessage(pergunta, 'user');
        input.value = '';
        setLoading(true);

        // 2. Insere loader (loader-dots)
        const loaderWrap = document.createElement('div');
        loaderWrap.className = 'message ai mb-0';
        loaderWrap.innerHTML = '<div class="avatar" aria-hidden="true">IA</div><div class="bubble loader"><span class="loader-dots"><span></span><span></span><span></span></span></div>';
        messages.appendChild(loaderWrap);
        messages.scrollTop = messages.scrollHeight;

        try {
            // 3. Envia para o Backend
            const payload = { tokken: TOKKEN, pergunta: pergunta, id: ID };
            const res = await fetch(API_URL, {
                method: 'POST',
                headers: { 'Content-Type':'application/json' },
                body: JSON.stringify(payload)
            });

            if (!res.ok) throw new Error('HTTP ' + res.status);

            const data = await res.json().catch(()=>null);
            const textoCompleto = (data && (data.resposta ?? data.message)) || JSON.stringify(data) || 'Resposta vazia.';
            
            // 4. Substituir loader por bubble vazia e digitar nela
            const newBubble = document.createElement('div');
            newBubble.className = 'bubble';
            
            loaderWrap.replaceChild(newBubble, loaderWrap.querySelector('.bubble'));
            
            await typeText(newBubble, textoCompleto, 16);

        } catch (err){
            // Erro: substituir loader pela mensagem de erro
            const errText = 'Erro: ' + (err.message || err);
            const newBubble = document.createElement('div');
            newBubble.className = 'bubble';
            loaderWrap.replaceChild(newBubble, loaderWrap.querySelector('.bubble'));
            await typeText(newBubble, errText, 12);
        } finally {
            setLoading(false);
            messages.scrollTop = messages.scrollHeight;
        }
    }
    
    // ----------------------------------------------------
    // LISTENERS E INICIALIZAÇÃO
    // ----------------------------------------------------

    openBtn.addEventListener('click', openChat);
    closeBtn.addEventListener('click', closeChat);
    input.addEventListener('keydown', e => { if (e.key === 'Enter') send(); });
    sendBtn.addEventListener('click', send);
    
    if (suggestionBubble) {
        suggestionBubble.addEventListener('click', () => {
            openChat();
        });
    }
    
    // Inicia o ciclo de sugestão automaticamente
    suggestionInterval = setInterval(showSuggestionBubble, SUGGESTION_CYCLE_MS);

    // Abrir automaticamente em telas pequenas
    if (window.innerWidth < 600) openChat();
})();