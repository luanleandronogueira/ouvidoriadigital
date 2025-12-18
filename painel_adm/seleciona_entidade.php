<?php
// Inicia a sessão e inclui o cabeçalho (assumindo que estão na pasta 'controladores')
// Começa a sessão
session_start();

// Carrega a Model e valida a sessão
// require 'model/SessaoModel.php';
// valida_sessao();

require 'model/NivelAcessoModel.php';
require 'controladores/headerLogin.php';

$nivel_acesso = new NivelAcessoAdm;

$nivel_acesso_adm = '';

if ($_SESSION['nivel_acesso'] === 'A') {

    $nivel_acesso_adm = $nivel_acesso->nivel_acesso_adm();

} else {

    $nivel_acesso_adm = $nivel_acesso->consulta_nivel_acesso($_SESSION['id']);
}

// echo '<pre>';
// print_r($nivel_acesso_adm);
// echo '</pre>';

?>
<script>
    // Verifique se a página foi recarregada (atualizada)
    if (performance.navigation.type === 1) {
        // Redirecione para a URL desejada
        window.location.href = 'seleciona_entidade.php';
    }
</script>

<section>
    <div class="login">
        <!-- Tela de Login -->
        <div class="login-container">
            <div class="logo-container">
                <img src="../assets/images/logo.png" alt="Logo" class="logo">
            </div>

            <div class="login-bemvindo">
                <h2>Selecione a Entidade</h2>
            </div>

            <form class="form-entidade" action="dados_analiticos.php" method="get">
                <h4 class="titulo-entidade">Escolha a entidade</h4>

                <div class="form-grupo">
                    <select class="form-select" name="id" id="id">
                        <?php foreach ($nivel_acesso_adm as $entidade) { ?>
                            <option value="<?= $entidade['id_entidade'] ?>">
                                <?= $entidade['nome_entidade'] ?>
                            </option>
                        <?php } ?>
                    </select>
                    <button class="btn btn-primary" type="submit">Escolher</button>
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

<?php require 'controladores/footerLogin.php' ?>