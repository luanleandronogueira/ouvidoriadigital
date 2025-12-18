<?php 
session_start();
require '../model/UsuarioAdmModel.php';

// Bloqueia acesso sem login
if (!isset($_SESSION['id'])) {
    session_destroy();
    header("Location: ../login.php?status=nao_autenticado");
    exit;
}

// Garante que o método é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    session_destroy();
    header("Location: ../login.php?status=metodo_invalido");
    exit;
}

$nome = $_POST['nome_usuario'] ?? '';
$email = $_POST['email'] ?? '';

if (empty($nome) || empty($email)) {
    header("Location: ../alterar_perfil.php?status=campos_vazios");
    exit;
}

$usuario_adm = new UsuarioAdm();
$id = $_SESSION['id'];

$validacao = $usuario_adm->altera_dados_usuario($id, $nome, $email);

if($validacao) {
    header("Location: ../perfil.php?status=sucesso");
    exit;

} else {
    header("Location: ../alterar_perfil.php?status0=erro_ao_alterar");
    exit;
}

?>