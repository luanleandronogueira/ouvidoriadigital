<?php 
/**
 * Arquivo: ouvidoriadigital/painel_adm/provedores/relatorio_manifestacoes.php
 * Relatório PDF com estilização baseada no style.css original
 */
session_start();

require_once __DIR__ . '/../../assets/lib/vendor/autoload.php';
require_once '../model/ManifestacoesModel.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$manifestacoes = new Manifestacoes;

if (!isset($_SESSION['id_entidade'])) {
    die("Sessão inválida.");
}

$id_entidade = (int) $_SESSION['id_entidade'];
$nome_entidade = $_SESSION['nome_entidade'] ?? 'Entidade';

// Dados
$total_geral         = $manifestacoes->getTotalManifestacoes($id_entidade);
$total_abertas       = $manifestacoes->getTotalManifestacoesPorStatus($id_entidade, 'A');
$total_finalizadas   = $manifestacoes->getTotalManifestacoesPorStatus($id_entidade, 'Concluído');
$total_anonimas      = $manifestacoes->getTotalManifestacoesAnonimas($id_entidade);
$contagem_ai         = $manifestacoes->getContagemAnonimasIdentificadas($id_entidade);
$total_identificadas = (int) ($contagem_ai['identificadas'] ?? 0);
$por_tipo            = $manifestacoes->getManifestacoesPorTipo($id_entidade);
$nao_respondidas_tipo = $manifestacoes->getManifestacoesNaoRespondidasPorTipo($id_entidade);

$data_emissao = date('d/m/Y H:i');

