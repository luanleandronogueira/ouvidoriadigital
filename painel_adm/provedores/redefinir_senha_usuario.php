<?php
// inicia a sessão
session_start();

// namespaces 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// traz as bibliotecas
require '../model/UsuarioAdmModel.php';
require '../assets/lib/vendor/autoload.php';
require '../assets/lib/vendor/phpmailer/phpmailer/src/Exception.php';
require '../assets/lib/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../assets/lib/vendor/phpmailer/phpmailer/src/SMTP.php';

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

// verifica se o method é get
if ($_SERVER['REQUEST_METHOD'] !== 'GET'){
    session_destroy();
    header("Location: ../login.php?status_erro=metodo_invalido");
    exit;
}

// Salva o ID na variável
$id = $_GET['id'] ?? '';

// Vê se o ID não é vazio
if (empty($id)){
    session_destroy();
    header("Location: ../login.php?status_erro=metodo_invalido");
    exit;
}

// Cria a instância
$usuarios = new UsuarioAdm;
// Chama o CPF do usuário
$usuario = $usuarios->chama_cpf($id);

// Salva os dados do banco em variáveis
$cpf = $usuario['cpf'] ?? '';
$email = $usuario['email'] ?? '';

// Valida se há email e CPF
if (empty($cpf) || empty($email)){
    session_destroy();
    header("Location: ../login.php?status_erro=metodo_invalido");
    exit;
}

// Cria a senha salvando os 4 sendo elas os 4 primeiros dígitos do CPF
$cria_senha = substr($cpf, 0, -7);

// Transforma a senha para a criptografia em HASH
$senha = password_hash($cria_senha, PASSWORD_DEFAULT);

// insere a senha no banco criptografada 
$validacao = $usuarios->altera_senha_usuario($id, $senha);

// valida se foi feito a alteração da senha
if($validacao){

        // Envia email para o usuário responsável
        try {
            //Server settings
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            $mail->SMTPDebug = false;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.titan.email';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'naoresponda@it-solucoes.inf.br';      //SMTP username
            $mail->Password   = '@Itsolit1';                             //SMTP password
            $mail->SMTPSecure = 'tls';                                  //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet = 'UTF-8';
        
            //Recipients
            $mail->setFrom('naoresponda@it-solucoes.inf.br', 'Aviso de Alteração de Senha');
            $mail->addAddress($email);     //Add a recipient
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Sua Senha Foi Alterada!';
            $mail->Body    = '<html lang="pt-br">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <meta name="description" content="Aplicativo web de Ouvidoria">
                <meta name="author" content="L3 Tecnologia/IT Soluções">
                <title>Ouvidoria Web</title>
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="assets/css/style.css">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            </head>
            <body>
            <main><center><div class="container mt-5 text-center"> <div class="card shadow-lg p-4"><img src="https://l3tecnologia.app.br/ouvidoriadigital/assets/images/logo.png" width="300px" class="img-fluid mt-3 rounded"><h1 class="text-primary">Sua Senha Foi Alterada!</h1><p class="mt-3 text-muted">Sua senha foi alterada pelo administrador, em caso de dúvidas entre em contato pelo suporte!</p><div class="mt-4"></div></div></div></center>
                </main>
            <script src="assets/js/script.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
            <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
            <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>';
            $mail->AltBody = 'Para ler essa mensagem se é necessário usar um Client que leia HTML.';
        
            $mail->send();
            //echo 'Message has been sent';

        } catch (Exception $e) {
            $mensagem = "Erro ao enviar o email, favor tentar mais tarde: {$mail->ErrorInfo}";
            header("Location: ../editar_usuario.php?id={$id}&&status_erro={$mensagem}");
            exit;
        }

    $mensagem = "Senha Alterada com Sucesso!";
    header("Location: ../editar_usuario.php?id={$id}&&status_senha={$mensagem}");
    exit;

} else {
    $mensagem = "Erro ao Alterar";
    header("Location: ../editar_usuario.php?id={$id}&&status_erro={$mensagem}");
    exit;

}
