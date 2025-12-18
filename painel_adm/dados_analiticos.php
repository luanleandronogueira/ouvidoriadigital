<?php
// Inicia a sessão e inclui o cabeçalho (assumindo que estão na pasta 'controladores')
// Começa a sessão
session_start();
// Carrega a Model e valida a sessão
require 'model/SessaoModel.php';
// valida a sesssão
valida_sessao();

require 'controladores/header.php';
require_once 'model/ManifestacoesModel.php';
require_once 'model/EntidadeModel.php';
require 'model/LocalizacaoModel.php';

$entidade = new Entidade;
$localizacao = new Localizacao;
$manifestacao = new Manifestacoes;

if (empty($_SESSION['id_entidade']) || empty($_SESSION['nome_entidade'])) {

    $_SESSION['id_entidade'] = $_GET['id'];
    $nome_entidade = $entidade->chama_nome_entidade($_SESSION['id_entidade']);
    $_SESSION['nome_entidade'] = $nome_entidade['nome_entidade'];
}

$id_entidade = $_SESSION['id_entidade'];

$manifestacao_protocolo = $manifestacao->chama_manifestacao_lista($_SESSION['id_entidade']);
$coodenadas_manifestacoes = json_encode($localizacao->chama_localizacao($_SESSION['id_entidade']), true);

$error_message = null;

// --- Lógica de Busca de Dados (Mantida, mas usando Mock Data em caso de falha) ---
if ($_SESSION['id_entidade'] > 0) {
    try {
        $manifestacoes_obj = new Manifestacoes();

        $data_analytics['total_geral'] = $manifestacoes_obj->getTotalManifestacoes($id_entidade);
        $data_analytics['total_abertas'] = $manifestacoes_obj->getTotalManifestacoesPorStatus($id_entidade, 'A');
        $data_analytics['total_finalizadas'] = $manifestacoes_obj->getTotalManifestacoesPorStatus($id_entidade, 'Concluído');
        $data_analytics['total_anonimas'] = $manifestacoes_obj->getTotalManifestacoesAnonimas($id_entidade);
        $data_analytics['por_mes'] = $manifestacoes_obj->getManifestacoesPorMes($id_entidade);
        $data_analytics['por_tipo'] = $manifestacoes_obj->getManifestacoesPorTipo($id_entidade);
        $data_analytics['total_identificados'] = $manifestacoes_obj->getContagemAnonimasIdentificadas($id_entidade);
    } catch (Exception $e) {
        $error_message = "Erro ao buscar dados: " . $e->getMessage() . ". Usando dados de demonstração (Mock).";
    }
} else {
    $error_message = "ID da Entidade não encontrado. Usando dados de demonstração (Mock).";
}

// Converte os dados PHP para JSON, crucial para o JavaScript dos gráficos
$js_data = json_encode($data_analytics);

?>

