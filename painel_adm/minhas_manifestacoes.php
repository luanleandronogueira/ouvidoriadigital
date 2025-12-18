<?php 
// Inicia a sessão e inclui o cabeçalho (assumindo que estão na pasta 'controladores')
// Começa a sessão
session_start();

// Carrega a Model e valida a sessão
require 'model/SessaoModel.php';
valida_sessao();

require 'controladores/header.php';
require 'model/ManifestacoesModel.php';

$manifestacoes = new Manifestacoes;
$minhas_manifetacoes = $manifestacoes->chama_manifestacao($_SESSION['id_entidade']);

// echo '<pre>';
// print_r($minhas_manifetacoes);
// echo '</pre>';

?>
<div class="solicitacoes">
    <?php if (isset($_GET['protocolo'])) { ?>
        <div class="alert alert-success mb-4 mt-4 text-center" role="alert">
            Sua solicitação foi enviada com sucesso, este é o nº do protocolo <strong><?= $_GET['protocolo'] ?></strong>
        </div>
    <?php } ?>

    <div class="solicitacoes-titlo">
        <h5>Todas as Solicitações</h5>
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

                        <td><small><?= $manifestacao['protocolo_manifestacao'] ?></small></td>
                        <td><small><?= $manifestacao['data_manifestacao'] ?></small></td>
                        <td><?= $manifestacao['motivo_manifestacao'] ?></td>
                        <td><?= $manifestacao['nome_entidade'] ?></td>

                        <?php if ($manifestacao['status_manifestacao'] == 'A') {
                            $manifestacao['status_manifestacao'] = 'Em Análise';
                        } else {
                            $manifestacao['status_manifestacao'] = 'Finalizado';
                        } ?>

                        <td><?= $manifestacao['status_manifestacao'] ?></td>

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


<?php require 'controladores/footer.php' ?>