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

$mensagem_sucesso = 'Senha alterada com sucesso.';
$mensagem_erro = '';

// Processa o formulário de alteração de senha
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha_atual = $_POST['senha_atual'] ?? '';
    $senha_nova = $_POST['senha_nova'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    
    // Validações
    if (empty($senha_atual) || empty($senha_nova) || empty($confirmar_senha)) {
        $mensagem_erro = 'Todos os campos são obrigatórios.';
    } elseif (strlen($senha_nova) < 4) {
        $mensagem_erro = 'A nova senha deve ter no mínimo 8 caracteres.';
    } elseif ($senha_nova !== $confirmar_senha) {
        $mensagem_erro = 'As senhas não conferem.';
    } else {
        
        $mensagem_sucesso = 'Implementar método de atualização na Model UsuarioAdm.';
    }
}

?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card shadow-lg" style="border-radius: 10px; border-top: 4px solid var(--cor-primaria);">
                <div class="card-body p-5">
                    <h1 class="text-center mb-4" style="color: var(--cor-primaria); font-family: var(--font-titulo);">
                        Alterar Senha
                    </h1>

                    <!-- Mensagens de Feedback -->
                    <?php if (isset($_GET['status']) && $_GET['status'] == 'sucesso'): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Feito!</strong> <?= htmlspecialchars($mensagem_sucesso) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($mensagem_erro)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Erro!</strong> <?= htmlspecialchars($mensagem_erro) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Formulário -->
                    <form method="POST" action="provedores/alterar_senha.php" id="formAlterarSenha">
                        <!-- Campo: Senha Atual -->
                         
                        <div class="mb-3">
                            <label for="senha_atual" class="form-label fw-bold">
                                <i class="iconify" data-icon="mdi:lock-outline"></i> Senha Atual
                            </label>
                            <input 
                                type="password" 
                                class="form-control form-control-lg" 
                                id="senha_atual" 
                                name="senha_atual"
                                placeholder="Digite sua senha atual"
                                required
                                style="border-radius: 8px; border: 2px solid #e0e0e0;"
                            >
                            <small class="form-text text-muted d-block mt-2">
                                Informe sua senha atual para confirmar a alteração.
                            </small>
                        </div>

                        <!-- Campo: Nova Senha -->
                        <div class="mb-3">
                            <label for="senha_nova" class="form-label fw-bold">
                                <i class="iconify" data-icon="mdi:lock"></i> Nova Senha
                            </label>
                            <input 
                                type="password" 
                                class="form-control form-control-lg" 
                                id="senha_nova" 
                                name="senha_nova"
                                placeholder="Digite sua nova senha"
                                required
                                minlength="8"
                                style="border-radius: 8px; border: 2px solid #e0e0e0;"
                            >
                            <small class="form-text text-muted d-block mt-2">
                                A senha deve ter no mínimo 8 caracteres, incluindo letras e números.
                            </small>
                            <!-- Indicador de Força de Senha -->
                            <div class="mt-2">
                                <div class="progress" style="height: 6px; border-radius: 3px;">
                                    <div 
                                        id="forcaSenha" 
                                        class="progress-bar" 
                                        role="progressbar" 
                                        style="width: 0%; background-color: var(--cor-primaria); border-radius: 3px;"
                                        aria-valuenow="0" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <small id="textoForca" class="form-text text-muted d-block mt-1">
                                    Força: Nenhuma
                                </small>
                            </div>
                        </div>

                        <!-- Campo: Confirmar Senha -->
                        <div class="mb-4">
                            <label for="confirmar_senha" class="form-label fw-bold">
                                <i class="iconify" data-icon="mdi:lock-check"></i> Confirmar Nova Senha
                            </label>
                            <input 
                                type="password" 
                                class="form-control form-control-lg" 
                                id="confirmar_senha" 
                                name="confirmar_senha"
                                placeholder="Confirme sua nova senha"
                                required
                                minlength="8"
                                style="border-radius: 8px; border: 2px solid #e0e0e0;"
                            >
                            <small class="form-text text-muted d-block mt-2" id="confirmacao">
                                As senhas devem ser idênticas.
                            </small>
                        </div>

                        <!-- Botões -->
                        <div class="d-grid gap-2 d-flex justify-content-between">
                            <a href="dashboard.php" class="btn btn-secondary btn-lg" style="border-radius: 8px;">
                                <i class="iconify" data-icon="mdi:close"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 8px; background-color: var(--cor-primaria); border-color: var(--cor-primaria);">
                                <i class="iconify" data-icon="mdi:check"></i> Alterar Senha
                            </button>
                        </div>
                    </form>

                    <!-- Informações Adicionais -->
                    <hr class="my-4">
                    <div class="alert alert-info" role="alert" style="border-radius: 8px;">
                        <h6 class="alert-heading">
                            <i class="iconify" data-icon="mdi:information"></i> Dicas de Segurança
                        </h6>
                        <ul class="mb-0">
                            <li>Use uma senha forte com números, letras maiúsculas e minúsculas.</li>
                            <li>Não compartilhe sua senha com ninguém.</li>
                            <li>Altere sua senha regularmente (a cada 3 meses é recomendado).</li>
                            <li>Evite usar informações pessoais óbvias (data de nascimento, nome, etc).</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts de Validação e Força de Senha -->