<div class="container my-5" id="area-pdf">
    <h1 class="text-center mb-5" style="color: var(--cor-primaria); font-family: var(--font-titulo);">Dashboard Analítico de Manifestações
        <small>
            <h4><?= $_SESSION['nome_entidade'] ?></h4>
        </small>
    </h1>

    <?php if ($error_message): ?>
        <div class="alert alert-warning text-center" role="alert">
            <?= $error_message ?>
        </div>
    <?php endif; ?>

    <!-- PARTE 3: Cartões de KPIs (Indicadores Chave de Performance) -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
        <!-- KPI 1: Total Geral -->
        <div class="col">
            <div class="card shadow-lg h-100 card-kpi-total" style="border-radius: 10px;">
                <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase fw-bold">Total Geral</h5>
                    <p class="card-text fs-2 fw-bolder" style="color: var(--cor-primaria);"><a href="minhas_manifestacoes.php"><?= $data_analytics['total_geral'] ?></a></p>
                </div>
            </div>
        </div>

        <!-- KPI 2: Anônimas -->
        <div class="col">
            <div class="card shadow-lg h-100 card-kpi-anonimas" style="border-radius: 10px;">
                <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase fw-bold">Anônimas</h5>
                    <p class="card-text fs-2 fw-bolder" style="color: var(--cor-primaria);"><a href="manifestacoes.php?tipo=anonima"><?= $data_analytics['total_anonimas'] ?></a></p>
                </div>
            </div>
        </div>

        <!-- KPI 3: Em Aberto -->
        <div class="col">
            <div class="card shadow-lg h-100 card-kpi-abertas" style="border-radius: 10px;">
                <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase fw-bold">Aberto/Análise</h5>
                    <p class="card-text fs-2 fw-bolder" style="color: var(--cor-primaria);"><a href="manifestacoes.php?tipo=analise_aberta"><?= $data_analytics['total_abertas'] ?></a></p>
                </div>
            </div>
        </div>

        <!-- KPI 4: Finalizadas -->
        <div class="col">
            <div class="card shadow-lg h-100 card-kpi-finalizadas" style="border-radius: 10px;">
                <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase fw-bold">Concluídas</h5>
                    <p class="card-text fs-2 fw-bolder" style="color: var(--cor-primaria);"><a href="manifestacoes.php?tipo=concluido"><?= $data_analytics['total_finalizadas'] ?></a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- PARTE 3: Seção de Gráficos -->
    <div class="row g-4">

        <!-- **GRÁFICO 1: Solicitações por Mês (Linha) - Ocupa 8 colunas no desktop** -->
        <div class="col-12 col-lg-8">
            <div class="card shadow-lg p-3 h-100" style="border-radius: 10px;">
                <h5 class="card-title text-center text-uppercase fw-bold mb-3" style="color: var(--cor-primaria);">Volume de Solicitações por Mês</h5>
                <!-- Contêiner de altura fixa -->
                <div class="chart-container">
                    <canvas id="chartManifestacoesPorMes"></canvas>
                </div>
            </div>
        </div>

        <!-- **GRÁFICO 2: Distribuição por Tipo (Pizza) - Ocupa 4 colunas no desktop** -->
        <div class="col-12 col-lg-4">
            <div class="card shadow-lg p-3 h-100" style="border-radius: 10px;">
                <h5 class="card-title text-center text-uppercase fw-bold mb-3" style="color: var(--cor-primaria);">Distribuição por Tipo em %</h5>
                <div class="chart-container d-flex justify-content-center">
                    <!-- Canvas para o Gráfico de Pizza -->
                    <canvas id="chartManifestacoesPorTipo"></canvas>
                </div>
            </div>
        </div>

        <!-- ESPAÇO VAZIO para o Gráfico 3 (Barra) -->
        <div class="row g-4 mt-4">
            <div class="col-12">
                <div class="card shadow-lg p-3 h-100 d-flex align-items-center justify-content-center" style="border-radius: 10px; height: 350px;">
                    <h2>Comparativo de Manifestações por Tipo</h2>
                    <!-- Contêiner onde o gráfico será renderizado -->
                    <div class="chart-container">
                        <canvas id="graficoPorTipo"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4 mt-4 align-items-stretch">
        <div class="col-12 col-lg-8">
            <div class="card shadow-lg p-3 h-100 d-flex flex-column" style="border-radius: 10px; height: 350px;">
                <h3 class="mb-3 text-center">Solicitações Anônimas vs. Identificadas</h3>
                <div class="chart-container flex-fill">
                    <canvas id="graficoAnonimas"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-lg p-3 h-100 d-flex flex-column" style="border-radius: 10px; height: 350px;">
                <h3 class="mb-3 text-center">Proporção de Manifestações Respondidas</h3>
                <div class="chart-container flex-fill">
                    <canvas id="graficoRespostas"></canvas>
                </div>
            </div>
        </div>

    </div>
    <div class="col-12 mt-4">
        <div>
            <h4 class="text-start" style="color: var(--cor-primaria); font-family: var(--font-titulo); margin-bottom: 10px;">Mapa de Ocorrências</h4>
            <div id="mapa"></div>
        </div>
    </div>

    <a class="btn btn-primary mt-4 mb-3" href="provedores/relatorio_manifestacoes.php">
        📄 Gerar Relatório PDF
    </a>
</div>

</div>

<!-- PARTE 4: JavaScript e Inicialização dos Gráficos -->
<!-- Inclui o Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    function gerarPDF() {
        const {
            jsPDF
        } = window.jspdf;

        const hoje = new Date().toLocaleDateString('pt-BR');

        const pdf = new jsPDF('p', 'mm', 'a4');

        pdf.html(document.body, {
            callback: function(doc) {
                doc.text(`Gerado em: ${hoje}`, 10, 10);
                doc.save(`relatorio-${hoje}.pdf`);
            },
            margin: [20, 10, 20, 10],
            autoPaging: 'text',
            html2canvas: {
                scale: 0.9
            }
        });
    }
</script>

<?php
// Rodapé
require 'controladores/footer.php';
?>