<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplicativo web de Ouvidoria">
    <meta name="author" content="L3 Tecnologia/IT Soluções">
    <title>Ouvidoria Digital - Anônimo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Russo+One&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Biblioteca de Icones -->
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>

</head>

<body class="anonima">
    <header>
        <nav class="nav_controller navbar d-none d-lg-block d-xl-block d-xxl-block">
            <div class="container-fluid">
                <div class="menu">
                    <div class="">
                        <a href="login.php"><img src="assets/images/logo_branca.png" width="200px" alt="Ouvidoria Web"></a>
                    </div>
                    <div class="menu-opcoes cont_sessao2"></div>
                </div>
            </div>
        </nav>

        <nav class="nav_controller_mobile navbar navbar-expand-lg d-lg-none d-xl-none d-xxl-none">
            <div class="container-fluid">
                <a class="navbar-brand" href="login.php">
                    <img src="assets/images/logo_branca.png" alt="Logo" width="200" class="d-inline-block align-text-top">
                </a>
                
                
                <a class="text-white" href="login.php?id=<?=$_GET['id']?>">Voltar</a>
                
                <!-- <div class="collapse navbar-collapse" id="navbarNavDropdown"> 
                    
                </div> -->
            </div>
        </nav>
    </header>
    <main>

        <!-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Enable both scrolling & backdrop</button> -->
