<?php
// inicia a sessão
session_start();
require '../model/NivelAcessoModel.php';

// Bloqueia acesso sem login
if (!isset($_SESSION['id'])) {
    session_destroy();
    header("Location: ../login.php?status=nao_autorizado");
    exit;
}

// verifica as sessões se estão ativas
if (!isset($_SESSION['sessao']) && $_SESSION['sessao'] !== 'ativo') {
    session_destroy();
    header("Location: ../login.php?status=nao_autorizado");
    exit;
}

// verifica os níveis de acesso
if (!isset($_SESSION['nivel_acesso']) && $_SESSION['nivel_acesso'] !== 'A') {
    session_destroy();
    header("Location: ../login.php?status=nao_autorizado");
    exit;
}

// verifica se o method é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    session_destroy();
    header("Location: ../login.php?status_erro=metodo_invalido");
    exit;
}

// Salva o ID na variável
$id = $_POST['id'] ?? '';
$nivel_acesso = $_POST['nivel_acesso'] ?? '';

// Vê se o ID não é vazio
if (empty($id) || empty($nivel_acesso)){
    session_destroy();
    header("Location: ../login.php?status_erro=metodo_invalido");
    exit;
}

// Instância o Objeto
$NivelAcesso = new NivelAcessoAdm;

// Valida se já existe ele no banco de dados
$valida_nivel_acesso = $NivelAcesso->consulta_nivel($id, $nivel_acesso);
if ($valida_nivel_acesso > 0){
    $mensagem = "Já incluído anteriomente!";
    header("Location: ../altera_nivel_acesso.php?id={$id}&&status_erro={$mensagem}");
    exit;
}

// Incluí no banco banco o nível de acesso
$validacao = $NivelAcesso->inclui_nivel_acesso($id, $nivel_acesso);
if ($validacao){
    $mensagem = "Incluído com Sucesso!";
    header("Location: ../altera_nivel_acesso.php?id={$id}&&status={$mensagem}");
    exit;

} else {
    $mensagem = "Erro ao Alterar";
    header("Location: ../editar_usuario.php?id={$id}&&status_erro={$mensagem}");
    exit;

}


