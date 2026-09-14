<?php
$page_title = "Certidões e Documentos - Cartório 2º Ofício de Manacapuru";
$page_desc = "Solicite certidões de Registro de Imóveis, Registro Civil (RCPN) e RTDPJ pelas centrais eletrônicas oficiais do Cartório 2º Ofício de Manacapuru.";
$is_home = false;
include 'components/header.php';
?>

<section class="page-header service-page-header">
    <div class="container">
        <span class="page-eyebrow">Centrais Oficiais de Atendimento</span>
        <h1>Certidões e Documentos</h1>
        <p>Solicite certidões eletrônicas com validade jurídica diretamente nas plataformas nacionais oficiais ou informe-se sobre os serviços do Cartório.</p>
    </div>
</section>

<main class="container service-page">
    <section class="service-overview" aria-labelledby="sobre-certidoes">
        <div class="service-overview-copy">
            <span class="resource-kicker">Atendimento digital</span>
            <h2 id="sobre-certidoes">Emissão Oficial de Certidões</h2>
            <p>O Cartório 2º Ofício de Manacapuru é integrado às centrais nacionais oficiais de serviços eletrônicos compartilhados, instituídas conforme normas do Conselho Nacional de Justiça (CNJ). Escolha abaixo a especialidade desejada para solicitar sua certidão com agilidade e segurança jurídica.</p>
        </div>
        <div class="service-list-card">
            <h3>Vantagens da certidão eletrônica</h3>
            <ul class="service-list">
                <li><i class="fa-solid fa-check"></i> Assinatura digital ICP-Brasil com validade legal plena</li>
                <li><i class="fa-solid fa-check"></i> Solicitação e pagamento 100% online</li>
                <li><i class="fa-solid fa-check"></i> Acompanhamento do status do pedido em tempo real</li>
                <li><i class="fa-solid fa-check"></i> Opção de recebimento digital (PDF) ou em papel</li>
            </ul>
        </div>
    </section>

    <!-- Cards das Centrais Nacionais -->
    <section class="resource-section" aria-labelledby="centrais-title">
        <div class="resource-heading">
            <div>
                <span class="resource-kicker">Plataformas integradas</span>
                <h2 id="centrais-title">Selecione o tipo de certidão</h2>
                <p>Cada especialidade conta com uma plataforma eletrônica nacional regulamentada para a solicitação de certidões.</p>
            </div>
        </div>

        <div class="gratuidade-grid" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); margin-top: 24px;">
            <!-- Registro de Imóveis -->
            <article class="resource-panel" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <span class="specialty-badge">Registro de Imóveis</span>
                        <i class="fa-solid fa-house-chimney" style="font-size: 2rem; color: var(--secondary);"></i>
                    </div>
                    <h3 style="color: #fff; font-size: 1.35rem; margin-bottom: 10px;">RI Digital (ONR)</h3>
                    <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">
                        Central oficial do Operador Nacional do Sistema de Registro Eletrônico de Imóveis. Ideal para pedidos de certidões imobiliárias.
                    </p>
                    <ul class="service-list" style="margin-bottom: 25px;">
                        <li><i class="fa-solid fa-check"></i> Certidão de Matrícula (Inteiro Teor)</li>
                        <li><i class="fa-solid fa-check"></i> Certidão de Ônus Reais e Ações</li>
                        <li><i class="fa-solid fa-check"></i> Certidão Negativa de Bens / Propriedade</li>
                        <li><i class="fa-solid fa-check"></i> Visualização de Matrícula online</li>
                    </ul>
                </div>
                <div>
                    <a href="https://ridigital.org.br/" target="_blank" rel="noopener noreferrer" class="btn-primary" style="width: 100%;">
                        Solicitar no RI Digital <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                    <div style="text-align: center; margin-top: 10px;">
                        <a href="imoveis" style="color: #cbd5e1; font-size: 0.85rem; text-decoration: underline;">Ver detalhes e requerimentos de Imóveis</a>
                    </div>
                </div>
            </article>

            <!-- Registro Civil das Pessoas Naturais -->
            <article class="resource-panel" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <span class="specialty-badge">Registro Civil</span>
                        <i class="fa-solid fa-id-card" style="font-size: 2rem; color: var(--secondary);"></i>
                    </div>
                    <h3 style="color: #fff; font-size: 1.35rem; margin-bottom: 10px;">Meu Registro Civil</h3>
                    <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">
                        Portal nacional oficial do Registro Civil (Arpen-Brasil) para solicitação de 2ª via de certidões de qualquer lugar do país.
                    </p>
                    <ul class="service-list" style="margin-bottom: 25px;">
                        <li><i class="fa-solid fa-check"></i> 2ª via de Certidão de Nascimento</li>
                        <li><i class="fa-solid fa-check"></i> 2ª via de Certidão de Casamento</li>
                        <li><i class="fa-solid fa-check"></i> 2ª via de Certidão de Óbito</li>
                        <li><i class="fa-solid fa-check"></i> Certidão eletrônica ou física</li>
                    </ul>
                </div>
                <div>
                    <a href="https://registrocivil.org.br/" target="_blank" rel="noopener noreferrer" class="btn-primary" style="width: 100%;">
                        Solicitar no Meu Registro <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                    <div style="text-align: center; margin-top: 10px;">
                        <a href="rcpn" style="color: #cbd5e1; font-size: 0.85rem; text-decoration: underline;">Ver gratuidades e formulários do RCPN</a>
                    </div>
                </div>
            </article>

            <!-- RTD e RCPJ -->
            <article class="resource-panel" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <span class="specialty-badge">RTD e RCPJ</span>
                        <i class="fa-solid fa-building" style="font-size: 2rem; color: var(--secondary);"></i>
                    </div>
                    <h3 style="color: #fff; font-size: 1.35rem; margin-bottom: 10px;">RTDPJ Brasil / SERP</h3>
                    <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">
                        Plataforma eletrônica para certidões e registros de Títulos e Documentos e de Pessoas Jurídicas (Associações, Sociedades, etc.).
                    </p>
                    <ul class="service-list" style="margin-bottom: 25px;">
                        <li><i class="fa-solid fa-check"></i> Certidão de Breve Relato de PJ</li>
                        <li><i class="fa-solid fa-check"></i> Certidão de Inteiro Teor de Atos e Estatutos</li>
                        <li><i class="fa-solid fa-check"></i> Certidão de Registro em Títulos e Documentos</li>
                        <li><i class="fa-solid fa-check"></i> Notificações Extrajudiciais online</li>
                    </ul>
                </div>
                <div>
                    <a href="https://serp.registros.org.br/" target="_blank" rel="noopener noreferrer" class="btn-primary" style="width: 100%;">
                        Solicitar no RTDPJ Brasil <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                    <div style="text-align: center; margin-top: 10px;">
                        <a href="rtdpj" style="color: #cbd5e1; font-size: 0.85rem; text-decoration: underline;">Ver modelos e downloads de RTD e RCPJ</a>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <!-- Bloco de Autenticidade e Selo AM -->
    <section class="resource-section resource-panel" aria-labelledby="selo-title">
        <div class="resource-heading">
            <div>
                <span class="resource-kicker">Segurança e transparência</span>
                <h2 id="selo-title">Consulta e Validação de Selo Digital</h2>
                <p>Todos os atos praticados pelo Cartório 2º Ofício de Manacapuru recebem o Selo Eletrônico do Tribunal de Justiça do Amazonas (TJAM). Você pode checar a autenticidade de qualquer documento emitido a qualquer momento.</p>
            </div>
            <a href="https://cidadao.portalseloam.com.br/#/" target="_blank" rel="noopener noreferrer" class="btn-resource">
                Consultar Selo AM <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
        </div>
    </section>

    <!-- Bloco CTA / Contato -->
    <section class="service-cta" aria-label="Dúvidas sobre certidões">
        <div>
            <span class="resource-kicker">Precisa de auxílio ou outro serviço?</span>
            <h2>Fale Diretamente com Nossa Equipe</h2>
            <p>Se preferir, solicite orientações sobre certidões específicas ou inicie seu atendimento online pelo nosso site.</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="#" id="openWhatsappMenuBtn" class="btn-primary">
                <i class="fa-brands fa-whatsapp"></i> Falar no WhatsApp
            </a>
            <a href="solicitar" class="btn-resource" style="padding: 12px 22px; border-radius: 50px; font-weight: 700;">
                <i class="fa-solid fa-file-pen"></i> Solicitar pelo Site
            </a>
        </div>
    </section>
</main>

<?php include 'components/footer.php'; ?>
