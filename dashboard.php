<?php
session_start();
require_once 'provedores/Classes.php';
verificaSessao();
require_once 'controladores/Controller.php';

$tipo_manifestacao = new TipoManifestacoes;
$t_manifestacao = $tipo_manifestacao->chama_tipo_manifestacoes();

// echo '<pre>';
//     print_r($_SESSION);
// echo '</pre>';

?>
<!-- <div class="aviso_inicial row">
    <div class="col-lg-6 col-xl-6 col-xxl-6">
        <section class="text-end">
            <h4>Como posso lhe ajudar?</h4>
            <strong>
                <p>Escolha uma das opções abaixo e escolha entre elas.</p>
            </strong>
        </section>
    </div>
</div> -->

<div class="servicos">
    <!-- <div class="d-lg-none d-xl-none d-xxl-none">
            <h4>Bem vindo, <?= $_SESSION['nome_usuario'] ?></h4>
        </div> -->
    <a class="servico-box box-bg-amarelo" href="registrar_manifestacao.php?id_manifestacao=<?= $t_manifestacao[1]['id_tipo_manifestacao'] ?>">
        <div class="servico-icone">
            <span class="iconify" data-icon="mage:megaphone-b" data-inline="false"></span>
        </div>
        <div class="box-dados">
            <h4>Manifestação - Ouvidoria</h4>
            <p>A Ouvidoria é o canal para registrar sugestões, reclamações, elogios ou denúncias. Sua participação ajuda a melhorar os serviços com transparência. Todas as manifestações são tratadas com sigilo e compromisso.</p>
        </div>
    </a>

    <a class="servico-box box-bg-lilas" href="registrar_manifestacao.php?id_manifestacao=<?= $t_manifestacao[0]['id_tipo_manifestacao'] ?>">
        <div class="servico-icone">
            <span class="iconify" data-icon="bx:like" data-inline="false"></span>
        </div>
        <div class="box-dados">
            <h4>Enviar um Elogio</h4>
            <p>Quer reconhecer um bom atendimento? Envie seu elogio e valorize quem fez a diferença! Seu feedback motiva, incentiva a excelência e contribui para a melhoria contínua dos serviços.</p>
        </div>
    </a>

    <a class="servico-box box-bg-laranja" href="registrar_manifestacao.php?id_manifestacao=<?= $t_manifestacao[2]['id_tipo_manifestacao'] ?>">
        <div class="servico-icone">
            <span class="iconify" data-icon="hugeicons:complaint" data-inline="false"></span>
        </div>
        <div class="box-dados">
            <h4>Enviar uma Reclamação</h4>
            <p>Teve uma experiência insatisfatória? Envie sua reclamação para que possamos melhorar. Seu feedback é essencial e será tratado com seriedade e sigilo, buscando soluções justas e eficazes.</p>
        </div>
    </a>

    <a class="servico-box box-bg-vermelho" href="registrar_manifestacao.php?id_manifestacao=<?= $t_manifestacao[4]['id_tipo_manifestacao'] ?>">
        <div class="servico-icone">
            <span class="iconify" data-icon="tabler:message-report" data-inline="false"></span>
        </div>
        <div class="box-dados">
            <h4>Registrar uma Denúncia</h4>
            <p>Presenciou algo irregular? Registre sua denúncia com segurança e sigilo. Sua manifestação é essencial para garantir transparência, integridade e medidas corretivas quando necessário.</p>
        </div>
    </a>

    <a class="servico-box box-bg-verde" href="registrar_manifestacao.php?id_manifestacao=<?= $t_manifestacao[3]['id_tipo_manifestacao'] ?>">
        <div class="servico-icone">
            <span class="iconify" data-icon="bx:task" data-inline="false"></span>
        </div>
        <div class="box-dados">
            <h4>Fazer uma Solicitação</h4>
            <p>Precisa de informações ou solicitar um serviço? Envie sua solicitação de forma simples. Cada pedido é analisado com atenção para garantir um atendimento eficiente e de qualidade.</p>
        </div>
    </a>

    <a class="servico-box box-bg-azul" href="minhas_manifestacoes.php">
        <div class="servico-icone">
            <span class="iconify" data-icon="gg:list" data-inline="false"></span>
        </div>
        <div class="box-dados">
            <h4>Consultar minhas Solicitações</h4>
            <p>Acompanhe suas solicitações de forma rápida e transparente. Consulte o status e as respostas com informações atualizadas a cada etapa do processo.</p>
        </div>
    </a>
</div>



<?php include_once 'controladores/Footer.php' ?>