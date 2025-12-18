    <footer class="mt-5">
        <div class="footer">
            <div class="footer-logo">
                <img src="../assets/images/logo_branca.png" alt="Ouvidoria Web">
            </div>
            <div class="footer-links">
                <h5>Usuário</h5>
                <a href="perfil.php">Meu Perfil</a></li>
                
            </div>
            <div class="footer-links">
                <h5>Informações</h5>
                <a href="minhas_manifestacoes.php">Manifestações</a>
                <a href="dados_analiticos.php#main">Dados Analíticos</a>
                <a target="_blank" href="https://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709.htm">Lei Geral de Proteção de Dados</a>
            </div>
            <div class="footer-links">
                <h5>Ajuda</h5>
                <a target="_blank" href="suporte.php">Suporte</a>
            </div>
        </div>
        <div class="copyright">
            &copy;<?= date('Y') ?> Desenvolvido por L3tecnologia
        </div>
    </footer>
    </main>
    <script src="../assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>

    <!-- Leaflet -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- Leaflet -->
    <script>
        const locais = <?php echo $coodenadas_manifestacoes; ?>;

        const marcadoresArray = [];

        locais.forEach(local => {
            const marker = L.marker([local.latitude, local.longitude])
                .bindPopup(`Manifestação: <a href='manifestacao.php?protocolo=${local.protocolo_manifestacao}'>${local.protocolo_manifestacao}</a>`);

            // Adiciona o marcador ao array de marcadores
            marcadoresArray.push(marker);
        })

        // 2. Criação do Grupo de Camadas (incluindo todos os marcadores)
        var cities = L.layerGroup(marcadoresArray);

        // 3. Camadas de Mapa
        var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        });

        var osmHOT = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
            maxZoom: 15,
            attribution: '© OpenStreetMap contributors, Tiles style by Humanitarian OpenStreetMap Team hosted by OpenStreetMap France'
        });

        // 4. Inicialização do Mapa
        var map = L.map('mapa', {
            center: [-8.88, -36.49], // Um ponto central na área dos seus marcadores (Pernambuco)
            zoom: 8, // Um zoom inicial mais adequado para a visualização local
            layers: [osm, cities]
        });

        // 5. Otimização: Ajustar o mapa para mostrar todos os marcadores na tela
        var bounds = cities.getBounds();
        if (bounds.isValid()) {
            map.fitBounds(bounds, {
                padding: [50, 50]
            });
        }
    </script>
    
    <script>
        // Mapeia o objeto de dados PHP para uma variável JavaScript
        // Usa fallback seguro quando a página que inclui o footer não definiu `$js_data`.
        const analyticsData = <?= isset($js_data) ? $js_data : json_encode([
            'por_tipo' => [],
            'por_mes' => [],
            'total_identificados' => ['anonimas' => 0, 'identificadas' => 0]
        ]) ?>;

        // Array de cores baseado no style.css para os gráficos de pizza/rosca
        const coresPrimarias = [
            '#303C60', // --cor-primaria (Azul Marinho)
            '#8A9ADE', // --cor-secundaria (Azul Lavanda)
            '#E9B91A', // --cor-amarela (Amarelo)
            '#F72627', // --cor-vermelha (Vermelho)
            '#007833', // --cor-verde (Verde)
            '#D8217B', // --cor-lilas (Pink/Lilás)
            '#FF7F17', // --cor-laranja (Laranja)
            '#0081F7', // --cor-azul (Azul Claro)
            '#9e9e9f' // --cor-cinza (Cinza)
        ];

        // Mapeamento de números de mês para nomes em Português
        const nomesMeses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

        // Funções auxiliares para processamento de dados

        function processarDadosPorMes(data) {
            // Ordena e formata as labels (Mês/Ano)
            const labels = data.map(item => `${nomesMeses[item.mes - 1]}/${item.ano.toString().substr(2, 2)}`);
            const totais = data.map(item => item.total);
            return {
                labels,
                totais
            };
        }

        // **FUNÇÃO AUXILIAR CORRIGIDA/ADICIONADA**
        function processarDadosPorTipo(data) {
            // Extrai nomes dos tipos e totais
            const labels = data.map(item => item.nome_tipo_manifestacao);
            const totais = data.map(item => item.total);
            return {
                labels,
                totais
            };
        }


        // Gráfico 1: Linha - Manifestações por Mês (Solicitações por mês)
        function criarChartPorMes() {
            const {
                labels,
                totais
            } = processarDadosPorMes(analyticsData.por_mes);
            const ctx = document.getElementById('chartManifestacoesPorMes').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total de Solicitações',
                        data: totais,
                        borderColor: coresPrimarias[1], // --cor-secundaria
                        backgroundColor: 'rgba(138, 154, 222, 0.2)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    // **CORREÇÃO CRÍTICA: Permite que o CSS controle a altura do gráfico**
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Quantidade'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Mês/Ano'
                            }
                        }
                    }
                }
            });
        }

        // **GRÁFICO 2: Pizza/Rosca - Distribuição por Tipo**
        function criarChartPorTipo() {
            const {
                labels,
                totais
            } = processarDadosPorTipo(analyticsData.por_tipo);

            const ctx = document.getElementById('chartManifestacoesPorTipo').getContext('2d');

            new Chart(ctx, {
                type: 'doughnut', // Tipo Pie (pizza) ou Doughnut (rosca)
                data: {
                    labels: labels,
                    datasets: [{
                        data: totais,
                        backgroundColor: coresPrimarias.slice(0, labels.length), // Usa as cores definidas
                        hoverOffset: 10 // Efeito de destaque ao passar o mouse
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom', // Posiciona a legenda abaixo
                            labels: {
                                font: {
                                    size: 12,
                                    family: 'var(--font-texto)'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    // Calcula a porcentagem
                                    const totalSum = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const currentValue = context.raw;
                                    const percentage = parseFloat((currentValue / totalSum * 100).toFixed(1));
                                    return `${label} ${currentValue} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Inicializa os gráficos
        document.addEventListener('DOMContentLoaded', function() {
            // Usa setTimeout para garantir que o Chart.js leia o tamanho correto do DOM
            setTimeout(() => {
                if (analyticsData.por_mes && analyticsData.por_mes.length > 0) {
                    criarChartPorMes();
                } else {
                    console.log("Dados por mês insuficientes para o gráfico de linha.");
                }

                // **NOVA CHAMADA:** Inicializa o Gráfico Por Tipo
                if (analyticsData.por_tipo && analyticsData.por_tipo.length > 0) {
                    criarChartPorTipo();
                } else {
                    // Se os dados estiverem vazios, exibe uma mensagem no console.
                    console.log("Dados por tipo insuficientes para o gráfico de rosca.");
                }
            }, 100);
        });

        // Mapeamento de Cores: Associa um tipo de manifestação a uma cor do seu CSS
        const COLORS = {
            'ELOGIO': 'rgb(0, 120, 51)', // --cor-verde
            'OUVIDORIA': 'rgb(0, 129, 247)', // --cor-azul
            'RECLAMAÇÃO': 'rgb(255, 127, 23)', // --cor-laranja
            'SOLICITAÇÃO': 'rgb(216, 33, 123)', // --cor-lilas
            'DENÚNCIA': 'rgb(247, 38, 39)', // --cor-vermelha
            // Cores de fallback para outros tipos
            'DEFAULT_COLORS': [
                'rgb(233, 185, 26)', // Amarela
                'rgb(48, 60, 96)', // Primária (Dark Blue)
                'rgb(138, 154, 222)' // Secundária (Light Blue/Grey)
            ]
        };

        // Dados de exemplo, simulando o retorno da sua função PHP (nome_tipo_manifestacao e total)
        // Agora usa diretamente os dados retornados pela função (via `analyticsData`), com fallback
        const dadosExemplo = (analyticsData && analyticsData.por_tipo) ? analyticsData.por_tipo : [];

        /**
         * Função para renderizar o gráfico de Barras de Tipos de Manifestação.
         * Espera dados formatados como o retorno da sua função PHP.
         * @param {Array<Object>} dados - Lista de objetos com { nome_tipo_manifestacao, total }.
         */
        function renderizarGraficoPorTipo(dados) {
            // 1. Prepara os dados e atribui cores
            const labels = dados.map(item => item.nome_tipo_manifestacao);
            const data = dados.map(item => item.total);

            // Gera cores, usando o mapeamento fixo e o array de fallback
            const backgroundColors = dados.map((item, index) => {
                const tipo = item.nome_tipo_manifestacao.toUpperCase();
                if (COLORS[tipo]) {
                    return COLORS[tipo];
                }
                // Usa cores de fallback em loop
                return COLORS.DEFAULT_COLORS[index % COLORS.DEFAULT_COLORS.length];
            });

            // 2. Obtém o contexto do canvas
            const ctx = document.getElementById('graficoPorTipo').getContext('2d');

            // Verifica se já existe uma instância do Chart.js e a destrói para evitar sobreposição
            if (window.tipoChart instanceof Chart) {
                window.tipoChart.destroy();
            }

            // 3. Cria a nova instância do gráfico
            window.tipoChart = new Chart(ctx, {
                type: 'bar', // Alterado para o tipo de gráfico: Barra
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total de Manifestações',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: backgroundColors.map(c => c.replace('rgb', 'rgba').replace(')', ', 1)')), // Borda sólida
                        borderWidth: 1,
                        borderRadius: 6 // Cantos arredondados
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false, // Não precisamos de legenda, pois as barras são auto-explicativas
                        },
                        title: {
                            display: false, // O título principal já está no H2 do card
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.parsed.y}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Contagem de Manifestações',
                                font: {
                                    family: 'var(--font-texto)'
                                }
                            },
                            ticks: {
                                callback: function(value) {
                                    // Garante que a escala Y mostre apenas números inteiros
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tipo de Manifestação',
                                font: {
                                    family: 'var(--font-texto)'
                                }
                            }
                        }
                    }
                }
            });
        }

        // Chama a função para renderizar o gráfico assim que a página carregar
        document.addEventListener('DOMContentLoaded', () => {
            // Renderiza com os dados de exemplo
            renderizarGraficoPorTipo(dadosExemplo);
        });

        // Cores fixas para Anônimas e Identificadas.
        // Usando as variáveis CSS globais (se disponíveis) ou definindo cores diretas.
        const COLORS_ANONIMAS = {
            // Usando a cor vermelha global do seu style.css para Anônimas (destaque/atenção)
            ANONIMAS: 'rgb(247, 38, 39, 0.8)',
            // Usando a cor azul global do seu style.css para Identificadas (padrão)
            IDENTIFICADAS: 'rgb(0, 129, 247, 0.8)'
        };

        // Dados de exemplo (anonimas/identificadas) a partir de `analyticsData`, com fallback para 0
        const dadosExemplo1 = {
            anonimas: (analyticsData && analyticsData.total_identificados && typeof analyticsData.total_identificados.anonimas !== 'undefined') ? analyticsData.total_identificados.anonimas : 0,
            identificadas: (analyticsData && analyticsData.total_identificados && typeof analyticsData.total_identificados.identificadas !== 'undefined') ? analyticsData.total_identificados.identificadas : 0
        };

        /**
         * Função para renderizar o gráfico de Barras Horizontais de Solicitações Anônimas.
         * Espera um objeto com { anonimas: number, identificadas: number }.
         */
        function renderizarGraficoAnonimas(dados) {
            // 1. Prepara os dados
            const labels = ['Anônimas', 'Identificadas'];
            const data = [dados.anonimas, dados.identificadas];
            const backgroundColors = [COLORS_ANONIMAS.ANONIMAS, COLORS_ANONIMAS.IDENTIFICADAS];

            // 2. Obtém o contexto do canvas
            const ctx = document.getElementById('graficoAnonimas').getContext('2d');

            // Verifica se já existe uma instância do Chart.js
            if (window.anonimasChart instanceof Chart) {
                window.anonimasChart.destroy();
            }

            // 3. Cria a nova instância do gráfico (Barras Horizontais)
            window.anonimasChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Contagem',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: backgroundColors.map(c => c.replace('0.8', '1')), // Borda sólida
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    indexAxis: 'y', // ESSENCIAL: Transforma para barras horizontais
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Total: ${context.parsed.x}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Contagem de Manifestações',
                                // Usando a variável global --font-texto do style.css
                                font: {
                                    family: 'var(--font-texto)'
                                }
                            },
                            ticks: {
                                callback: function(value) {
                                    // Garante que a escala X mostre apenas números inteiros
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                }
                            }
                        },
                        y: {
                            // O rótulo "Anônimas" e "Identificadas" fica aqui (eixo Y)
                        }
                    }
                }
            });
        }

        // Chama a função para renderizar o gráfico assim que a página carregar
        document.addEventListener('DOMContentLoaded', () => {
            // Renderiza com os dados de exemplo
            renderizarGraficoAnonimas(dadosExemplo1);
        });

        // Dados de exemplo, simulando o retorno da sua função PHP: 
        // { respondidas: 200, nao_respondidas: 50 }
        const dadosExemplo2 = {
            respondidas: 200,
            nao_respondidas: 50
        };

        /**
         * Função para renderizar o gráfico de Pizza (Doughnut) de Status de Resposta.
         * @param {Object} dados - Objeto com { respondidas: number, nao_respondidas: number }.
         */
        function renderizarGraficoRespostas(dados) {
            // 1. Prepara os dados
            const labels = ['Respondidas', 'Não Respondidas'];
            const data = [dados.respondidas, dados.nao_respondidas];

            // Cores baseadas nas variáveis globais (Verde para sucesso/respondidas, Vermelho para pendência/não respondidas)
            // Usa getComputedStyle para garantir que as cores do style.css sejam aplicadas
            const corVerde = getComputedStyle(document.documentElement).getPropertyValue('--cor-verde').trim() || '#007833';
            const corVermelha = getComputedStyle(document.documentElement).getPropertyValue('--cor-vermelha').trim() || '#F72627';

            const backgroundColors = [
                corVerde, // Respondidas: Verde
                corVermelha // Não Respondidas: Vermelha
            ];

            // 2. Obtém o contexto do canvas
            const ctx = document.getElementById('graficoRespostas').getContext('2d');

            // Verifica se já existe uma instância do Chart.js
            if (window.respostasChart instanceof Chart) {
                window.respostasChart.destroy();
            }

            // 3. Cria a nova instância do gráfico (Doughnut)
            window.respostasChart = new Chart(ctx, {
                type: 'doughnut', // Tipo de gráfico: Rosquinha (Doughnut)
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Contagem',
                        data: data,
                        backgroundColor: backgroundColors,
                        hoverOffset: 4,
                        borderWidth: 2,
                        borderColor: 'white' // Borda branca para destacar as fatias
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%', // Faz o gráfico parecer uma rosquinha
                    plugins: {
                        legend: {
                            position: 'bottom', // Move a legenda para a parte de baixo
                            labels: {
                                font: {
                                    family: 'var(--font-texto)'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const currentValue = context.raw;
                                    const percentage = ((currentValue / total) * 100).toFixed(1) + '%';
                                    return `${context.label}: ${currentValue} (${percentage})`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Chama a função para renderizar o gráfico assim que a página carregar
        document.addEventListener('DOMContentLoaded', () => {
            // Renderiza com os dados de exemplo
            renderizarGraficoRespostas(dadosExemplo2);
        });



        $(document).ready(function() {
            $('#myTable').DataTable({
                "order": [
                    [1, "desc"] // Mude o índice para a coluna de data_manifestacao
                ],
                "language": {
                    "decimal": "",
                    "emptyTable": "Nenhum dado disponível na tabela",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "inptyFiltered": "(filtrado de _MAX_ entradas totais)",
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
    </body>

    </html>