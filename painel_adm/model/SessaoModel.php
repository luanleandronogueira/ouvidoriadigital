<?php

function valida_sessao()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION['sessao']) || $_SESSION['sessao'] !== 'ativo'){
        session_unset();
        session_destroy();
        $mensagem = "Não autenticado 2";
        header("Location: ./login.php?status={$mensagem}");
        exit;
    }

    if (empty($_SESSION['status_atividade']) || $_SESSION['status_atividade'] !== 'A'){
        session_unset();
        session_destroy();
        $mensagem = "Usuário está bloqueado";
        header("Location: ./login.php?status={$mensagem}");
        exit;
    }

    // if (empty($_SESSION['id_entidade']) || empty($_SESSION['id']) || empty($_SESSION['nome_entidade']) ){
    //     session_unset();
    //     session_destroy();
    //     $mensagem = "Não autenticado 3";
    //     header("Location: ./login.php?status={$mensagem}");
    //     exit;
    // }

}
