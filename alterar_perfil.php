<?php
session_start();
require_once 'provedores/Classes.php';
verificaSessao();
require_once 'controladores/Controller.php';

$usuario = new Usuario;
$dados = $usuario->chama_usuario_perfil($_SESSION['id_usuario']);


?>


<form class="perfil" action="provedores/AlterarUsuario.php" method="post">
    <h5>Meu Perfil</h5>

    <div class="perfil-div">
        <div class="form-floating">
            <input type="text" class="form-control" name="nome_usuario" id="nome_usuario" value="<?= $dados['nome_usuario'] ?>">
            <label for="nome_usuario">Nome:</label>
        </div>

        <div class="form-floating">
            <input type="text" class="form-control" name="sobrenome_usuario" id="sobrenome_usuario" value="<?= $dados['sobrenome_usuario'] ?>">
            <label for="sobrenome_usuario">Sobrenome:</label>
        </div>
    </div>

    <div class="perfil-div">
        <div class="form-floating">
            <input type="text" disabled class="form-control" name="cpf_usuario" id="cpf_usuario" value="<?= $dados['cpf_usuario'] ?>">
            <label for="cpf_usuario">CPF:</label>
        </div>

        <div class="form-floating">
            <input type="text" class="form-control" name="email_usuario" id="email_usuario" value="<?= $dados['email_usuario'] ?>">
            <label for="email_usuario">E-mail:</label>
        </div>

        <div class="form-floating">
            <input type="text" class="form-control" name="telefone_whatsapp" id="telefone_whatsapp" value="<?= !empty($dados['telefone_whatsapp']) ? $dados['telefone_whatsapp'] : 'Insira um número de telefone' ?>">
            <label for="telefone_whatsapp">Telefone/WhatsApp:</label>
        </div>
    </div>

    <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'] ?>">

    <div class="mt-3 text-center">
        <hr>
        <h5>Enviar atualizações</h5>
        <button type="submit" class="btn1 btn-primary btn">Atualizar</button>
    </div>
</form>



<?php include_once 'controladores/Footer.php' ?>