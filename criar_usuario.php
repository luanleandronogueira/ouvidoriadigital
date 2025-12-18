<?php
session_start();
require_once 'controladores/ControllerLogin.php';
require_once 'provedores/Classes.php';

// Gerar o token na primeira requisição
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = gerarTokenCSRF();
}
?>
<script>
    // Verifique se a página foi recarregada (atualizada)
    if (performance.navigation.type === 1) {
        // Redirecione para a URL desejada
        window.location.href = 'criar_usuario.php';
    }
</script>
<section>
    <div class="login">
        <div class="login-container">
            <div class="logo-container">
                <img src="./assets/images/logo.png" alt="Logo" class="logo">
            </div>

            <div class="form-cadastro">
                <h3>Criar Conta</h3>

                <?php if (isset($_GET['status']) and $_GET['status'] === 'cpf_ja_cadastrado') { ?>
                    <div class="alert alert-danger w-100 text-center" role="alert">
                        O CPF já foi cadastrado anteriormente! Redefina sua senha clicando <a href="redefinir_senha.php">aqui!</a>
                    </div>
                <?php } ?>

                <form class="form-cadastro-dados" action="provedores/CriarUsuario.php" method="post">
                    <div class="form-floating">
                        <input type="text" name="nome_usuario" class="form-control" id="nome_usuario" placeholder="Nome" required>
                        <label for="nome_usuario">Nome:</label>
                    </div>

                    <!-- <label for="nome_usuario">Nome:</label>
                    <input type="text" name="nome_usuario" required id="nome_usuario" class="form-control"> -->

                    <div class="form-floating">
                        <input type="text" name="sobrenome_usuario" class="form-control" id="sobrenome_usuario" placeholder="Sobrenome" required>
                        <label for="sobrenome_usuario">Sobrenome:</label>
                    </div>

                    <!-- <label for="sobrenome_usuario">Sobrenome:</label>
                    <input type="text" name="sobrenome_usuario" required id="sobrenome_usuario" class="form-control"> -->

                    <div class="form-floating">
                        <input type="text" name="cpf_usuario"
                            onblur="consulta_cpf();"
                            onkeyup="
                                const valor = this.value;
                                const valido = validaCPF(valor);
                                const span = document.getElementById('validation');

                                if (valor === '') {
                                    span.style.display = 'none';
                                } else {
                                    span.style.display = 'block';
                                    span.innerHTML = valido ? 'CPF válido' : 'CPF inválido';
                                    span.style.color = valido ? 'green' : 'red';
                                }

                                verificaEstilo(this, valido);
                            "
                            class="form-control" id="cpf_usuario" placeholder="Sobrenome" required>

                        <label for="cpf_usuario">CPF:</label>
                    </div>
                    <span class="valida-cpf" id="validation"></span>

                    <!-- <label for="cpf_usuario">CPF:</label>
                    <input type="text" name="cpf_usuario" onblur="consulta_cpf();" onkeyup="document.getElementById('validation').innerHTML = validaCPF(this.value) ? 'Válido<br>' : 'Inválido<br>'; verificaEstilo(this, validaCPF(this.value))" required id="cpf_usuario" class="form-control cpf">
                    <span class="" id="cpf_validado"></span>
                    <span class="text-center" id="validation"></span> -->

                    <div class="form-floating">
                        <input type="email" name="email_usuario" class="form-control" id="email_usuario" placeholder="Email">
                        <label for="email_usuario">Email:</label>
                    </div>

                    <div class="form-floating">
                        <input type="text" name="telefone_whatsapp" class="form-control phone_brazil" id="telefone_whatsapp" placeholder="WhatsApp" required>
                        <label for="telefone_whatsapp">WhatsApp:</label>
                    </div>

                    <!-- <label for="email_usuario">E-mail:</label>
                    <input type="email" name="email_usuario" required id="email_usuario" class="form-control"> -->

                    <!-- <hr>
                    <h4 class="text-center">Informações para acesso:</h4> -->

                    <h4 class="titulo-entidade">Defina sua senha de acesso</h4>

                    <div class="form-floating">
                        <input type="password" name="senha_usuario" class="form-control" id="senha_usuario" placeholder="Senha" required>
                        <label for="senha_usuario">Defina a senha:</label>
                    </div>

                    <!-- <label for="senha_usuario">Defina a senha:</label>
                    <input type="password" name="senha_usuario" required id="senha_usuario" class="form-control"> -->

                    <div class="form-floating">
                        <input type="password" name="confirmar_senha_usuario" class="form-control" id="confirmar_senha_usuario" onblur="consulta_senhas()" placeholder="Senha" required>
                        <label for="confirmar_senha_usuario">Confirmar senha:</label>
                    </div>

                    <!-- <label for="confirmar_senha_usuario">Confirmar senha:</label>
                    <input type="password" onblur="consulta_senhas()" name="confirmar_senha_usuario" id="confirmar_senha_usuario" class="form-control">
                    <span id="mensagem_senha"></span> -->

                    <!-- Token csrf -->
                    <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                    <input type="hidden" name="id_entidade" id="id" value="<?= $_GET['id'] ?>">
                    <input type="hidden" name="id_portal" id="id_portal" value="<?= $_GET['id_portal'] ?>">

                    <div class="form-cadastro-botoes">
                        <button class="btn btn-primary btn1" id="button_submit" type="submit">Cadastrar</button>
                        <a href="login.php" class="btn btn-secondary btn1" id="button_submit" type="submit">Voltar</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="login-hero">
            <div class="login-hero-info">
                <h1>O seu espaço para Manifestações</h1>
                <p>A Ouvidoria Geral do Município é uma instância de participação e controle social que permite identificar melhorias para a gestão e serviços públicos. Ela é o seu canal de interação para falar sobre os serviços municipais.</p>
            </div>
        </div>
    </div>

</section>
<?php require_once 'controladores/FooterLogin.php' ?>