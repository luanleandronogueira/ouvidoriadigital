<?php 
include_once('provedores/Classes.php');
$todas_entidades = new Entidades;
$ent = $todas_entidades->chama_entidade_id_portal($_GET['id']);

// echo '<pre>';
// print_r($ent);
// echo '</pre>';

if(!empty($_GET)){
    
    $id = $_GET['id'];

} else {
    // $id = $_GET['id'];
    header("Location: index.php?");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="Aplicativo web de Ouvidoria"/>
    <meta name="author" content="L3 Tecnologia/IT Soluções" />
    <title>Ouvidoria Digital</title>

    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Russo+One&display=swap"
        rel="stylesheet"/>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>

    <link rel="stylesheet" href="style.css"/>

    <!-- Biblioteca de Icones -->
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
</head>

<body>
    <header>
        <nav class="nav_controller navbar d-none d-lg-block d-xl-block d-xxl-block">
            <div class="container-fluid">
                <div class="menu">
                    <div class="">
                        <a href="login.php?id=<?=$ent['id_entidade'] . '-' . $ent['nome_entidade']?>&&id_portal=<?=$ent['id_portal_entidade']?>"><img src="./assets/images/logo.png" width="200px" alt="Logo"></a>
                    </div>
                    <h3 class="menu-opcoes">
                        Ouvidoria Geral - <?= $ent['nome_entidade'] ?>
                    </h3>
                </div>
            </div>
        </nav>

        <nav class="nav_controller_mobile navbar navbar-expand-lg d-lg-none d-xl-none d-xxl-none">
            <div class="container-fluid">
                <a class="navbar-brand" href="dashboard.php">
                    <img src="./assets/images/logo.png" alt="Logo" width="200" class="d-inline-block align-text-top">
                    <h3 class="menu-opcoes">
                        Ouvidoria Geral do Município
                    </h3>
                </a>

                <button class="navbar-toggler border-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">

                </div>
            </div>
        </nav>

        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
            aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header">
                <a class="navbar-brand" href="dashboard.php">
                    <img src="./assets/images/logo.png" alt="Logo" width="200" class="d-inline-block align-text-top">

                    <h3 class="menu-opcoes">
                        Ouvidoria Geral do Município
                    </h3>
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul></ul>
            </div>
        </div>

    </header>

    <div class="servicos">
        <a class="servico-box box-bg-amarelo" href="login.php?id=<?=$ent['id_entidade'] . '-' . $ent['nome_entidade']?>&&id_portal=<?=$ent['id_portal_entidade']?>">
            <div class="servico-icone">
                <span class="iconify" data-icon="mage:megaphone-b" data-inline="false"></span>
            </div>
            <div class="box-dados">
                <h4>Manifestação - Ouvidoria</h4>
                <p>A Ouvidoria é o canal para registrar sugestões, reclamações, elogios ou denúncias. Sua participação
                    ajuda a melhorar os serviços com transparência. Todas as manifestações são tratadas com sigilo e
                    compromisso.</p>
            </div>
        </a>

        <a class="servico-box box-bg-lilas" href="login.php?id=<?=$ent['id_entidade'] . '-' . $ent['nome_entidade']?>&&id_portal=<?=$ent['id_portal_entidade']?>">
            <div class="servico-icone">
                <span class="iconify" data-icon="bx:like" data-inline="false"></span>
            </div>
            <div class="box-dados">
                <h4>Enviar um Elogio</h4>
                <p>Quer reconhecer um bom atendimento? Envie seu elogio e valorize quem fez a diferença! Seu feedback
                    motiva, incentiva a excelência e contribui para a melhoria contínua dos serviços.</p>
            </div>
        </a>

        <a class="servico-box box-bg-laranja" href="login.php?id=<?=$ent['id_entidade'] . '-' . $ent['nome_entidade']?>&&id_portal=<?=$ent['id_portal_entidade']?>">
            <div class="servico-icone">
                <span class="iconify" data-icon="hugeicons:complaint" data-inline="false"></span>
            </div>
            <div class="box-dados">
                <h4>Enviar uma Reclamação</h4>
                <p>Teve uma experiência insatisfatória? Envie sua reclamação para que possamos melhorar. Seu feedback é
                    essencial e será tratado com seriedade e sigilo, buscando soluções justas e eficazes.</p>
            </div>
        </a>

        <a class="servico-box box-bg-vermelho" href="login.php?id=<?=$ent['id_entidade'] . '-' . $ent['nome_entidade']?>&&id_portal=<?=$ent['id_portal_entidade']?>">
            <div class="servico-icone">
                <span class="iconify" data-icon="tabler:message-report" data-inline="false"></span>
            </div>
            <div class="box-dados">
                <h4>Registrar uma Denúncia</h4>
                <p>Presenciou algo irregular? Registre sua denúncia com segurança e sigilo. Sua manifestação é essencial
                    para garantir transparência, integridade e medidas corretivas quando necessário.</p>
            </div>
        </a>

        <a class="servico-box box-bg-verde" href="login.php?id=<?=$ent['id_entidade'] . '-' . $ent['nome_entidade']?>&&id_portal=<?=$ent['id_portal_entidade']?>">
            <div class="servico-icone">
                <span class="iconify" data-icon="bx:task" data-inline="false"></span>
            </div>
            <div class="box-dados">
                <h4>Fazer uma Solicitação</h4>
                <p>Precisa de informações ou solicitar um serviço? Envie sua solicitação de forma simples. Cada pedido é
                    analisado com atenção para garantir um atendimento eficiente e de qualidade.</p>
            </div>
        </a>

        <a class="servico-box box-bg-azul" href="login.php?id=<?=$ent['id_entidade'] . '-' . $ent['nome_entidade']?>&&id_portal=<?=$ent['id_portal_entidade']?>">
            <div class="servico-icone">
                <span class="iconify" data-icon="gg:list" data-inline="false"></span>
            </div>
            <div class="box-dados">
                <h4>Consultar minhas Solicitações</h4>
                <p>Acompanhe suas solicitações de forma rápida e transparente. Consulte o status e as respostas com
                    informações atualizadas a cada etapa do processo.</p>
            </div>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>