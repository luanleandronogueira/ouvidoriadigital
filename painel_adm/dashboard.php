<?php
// Começa a sessão
session_start();

// Carrega a Model e valida a sessão
require 'model/SessaoModel.php';
valida_sessao();

require 'controladores/header.php';
require 'model/LocalizacaoModel.php';
require 'model/ManifestacoesModel.php';

if (isset($_GET['id'])) {

    $_SESSION['id_entidade'] = $_GET['id'];
}

$localizacao = new Localizacao;
$manifestacao = new Manifestacoes;

$manifestacao_protocolo = $manifestacao->chama_manifestacao_lista($_SESSION['id_entidade']);
$coodenadas_manifestacoes = json_encode($localizacao->chama_localizacao($_SESSION['id_entidade']), true);

// echo '<pre>';
// print_r($_SESSION, false);
// echo '</pre>';

?>

<div class="container">
    <div class="row">

        <div class="col-lg-5 mt-4">

            <h4 class="text-start" style="color: var(--cor-primaria); font-family: var(--font-titulo);">Últimas 5 Manifestações</h4>
            <p class="text-secondary">Visão rápida dos registros mais recentes no sistema.</p>

            <div class="card p-3 mb-3 ultimas-manifestacoes-card">

                <?php foreach ($manifestacao_protocolo as $item): ?>
                    <div class="manifestacao-item">
                        <div class="item-header">
                            <span class="protocolo"># Protocolo <a href="manifestacao.php?protocolo=<?= $item['protocolo_manifestacao'] ?>"><?= $item['protocolo_manifestacao'] ?></a></span>
                        </div>
                        <div class="item-body">
                            <p class="data-registro">Registrado em: **<?= $item['data_manifestacao'] ?>**</p>
                            <!-- <span class="status status-<?= strtolower(str_replace(' ', '-', $item['status_manifestacao'])) ?>"><?= $item['status_manifestacao'] ?></span> -->
                        </div>
                        <a href="manifestacao.php?protocolo=<?= $item['protocolo_manifestacao'] ?>" class="btn-detalhes" title="Ver Detalhes">
                            <i class="fas fa-arrow-right"></i> </a>
                    </div>
                <?php endforeach; ?>

                <a href="minhas_manifestacoes.php" class="btn btn-sm mt-3" style="background-color: var(--cor-secundaria); color: var(--cor-branca);">Ver todas as Manifestações</a>
            </div>
        </div>

        <div class="col-lg-7 mt-4">
            <h4 class="text-start" style="color: var(--cor-primaria); font-family: var(--font-titulo); margin-bottom: 10px;">Mapa de Ocorrências</h4>
            <div>
                <div id="mapa"></div>
            </div>
        </div>

    </div>
</div>



<?php require 'controladores/footer.php' ?>