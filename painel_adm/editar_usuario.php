<?php
// Inicia a sessão e inclui o cabeçalho (assumindo que estão na pasta 'controladores')
// Começa a sessão
session_start();

// Carrega a Model e valida a sessão
require 'model/SessaoModel.php';
valida_sessao();

require 'controladores/header.php';
require 'model/UsuarioAdmModel.php';
require 'model/NivelAcessoModel.php';

//$nivel_acesso = new NivelAcessoAdm;
//$nivel_acesso_adm = $nivel_acesso->nivel_acesso_adm();

$UsuarioAdm = new UsuarioAdm;
$id = $_GET['id'];
$usuario = $UsuarioAdm->chama_usuario($id);
?>

<div class="container my-5 mt-5">   

    <?php if (isset($_GET['status']) and $_GET['status'] === 'sucesso') { ?>
        <div class="alert alert-success mb-4 mt-4 text-center" role="alert">
            Cadastrado com Sucesso!
        </div>
    <?php } elseif (isset($_GET['status_senha'])) { ?>
        <div class="alert alert-success mb-4 mt-4 text-center" role="alert">
            <?= $_GET['status_senha'] ?>
        </div>

    <?php } elseif (isset($_GET['status_erro'])) { ?>
        <div class="alert alert-danger mb-4 mt-4 text-center" role="alert">
           <?= $_GET['status_erro'] ?>
        </div>
    <?php } ?>


    <?php if (!empty($usuario)) { ?>
        <div class="solicitacoes-titlo">
            <h5>Editar Usuário</h5>
            <hr>

            <form method="POST" action="provedores/editar_usuario.php" class="needs-validation" novalidate>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                <!-- Nome do Usuário -->
                <div class="mb-3">
                    <label for="usuario" class="form-label">Nome do Usuário</label>
                    <input type="text" class="form-control" id="usuario" name="usuario"
                        value="<?php echo htmlspecialchars($usuario['usuario'] ?? ''); ?>" required>
                    <div class="invalid-feedback">
                        Por favor, insira um nome de usuário válido.
                    </div>
                </div>

                <!-- CPF -->
                <div class="mb-3">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" value="<?php echo htmlspecialchars($usuario['cpf'] ?? ''); ?>" placeholder="000.000.000-00" disabled maxlength="14" readonly required>
                    <div class="invalid-feedback">
                        Por favor, insira um CPF válido.
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" disabled readonly id="email" value="<?= htmlspecialchars($usuario['email'] ?? ''); ?>" required>
                    <div class="invalid-feedback">
                        Por favor, insira um email válido.
                    </div>
                </div>

                <!-- Nível de Acesso -->
                <div class="mb-3">
                    <label for="nivel_acesso" class="form-label">Nível de Acesso</label>
                    <select class="form-select" id="nivel_acesso" name="nivel_acesso" required>
                        <option value="">Selecione um nível de acesso</option>
                        <option value="A" <?php echo ($usuario['nivel_acesso'] ?? '') === 'A' ? 'selected' : ''; ?>>Administrador</option>
                        <option value="U" <?php echo ($usuario['nivel_acesso'] ?? '') === 'U' ? 'selected' : ''; ?>>Usuário</option>

                    </select>
                    <div class="invalid-feedback">
                        Por favor, selecione um nível de acesso.
                    </div>
                </div>

                <!-- Status de Atividade -->
                <div class="mb-3">
                    <label for="status_atividade" class="form-label">Status de Atividade</label>
                    <select class="form-select" id="status_atividade" name="status_atividade" required>
                        <option value="">Selecione um status</option>
                        <option value="A" <?= ($usuario['status_atividade'] ?? '') === 'A' ? 'selected' : ''; ?>>Ativo</option>
                        <option value="I" <?= ($usuario['status_atividade'] ?? '') === 'I' ? 'selected' : ''; ?>>Inativo</option>
                    </select>
                    <div class="invalid-feedback">
                        Por favor, selecione um status de atividade.
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
                    <a href='./provedores/redefinir_senha_usuario.php?id=<?= $id ?>' class="btn btn-info mt-3">Redefinir Senha do Usuário</a>
                    <a href="listagem_usuarios.php" class="btn btn-secondary mt-3">Cancelar</a>
                </div>

            </form>

        </div>

    <?php } else { ?>

        <div class="text-center solicitacoes-titlo mt-5">
            <div class="mt-5">
                <h5>Este usuário não existe!</h5>
                Selecione um usuário que seja existente, <a href="listagem_usuarios.php">clique aqui!</a>
            </div>
        </div>

    <?php } ?>



</div>

<script>
    function mostraNivelAcesso(v) {
        let nivelAcessoDiv = document.getElementById('nivelAcessoDiv');

        if (v === 'U') {
            nivelAcessoDiv.classList.remove('d-none');
        } else {
            nivelAcessoDiv.classList.add('d-none');
        }
    }
</script>

<script>
    // Validação do formulário
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<?php include_once 'controladores/Footer.php' ?>