<?php
session_start();
require_once 'provedores/Classes.php';
include 'controladores/ControllerLogin.php';

?>
<div class="login">
    <div class="login-container">
        <div class="logo-container">
            <img src="./assets/images/logo.png" alt="Logo" class="logo">
        </div>

        <div class="form-cadastro">
            <h3>Recuperar Senha</h3>

            <!-- <div class="form-floating">
                <input type="text" onblur="consulta_email(); salva_cookie()" name="email_usuario" class="form-control" id="email_usuario" placeholder="Motivo da Manifestação">
                <label for="email_usuario">Insira seu e-mail cadastrado:</label>
            </div> -->

            <div class="Form-senha">
                <div class="form-floating">
                    <input type="text" onblur="consulta_email(); salva_cookie()" name="email_usuario" class="form-control" id="email_usuario" placeholder="Motivo da Manifestação">
                    <label for="email_usuario">Insira seu e-mail cadastrado:</label>
                </div>

                <!-- <div class="p-3 text-center">
                    <label for="email_usuario">Insira seu e-mail cadastrado:</label>
                    <input onblur="consulta_email(); salva_cookie()" type="text" class="text-center form-control" name="email_usuario" id="email_usuario">
                </div> -->
                <div id="btnCodigo" class="alert alert-primary my-4 d-none text-center" role="alert">
                    <strong>Encontramos seu e-mail, deseja iniciar o processo de recuperação da senha?</strong>
                    <a href="processo_recuperar_senha.php?id=<?= $_GET['id'] ?>" class="btn1 btn btn-primary  mt-3">Iniciar</a>
                </div>
                
                <div id="email_invalido" class="alert alert-danger my-4 d-none text-center" role="alert">
                    <strong>O email não foi encontrado, revise o e-mail ou inicie o processo de cadastro</strong>
                    <a href="criar_usuario.php?id=<?= $_GET['id'] ?>" class="btn1 btn btn-danger mt-3">Iniciar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="login-hero">
        <div class="login-hero-info">
            <h1>O seu espaço para Manifestações</h1>
            <p>A Ouvidoria Geral do Município é uma instância de participação e controle social que permite identificar melhorias para a gestão e serviços públicos. Ela é o seu canal de interação para falar sobre os serviços municipais.</p>
        </div>
    </div>
</div>
</div>


<?php include_once 'controladores/FooterLogin.php' ?>