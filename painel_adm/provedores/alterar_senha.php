<?php
session_start();
require '../model/UsuarioAdmModel.php';

// Bloqueia acesso sem login
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php?status=nao_autenticado");
    exit;
}
//die();
// Garante que o método é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php?status=metodo_invalido");
    exit;
}

// Verifica campos obrigatórios
$senha_atual = $_POST['senha_atual'] ?? '';
$nova_senha = $_POST['senha_nova'] ?? '';
$confirmar_senha = $_POST['confirmar_senha'] ?? '';


if (empty($senha_atual) || empty($nova_senha) || empty($confirmar_senha)) {
    header("Location: ../alterar_senha.php?status=campos_vazios");
    exit;
}

// Confere se nova senha e confirmação batem
if ($nova_senha !== $confirmar_senha) {
    header("Location: ../alterar_senha.php?status=senhas_diferentes");
    exit;
}

// Valida complexidade mínima da nova senha
if (strlen($nova_senha) < 8) {
    header("Location: ../alterar_senha.php?status=senha_fraca");
    exit;
}

$usuario_adm = new UsuarioAdm();
$id = $_SESSION['id'];

// Consulta senha atual no banco
$dados_usuario = $usuario_adm->consulta_senha($id);

if (empty($dados_usuario) || !isset($dados_usuario['senha'])) {
    session_destroy();
    header("Location: ../login.php?status=usuario_inexistente");
    exit;
}

// Verifica senha atual
if (!password_verify($senha_atual, $dados_usuario['senha'])) {
    header("Location: ../alterar_senha.php?status=senha_incorreta");
    exit;
}

// Gera hash da nova senha
$nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

if (!$nova_senha_hash) {
    header("Location: ../alterar_senha.php?status=erro_hash");
    exit;
}

// Atualiza no banco
$alterou = $usuario_adm->altera_senha_usuario($id, $nova_senha_hash);

if ($alterou) {
    header("Location: ../alterar_senha.php?status=sucesso");
    exit;
} else {
    header("Location: ../alterar_senha.php?status=erro_atualizar");
    exit;
}
