<?php
session_start();
require_once 'provedores/Classes.php';
verificaSessao();
require_once 'controladores/Controller.php';
$entidade = new Entidades;
$email_entidade = $entidade->chama_email_entidade($_SESSION['id_entidade']);

?>

<div class="container mt-4">
    <div class="row">
        <div class="mt-3">
            <h5>Políticas de Privacidade </h5>
            <hr>
        </div>
        <div>
            <h6>Política de Privacidade da Ouvidoria</h6>

            <p>A sua privacidade é importante para nós. Esta Política de Privacidade explica como coletamos, usamos, armazenamos e protegemos seus dados pessoais ao utilizar a nossa página de ouvidoria, em conformidade com a Lei Geral de Proteção de Dados Pessoais (LGPD - Lei nº 13.709/2018).</p>

            <p>
                <strong>1. Coleta de Dados Pessoais</strong></br>
                Ao utilizar nossa página de ouvidoria, poderemos coletar os seguintes dados pessoais:
            <ul>
                <li>Nome;</li>
                <li>E-mail;</li>
                <li>Telefone (opcional);</li>
                <li>Informações contidas na sua manifestação (reclamação, sugestão, elogio ou denúncia);</li>
            </ul>
            </p>

            <p>
                <strong>2. Finalidade do Tratamento dos Dados</strong></br>
                Os dados pessoais coletados serão utilizados para os seguintes propósitos:
                <ul>
                    <li>Receber e responder às manifestações enviadas;</li>
                    <li>Garantir a transparência e a qualidade do atendimento;</li>
                    <li>Cumprir obrigações legais e regulatórias;</li>
                    <li>Melhorar nossos serviços e funcionalidades da página de ouvidoria.</li>
                </ul>
            </p>

            <p>
                <strong>3. Compartilhamento de Dados</strong></br>
                Os dados pessoais poderão ser compartilhados apenas nos seguintes casos:
                <ul>
                    <li>Com órgãos reguladores ou autoridades competentes, quando exigido por lei;</li>
                    <li>Com parceiros e prestadores de serviço contratados para o suporte e manutenção do sistema, garantindo a segurança dos dados.</li>
                </ul>
            </p>

            <p>
                <strong>4. Armazenamento e Segurança dos Dados</strong>
                <ul>
                    <li>Adotamos medidas de segurança técnicas e organizacionais para proteger seus dados contra acessos não autorizados, vazamentos, alterações ou destruições indevidas. Os dados serão armazenados pelo período necessário para o cumprimento das finalidades descritas nesta política.</li>
                </ul>
            </p>

            <p>
                <strong>5. Direitos do Titular dos Dados</strong></br>
                Você tem direitos garantidos pela LGPD, incluindo:
                <ul>
                    <li>Confirmar a existência do tratamento de seus dados;</li>
                    <li>Acessar seus dados pessoais;</li>
                    <li>Corrigir dados incompletos, inexatos ou desatualizados;</li>
                    <li>Solicitar a exclusão dos dados, quando aplicável;</li>
                    <li>Revogar o consentimento para o tratamento dos dados.</li>
                </ul>
                Para exercer seus direitos, entre em contato conosco através do e-mail: <a href="mailto: <?=$email_entidade['email_entidade'] ?>" target="_blank" rel="Email Institucional"><?=$email_entidade['email_entidade'] ?></a>.
            </p>

            <p>
                <strong>6. Alterações nesta Política</strong></br>
                Podemos atualizar esta Política de Privacidade periodicamente. Recomendamos que você a revise regularmente para se manter informado sobre como estamos protegendo seus dados.
            </p>

            <p>
                <strong>7. Contato</strong></br>
                Se tiver dúvidas ou quiser mais informações sobre nossa Política de Privacidade, entre em contato pelo e-mail. Ao utilizar a página de ouvidoria, você declara estar ciente e de acordo com os termos desta Política de Privacidade, entre em contato pelo e-mail: <a href="mailto: <?=$email_entidade['email_entidade'] ?>" target="_blank" rel="Email Institucional"><?=$email_entidade['email_entidade'] ?></a>.
            </p>


        </div>
    </div>
</div>
<?php include_once 'controladores/Footer.php' ?>