<script>
    // Validação de força de senha em tempo real
    const senhaNovaInput = document.getElementById('senha_nova');
    const confirmarSenhaInput = document.getElementById('confirmar_senha');
    const forcaSenhaDiv = document.getElementById('forcaSenha');
    const textoForca = document.getElementById('textoForca');
    const confirmacao = document.getElementById('confirmacao');

    function calcularForcaSenha(senha) {
        let forca = 0;
        
        if (senha.length >= 8) forca += 20;
        if (senha.length >= 12) forca += 20;
        if (/[a-z]/.test(senha)) forca += 15;
        if (/[A-Z]/.test(senha)) forca += 15;
        if (/[0-9]/.test(senha)) forca += 15;
        if (/[^a-zA-Z0-9]/.test(senha)) forca += 15;
        
        return Math.min(forca, 100);
    }

    function atualizarForca() {
        const senha = senhaNovaInput.value;
        const forca = calcularForcaSenha(senha);
        
        forcaSenhaDiv.style.width = forca + '%';
        
        if (forca < 30) {
            forcaSenhaDiv.style.backgroundColor = '#dc3545'; // Vermelho
            textoForca.textContent = 'Força: Fraca';
        } else if (forca < 60) {
            forcaSenhaDiv.style.backgroundColor = '#ffc107'; // Amarelo
            textoForca.textContent = 'Força: Média';
        } else if (forca < 90) {
            forcaSenhaDiv.style.backgroundColor = '#17a2b8'; // Azul
            textoForca.textContent = 'Força: Boa';
        } else {
            forcaSenhaDiv.style.backgroundColor = '#28a745'; // Verde
            textoForca.textContent = 'Força: Excelente';
        }
    }

    function validarConfirmacao() {
        if (confirmarSenhaInput.value && senhaNovaInput.value !== confirmarSenhaInput.value) {
            confirmacao.classList.add('text-danger');
            confirmacao.classList.remove('text-muted');
            confirmacao.textContent = '❌ As senhas não conferem.';
            confirmarSenhaInput.classList.add('is-invalid');
        } else if (confirmarSenhaInput.value && senhaNovaInput.value === confirmarSenhaInput.value) {
            confirmacao.classList.remove('text-danger');
            confirmacao.classList.add('text-success');
            confirmacao.textContent = '✓ As senhas conferem.';
            confirmarSenhaInput.classList.remove('is-invalid');
            confirmarSenhaInput.classList.add('is-valid');
        } else {
            confirmacao.classList.remove('text-danger', 'text-success');
            confirmacao.classList.add('text-muted');
            confirmacao.textContent = 'As senhas devem ser idênticas.';
            confirmarSenhaInput.classList.remove('is-invalid', 'is-valid');
        }
    }

    senhaNovaInput.addEventListener('input', atualizarForca);
    senhaNovaInput.addEventListener('input', validarConfirmacao);
    confirmarSenhaInput.addEventListener('input', validarConfirmacao);

    // Validação no submit do formulário
    document.getElementById('formAlterarSenha').addEventListener('submit', function(e) {
        if (senhaNovaInput.value !== confirmarSenhaInput.value) {
            e.preventDefault();
            alert('As senhas não conferem!');
            return false;
        }
        
        if (senhaNovaInput.value.length < 8) {
            e.preventDefault();
            alert('A senha deve ter no mínimo 8 caracteres!');
            return false;
        }
    });
</script>




<?php include_once 'controladores/Footer.php' ?>