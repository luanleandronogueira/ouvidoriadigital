<?php 
// Inicia a sessão e inclui o cabeçalho (assumindo que estão na pasta 'controladores')
// Começa a sessão
session_start();

// Carrega a Model e valida a sessão
require 'model/SessaoModel.php';
valida_sessao();

require 'controladores/header.php';
require 'model/ManifestacoesModel.php';

$manifestacoes = new Manifestacoes;

// Tenta carregar os dados da manifestação pelo protocolo da URL
$manifestacao = $manifestacoes->chama_manifestacao_protocolo($_GET['protocolo']);


// Funções utilitárias (pode estar no seu helper)
function formatar_data($data) {
    return date('d/m/Y H:i', strtotime($data));
}
?>

<div class="container my-5">
    <div class="row">
        <!-- Título principal e protocolo -->
        <div class="col-12 mb-4">
            <h1 class="manifestacao-titulo">
                Detalhes da Manifestação 
                <span class="protocolo-tag">#<?= $manifestacao['protocolo_manifestacao'] ?></span>
            </h1>
            <p class="text-muted">Acompanhe o status e as informações completas do seu registro.</p>
        </div>

        <!-- Coluna de Detalhes Principais (Descrição e Resposta) -->
        <div class="col-lg-8">
            <!-- CARD DA DESCRIÇÃO ORIGINAL -->
            <div class="card detalhe-card shadow-sm mb-4">
                <div class="card-header manifestacao-card-header">
                    <i class="fas fa-file-alt"></i> Descrição Original
                    <!-- Tag de Status Dinâmica -->
                    <span class="status-tag status-<?= strtolower(str_replace(' ', '-', $manifestacao['status_manifestacao'])) ?>">
                       
                    </span>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <strong>Cidadão: </strong> <?= $manifestacao['nome_usuario'] . ' ' . $manifestacao['sobrenome_usuario']?>
                    </p>
                    <p class="card-text">
                        <strong>Conteúdo da Manifestação: </strong><?= $manifestacao['conteudo_manifestacao'] ?>
                    </p>
                    <p class="card-text">
                        <strong>Observações: </strong><?= $manifestacao['observacoes_manifestacao'] ?>
                    </p>
                    <p class="card-text">
                        <strong>Status da Manifestação: </strong><?= $manifestacao['status_manifestacao'] ?>
                    </p>
                </div>
            </div>

            <!-- CARD DE RESPOSTA DA ENTIDADE (Se houver) -->
            <?php if (!empty($manifestacao['resposta_entidade'])): ?>
            <div class="card detalhe-card resposta-card shadow-sm mb-4">
                <div class="card-header manifestacao-card-header">
                    <i class="fas fa-reply-all"></i> Resposta/Atualização da Entidade
                </div>
                <div class="card-body">
                    <p class="card-text"><?= nl2br(htmlspecialchars($manifestacao['resposta_entidade'])) ?></p>
                    <small class="text-muted">Última atualização: <?= formatar_data($manifestacao['data_atualizacao']) ?></small>
                </div>
            </div>
            <?php endif; ?>

            <!-- CARD DE ANEXOS (Se houver) -->
            <?php if (!empty($manifestacao['anexos'])): ?>
            <div class="card detalhe-card shadow-sm mb-4">
                <div class="card-header manifestacao-card-header">
                    <i class="fas fa-paperclip"></i> Arquivos Anexados
                </div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($manifestacao['anexos'] as $anexo): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($anexo['nome']) ?>
                        <a href="<?= htmlspecialchars($anexo['url']) ?>" target="_blank" class="btn-anexo">
                            <i class="fas fa-download"></i> Baixar
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

        </div>

        <!-- Coluna Lateral de Metadados -->
        <div class="col-lg-4">
            
            <!-- CARD DE INFORMAÇÕES GERAIS -->
            <div class="card detalhe-card metadado-card shadow-sm mb-4">
                <div class="card-header manifestacao-card-header">
                    <i class="fas fa-info-circle"></i> Informações Gerais
                </div>
                <div class="card-body">
                    <div class="metadado-item">
                        <span class="metadado-label"><strong>Tipo</strong>:</span>
                        <span class="tipo-tag tipo-<?= strtolower($manifestacao['nome_tipo_manifestacao']) ?>">
                            <?= $manifestacao['nome_tipo_manifestacao'] ?>
                        </span>
                    </div>
                    <div class="metadado-item">
                        <span class="metadado-label"><strong>Data de Registro</strong>:</span>
                        <span><?= formatar_data($manifestacao['data_manifestacao']) ?></span>
                    </div>
                </div>
            </div>

            <!-- CARD DE LOCALIZAÇÃO -->
            <div class="card detalhe-card metadado-card shadow-sm mb-4">
                <div class="card-header manifestacao-card-header">
                    <i class="fas fa-map-marker-alt"></i> Localização
                </div>
                <div class="card-body">
                    <div class="metadado-item">
                        <span class="metadado-label"><strong>Bairro</strong>:</span>
                        <span><?= $manifestacao['local_manifestacao'] ?? 'Não informado' ?></span>
                    </div>
                    <div class="metadado-item">
                        <span class="metadado-label"><strong>Protocolo</strong>:</span>
                        <span><?= $manifestacao['protocolo_manifestacao'] ?? 'Não informado' ?></span>
                    </div>
                    <div class="metadado-item">
                        <span class="metadado-label"><strong>IP:</strong>:</span>
                        <span><?= $manifestacao['ip'] ?? 'Não coletado' ?></span>
                    </div>
                    <div class="metadado-item">
                        <span class="metadado-label"><strong>Coodenadas:</strong>:</span>
                        <span><?= $manifestacao['latitude'] . '' . $manifestacao['longitude'] ?? 'Não coletado' ?></span>
                    </div>
                    <!-- Aqui você pode adicionar um pequeno mapa Leaflet com o marcador se as coordenadas estiverem disponíveis -->
                </div>
            </div>

            <!-- Botão de Voltar -->
            <a href="dashboard.php" class="btn btn-block btn-voltar-dashboard">
                <i class="fas fa-chevron-left"></i> Voltar ao Dashboard
            </a>

        </div>
    </div>
</div>

<?php require 'controladores/footer.php' ?>