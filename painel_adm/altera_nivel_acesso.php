<?php
// Inicia a sessão e inclui o cabeçalho (assumindo que estão na pasta 'controladores')
// Começa a sessão
session_start();

// Carrega a Model e valida a sessão
require 'model/SessaoModel.php';
valida_sessao();

require 'controladores/header.php';
require 'model/UsuarioAdmModel.php';
require 'model/NivelAcessoModel.php';

// cria a instancia do Objeto
$UsuarioAdm = new UsuarioAdm;
$id = $_GET['id'] ?? '';
$usuario = $UsuarioAdm->chama_usuario($id);

//Cria a instancia do Objeto
$nivel_acesso = new NivelAcessoAdm;
$nivel_acesso_adm = $nivel_acesso->nivel_acesso_adm();
$nivel_acesso_usuario = '';

if ($usuario['nivel_acesso'] === 'U') {
    $nivel_acesso_usuario = $nivel_acesso->consulta_nivel_acesso($id);
}
?>

<div class="container my-5">
    <?php if (isset($_GET['status'])) { ?>
        <div class="alert alert-success mb-4 mt-4 text-center" role="alert">
            <?= $_GET['status'] ?>
        </div>
    <?php } elseif (isset($_GET['status_erro'])) { ?>
        <div class="alert alert-danger mb-4 mt-4 text-center" role="alert">
            <?= $_GET['status_erro'] ?>
        </div>

    <?php } ?>

    <div class="solicitacoes-titlo">
        <h5>Altera Nível Acesso</h5>
    </div>

    <?php if ($usuario['nivel_acesso'] === 'U') { ?>

        <?php if ($_SESSION['nivel_acesso'] === 'A') { ?>

            <?php if (empty($id) || $usuario === null) { ?>

                <p>Usuário não existe</p><br>
                <a href="configuracoes.php">Retornar</a>

            <?php } elseif ($usuario == false) { ?>

                <p>Usuário não existe</p><br>
                <a href="configuracoes.php">Retornar</a>

            <?php } else { ?>

                <?= $usuario['usuario'] ?>
                <form action="provedores/incluir_nivel_acesso.php" method="post">

                    <hr>
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="col-xxl-12 col-lg-12 col-sm-12" id="nivelAcessoDiv">
                        <label class="form-label" for="email">Definir Nível de Acesso:</label>
                        <select class="form-control" name="nivel_acesso" id="acesso2">
                            <?php foreach ($nivel_acesso_adm as $entidade) { ?>
                                <option value="<?= $entidade['id_entidade'] ?>">
                                    <?= $entidade['nome_entidade'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <button class="btn1 btn-primary btn mt-3" type="submit">Incluir Acesso</button>

                </form>

                <hr>
                <div class="solicitacoes-titlo">
                    <h5>Nível Acesso Permitido</h5>
                </div>

                <div>
                    <table class="table table-striped sua-tabela" id="myTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Entidades Permitidas</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($nivel_acesso_usuario as $n) { ?>
                                <tr>
                                    <td><?= $n['id_entidade'] ?></td>
                                    <td><?= $n['nome_entidade'] ?></td>
                                    <td><a href="provedores/excluir_nivel_acesso.php?id_entidade=<?= $n['id_entidade']?>&&id_usuario=<?=$id?>">Excluir Acesso</a></td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            <?php } ?>

        <?php } else { ?>

            <p>Não Autorizado ou esse usuário não existe</p><br>
            <a href="configuracoes.php">Retornar</a>

        <?php } ?>

    <?php } else { ?>

        <p>Este usuário já é um administrador! Altere o status dele para definir um nivel de acesso</p><br>
        <a href="editar_usuario.php?id=<?= $_GET['id'] ?>">Alterar Status</a>

    <?php } ?>


</div>









<?php include_once 'controladores/Footer.php' ?>