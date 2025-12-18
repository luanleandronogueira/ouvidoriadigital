<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'Classes.php';
require '../assets/lib/vendor/phpmailer/phpmailer/src/Exception.php';
require '../assets/lib/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../assets/lib/vendor/phpmailer/phpmailer/src/SMTP.php';
require '../assets/lib/vendor/autoload.php';
//verificaSessao();
// verificarTokenCSRF();
$usuario_anonimo = new Usuario;
$id_usuario_anonimo = $usuario_anonimo->chama_usuario_anonimo();
$entidade = new Entidades;
$manifestacoes = new Manifestacoes;
$mail = new PHPMailer(true);


if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST)){       
        // filtra os dados
        $arquivo_manifestacao = filter_var($_POST['arquivo_manifestacao'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id_entidade_manifestacao = filter_var($_POST['id_entidade_manifestacao'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id_tipo_manifestacao = filter_var($_POST['id_tipo_manifestacao'], FILTER_SANITIZE_NUMBER_INT);
        $motivo_manifestacao = filter_var($_POST['motivo_manifestacao'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $conteudo_manifestacao = filter_var($_POST['conteudo_manifestacao'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $observacoes_manifestacao = filter_var($_POST['observacoes_manifestacao'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $local_manifestacao = filter_var($_POST['local_manifestacao'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id_usuario_manifestacao = filter_var($id_usuario_anonimo['id_usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data_manifestacao = date('Y-m-d');
        $protocolo_manifestacao = $id_entidade_manifestacao . '-' . $id_usuario_manifestacao . '-' . date('dmyHms');

        // se vazio, insere dados
        if(empty($observacoes_manifestacao)){
            $observacoes_manifestacao = 'Sem observações';
        }
        // se vazio, insere dados
        if(empty($local_manifestacao)){
            $local_manifestacao = 'Sem observações';
        }
        // chama email da entidade
        $email_entidade = $entidade->chama_email_entidade($_SESSION['id_entidade']);

        // Insere no banco de dados a manifestacao
       $manifestacoes->inserir_manifestacao($motivo_manifestacao, $id_entidade_manifestacao, $id_tipo_manifestacao, $conteudo_manifestacao, $observacoes_manifestacao, $local_manifestacao, $arquivo_manifestacao, $id_usuario_manifestacao, 'A', $data_manifestacao, $protocolo_manifestacao);

        // Envia email para o orgão responsável
        try {
            //Server settings
            $mail->SMTPDebug = false;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.titan.email';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'naoresponda@l3tecnologia.app.br';      //SMTP username
            $mail->Password   = '@Itsolit';                             //SMTP password
            $mail->SMTPSecure = 'tls';                                  //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet = 'UTF-8';
        
            //Recipients
            $mail->setFrom('naoresponda@l3tecnologia.app.br', 'Nova Solicitação Anônima na Ouvidoria ');
            $mail->addAddress($email_entidade['email_entidade']);     //Add a recipient
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Você Recebeu uma nova Solicitação na Ouvidoria';
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
            <main><center><div class="container mt-5 text-center"> <div class="card shadow-lg p-4"><img src="https://l3tecnologia.app.br/ouvidoriaweb/assets/images/anonima.jpg" width="300px" class="img-fluid mt-3 rounded"><h1 class="text-primary">Nova Solicitação Anônima Recebida!</h1><p class="mt-3 text-muted">Uma nova solicitação foi enviada à ouvidoria. Acesse a plataforma e confira a solicitação.</p><div class="mt-4"></div></div></div></center>
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
            echo "Erro ao enviar o email, favor tentar mais tarde: {$mail->ErrorInfo}";
        }
        //Redireciona para a página de manifestações listadas
        header("Location: ../resposta_anonima.php?status=sucesso&&protocolo={$protocolo_manifestacao}");

    } else {
        // Redireciona para a página de manifestações listadas
        header("Location: ../login.php?erro=post_vazio");
        die();

    }

} else {
     // Redireciona para a página de manifestações listadas
     header("Location: ../login.php?erro=post_vazio");
     die();

}

