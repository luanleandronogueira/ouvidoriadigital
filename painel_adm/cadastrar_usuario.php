<?php
// Inicia a sessão e inclui o cabeçalho (assumindo que estão na pasta 'controladores')
// Começa a sessão
session_start();

// Carrega a Model e valida a sessão
require 'model/SessaoModel.php';
valida_sessao();

require 'controladores/header.php';
require 'model/NivelAcessoModel.php';

$nivel_acesso = new NivelAcessoAdm;
$nivel_acesso_adm = $nivel_acesso->nivel_acesso_adm();

?>
<div class="container my-5">

    <?php if (isset($_GET['status']) and $_GET['status'] === 'sucesso') { ?>
        <div class="alert alert-success mb-4 mt-4 text-center" role="alert">
            Cadastrado com Sucesso!
        </div>
    <?php } ?>
    <?php if (isset($_GET['status_erro'])) { ?>
        <div class="alert alert-danger mb-4 mt-4 text-center" role="alert">
           <?= $_GET['status_erro'] ?>
        </div>
    <?php } ?>

    <div class="solicitacoes-titlo">
        <h5>Cadastrar Usuário</h5>
        <hr>
    </div>
    <form action="./provedores/cadastrar_usuario.php" method="post">
        <div class="row">
            <div class="col-xxl-6 col-lg-6 col-sm-12">
                <label class="form-label" for="nome">Nome Completo:</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome completo" required>
            </div>

            <div class="col-xxl-6 col-lg-6 col-sm-12">
                <label class="form-label" for="cpf">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf" maxlength="11" placeholder="Digite o CPF" required>
            </div>

            <div class="col-xxl-6 col-lg-6 col-sm-12">
                <label class="form-label" for="email">E-mail:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Digite o email" required>
            </div>

            <div class="col-xxl-6 col-lg-6 col-sm-12 mb-3">
                <label class="form-label" for="email">Acesso:</label>
                <select class="form-control" name="acesso" id="acesso" onchange="mostraNivelAcesso(this.value)">
                    <option value="A">Administrador</option>
                    <option value="U">Usuário</option>
                </select>
            </div>

            <hr>

            <div class="d-none col-xxl-12 col-lg-12 col-sm-12" id="nivelAcessoDiv">
                <label class="form-label" for="email">Definir Nível de Acesso:</label>
                <select class="form-control" name="nivel_acesso" id="acesso2">
                    <?php foreach ($nivel_acesso_adm as $entidade) { ?>
                        <option value="<?= $entidade['id_entidade'] ?>">
                            <?= $entidade['nome_entidade'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mt-3 text-center">
                <button type="submit" class="btn1 btn-primary btn">Cadastrar</button>
            </div>

        </div>
    </form>
</div>

<script>
    function mostraNivelAcesso(v) {
        let nivelAcessoDiv = document.getElementById('nivelAcessoDiv');

        if (v === 'U') {
            nivelAcessoDiv.classList.remove('d-none');
        } else {
            nivelAcessoDiv.classList.add('d-none');
        }
    }
</script>
<?php include_once 'controladores/Footer.php' ?>