<?php 
require_once 'Classes.php';
$usuario = new Usuario;

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {

    // verificarTokenCSRF();

    if(!empty($_GET['email_usuario'])){

        $email_usuario = filter_var($_GET['email_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $response = $usuario->email_usuario($email_usuario);

        echo json_encode($response);

    } else {

        echo json_encode('Não Autorizado1');
    }
} else {
    
    echo json_encode('Não Autorizado');
    die();
}

