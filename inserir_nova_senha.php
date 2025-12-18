<?php
session_start();
require_once 'provedores/Classes.php';
include 'controladores/ControllerLogin.php';
?>
<div class="mt-5 container">
    <div class="row">
        <h3 class="text-center" id="titulo1">Insira o código de recuperação</h3>
        <h3 class="text-center d-none" id="titulo2">Insira uma nova senha</h3>
        <hr>
        <div class="text-center" id="div_codigo">
            <img src="assets/images/recup_senha.png" width="270" alt="Recuperar à senha"></br>
            <p><strong>Enviamos um código para seu e-mail </strong></p>
            <div id="div_codigo_verificacao">
                <label for="codigo_verificacao">Insira o código recebido no e-mail:</label>
                <input type="text" class="text-center form-control" onkeyup="verifica_campo_codigo()" name="codigo_verificacao" id="codigo_verificacao">
                <input type="hidden" name="email_usuario" id="email_usuario">
                <button class="mt-2 btn1 btn btn-primary" id="btn_codigo" disabled onclick="verifica_codigo()">Verificar código</button>
                <button class="mt-2 btn1 btn btn-warning" type="submit">Solicitar novo código</button>
            </div>
        </div>
        <div id="div_recuperacao" class="d-none">
            <center>
            <form action="provedores/AlterarSenhaUsuario.php" method="post">
                <h4><span id="mensagem"></span></h4>
                <div class="col-6">
                    <label for="senha_atualizada">Insira sua nova senha:</label>
                    <input type="password" class="text-center form-control" name="senha_atualizada" id="senha_atualizada">
                    <label for="senha_atualizada_confirmada">Confirme sua nova senha:</label>
                    <input type="password" onblur="confere_senhas()" class="text-center form-control" name="senha_atualizada_confirmada" id="senha_atualizada_confirmada">

                    <input type="hidden" name="email_usuario_1" id="email_usuario_1">
                    <!-- Token csrf -->
                    <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="id" id="id" value="<?=$_GET['id'] ?>">
                    
                    <button class="mt-2 btn1 btn btn-secondary" disabled id="btn_atualizar" type="submit">Atualizar</button>
                </div>
            </form>

            </center>
        </div>
    </div>
</div>
<?php include_once 'controladores/FooterLogin.php' ?>
<script>
    insere_cookie_email_recuperacao();
    insere_cookie_email_recuperacao1(document.getElementById('email_usuario').value);
</script>
