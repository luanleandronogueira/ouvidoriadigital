<?php
session_start();
require_once 'Classes.php';
$usuario = new Usuario;

// verfica se foi enviado por post
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // verifica se o POST tá vazio
    if(!empty($_POST)){
        // // filtra os campos enviados por POST
        $nome_usuario = filter_var($_POST['nome_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sobrenome_usuario = filter_var($_POST['sobrenome_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email_usuario = filter_var($_POST['email_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id_usuario = filter_var($_POST['id_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $telefone_whatsapp = filter_var($_POST['telefone_whatsapp'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // // verifica se estão em branco
        if(!empty($nome_usuario) < 3 || !empty($sobrenome_usuario) < 3 || !empty($email_usuario) <= 3){
            // atualiza no banco os dados
            $usuario->atualizar_usuario($id_usuario, $nome_usuario, $sobrenome_usuario, $email_usuario, $telefone_whatsapp);
            header("Location: ../perfil.php?status=sucesso");
            // echo '<pre>';
            // print_r($_POST);
            // echo '</pre>';

        } else {
            header("Location: ../perfil.php?status0=campos_vazios");
            die();
        }
    } else {
        header("Location: ../login.php?status1=campos_vazios");
        die();
    }

} else {
    header("Location: ../login.php?status2=campos_vazios");
    die();

}