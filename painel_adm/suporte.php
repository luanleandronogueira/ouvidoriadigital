<?php
// Inicia a sessão e inclui o cabeçalho (assumindo que estão na pasta 'controladores')
// Começa a sessão
session_start();

// Carrega a Model e valida a sessão
require 'model/SessaoModel.php';
valida_sessao();

require 'controladores/header.php';
?>

<!-- SEÇÃO HERO -->
<section class="py-5" style="background: linear-gradient(135deg, var(--cor-primaria) 0%, var(--cor-secundaria) 100%); color: var(--cor-branca);">
    <div class="container text-center">
        <h1 class="display-4 mb-3" style="font-family: var(--font-titulo);">Central de Suporte</h1>
        <p class="lead" style="font-family: var(--font-texto); opacity: 0.9;">Estamos aqui para ajudar você em tudo que precisar</p>
    </div>
</section>

<!-- CANAIS DE CONTATO - Usando estrutura similar aos serviços -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5" style="font-family: var(--font-titulo); color: var(--cor-primaria);">Formas de Contato</h2>

        <div class="row g-4">

            <!-- Card Telefone -->
            <div class="col-md-4">
                <div class="card h-100 text-center border-0 shadow-sm" style="transition: all 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 8px 16px rgba(0,0,0,0.15)'; this.style.backgroundColor='var(--cor-primaria)'; this.style.color='var(--cor-branca)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'; this.style.backgroundColor='var(--cor-bg)'; this.style.color='inherit';">
                    <div class="card-body">
                        <div class="fs-1 mb-3">📞</div>
                        <h3 class="card-title" style="font-family: var(--font-titulo); color: var(--cor-primaria);">Telefone</h3>
                        <p class="card-text" style="color: var(--cor-cinza-dark);">Suporte por telefone disponível de segunda a sexta, das 8h às 17h</p>
                        <p class="fw-bold fs-5" style="color: var(--cor-laranja);">(87) 98821-6403</p>
                    </div>
                </div>
            </div>

            <!-- Card Email -->
            <div class="col-md-4">
                <div class="card h-100 text-center border-0 shadow-sm" style="transition: all 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 8px 16px rgba(0,0,0,0.15)'; this.style.backgroundColor='var(--cor-secundaria)'; this.style.color='var(--cor-branca)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'; this.style.backgroundColor='var(--cor-bg)'; this.style.color='inherit';">
                    <div class="card-body">
                        <div class="fs-1 mb-3">✉️</div>
                        <h3 class="card-title" style="font-family: var(--font-titulo); color: var(--cor-primaria);">Email</h3>
                        <p class="card-text" style="color: var(--cor-cinza-dark);">Responderemos sua solicitação em até 24 horas úteis</p>
                        <p class="fw-bold fs-6" style="color: var(--cor-azul);">arquivos2.itsolucoes@gmail.com</p>
                    </div>
                </div>
            </div>

            <!-- Card Manual -->
            <div class="col-md-4">
                <div class="card h-100 text-center border-0 shadow-sm" style="transition: all 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 8px 16px rgba(0,0,0,0.15)'; this.style.backgroundColor='var(--cor-verde)'; this.style.color='var(--cor-branca)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'; this.style.backgroundColor='var(--cor-bg)'; this.style.color='inherit';">
                    <div class="card-body">
                        <div class="fs-1 mb-3">📖</div>
                        <h3 class="card-title" style="font-family: var(--font-titulo); color: var(--cor-primaria);">Manual do Usuário</h3>
                        <p class="card-text" style="color: var(--cor-cinza-dark);">Acesse nosso guia completo com instruções passo a passo</p>
                        <a href="#" class="btn btn-success mt-3">Download</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- SEÇÃO DE HORÁRIO E INFORMAÇÕES -->
<section class="py-5" style="background-color: var(--cor-bg);">
    <div class="container">
        <h2 class="text-center mb-5" style="font-family: var(--font-titulo); color: var(--cor-primaria);">Informações Úteis</h2>

        <div class="row g-4 justify-content-center">

            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title" style="font-family: var(--font-titulo); color: var(--cor-primaria);">⏰ Horário de Atendimento</h3>
                        <ul class="list-unstyled" style="color: var(--cor-cinza-dark);">
                            <li class="py-2 border-bottom border-light"><strong>Segunda a Sexta:</strong> 8h às 17h</li>
                            <li class="py-2"><strong>Sábado, Domingo e Feriados:</strong> Fechado</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title" style="font-family: var(--font-titulo); color: var(--cor-primaria);">📍 Localização</h3>
                        <p class="card-text" style="color: var(--cor-cinza-dark); line-height: 1.6;">
                            <strong>IT Soluções Inteligentes</strong><br>
                            Av. Santo Antônio, 190. 2º andar sala 7<br>
                            Garanhuns - PE, 55290-000<br>
                            Brasil
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<?php include_once 'controladores/Footer.php' ?>