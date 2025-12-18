<?php
session_start();
require_once 'provedores/Classes.php';
verificaSessao();
require_once 'controladores/Controller.php';

$tipo_manifestacao = new TipoManifestacoes;
$t_manifestacao = $tipo_manifestacao->chama_manifestacao($_GET['id_manifestacao']);

// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';

?>


<?php if (isset($_GET['arquivo']) and $_GET['arquivo'] === 'n_permitido') { ?>
    <div class="p-3 bg-danger bg-opacity-10 border border-danger border-start-0 border-end-0 text-center">
        tipo de arquivo não permitido! Aceitos somente '.pdf', '.jpeg', '.jpg', '.png'
    </div></br>
<?php } ?>

<form class="form-manifestacao" action="revisar_dados.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-12 col-sm-12 mb-4">
            <h5>Faça seu registro preenchendo as informações abaixo</h5>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-4 text-end">
            <div><a target="_blank" href="https://portaltransparencia.app.br/ouvidoriaMunicipal.aspx?p_i=<?= $_SESSION['id_portal'] ?>&p_t=1" class="btn btn-sm btn-dark">Ouvidoria Presencial</a></div>
        </div>
    </div>
    <hr>

    <div class="form-grupo-dados">
        <div class="form-dados-desc">
            <h5>Destino da Manifestação</h5>
            <p>Informações sobre o destino da manifestação.</p>
        </div>

        <div class="form-dados-campos">
            <div class="form-floating">
                <input type="text" required disabled class="form-control" name="tipo_manifestacao" id="tipo_manifestacao" value="<?= $t_manifestacao['nome_tipo_manifestacao'] ?>">
                <label for="tipo_manifestacao">Tipo de Manifestação:</label>
            </div>

            <div class="form-floating">
                <input type="text" required disabled class="form-control" name="entidade_manifestacao" id="entidade_manifestacao" value="<?= $_SESSION['entidade_nome'] ?>">
                <label for="entidade_manifestacao">Entidade Responsável:</label>
            </div>
        </div>
    </div>

    <hr>

    <div class="form-grupo-dados">
        <div class="form-dados-desc">
            <h5>Detalhes da Manifestação</h5>
            <p>Descreva o motivo e os detalhes da sua manifestação. Anexe documentos, se necessário.</p>
        </div>

        <div class="form-dados-campos-unico">
            <div class="form-floating">
                <input type="text" maxlength="60" name="motivo_manifestacao" class="form-control" id="motivo_manifestacao" placeholder="Motivo da Manifestação" required>
                <label for="motivo_manifestacao">Motivo da Manifestação:</label>
            </div>

            <div>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Descrição detalhada da manifestação" name="conteudo_manifestacao" id="conteudo_manifestacao" maxlength="8000" rows="9" style="height: 100px" onkeyup="contador_caracteres('conteudo_manifestacao', 'contador1')"></textarea>
                    <label for="conteudo_manifestacao">Descrição detalhada da manifestação:</label>
                </div>
                <small><em id="contador1"></em>/8000 caracteres digitados</small>
            </div>

            <!-- <div>
                <label class="label" for="arquivo_manifestacao">Anexar arquivo:</label>
                <input type="file" name="arquivo_manifestacao" id="arquivo_manifestacao" class="form-control">
                <small>Arquivos aceitos: PDF, JPEG, JPG, PNG</small>
            </div> -->
        </div>
    </div>

    <hr>

    <div class="form-grupo-dados">
        <div class="form-dados-desc">
            <h5>Local do Ocorrido</h5>
            <p>Informe onde os fatos ocorreram e adicione observações, se houver.</p>
        </div>

        <div class="form-dados-campos-unico">
            <div class="form-floating">
                <input type="text" maxlength="60" name="local_manifestacao" class="form-control" id="local_manifestacao" placeholder="Motivo da Manifestação" required>
                <label for="local_manifestacao">Local do Ocorrido:</label>
            </div>

            <div>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Outras informações relevantes" name="observacoes_manifestacao" id="observacoes_manifestacao" maxlength="8000" rows="9" style="height: 100px" onkeyup="contador_caracteres('observacoes_manifestacao', 'contador2')"></textarea>
                    <label for="observacoes_manifestacao">Outras informações relevantes:</label>
                </div>
                <small><em id="contador2"></em>/8000 caracteres digitados</small>
            </div>
        </div>
    </div>

    <input type="hidden" name="id_entidade" value="<?= $_SESSION['id_entidade'] ?>">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <input type="hidden" name="id_tipo_manifestacao" value="<?= $t_manifestacao['id_tipo_manifestacao'] ?>">


    <div class="form-grupo-dados">
        <div class="form-dados-desc"></div>
        <div class="form-dados-botoes">
            <a class="btn btn-secondary btn1" href="dashboard.php">Voltar</a>
            <button class="btn btn-primary btn1">Prosseguir</button>
        </div>
    </div>
</form>

<?php include_once 'controladores/Footer.php' ?>
