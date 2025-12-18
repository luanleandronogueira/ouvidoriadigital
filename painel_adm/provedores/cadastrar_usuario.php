<?php 
session_start();
require '../model/UsuarioAdmModel.php';
require '../model/NivelAcessoModel.php';

// Inicia a instância
$UsuarioAdm = new UsuarioAdm;

// Bloqueia acesso sem login
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php?status=nao_autenticado");
    exit;
}

// verifica se o method é post
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    session_destroy();
    header("Location: ../login.php?status_erro=metodo_invalido");
    exit;
}

// Recebe os dados do CPF
$cpf = $_POST['cpf'] ?? '';

// Verifica o CPF
$verifica_cpf = $UsuarioAdm->consulta_cpf($cpf);

if($verifica_cpf > 0){
    $mensagem = "Esse CPF já foi cadastrado!";
    header("Location: ../cadastrar_usuario.php?status_erro={$mensagem}");
    exit;
}

// Verifica o email
$email = $_POST['email'] ?? '';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../cadastrar_usuario.php?status_erro=Email inválido");
    exit;
}

// Verifica o E-mail
$verifica_email = $UsuarioAdm->consulta_email($email);

if($verifica_email > 0){
    $mensagem = "Esse E-mail já foi cadastrado!";
    header("Location: ../cadastrar_usuario.php?status_erro={$mensagem}");
    exit;
}

// Deixa o nome minusculo
$usuario_recebido = strtolower($_POST['nome']);

//Deixa as primeiras letras iniciais maiusculuas
$usuario = ucwords($usuario_recebido, " ") ?? '';
$acesso = $_POST['acesso'] ?? '';
$nivel_acesso = '';

// Cria a senha salvando os 4 sendo elas os 4 primeiros dígitos do CPF
$cria_senha = substr($cpf, 0, -7);

// Transforma a senha para a criptografia em HASH
$senha = password_hash($cria_senha, PASSWORD_DEFAULT);

// valida e recebe o valor do nível de acesso
if(isset($acesso) && $acesso === 'U'){
    $nivel_acesso = $_POST['nivel_acesso'] ?? '';
}

// Valida se há algum campo em branco
if (empty($usuario) || empty($cpf) || empty($email) || empty($acesso)){
    $mensagem = "Campos Vazios";
    header("Location: ../cadastrar_usuario.php?status_erro={$mensagem}");
    exit;
}

// valida se o CPF tem exatos 11 caracteres
if(strlen($cpf) !== 11){
    $mensagem = "Este CPF é inválido!";
    header("Location: ../cadastrar_usuario.php?status_erro={$mensagem}");
    exit;
}

// Faz a inserção do novo usuário e recupera o ID para cadastrar o nível de acesso
$id_usuario_adm = $UsuarioAdm->inclui_novo_usuario($usuario, $cpf, $senha, $email, $acesso);

// Se for cadastrado como usuario ele insere o nivel de acesso selecionado.
if($acesso === 'U'){
    $NivelAcessoAdm = new NivelAcessoAdm;
    $NivelAcessoAdm->inclui_nivel_acesso($id_usuario_adm, $nivel_acesso);
}

if($id_usuario_adm){
    header("Location: ../cadastrar_usuario.php?status=sucesso");
    exit;

} else {
    $mensagem = "Erro ao Alterar";
    header("Location: ../cadastrar_usuario.php?status_erro={$mensagem}");
    exit;
}



