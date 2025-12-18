<!-- <div id="it-ai-chat-container">
    
    <div id="it-ai-suggestion-bubble" class="it-ai-suggestion-bubble" style="display: none;">
      Oi, me chamo ItAI! Como Posso ajudar?
    </div>

    <div class="it-ai-chat-button" id="openChat">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gemini-style">
            <circle cx="12" cy="6" r="2"></circle>
            <circle cx="12" cy="18" r="2"></circle>
            <circle cx="6" cy="12" r="2"></circle>
            <circle cx="18" cy="12" r="2"></circle>
            <path d="M12 8v8M8 12h8"></path>
        </svg>
    </div>

    <div class="it-ai-chat-window" id="chatPanel" aria-hidden="true">
        <div class="it-ai-header">
            <span class="it-ai-title">It Soluções IA</span>
            <button class="it-ai-close-button" id="closeChat">&times;</button>
        </div>
        <div class="it-ai-messages-wrapper" id="messages">
            <div class="message ai mb-0">
                <div class="avatar" aria-hidden="true">IA</div>
                <div class="bubble">Olá! Eu sou a IA da It Soluções Inteligentes. Como posso te ajudar com o Portal da Transparência?</div>
            </div>
            </div>
        <div class="it-ai-input-area">
            <input type="text" id="inputPergunta" placeholder="Digite sua pergunta...">
            <button id="sendBtn">Enviar</button>
        </div>
    </div>
</div> -->


<footer class="mt-5">
    <div class="footer">
        <div class="footer-logo">
            <img src="assets/images/logo_branca.png" alt="Ouvidoria Web">
        </div>
        <div class="footer-links">
            <h5>Usuário</h5>
            <a href="perfil.php">Meu Perfil</a></li>
            <a href="minhas_manifestacoes.php">Minhas Solicitações</a>
            <a href="dashboard.php#main">Registrar uma Solicitação</a>
        </div>
        <div class="footer-links">
            <h5>Informações</h5>
            <a href="faq.php">Perguntas Frequentes</a>
            <a href="politica_privacidades.php">Políticas de Privacidade</a>
            <a target="_blank" href="https://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709.htm">Lei Geral de Proteção de Dados</a>
            <a href="mapa_site.php">Mapa do Site</a>
        </div>
        <div class="footer-links">
            <h5>Ajuda</h5>
            <a target="_blank" href="https://portaltransparencia.app.br/ouvidoriaMunicipal.aspx?p_i=<?=$_SESSION['id_portal']?>&p_t=1">Ouvidoria Presencial</a>
        </div>
    </div>
    <div class="copyright">
        &copy;<?= date('Y') ?> Desenvolvido por L3tecnologia
    </div>
</footer>
</main>
<script src="assets/js/script.js"></script>
<script src="assets/js/chat_ia.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "order": [
                [0, "desc"]
            ],
            "language": {
                "decimal": "",
                "emptyTable": "Nenhum dado disponível na tabela",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                "infoFiltered": "(filtrado de _MAX_ entradas totais)",
                "infoPostFix": "",
                "thousands": ".",
                "lengthMenu": "Mostrar _MENU_ entradas",
                "loadingRecords": "Carregando...",
                "processing": "Processando...",
                "search": "Pesquisar:",
                "zeroRecords": "Nenhum registro encontrado",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": ativar para ordenar a coluna em ordem crescente",
                    "sortDescending": ": ativar para ordenar a coluna em ordem decrescente"
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.date').mask('00/00/0000');
        $('.time').mask('00:00:00');
        $('.date_time').mask('00/00/0000 00:00:00');
        $('.cep').mask('00000-000');
        $('.phone').mask('0000-0000');
        $('.phone_with_ddd').mask('(00) 0000-0000');
        $('.phone_us').mask('(000) 000-0000');
        $('.mixed').mask('AAA 000-S0S');
        $('.cpf').mask('000.000.000-00', {
            reverse: true
        });
        $('.cnpj').mask('00.000.000/0000-00', {
            reverse: true
        });
        $('.money').mask('000.000.000.000.000,00', {
            reverse: true
        });
        $('.money2').mask("#.##0,00", {
            reverse: true
        });
        $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
            translation: {
                'Z': {
                    pattern: /[0-9]/,
                    optional: true
                }
            }
        });
        $('.ip_address').mask('099.099.099.099');
        $('.percent').mask('##0,00%', {
            reverse: true
        });
        $('.clear-if-not-match').mask("00/00/0000", {
            clearIfNotMatch: true
        });
        $('.placeholder').mask("00/00/0000", {
            placeholder: "__/__/____"
        });
        $('.fallback').mask("00r00r0000", {
            translation: {
                'r': {
                    pattern: /[\/]/,
                    fallback: '/'
                },
                placeholder: "__/__/____"
            }
        });
        $('.selectonfocus').mask("00/00/0000", {
            selectOnFocus: true
        });
    });
</script>
<script>
    /**
 * Define um cookie.
 * @param {string} name Nome do cookie.
 * @param {string} value Valor a ser salvo (pode ser o JSON das coordenadas).
 * @param {number} days Dias de validade.
 */
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    // Salva o cookie no caminho raiz (/) para que esteja acessível em todas as páginas
    document.cookie = name + "=" + (value || "")  + expires + "; path=/; secure; samesite=Lax";
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for(let i=0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
    // coletaLocalizacao();
    document.addEventListener('DOMContentLoaded', (event) => {

        const opcoes = {
            enableHighAccuracy: true,
            timeout: 5000, // Tempo limite de 5 segundos
            maximumAge: 0 // Não usar localização em cache
        };

        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(

                (localizacaoAtual) => {

                    const latitude = localizacaoAtual.coords.latitude
                    const longitude = localizacaoAtual.coords.longitude

                    // Salva latitude e longitude no Cookie
                    setCookie('latitude', latitude, 1)
                    setCookie('longitude', longitude, 1)

                },
                (error) => {

                    console.error('erro:', error);
                },
                opcoes
            )


        } else {
            
            console.error("Geolocalização não é suportada neste navegador.");

        }

    })
</script>
</body>

</html>