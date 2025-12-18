<?php
session_start();
require_once 'provedores/Classes.php';
verificaSessao();
require_once 'controladores/Controller.php';

$Manifestacoes = new Manifestacoes;
$minhas_manifetacoes = $Manifestacoes->chama_minhas_manifestacoes($_SESSION['id_usuario'], $_SESSION['id_entidade']);
// echo '<pre>';
// print_r($minhas_manifetacoes);
// echo '<pre>';
?>

<div class="solicitacoes">
    <?php if (isset($_GET['protocolo'])) { ?>
        <div class="alert alert-success mb-4 mt-4 text-center" role="alert">
            Sua solicitação foi enviada com sucesso, este é o nº do protocolo <strong><?= $_GET['protocolo'] ?></strong>
        </div>
    <?php } ?>

    <div class="solicitacoes-titlo">
        <h5>Minhas Solicitações</h5>
    </div>

    <hr>

    <div>
        <table class="table table-striped sua-tabela" id="myTable">
            <thead>
                <tr>
                    <th>Nº protocolo</th>
                    <th>Motivo</th>
                    <th>Entidade</th>
                    <th>Situação</th>
                    <th>Ver Detalhes</th>
                    <th>Consultar Protocolo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($minhas_manifetacoes as $manifestacao) { ?>
                    <tr>

                        <td><?= $manifestacao['protocolo_manifestacao'] ?></td>
                        <td><?= $manifestacao['motivo_manifestacao'] ?></td>
                        <td><?= $manifestacao['nome_entidade'] ?></td>

                        <?php if ($manifestacao['status_manifestacao'] == 'A') {
                            $manifestacao['status_manifestacao'] = 'Em Análise';
                        } else {
                            $manifestacao['status_manifestacao'] = 'Finalizado';
                        } ?>

                        <td><?= $manifestacao['status_manifestacao'] ?></td>


                        <td><a href="manifestacao.php?id_manifestacao=<?= $manifestacao['id_manifestacao'] ?>" class="btn btn-primary btn-sm">Detalhar</a></td>

                        <td>
                            <form action="https://l3tecnologia.app.br/api_ouvidoria_web/public/api/v1/consulta_manifestacao" method="post">
                                <input type="hidden" name="protocolo" value="<?=$manifestacao['protocolo_manifestacao']?>">
                                <button target="_blank" class="btn btn1 btn-sm btn-primary" type="submit">Consultar</button>
                            </form>
                        </td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once 'controladores/Footer.php' ?>