$html = "
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <style>
        /* Mapeamento do style.css */
        @page { margin: 120px 40px 60px 40px; }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif; /* Fallback para Montserrat */
            color: #5f5f5f; /* --cor-cinza-dark */
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* Cabeçalho */
        header {
            position: fixed;
            top: -95px;
            left: 0;
            right: 0;
            height: 80px;
            border-bottom: 2px solid #303c60; /* --cor-primaria */
            padding-bottom: 10px;
        }

        .entidade-titulo {
            font-family: 'Helvetica-Bold', sans-serif; /* Simulação do Russo One */
            color: #303c60;
            font-size: 16pt;
            text-transform: uppercase;
            margin: 0;
        }

        .sistema-subtitulo {
            color: #8a9ade; /* --cor-secundaria */
            font-size: 9pt;
            font-weight: bold;
            letter-spacing: 1px;
        }

        /* Footer */
        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #9e9e9f; /* --cor-cinza */
            border-top: 1px solid #d9d9d9;
            padding-top: 5px;
        }

        /* Cards / KPIs - Baseado no .card do style.css */
        .kpi-row { width: 100%; margin-top: 20px; border-spacing: 10px 0; }
        .card {
            background-color: #f5f5f5; /* --cor-cinza-light2 */
            border: 1px solid #d9d9d9; /* --cor-cinza-light */
            border-radius: 10px;
            padding: 15px;
            text-align: center;
        }
        .card-valor {
            display: block;
            font-size: 18pt;
            font-weight: bold;
            color: #303c60;
            margin-bottom: 2px;
        }
        .card-label {
            font-size: 7pt;
            text-transform: uppercase;
            font-weight: bold;
            color: #5f5f5f;
        }

        /* Títulos de Seção */
        .section-header {
            background-color: #ecf5fb; /* --cor-bg */
            color: #303c60;
            padding: 7px 12px;
            font-weight: bold;
            font-size: 11pt;
            border-left: 5px solid #303c60;
            margin: 30px 0 15px 0;
            text-transform: uppercase;
        }

        /* Tabelas - Estilo do Projeto */
        table.tabela-dados {
            width: 100%;
            border-collapse: collapse;
        }
        table.tabela-dados th {
            background-color: #303c60;
            color: #ffffff;
            font-size: 9pt;
            padding: 10px;
            text-align: left;
            text-transform: uppercase;
        }
        table.tabela-dados td {
            padding: 9px 10px;
            border-bottom: 1px solid #d9d9d9;
            font-size: 10pt;
        }

        /* Barras de progresso simulated */
        .progress-container {
            background-color: #d9d9d9;
            width: 100%;
            height: 8px;
            border-radius: 4px;
            margin-top: 5px;
        }
        .progress-bar {
            background-color: #8a9ade;
            height: 100%;
            border-radius: 4px;
        }

        .text-danger { color: #f72627; font-weight: bold; }
        .text-success { color: #007833; font-weight: bold; }
    </style>
</head>
<body>

    <header>
        <table width='100%' style='border:none;'>
            <tr>
                <td style='border:none;'>
                    <div class='sistema-subtitulo'>OUVIDORIA DIGITAL</div>
                    <h1 class='entidade-titulo'>$nome_entidade</h1>
                </td>
                <td style='border:none; text-align: right; vertical-align: bottom;'>
                    <span style='font-size: 8pt; color: #9e9e9f;'>Relatório Analítico | $data_emissao</span>
                </td>
            </tr>
        </table>
    </header>

    <footer>
        L3 Tecnologia - Relatório Gerencial de Manifestações - Página <script type='text/php'>echo \$fontMetrics->get_page_number();</script>
    </footer>

    <!-- KPIs -->
    <table class='kpi-row'>
        <tr>
            <td width='25%' style='border:none;'>
                <div class='card'>
                    <span class='card-valor'>$total_geral</span>
                    <span class='card-label'>Manifestações</span>
                </div>
            </td>
            <td width='25%' style='border:none;'>
                <div class='card' style='border-top: 3px solid #f72627;'>
                    <span class='card-valor'>$total_abertas</span>
                    <span class='card-label'>Em Aberto</span>
                </div>
            </td>
            <td width='25%' style='border:none;'>
                <div class='card' style='border-top: 3px solid #007833;'>
                    <span class='card-valor'>$total_finalizadas</span>
                    <span class='card-label'>Concluídas</span>
                </div>
            </td>
            <td width='25%' style='border:none;'>
                <div class='card' style='border-top: 3px solid #e9b91a;'>
                    <span class='card-valor'>$total_anonimas</span>
                    <span class='card-label'>Anônimas</span>
                </div>
            </td>
        </tr>
    </table>

    <!-- DISTRIBUIÇÃO POR TIPO -->
    <div class='section-header'>Distribuição por Tipo</div>
    <table class='tabela-dados'>
        <thead>
            <tr>
                <th>Tipo de Manifestação</th>
                <th width='60' style='text-align: center;'>Qtd</th>
                <th width='180'>Proporção</th>
            </tr>
        </thead>
        <tbody>";
        foreach ($por_tipo as $t) {
            $p = ($total_geral > 0) ? ($t['total'] / $total_geral) * 100 : 0;
            $html .= "<tr>
                <td>{$t['nome_tipo_manifestacao']}</td>
                <td style='text-align: center;'><strong>{$t['total']}</strong></td>
                <td>
                    <div class='progress-container'>
                        <div class='progress-bar' style='width: {$p}%'></div>
                    </div>
                    <span style='font-size: 7pt; color: #8a9ade;'>".round($p, 1)."% do total</span>
                </td>
            </tr>";
        }
$html .= "</tbody>
    </table>

    <!-- PENDÊNCIAS -->
    <div class='section-header'>Manifestações não Respondidas</div>
    <table class='tabela-dados'>
        <thead>
            <tr>
                <th>Tipo</th>
                <th style='text-align: center;'>Status</th>
                <th width='100' style='text-align: center;'>Pendências</th>
            </tr>
        </thead>
        <tbody>";
        foreach ($nao_respondidas_tipo as $n) {
            if($n['total_nao_respondidas'] > 0){
                $html .= "<tr>
                    <td>{$n['nome_tipo_manifestacao']}</td>
                    <td style='text-align: center;' class='text-danger'>AGUARDANDO</td>
                    <td style='text-align: center;'><strong>{$n['total_nao_respondidas']}</strong></td>
                </tr>";
            }
        }
$html .= "</tbody>
    </table>

    <!-- IDENTIFICAÇÃO -->
    <div class='section-header'>Perfil de Identificação</div>
    <table class='tabela-dados'>
        <tr>
            <td width='50%'><strong>Manifestações Identificadas:</strong> $total_identificadas</td>
            <td width='50%'><strong>Manifestações Anônimas:</strong> $total_anonimas</td>
        </tr>
    </table>

</body>
</html>";

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Helvetica');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$nome_file = "relatorio_" . date('Ymd_Hi') . ".pdf";
$dompdf->stream($nome_file, ["Attachment" => true]);