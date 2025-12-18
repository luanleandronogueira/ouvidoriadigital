<?php 
require_once 'Classes.php';
$codigo_recuperacao = new CodigoRecuperacao;

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    if(!empty($_GET['email_usuario']) && !empty($_GET['codigo'])){
        $email_usuario = trim(filter_var($_GET['email_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $codigo_recup = trim(filter_var($_GET['codigo'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $validador = substr($codigo_recup, -2);
        // traz o código de verificação e suas validações
        $codigo = $codigo_recuperacao->consulta_codigo($email_usuario, 'A', date('Y-m-d'), $validador);

        // echo '<pre>';
        // print_r($codigo);
        // echo '</pre>';

        if(!empty($codigo)){
            if($codigo['status_codigo_recuperacao'] === 'A'){
                //verifica o código se é igual ao do banco de dados
                if(password_verify($codigo_recup, $codigo['codigo_codigo_recuperacao'])){
                    // Atualiza status tornando o código inativo
                    $codigo_recuperacao->atualiza_status('I', $codigo['id_codigo_recuperacao']);
                    //retorna o json autorizando
                    echo json_encode(['autorizado']);
                } else {
                    //retorna o json não autorizado
                    echo json_encode(['nao_autorizado']);
                }
            } else {
                //retorna o json não autorizado
                echo json_encode(['nao_autorizado_codigo_invalido']);
            }
        } else {
            echo json_encode(['nao_autorizado']);
        }   
    } else {
        header("Location: ../login.php");
        die();
    }
} else {
    header("Location: ../login.php");
    die();
}