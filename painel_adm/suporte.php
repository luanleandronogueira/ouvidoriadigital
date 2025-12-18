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
<section style="padding: 60px 40px; background: linear-gradient(135deg, var(--cor-primaria) 0%, var(--cor-secundaria) 100%); color: var(--cor-branca); text-align: center;">
    <h1 style="font-family: var(--font-titulo); font-size: 42px; margin-bottom: 15px;">Central de Suporte</h1>
    <p style="font-family: var(--font-texto); font-size: 18px; opacity: 0.9;">Estamos aqui para ajudar você em tudo que precisar</p>
</section>

<!-- CANAIS DE CONTATO - Usando estrutura similar aos serviços -->
<section style="padding: 60px 80px;">
    <h2 style="font-family: var(--font-titulo); font-size: 28px; color: var(--cor-primaria); margin-bottom: 40px; text-align: center;">Formas de Contato</h2>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">

        <!-- Card Telefone -->
        <div style="padding: 30px; background-color: var(--cor-bg); border-radius: 12px; text-align: center; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 8px 16px rgba(0,0,0,0.15)'; this.style.backgroundColor='var(--cor-primaria)'; this.style.color='var(--cor-branca)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'; this.style.backgroundColor='var(--cor-bg)'; this.style.color='inherit';">
            <div style="font-size: 48px; margin-bottom: 20px;">📞</div>
            <h3 style="font-family: var(--font-titulo); font-size: 20px; margin-bottom: 10px; color: var(--cor-primaria);">Telefone</h3>
            <p style="font-size: 14px; color: var(--cor-cinza-dark); margin-bottom: 15px;">Suporte por telefone disponível de segunda a sexta, das 8h às 17h</p>
            <p style="font-weight: 700; font-size: 18px; color: var(--cor-laranja);">(87) 98821-6403</p>
        </div>

        <!-- Card Email -->
        <div style="padding: 30px; background-color: var(--cor-bg); border-radius: 12px; text-align: center; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 8px 16px rgba(0,0,0,0.15)'; this.style.backgroundColor='var(--cor-secundaria)'; this.style.color='var(--cor-branca)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'; this.style.backgroundColor='var(--cor-bg)'; this.style.color='inherit';">
            <div style="font-size: 48px; margin-bottom: 20px;">✉️</div>
            <h3 style="font-family: var(--font-titulo); font-size: 20px; margin-bottom: 10px; color: var(--cor-primaria);">Email</h3>
            <p style="font-size: 14px; color: var(--cor-cinza-dark); margin-bottom: 15px;">Responderemos sua solicitação em até 24 horas úteis</p>
            <p style="font-weight: 700; font-size: 16px; color: var(--cor-azul);">arquivos2.itsolucoes@gmail.com</p>
        </div>

        <!-- Card Manual -->
        <div style="padding: 30px; background-color: var(--cor-bg); border-radius: 12px; text-align: center; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 8px 16px rgba(0,0,0,0.15)'; this.style.backgroundColor='var(--cor-verde)'; this.style.color='var(--cor-branca)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'; this.style.backgroundColor='var(--cor-bg)'; this.style.color='inherit';">
            <div style="font-size: 48px; margin-bottom: 20px;">📖</div>
            <h3 style="font-family: var(--font-titulo); font-size: 20px; margin-bottom: 10px; color: var(--cor-primaria);">Manual do Usuário</h3>
            <p style="font-size: 14px; color: var(--cor-cinza-dark); margin-bottom: 15px;">Acesse nosso guia completo com instruções passo a passo</p>
            <a href="#" style="display: inline-block; padding: 10px 20px; background-color: var(--cor-verde); color: var(--cor-branca); border-radius: 8px; text-decoration: none; font-weight: 700; transition: all 0.3s;">Download</a>
        </div>

    </div>
</section>

<!-- SEÇÃO DE HORÁRIO E INFORMAÇÕES -->
<section style="padding: 60px 80px; background-color: var(--cor-bg);">
    <h2 style="font-family: var(--font-titulo); font-size: 28px; color: var(--cor-primaria); margin-bottom: 40px; text-align: center;">Informações Úteis</h2>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; max-width: 1000px; margin: 0 auto;">

        <div style="padding: 30px; background-color: var(--cor-branca); border-radius: 12px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1);">
            <h3 style="font-family: var(--font-titulo); font-size: 20px; color: var(--cor-primaria); margin-bottom: 20px;">⏰ Horário de Atendimento</h3>
            <ul style="list-style: none; color: var(--cor-cinza-dark);">
                <li style="padding: 8px 0; border-bottom: 1px solid var(--cor-cinza-light);"><strong>Segunda a Sexta:</strong> 8h às 17h</li>
                <li style="padding: 8px 0;"><strong>Sábado, Domingo e Feriados:</strong> Fechado</li>
            </ul>
        </div>

        <div style="padding: 30px; background-color: var(--cor-branca); border-radius: 12px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1);">
            <h3 style="font-family: var(--font-titulo); font-size: 20px; color: var(--cor-primaria); margin-bottom: 20px;">📍 Localização</h3>
            <p style="color: var(--cor-cinza-dark); line-height: 1.6;">
                <strong>IT Soluções Inteligentes</strong><br>
                Av. Santo Antônio, 190. 2º andar sala 7<br>
                Garanhuns - PE, 55290-000<br>
                Brasil
            </p>
        </div>

    </div>
</section>


<?php include_once 'controladores/Footer.php' ?>