<?php 
session_start();
session_destroy();
?>
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


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<script>
    // Verifique se a página foi recarregada (atualizada)
    if (performance.navigation.type === 1) {
        // Redirecione para a URL desejada
        window.location.href = 'login.php';
    }
</script>

<body>
    <main>
        <section>
            <div class="login">
                <div class="login-container">
                    <div class="logo-container">
                        <img src="../assets/images/logo.png" alt="Logo" class="logo">
                    </div>

                    <div class="login-bemvindo">
                        <h1>Painel de Administração</h1>
                    </div>

                    <?php if (isset($_GET['status'])) { ?>
                        <div class="alert alert-danger mb-4 mt-4 text-center" role="alert">
                           <strong><?= $_GET['status'] ?></strong>
                        </div>
                    <?php } ?>


                    <form class="form-login" action="provedores/autentica_usuario.php" method="POST">
                        <div>
                            <div class="form-login-dados">

                                <div class="form-floating">
                                    <input type="text" name="login_usuario" class="form-control" id="login_usuario" placeholder="email@email.com ou 12345678900" required>
                                    <label for="login_usuario">Email ou CPF:</label>
                                </div>

                                <div class="form-floating">
                                    <input type="password" name="senha_usuario" class="form-control" id="senha_usuario" placeholder="Insira sua senha" required>
                                    <label for="senha_usuario">Senha:</label>
                                </div>

                                <button type="submit" class="btn btn-secondary">Entrar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="login-hero">
                    <div class="login-hero-info">
                        <h1>O seu espaço para Manifestações</h1>
                        <p>A Ouvidoria Geral do Município é uma instância de participação e controle social que permite identificar melhorias para a gestão e serviços públicos. Ela é o seu canal de interação para falar sobre os serviços municipais.</p>
                    </div>
                </div>
            </div>
        </section>


    </main>
    <script src="../assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "order": [
                    [0, "desc"]
                ],
                "language": {
                    "decimal": "",
                    "emptyTable": "Nenhum dado disponível na tabela",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "infoFiltered": "(filtrado de _MAX_ entradas totais)",
                    "infoPostFix": "",
                    "thousands": ".",
                    "lengthMenu": "Mostrar _MENU_ entradas",
                    "loadingRecords": "Carregando...",
                    "processing": "Processando...",
                    "search": "Pesquisar:",
                    "zeroRecords": "Nenhum registro encontrado",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Último",
                        "next": "Próximo",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": ativar para ordenar a coluna em ordem crescente",
                        "sortDescending": ": ativar para ordenar a coluna em ordem decrescente"
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.date').mask('00/00/0000');
            $('.time').mask('00:00:00');
            $('.date_time').mask('00/00/0000 00:00:00');
            $('.cep').mask('00000-000');
            $('.phone').mask('0000-0000');
            $('.phone_with_ddd').mask('(00) 0000-0000');
            $('.phone_us').mask('(000) 000-0000');
            $('.mixed').mask('AAA 000-S0S');
            $('.cpf').mask('000.000.000-00', {
                reverse: true
            });
            $('.cnpj').mask('00.000.000/0000-00', {
                reverse: true
            });
            $('.money').mask('000.000.000.000.000,00', {
                reverse: true
            });
            $('.money2').mask("#.##0,00", {
                reverse: true
            });
            $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
                translation: {
                    'Z': {
                        pattern: /[0-9]/,
                        optional: true
                    }
                }
            });
            $('.ip_address').mask('099.099.099.099');
            $('.percent').mask('##0,00%', {
                reverse: true
            });
            $('.clear-if-not-match').mask("00/00/0000", {
                clearIfNotMatch: true
            });
            $('.placeholder').mask("00/00/0000", {
                placeholder: "__/__/____"
            });
            $('.fallback').mask("00r00r0000", {
                translation: {
                    'r': {
                        pattern: /[\/]/,
                        fallback: '/'
                    },
                    placeholder: "__/__/____"
                }
            });
            $('.selectonfocus').mask("00/00/0000", {
                selectOnFocus: true
            });
        });
    </script>
</body>

</html>