<?php
session_start();
require_once 'provedores/Classes.php';
include 'controladores/ControllerLogin.php';
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = gerarTokenCSRF();
}
?>

<div class="mt-5 container">
    <div class="row">
        <h3 class="text-center">Recuperando sua Senha</h3>
        <hr>
        <div class="text-center">
            <img src="assets/images/icon_gif.gif" width="150px" alt="Icone Email">
            <form action="provedores/RecuperarSenha.php" method="post">
                <input type="text" readonly class="text-center form-control" name="email_usuario" id="email_usuario">
                <!-- Token csrf -->
                <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="id" value="<?=$_GET['id']?>">
                <button class="mt-2 btn1 btn btn-primary" type="submit">Enviar código de verificação</button>
            </form>
            
        </div>
    </div>
</div>

<?php include_once 'controladores/FooterLogin.php' ?>
<script>
    insere_cookie(); 
</script>