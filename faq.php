<?php
session_start();
require_once 'provedores/Classes.php';
verificaSessao();
require_once 'controladores/Controller.php';

?>

<div class="container mt-4">
    <div class="row">
        <div class="faq">
            <h5>Perguntas Frequentes</h5>
        </div>
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        1. O que é uma ouvidoria?
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">A ouvidoria é um canal que permite ao cidadão apresentar sugestões, elogios, solicitações, reclamações e denúncias. Atua como uma ponte entre o público e a administração pública, recebendo manifestações, analisando-as e encaminhando-as às áreas responsáveis para tratamento ou apuração.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        2. O que é uma manifestação?
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Manifestação é a forma pela qual o cidadão expressa seus anseios, dúvidas, opiniões ou satisfações em relação a um atendimento ou serviço recebido. Isso auxilia o poder público a aprimorar a gestão de políticas e serviços ou a combater práticas ilícitas.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        3. Quais são os tipos de manifestação?
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">As manifestações podem ser classificadas como:
                        <ul>
                            <li>Sugestão: Proposta de melhoria de políticas e serviços prestados pela administração pública.</li>
                            <li>Elogio: Reconhecimento ou satisfação com o serviço oferecido ou atendimento recebido.</li>
                            <li>Solicitação: Requerimento de adoção de providência por parte da administração.</li>
                            <li>Reclamação: Demonstração de insatisfação relativa a serviço público.</li>
                            <li>Denúncia: Comunicação de prática de ato ilícito cuja solução dependa da atuação de órgão de controle interno ou externo.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo1" aria-expanded="false" aria-controls="flush-collapseTwo1">
                        4. Como posso fazer uma manifestação?
                    </button>
                </h2>
                <div id="flush-collapseTwo1" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">As manifestações podem ser realizadas de forma presencial, pela internet, por carta ou por telefone, dependendo da ouvidoria de interesse. Para saber quais tipos de atendimento são utilizados, é recomendável consultar a lista disponível no site da ouvidoria correspondente.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo2" aria-expanded="false" aria-controls="flush-collapseTwo2">
                    5. Quem pode recorrer à ouvidoria?
                    </button>
                </h2>
                <div id="flush-collapseTwo2" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Qualquer cidadão que deseje apresentar solicitações, reclamações, denúncias, sugestões ou elogios relacionados a temas pertinentes ao órgão ou entidade em questão.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo3" aria-expanded="false" aria-controls="flush-collapseTwo3">
                    6. É possível fazer uma manifestação de forma anônima?
                    </button>
                </h2>
                <div id="flush-collapseTwo3" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Sim, é possível registrar manifestações de forma anônima. No entanto, ao se identificar, o cidadão permite um retorno mais personalizado e facilita o acompanhamento da manifestação.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo4" aria-expanded="false" aria-controls="flush-collapseTwo4">
                        7. Qual é o prazo para receber uma resposta da ouvidoria?
                    </button>
                </h2>
                <div id="flush-collapseTwo4" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">O prazo para resposta pode variar conforme a ouvidoria e a complexidade da manifestação. É importante verificar as diretrizes específicas da ouvidoria em questão para informações precisas sobre os prazos. </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo9" aria-expanded="false" aria-controls="flush-collapseTwo9">
                        8. Como acompanhar o andamento da minha manifestação?
                    </button>
                </h2>
                <div id="flush-collapseTwo9" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Após registrar uma manifestação, é possível acompanhar seu andamento por meio do sistema utilizado pela ouvidoria, seja ele online ou por meio de contato direto com a mesma. </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo5" aria-expanded="false" aria-controls="flush-collapseTwo5">
                        9. Quais são os direitos do usuário do serviço público ao recorrer à ouvidoria?
                    </button>
                </h2>
                <div id="flush-collapseTwo5" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Os direitos incluem: participação no acompanhamento da prestação e na avaliação dos serviços; obtenção e utilização dos serviços sem discriminação; acesso a informações relativas à sua pessoa constantes de registros ou bancos de dados; proteção de suas informações pessoais; entre outros.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo6" aria-expanded="false" aria-controls="flush-collapseTwo6">
                        10. Quais são os deveres do usuário do serviço público ao recorrer à ouvidoria?
                    </button>
                </h2>
                <div id="flush-collapseTwo6" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Os deveres incluem: utilizar adequadamente os serviços, procedendo com urbanidade e boa-fé; prestar as informações pertinentes ao serviço prestado quando solicitadas; colaborar para a adequada prestação do serviço; e preservar as condições dos bens públicos por meio dos quais lhe são prestados os serviços.</div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include_once 'controladores/Footer.php' ?>