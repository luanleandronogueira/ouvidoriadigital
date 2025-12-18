<?php
session_start();
require '../model/UsuarioAdmModel.php';
require '../model/NivelAcessoModel.php';

$usuario_adm = new UsuarioAdm;
$nivel_acesso = new NivelAcessoAdm;

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['login_usuario'])) {
        $login_usuario = trim(filter_var($_POST['login_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if (strlen($_POST['login_usuario']) <= 11) {
            $login_usuario = str_replace(['.', '-'], '', trim(filter_var($_POST['login_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS)));

        }   

        // salva valor da senha
        $senha_usuario = trim(filter_var($_POST['senha_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Consulta dados no DB
        $dados_usuario = $usuario_adm->consulta_usuario_adm($login_usuario);

        // Validação básica
        if (empty($login_usuario) || empty($senha_usuario)) {
            header("Location: ../login.php?status=nao_autorizado1&&id=");
            die();
        }

        if (!empty($dados_usuario)) {

            if (password_verify($senha_usuario, $dados_usuario['senha'])) {

                if ($dados_usuario['status_atividade'] === 'A') {

                    if($dados_usuario['nivel_acesso'] === 'A') {

                        $nivel_acesso_adm = $nivel_acesso->nivel_acesso_adm();

                        $_SESSION['nome'] = $dados_usuario['usuario'];
                        $_SESSION['email'] = $dados_usuario['email'];
                        $_SESSION['sessao'] = 'ativo';
                        $_SESSION['nivel_acesso'] = $dados_usuario['nivel_acesso'];
                        $_SESSION['status_atividade'] = $dados_usuario['status_atividade'];
                        $_SESSION['id'] = $dados_usuario['id'];

                        header("Location: ../seleciona_entidade.php");

                    } else {
                        
                        $nivel_acesso_adm = $nivel_acesso->consulta_nivel_acesso($dados_usuario['id']);

                        $_SESSION['nome'] = $dados_usuario['usuario'];
                        $_SESSION['email'] = $dados_usuario['email'];
                        $_SESSION['sessao'] = 'ativo';
                        $_SESSION['nivel_acesso'] = $dados_usuario['nivel_acesso'];
                        $_SESSION['status_atividade'] = $dados_usuario['status_atividade'];
                        $_SESSION['id'] = $dados_usuario['id'];

                        header("Location: ../seleciona_entidade.php");
                    }

                } else {

                    $msg = 'Usuário Bloqueado';
                    header("Location: ../login.php?status=".$msg);
                }

            } else {

                header("Location: ../login.php?status=senha_invalida&&autentica_usuario");
                die();

            }
            
        } else {

            $msg = 'Usuário não encontrado';
            header("Location: ../login.php?status=".$msg);
            die();

        }

    } else {
        $msg = 'Usuário não encontrado';
        header("Location: ../login.php?status=".$msg);
        die();
    }
} else {

    header("Location: ../login.php?status=nao_autorizado2&&AutenticaUsuario");
    die();
}
