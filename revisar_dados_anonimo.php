<?php
session_start();
require_once 'provedores/Classes.php';
verificaSessao();
require_once 'controladores/ControllerAnonimo.php';

//salva o arquivo
if($_FILES['arquivo_manifestacao']['error'] != 4 AND $_FILES['arquivo_manifestacao']['error'] == 0){

    if($_FILES['arquivo_manifestacao']['type'] == 'application/pdf' || 
       $_FILES['arquivo_manifestacao']['type'] == 'image/jpeg' || 
       $_FILES['arquivo_manifestacao']['type'] == 'image/png' || 
       $_FILES['arquivo_manifestacao']['type'] == 'image/jpg') {

        $nome_ = $_FILES['arquivo_manifestacao']['name']; // salva o nome antigo
        $extensao = pathinfo($_FILES['arquivo_manifestacao']['type']); // separa a extensão
        $_FILES['arquivo_manifestacao']['name'] = $_POST['id_entidade'] . '-' . date('dmyHis') . '.' . $extensao['basename']; // coloca o novo nome
        $caminho = 'assets/comprovantes/' . $_FILES['arquivo_manifestacao']['name']; //gera o novo caminho
        move_uploaded_file($_FILES['arquivo_manifestacao']['tmp_name'], $caminho); // salva no novo caminho
    } else {
        header("Location: registrar_manifestacao.php?arquivo=n_permitido&&id_manifestacao=" . $_POST['id_entidade']);

    }

} else {
    $nome_ = 'Sem arquivo';

}
?>

<div class="revisar">
    <div class="revisar-header">
        <h4>Revise suas informações</h4>
        <p>Veja os dados da sua manifestação abaixo:</p>
    </div>

    <div class="revisar-conteudo">
        <div class="revisar-info">
            <h4>Título:</h4> <?= $_POST['motivo_manifestacao'] ?>
        </div>
        <div class="revisar-info">
            <h4>Destinatário:</h4> <?= $_POST['entidade_manifestacao'] ?>
        </div>
        <div class="revisar-info">
            <h4>Local do Ocorrido:</h4> <?= $_POST['local_manifestacao'] ?>
        </div>
        <div class="revisar-info">
            <h4>Descrição da manifestação:</h4>
            <div class="card text-bg-light mb-3">
                <div class="card-body">
                    <p><?= $_POST['conteudo_manifestacao'] ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="revisar-info">
        <h4>Arquivo anexado:</h4>

        <?php if (isset($caminho)) { ?>
            <a class="icon-link" target="_blank" href="<?= $caminho ?>">
                <svg class="bi" aria-hidden="true">
                    <use xlink:href="#box-seam"></use>
                </svg>
                <?= $nome_ ?>
            </a>
        <?php } else { ?>

            <span>Sem anexos</span>
            <?php $caminho = 'Sem anexos'; ?>

        <?php } ?>

    </div>
    <?php if (!empty($_POST['observacoes_manifestacao'])) { ?>
        <div class="revisar-info">
            <h4>Demais Observações:</h4> <?= $_POST['observacoes_manifestacao'] ?>
        </div>

    <?php } else { ?>
        <div class="revisar-info">
            <h5>Demais Observações:</h5> Sem observações
        </div>
    <?php } ?>


    <form action="provedores/CadastraManifestacaoAnonima.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="arquivo_manifestacao" id="arquivo_manifestacao" value="<?= $caminho ?>">
        <input type="hidden" name="id_entidade_manifestacao" value="<?= $_POST['id_entidade'] ?>">
        <input type="hidden" name="id_tipo_manifestacao" value="<?= $_POST['id_tipo_manifestacao'] ?>">
        <input type="hidden" name="motivo_manifestacao" value="<?= $_POST['motivo_manifestacao'] ?>">
        <input type="hidden" name="conteudo_manifestacao" value="<?= $_POST['conteudo_manifestacao'] ?>">
        <input type="hidden" name="observacoes_manifestacao" value="<?= $_POST['observacoes_manifestacao'] ?>">
        <!-- <input type="hidden" name="csrf_token" value="<?= $_POST['csrf_token'] ?>"> -->
        <input type="hidden" name="local_manifestacao" value="<?= $_POST['local_manifestacao'] ?>">

        <div class="revisar-botoes">
            <a class="btn btn-secondary btn1" href="dashboard.php">Voltar</a>
            <button type="submit" class="btn btn-primary btn1">Enviar Manifestação</button>
        </div>
    </form>
</div>
<?php include_once 'controladores/Footer.php' ?>