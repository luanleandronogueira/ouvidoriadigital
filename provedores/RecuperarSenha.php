<?php
session_start();
require_once 'Classes.php';
require '../assets/lib/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$usuario = new Usuario;
$codigo_recuperacao = new CodigoRecuperacao;

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    verificarTokenCSRF();

    //salva email e verifica
    $email_usuario = filter_var($_POST['email_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //verifica se existe o email na base
    $response = $usuario->email_usuario($email_usuario);
    if($response == 1){

        // gera código de recuperação 5 dígitos aleatório
        $codigo_envio = rand(10000, 99999);
        $codigo_envio_hash = password_hash($codigo_envio, PASSWORD_DEFAULT);
        $validador = substr($codigo_envio, -2);
        
        // banco de dados
        $codigo_recuperacao->registra_codigo_recuperacao($codigo_envio_hash, $email_usuario, date("Y-m-d"), 'A', $validador);
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = false;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.titan.email';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'nao-responda@l3tecnologia.app.br';      //SMTP username
            $mail->Password   = '@Itsolit';                             //SMTP password
            $mail->SMTPSecure = 'ssl';                                  //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet = 'UTF-8';

            //Recipients
            $mail->setFrom('nao-responda@l3tecnologia.app.br', 'Recuperação de Senha');
            $mail->addAddress($email_usuario);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Recuperar Senha';
            $mail->Body    = '<!doctype html>
            <html lang="pt-br">
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
            <main>
            <div class="mt-5 container">
                <div class="row">
                    <center>
                    <h3 class="text-center">Código de Recuperação</h3>
                    <span>Oi, tudo bem? Você solicitou o código de recuperação de senha.</span>
                    <hr>
                    <div class="text-center">
                        <img src="https://l3tecnologia.app.br/ouvidoriaweb/assets/images/icon_gif.gif" width="150px" alt="Icone Email">
                    <h1>'. $codigo_envio .'</h1>
                    <span>Não compartilhe esse código!</span></br>
                    <p>Esta mensagem foi gerada automaticamente. Não responda a este e-mail. Caso necessite de ajuda, acesse o Suporte.</p>
                    </center>
                    </div>
                </div>
            </div>
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
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        header("Location: ../inserir_nova_senha.php?id=".$_POST['id']);
        die();

    } else{
        header("Location: ../login.php?status=nao_autorizado2&&id=".$_POST['id']);
        die(); 
    }
} else {
    header("Location: ../login.php?status=nao_autorizado2&&id=".$_POST['id']);
    die();

}