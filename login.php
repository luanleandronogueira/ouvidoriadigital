<?php
session_start();
require_once 'provedores/Classes.php';
include 'controladores/ControllerLogin.php';
$todas_entidades = new Entidades;

// Gerar o token na primeira requisição
if (!isset($csrf_token['csrf_token'])) {
    $csrf_token['csrf_token'] = gerarTokenCSRF();
}

$entidade = $todas_entidades->chama_entidades();
// echo '<pre>';
// print_r($entidade);
// echo '</pre>';
$id_portal = array();
$id_portal_transparencia = null;

if (!empty($_GET)) {
    $ent = $todas_entidades->chama_entidade($_GET['id']);
    if(isset($_GET['id_portal'])){
        $id_portal_transparencia = $_GET['id_portal'];
    }else {
        $id_portal = explode('-', $_GET['id']);
        $id_portal_transparencia = $id_portal[2];
    }
}

?>
<script>
    // Verifique se a página foi recarregada (atualizada)
    if (performance.navigation.type === 1) {
        // Redirecione para a URL desejada
        window.location.href = 'login.php';
    }
</script>

<section>
    <div class="login">
        <!-- Tela de Login -->
        <div class="login-container">
            <div class="logo-container">
                <img src="./assets/images/logo.png" alt="Logo" class="logo">
            </div>

            <div class="login-bemvindo">
                <h1>Bem-Vindo</h1>
            </div>

            <?php if (isset($_GET['status']) and $_GET['status'] === 'faca_login') { ?>
                <div class="alert alert-success w-100 text-center" role="alert">
                    Cadastro feito com sucesso, Faça seu primeiro Login!
                </div>
            <?php } ?>

            <?php if (isset($_GET['status']) and $_GET['status'] === 'senha_invalida') { ?>
                <div class="alert alert-danger w-100 text-center" role="alert">
                    Login ou senha Inválida!
                </div>
            <?php } ?>

            <?php if (!empty($_GET)) { ?>

                <form class="form-login" action="provedores/AutenticaUsuario.php" method="POST">
                    <div>
                        <div class="form-login-dados">
                            <!-- 
                        
                            <input type="text" required name="login_usuario" class="form-control text-center" id="login_usuario" placeholder="Exemplo: email@email.com ou 12345678900" aria-describedby="login_usuario"> 
                            
                            <label for="senha_usuario" class="form-label"><strong>Senha:</strong></label>
                            <input type="password" required placeholder="Insira sua senha" name="senha_usuario" class="form-control text-center" id="senha_usuario">
                            
                            -->
                            
                            <div class="form-floating">
                                <input type="text" name="login_usuario" class="form-control" id="login_usuario" placeholder="email@email.com ou 12345678900" required>
                                <label for="login_usuario">Email ou CPF:</label>
                            </div>

                            <div class="form-floating">
                                <input type="password" name="senha_usuario" class="form-control" id="senha_usuario" placeholder="Insira sua senha" required>
                                <label for="senha_usuario">Senha:</label>
                            </div>


                            <!-- Token de verificação -->
                            <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $csrf_token['csrf_token'] ?>">
                            <input type="hidden" name="id" value="<?= $ent['id_entidade'] ?>">
                            <input type="hidden" name="entidade_nome" value="<?= $ent['nome_entidade'] ?>">
                            <input type="hidden" name="id_portal" value="<?= $id_portal_transparencia ?>">

                            <button type="submit" class="btn btn-secondary">Entrar</button>
                        </div>
                        
                        
                        <p class="form-criar-conta">
                        <small><a href="recuperar_senha.php?id=<?= $ent['id_entidade'] ?>">Esqueci à Senha</a> <span>|</span> <a href="criar_usuario.php?id=<?= $ent['id_entidade'] ?>&&id_portal=<?= $id_portal_transparencia ?>">Criar uma conta</a> | <a href="painel_adm/login.php">Painel Administrativo</a></p></small>

                        <div class="form-login-anonimo">
                            <h4 class="titulo-entidade">Realizar Solicitação Anônima</h4>    

                            <div class="botoes-anonima">
                                <a href="denuncia_anonima.php?id=<?= $ent['id_entidade'] ?>&&id_manifestacao=5&&id_portal=<?= $id_portal_transparencia ?>;" class="btn btn-dark justify-center">Denúncia Anônima</a>
                                <a type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning justify-center">Consultar Protocolo</a>
                            </div>
                        </div>

                    </div>
                </form>

            <?php } else { ?>


                <form class="form-entidade" action="" method="get">
                    <h4 class="titulo-entidade">Escolha a entidade</h4>

                    <div class="form-grupo">
                        <select class="form-select" name="id" id="id">
                            <?php foreach ($entidade as $e) { ?>
                                <option value="<?= $e['id_entidade'] . '-' . $e['nome_entidade'] . '-' . $e['id_portal_entidade']?>">
                                    <?= $e['nome_entidade'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button class="btn btn-primary" type="submit">Escolher</button>
                    </div>

                </form>

                <small class="mt-4">
                    <a href="painel_adm/login.php">Acessar Painel Administrativo</a>
                </small>

            <?php } ?>

        </div>

        <div class="login-hero">
            <div class="login-hero-info">
                <h1>O seu espaço para Manifestações</h1>
                <p>A Ouvidoria Geral do Município é uma instância de participação e controle social que permite identificar melhorias para a gestão e serviços públicos. Ela é o seu canal de interação para falar sobre os serviços municipais.</p>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Consulte usando o Nº do Protocolo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Formulario de consulta a solicitação anonima -->
                <form action="https://l3tecnologia.app.br/api_ouvidoria_web/public/api/v1/consulta_manifestacoes_protocolo_template" method="post">
                    <div class="modal-body">
                        <div class="input-group">
                            <div class="input-group-text" id="btnGroupAddon">Nº</div>
                            <input type="text" class="form-control" name="protocolo" placeholder="Digite o número de protocolo" aria-label="Digite o número de protocolo" aria-describedby="btnGroupAddon">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sair</button>
                        <button type="submit" class="btn btn-dark">Consultar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
<?php include_once 'controladores/FooterLogin.php' ?>