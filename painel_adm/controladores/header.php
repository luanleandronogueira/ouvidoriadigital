<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplicativo web de Ouvidoria">
    <meta name="author" content="L3 Tecnologia/IT Soluções">
    <title>Ouvidoria Digital</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Russo+One&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />


    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        #mapa {
            height: 100vh;
            /* Exemplo: Ocupa 100% da altura da viewport */
            width: 100%;
            /* Adicione o estilo visual aqui se não for para o style.css */
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            border: 1px solid var(--cor-cinza-light);
        }

        /* Adicione o media query para dispositivos móveis */
        @media (max-width: 991px) {
            #mapa {
                height: 60vh;
                margin-bottom: 20px;
            }
        }
    </style>

    <!-- Biblioteca de Icones -->
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>


    <style>
        /* Adicione um estilo específico para telas menores, como celulares */
        @media (max-width: 767px) {

            /* Seletor para a tabela que você deseja adicionar o scroll horizontal */
            .sua-tabela {
                /* Defina a largura máxima da tabela para ativar o scroll horizontal quando necessário */
                max-width: 100%;
                /* Adicione um scroll horizontal quando o conteúdo excede a largura da tabela */
                overflow-x: auto;
                display: block;
                /* Adicione display: block para forçar a barra de rolagem horizontal */
            }

            /* Opcional: Remova as bordas da tabela para um visual mais limpo */
            .sua-tabela,
            .sua-tabela th,
            .sua-tabela td {
                border: none;
            }
        }
    </style>
</head>
<main>

    <body>
        <header>
            <nav class="nav_controller navbar d-none d-lg-block d-xl-block d-xxl-block">
                <div class="container-fluid">
                    <div class="menu">
                        <div class="">
                            <a href="dados_analiticos.php"><img src="../assets/images/logo.png" width="200px" alt="Ouvidoria Web"></a>
                        </div>
                        <div class="menu-opcoes cont_sessao2">
                            <span class="spanPersonal">
                                <strong><a class="aPersonal" href="dados_analiticos.php">Início</a></strong>
                            </span>
                            <span class="spanPersonal">
                                <strong><a class="aPersonal" href="minhas_manifestacoes.php#main">Manifestações</a></strong>
                            </span>
                            <span class="spanPersonal">
                                <strong><a class="aPersonal" href="dados_analiticos.php">Dados Analíticos</a></strong>
                            </span>
                        </div>
                        <div class="menu-box-user">
                            <div class="menu-dados-user">
                                <div class="cont_sessao">
                                    Bem Vindo, <?= $_SESSION['nome'] ?>!
                                </div>
                                <div class="cont_sessao2">
                                    <a href="perfil.php">Ver Perfil</a> • <a href="configuracoes.php">Configurações</a> • <a href="sair.php">Sair </a>
                                </div>
                            </div>
                            <div class="menu-box-user2">
                                <img src="../assets/images/avatar.png" alt="User" width="50px" height="50px" class="img_user">
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <nav class="nav_controller_mobile navbar navbar-expand-lg d-lg-none d-xl-none d-xxl-none">
                <div class="container-fluid">
                    <a class="navbar-brand" href="dashboard.php">
                        <img src="../assets/images/logo.png" alt="Logo" width="200" class="d-inline-block align-text-top">
                    </a>
                    <button class="navbar-toggler border-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">

                    </div>
                </div>
            </nav>
        </header>

        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header">
                <a class="navbar-brand" href="dashboard.php">
                    <img src="../assets/images/logo.png" alt="Logo" width="200" class="d-inline-block align-text-top">
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul>
                    <p><a href="perfil.php">Ver Perfil</a></p>
                    <p><a href="dados_analiticos.php">Início</a></p>
                    <p><a href="minhas_manifestacoes.php">Manifestações</a></p>
                    <p><a href="sair.php">Sair</a></p>
                </ul>
            </div>
        </div>