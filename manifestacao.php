<?php
session_start();
require_once 'provedores/Classes.php';
verificaSessao();
require_once 'controladores/Controller.php';

$Manifestacoes = new Manifestacoes;
$minha_manifetacao = $Manifestacoes->chama_manifestacao($_GET['id_manifestacao']);

extract($minha_manifetacao);


?>
<div class="revisar">
    <div class="revisar-header">
        <h4>Solicitação: <?= $minha_manifetacao['protocolo_manifestacao'] ?></h4>
    </div>


    <div class="revisar-conteudo">
        <div class="revisar-info"><h4>Tipo de Manifestação: </h4><?= $nome_tipo_manifestacao ?></div>
        <div class="revisar-info"><h4>Destinatário: </h4><?= $nome_entidade ?></div>
        <div class="revisar-info"><h4>Motivo: </h4> <?= $motivo_manifestacao ?></div>
        <div class="revisar-info"><h4>Conteudo da Manifestação: </h4> <?= $conteudo_manifestacao ?></div>
        <hr>
        <div class="revisar-info"><h4>Local do Fato:</h4> <?= $local_manifestacao ?></div>
        <div class="revisar-info"><h4>Demais Observações:</h4> <?= $observacoes_manifestacao ?></div>
        <hr>
        <div class="revisar-info"><h4>Data da Solicitação:</h4> <?= $data_manifestacao ?></div>

        <?php if ($arquivo_manifestacao == 'Sem anexos') {
            $arquivo_manifestacao = 'sem anexos enviados'; ?>
            <div class="revisar-info"><h4>Anexo enviado:</h4> <?= $arquivo_manifestacao ?></div>
        <?php } else { ?>
            <div class="revisar-info"><h4>Anexo enviado:</h4> <a href="<?= $arquivo_manifestacao ?>" target="_blank">confira o anexo</a></div>
        <?php }  ?>

        <?php if ($status_manifestacao == 'A') {
            $status_manifestacao = 'Em análise';
        } else {
            $status_manifestacao = 'Finalizado';
        } ?>

        <div class="revisar-info"><h4>Status da Manifestação:</h4> <?= $status_manifestacao ?></div>
    </div>
</div>
</div>

<?php include_once 'controladores/Footer.php' ?>