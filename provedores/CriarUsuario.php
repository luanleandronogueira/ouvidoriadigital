<?php
session_start();
require_once 'Classes.php';
$usuario = new Usuario;

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

    verificarTokenCSRF();

    if (!empty($_POST)) {

        $cpf_usuario_sem_formatado = filter_var($_POST['cpf_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cpf_usuario = str_replace(['.', '-'], '', $cpf_usuario_sem_formatado);

        $consulta_cpf = $usuario->consulta_cpf($cpf_usuario);

        if ($consulta_cpf == 0) {

            $nome_usuario = ucwords(filter_var($_POST['nome_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $sobrenome_usuario = ucwords(filter_var($_POST['sobrenome_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $telefone_whatsapp = filter_var($_POST['telefone_whatsapp'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if(!empty($_POST['email_usuario'])) {
                $email_usuario = filter_var($_POST['email_usuario'], FILTER_SANITIZE_EMAIL);

            } else {
                $email_usuario = 'naoresponda@it-solucoes.inf.br';

            }
            
            // $login_usuario = filter_var($_POST['login_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $senha_usuario = password_hash($_POST['senha_usuario'], PASSWORD_DEFAULT);

            if(!empty($nome_usuario) || !empty($email_usuario) || !empty($cpf_usuario) ||!empty($login_usuario) ||!empty($senha)) {
                $id = $_POST['id_entidade'];
                $usuario->inserir_usuario($nome_usuario, $sobrenome_usuario, $cpf_usuario, $email_usuario, $senha_usuario, $telefone_whatsapp);
                //echo 'caiu aqui !';
                header("Location: ../login.php?status=faca_login&&id=".$id . "&&id_portal=" . $_POST['id_portal']);

            } else {

                //header("Location: ../criar_usuario.php?status=campos_obrigatorios&&id=".$id);
                //die();
            }
        } else {

            //header("Location: ../criar_usuario.php?status=cpf_ja_cadastrado&&id=".$id);
            //die();
        }
    } else {

       // header("Location: ../login.php?status=nao_autorizado1&&id=".$id);
       // die();
    }
} else {

    header("Location: ../login.php?status=nao_autorizado2&&id=".$id);
    die();
}
