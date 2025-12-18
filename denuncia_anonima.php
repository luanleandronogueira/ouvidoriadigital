<?php
session_start();
require_once 'provedores/Classes.php';
//verificaSessao();
require_once 'controladores/ControllerAnonimo.php';
$usuario_anonimo = new Usuario;
$tipo_manifestacao = new TipoManifestacoes;
$entidades = new Entidades;
$entidade = $entidades->chama_entidade($_GET['id']);
$t_manifestacao = $tipo_manifestacao->chama_manifestacao($_GET['id_manifestacao']);
$anonimo = $usuario_anonimo->chama_usuario_anonimo();
$_SESSION['id_entidade'] = $_GET['id'];
$_SESSION['csrf_token'] = '';
$id_portal = filter_var($_GET['id_portal'], FILTER_SANITIZE_NUMBER_INT);

//print_r($_SESSION['id_entidade']);

?>

<form class="form-manifestacao" action="revisar_dados_anonimo.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-12 col-sm-12 mb-4">
            <h5>Aqui você consegue fazer sua denúncia anônima</h5>
            <strong>
                <p>Os campos estão disponíveis para suas manifestações, não se preocupe não revelaremos sua identidade.</p>
            </strong>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-4 text-end">
            <div><a href="https://portaltransparencia.app.br/ouvidoriaMunicipal.aspx?p_i=<?=$id_portal?>&p_t=1" class="btn btn-warning">Ouvidoria Presencial</a></div>
        </div>
    </div>

    

    <?php if (isset($_GET['arquivo']) and $_GET['arquivo'] === 'n_permitido') { ?>
        <div class="p-3 bg-danger bg-opacity-10 border border-danger border-start-0 border-end-0 text-center">
            tipo de arquivo não permitido! Aceitos somente '.pdf', '.jpeg', '.jpg', '.png'
        </div></br>
    <?php } ?>

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
                <input type="text" required disabled class="form-control" name="entidade_manifestacao" id="entidade_manifestacao" value="<?= $entidade['nome_entidade'] ?>">
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

    <input type="hidden" name="id_entidade" value="<?= $entidade['id_entidade'] ?>">
    <!-- <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"> -->
    <input type="hidden" name="id_tipo_manifestacao" value="<?= $t_manifestacao['id_tipo_manifestacao'] ?>">

    <div class="form-grupo-dados">
        <div class="form-dados-desc"></div>
        <div class="form-dados-botoes">
            <a class="btn btn-secondary btn1" href="login.php">Voltar</a>
            <button class="btn btn-primary btn1">Prosseguir</button>
        </div>
    </div>
</form>

<!-- ---------------------------------------------------------------- -->
<!-- 
<div class="aviso_inicial row">
    <div class="col-lg-12 col-xl-12 col-xxl-12">
        <section class="text-start">
            <h4>Aqui você consegue fazer sua denúncia anônima</h4>
            <strong>
                <p>Os campos estão disponíveis para suas manifestações, não se preocupe não revelaremos sua identidade.</p>
            </strong>
        </section>
    </div>
</div>

<?php if (isset($_GET['arquivo']) and $_GET['arquivo'] === 'n_permitido') { ?>
    <div class="p-3 bg-danger bg-opacity-10 border border-danger border-start-0 border-end-0 text-center">
        tipo de arquivo não permitido! Aceitos somente '.pdf', '.jpeg', '.jpg', '.png'
    </div></br>
<?php } ?>

<div class="container">
    <form action="revisar_dados_anonimo.php" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="mt-3">
                <h5>Destino</h5>
                <hr>
            </div>
            <div class="col-lg-4 col-xxl-4 col-xl-4 col-md-12 col-sm-12 ">
                <label for="nome_entidade_manifestacao">Tipo de Manifestação:</label>
                <input type="text" required readonly class="form-control" name="tipo_manifestacao" id="tipo_manifestacao" value="<?= $t_manifestacao['nome_tipo_manifestacao'] ?>">
            </div>
            <div class="col-lg-8 col-xxl-8 col-xl-8 col-md-12 col-sm-12 mb-4">
                <label for="entidade_manifestacao">Entidade de Destino:</label>
                <input type="text" required readonly class="form-control" name="entidade_manifestacao" id="entidade_manifestacao" value="<?= $entidade['nome_entidade'] ?>">
            </div>
            <h5>Descrição da Manifestação</h5>
            <hr>
            <div class="col-lg-12 col-xxl-12 col-xl-12 col-md-12 col-sm-12 mb-4">
                <label for="motivo_manifestacao">Qual o motivo da sua manifestação:</label>
                <input type="text" maxlength="60" name="motivo_manifestacao" id="motivo_manifestacao" required class="form-control">
            </div>

            <div class="col-lg-12 col-xxl-12 col-xl-12 col-md-12 col-sm-12 mb-4">
                <label for="conteudo_manifestacao">Descreva a manifestação:</label>
                <textarea maxlength="8000" name="conteudo_manifestacao" onkeyup="contador_caracteres()" class="form-control" rows="9" id="conteudo_manifestacao"></textarea>
                <small><em id="contador"></em>/8000 caracteres digitados</small>
            </div>

            <div class="col-lg-12 col-xxl-12 col-xl-12 col-md-12 col-sm-12 mb-4">
                <label for="arquivo_manifestacao">Arquivos para envio</label>
                <input type="file" name="arquivo_manifestacao" id="arquivo_manifestacao" class="form-control">
                <small>São aceitos documentos de texto (.pdf), imagens (.jpeg, .jpg, .png)</small>
            </div>
            <h5>Local dos Fatos? </h5>
            <hr>

            <div class="col-lg-12 col-xxl-12 col-xl-12 col-md-12 col-sm-12 mb-4">
                <label for="local_manifestacao">Local do ocorrido</label>
                <input type="text" name="local_manifestacao" id="local_manifestacao" class="form-control">
            </div>

            <div class="col-lg-12 col-xxl-12 col-xl-12 col-md-12 col-sm-12 mb-4">
                <label for="observacoes_manifestacao">Mais Observações</label>
                <textarea maxlength="8000" name="observacoes_manifestacao" class="form-control" rows="9" id="observacoes_manifestacao"></textarea>
            </div>

            <input type="hidden" name="id_entidade" value="<?= $entidade['id_entidade'] ?>">
            <input type="hidden" name="id_tipo_manifestacao" value="<?= $t_manifestacao['id_tipo_manifestacao'] ?>">

            <hr>
            <div class="text-center">
                <a class="btn btn-outline-dark btn1" href="login.php">Voltar</a>
                <button class="btn btn-dark btn1">Prosseguir</button>
            </div>
    </form>
</div>
</div>-->


<?php include_once 'controladores/FooterAnonimo.php' ?>