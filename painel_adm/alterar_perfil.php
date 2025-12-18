<?php
// Inicia a sessão e inclui o cabeçalho (assumindo que estão na pasta 'controladores')
// Começa a sessão
session_start();

// Carrega a Model e valida a sessão
require 'model/SessaoModel.php';
valida_sessao();

require 'controladores/header.php';
require 'model/UsuarioAdmModel.php';

$UsuarioAdm = new UsuarioAdm;
$usuario = $UsuarioAdm->chama_usuario($_SESSION['id']);

if ($usuario['nivel_acesso'] === 'A') {

    $nivel_acesso = 'Administrador';
} else {

    $nivel_acesso = 'Usuário';
}

?>

<div class="perfil">

    <?php if (isset($_GET['status']) and $_GET['status'] === 'sucesso') { ?>
        <div class="alert alert-success mb-4 mt-4 text-center" role="alert">
            Atualizado com Sucesso!
        </div>
    <?php } ?>
    <?php if (isset($_GET['status0']) and $_GET['status0'] === 'erro_ao_alterar') { ?>
        <div class="alert alert-danger mb-4 mt-4 text-center" role="alert">
            Os campos estão vazios ou com poucos dados!
        </div>
    <?php } ?>


    <h5>Meu Perfil</h5>
    <form action="./provedores/alterar_perfil.php" method="post">
        
        <div class="perfil-div">
            <div class="form-floating">
                <input type="text" class="form-control" name="nome_usuario" id="nome_usuario" value="<?= $usuario['usuario'] ?>">
                <label for="nome_usuario">Nome:</label>
            </div>

            <div class="form-floating">
                <input type="text" disabled class="form-control" name="sobrenome_usuario" id="sobrenome_usuario" value="<?= $usuario['cpf'] ?>">
                <label for="sobrenome_usuario">CPF:</label>
            </div>
        </div>

        <div class="perfil-div mt-2">
            <div class="form-floating">
                <input type="text" class="form-control" name="email" id="email" value="<?= $usuario['email'] ?>">
                <label for="cpf_usuario">E-mail:</label>
            </div>

        </div>


        <div class="mt-3 text-center">
            <hr>
            <h5>Deseja alterar seus dados?</h5>
            <button type="submit" class="btn1 btn-primary btn">Alterar</button>

        </div>
    </form>
</div>
</div>


<?php include_once 'controladores/Footer.php' ?>