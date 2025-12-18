<?php
// Inicia a sessão e inclui o cabeçalho (assumindo que estão na pasta 'controladores')
// Começa a sessão
session_start();

// Carrega a Model e valida a sessão
require 'model/SessaoModel.php';
valida_sessao();

require 'controladores/header.php';
require 'model/UsuarioAdmModel.php';

$UsuarioAdm = new UsuarioAdm;
$usuario = $UsuarioAdm->chama_usuario_nivel_acesso($_SESSION['id']);

?>

<div class="container my-5">

    <div class="solicitacoes-titlo">
        <h5>Opções de Configuração do Usuário</h5>
    </div>

    <div class="row">
        <ul>
            <li><a href="alterar_senha.php">Alterar Senha</a></li>
            <li><a href="perfil.php">Meu Perfil</a></li>
            <li><a href="suporte.php">Suporte</a></li>
            <hr>
            <div class="solicitacoes-titlo mt-2">
                <h5>Opções de Configuração do Administrador</h5>
            </div>
            <?php if($usuario['nivel_acesso'] == 'A'){ ?>

                <li><a href="listagem_usuarios.php">Alterar Nivel de Acesso</a></li>
                <li><a href="cadastrar_usuario.php">Cadastrar um Usuário</a></li>
                <li><a href="listagem_usuarios.php">Listagem de Usuário</a></li>
            <?php } else { ?>

                <div class="text-center">
                    <p>Você não te acesso a esse módulo</p>
                </div>

            <?php }?>
        </ul>

    </div>

</div>

<?php include_once 'controladores/Footer.php' ?>