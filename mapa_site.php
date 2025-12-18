<?php
session_start();
require_once 'provedores/Classes.php';
verificaSessao();
require_once 'controladores/Controller.php';
?>
<div class="container mt-4">
    <div class="row">
        <div class="mt-3">
            <h5>Mapa do Site</h5>
            <hr>
            <div>
                <ul class="list-group">
                    <li class="list-group-item"><a href="dashboard.php">Início</a></li>
                    <li class="list-group-item"><a target="_blank" href="https://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709.htm">Lei Geral de Proteção de Dados</a></li>
                    <li class="list-group-item"><a href="perfil.php">Meu Perfil</a></li>
                    <li class="list-group-item"><a href="mapa_site.php">Mapa do Site</a></li>
                    <li class="list-group-item"><a href="minhas_manifestacoes.php">Minhas Solicitações</a></li>
                    <li class="list-group-item"><a href="faq.php">Perguntas Frequentes</a></li>
                    <li class="list-group-item"><a href="politica_privacidades.php">Políticas de Privacidade</a></li>
                    <li class="list-group-item"><a href="dashboard.php#main">Registrar Manifestação</a></li>
                    <li class="list-group-item"><a href="dashboard.php#main">Registrar uma Solicitação</a></li>
                    <li class="list-group-item"><a href="#">Suporte</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include_once 'controladores/Footer.php' ?>