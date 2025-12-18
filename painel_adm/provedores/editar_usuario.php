<?php 
session_start();
require '../model/UsuarioAdmModel.php';

// Bloqueia acesso sem login
if (!isset($_SESSION['id'])) {
    session_destroy();
    header("Location: ../login.php?status=nao_autenticado");
    exit;
}

// verifica se o method é post
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    session_destroy();
    header("Location: ../login.php?status_erro=metodo_invalido");
    exit;
}

// Salva dados em uam variável
$id = filter_var(intval($_POST['id']), FILTER_SANITIZE_NUMBER_INT) ?? ' ';
$nivel_acesso = filter_var($_POST['nivel_acesso'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? ' ';
$nome_minusculo = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? ' ';
$status_atividade = $_POST['status_atividade'];

// nome fica com as primeiras letras maiusculos
$nome = ucwords($nome_minusculo, ' ');

// verifica se os campos estão em branco
if (empty($id) || empty($nivel_acesso) || empty($nome) || empty($status_atividade)){
    $mensagem = "Dados em Branco, favor preencha os campos";
    header("Location: ../editar_usuario.php?id={$id}&&status_senha={$mensagem}");
    exit();
}

// Cria a instância
$UsuarioAdm = new UsuarioAdm;

// Dispara a função de atualizar os dados
$validacao = $UsuarioAdm->altera_dados_usuario_adm($id, $nome, $nivel_acesso, $status_atividade);

// Valida se foi feito true retorna os dados
if($validacao){
    $mensagem = "Dados Alterados com Sucesso!";
    header("Location: ../editar_usuario.php?id={$id}&&status_senha={$mensagem}");
    exit;

} else {
    $mensagem = "Erro ao Alterar";
    header("Location: ../editar_usuario.php?id={$id}&&status_erro={$mensagem}");
    exit;

}





