<?php
session_start();
require_once 'provedores/Classes.php';
require_once 'controladores/ControllerAnonimo.php';

?>

<div class="container">
    <div class="protocolo-anonimo">
        <div class="protocolo-mensagem">
            <h4>Sua denúncia foi registrada com sucesso!</h4><br>
            <p>Obrigado por contribuir com a nossa plataforma. Sua manifestação é importante para nós.</p>
            <p>Você pode acompanhar o andamento da sua denúncia através deste número do protocolo.</p>
        </div>
        
        <div class="protocolo-numero">
            <span>Protocolo:</span>
            <h1><?= $_GET['protocolo'] ?></h1>
            <p>Anote e não perca!</p>
        </div>

        <a class="btn btn-sm btn-dark bt" href="login.php">Voltar e Fazer Login</a>
    </div>
</div>