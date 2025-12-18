<?php
session_start();
require_once 'Classes.php';
$usuario = new Usuario;

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    verificarTokenCSRF();

    if (!empty($_POST)) {
        if(strlen($_POST['login_usuario']) > 11){
            $login_usuario = trim(filter_var($_POST['login_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        } else {
            $login_usuario = str_replace(['.', '-'], '', trim(filter_var($_POST['login_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
        }
        $senha_usuario = trim(filter_var($_POST['senha_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        
        // Validação básica
        if (empty($login_usuario) || empty($senha_usuario)) {
            header("Location: ../login.php?status=nao_autorizado1&&id=".urlencode($_SESSION['id_entidade']));
            die();
        }
        $consulta_usuario = $usuario->consulta_usuario($login_usuario);
        if(!empty($consulta_usuario)){
            if(password_verify($senha_usuario, $consulta_usuario['senha_usuario'])) {
                $_SESSION = $consulta_usuario;
                $_SESSION['csrf_token'] = $_POST['csrf_token'];
                $_SESSION['id_entidade'] = $_POST['id'];
                $_SESSION['entidade_nome'] = $_POST['entidade_nome'];
                $_SESSION['id_portal'] = $_POST['id_portal'];
                header("Location: ../dashboard.php");
            } else {
                $id = $_POST['id'];
                header("Location: ../login.php?status=senha_invalida&&AutenticaUsuario1&&id={$id}");
                die();
            }
        } else {
            $id = $_POST['id'];
            header("Location: ../login.php?status=log_senha_invalida&&AutenticaUsuario2&&id={$id}");
            die();
        }
    } else {
        header("Location: ../login.php?status=nao_autorizado1&&AutenticaUsuario&&id={$_POST['id']}");
        die();
    }
} else {
    header("Location: ../login.php?status=nao_autorizado2&&AutenticaUsuario&&id=&&id={$_POST['id']}");
    die();
}

