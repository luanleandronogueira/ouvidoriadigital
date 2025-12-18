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

// echo '<pre>';
// print_r($usuario);
// echo '</pre>';

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
    <?php if (isset($_GET['status0']) and $_GET['status0'] === 'campos_vazios') { ?>
        <div class="alert alert-danger mb-4 mt-4 text-center" role="alert">
            Os campos estão vazios ou com poucos dados!
        </div>
    <?php } ?>


    <h5>Meu Perfil</h5>

    <div class="perfil-div">
        <div class="form-floating">
            <input type="text" disabled class="form-control" name="nome_usuario" id="nome_usuario" value="<?= $usuario['usuario'] ?>">
            <label for="nome_usuario">Nome:</label>
        </div>

        <div class="form-floating">
            <input type="text" disabled class="form-control" name="sobrenome_usuario" id="sobrenome_usuario" value="<?= $usuario['cpf'] ?>">
            <label for="sobrenome_usuario">CPF:</label>
        </div>
    </div>

    <div class="perfil-div">
        <div class="form-floating">
            <input type="text" disabled class="form-control" name="cpf_usuario" id="cpf_usuario" value="<?= $usuario['email'] ?>">
            <label for="cpf_usuario">E-mail:</label>
        </div>

        <div class="form-floating">
            <input type="text" disabled class="form-control" name="contagem_manifestacao" id="contagem_manifestacao" value="<?= $nivel_acesso ?>">
            <label for="contagem_manifestacao">Nível de Acesso:</label>
        </div>
    </div>


    <div class="mt-3 text-center">
        <hr>
        <h5>Deseja realizar alguma alteração nos seus dados?</h5>
        <a href="alterar_perfil.php?id=<?= $_SESSION['id'] ?>" class="btn1 btn-primary btn">Alterar</a>
        
    </div>

</div>
</div>


<?php include_once 'controladores/Footer.php' ?>