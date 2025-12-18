<?php 
session_start();
require_once 'Classes.php';
$usuario = new Usuario;
$codigo_recuperacao = new CodigoRecuperacao;

// verfica se foi enviado por post
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    verificarTokenCSRF();
    $senha_atualizada = filter_var($_POST['senha_atualizada'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $senha_atualizada_confirmada = filter_var($_POST['senha_atualizada_confirmada'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email_usuario = filter_var($_POST['email_usuario_1'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = filter_var($_POST['id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if($senha_atualizada === $senha_atualizada_confirmada){
        // criptografa a senha
        $senha_atualizada_hash = password_hash($senha_atualizada_confirmada, PASSWORD_DEFAULT);
        //salva a senha no banco de dados
        $usuario->atualizar_senha_usuario($senha_atualizada_hash, $email_usuario);
        // echo '<pre>';
        //     print_r($_POST);
        // echo '</pre>';
        // echo $id;
        header("Location: ../login.php?status=faca_login&&id=".$id);

    } else {
        /// ajustar essa lógica
        header("Location: ../login.php?status=senhas_diferentes&&id=".$id);
        die();
    }

    

} else {
    header("Location: ../login.php?status=senhas_diferentes&&id=".$id);
    die();

}