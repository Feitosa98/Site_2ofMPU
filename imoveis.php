<?php
$page_title = "Registro de Imóveis - Cartório 2º Ofício de Manacapuru";
$is_home = false;
require_once __DIR__ . '/components/service-resources.php';
include 'components/header.php';

$riDocuments = [
    'Registro de Imóveis' => [
        'Adjudicação Compulsória Extrajudicial' => 'documentos/Manacapuru/Adjudicação compulsória extrajudicial.pdf',
        'Alteração de Dados do Imóvel' => 'documentos/Manacapuru/Alteração de dados do imóvel.pdf',
        'Alteração de Estado Civil ou Complementação' => 'documentos/Manacapuru/Alteração de estado civil ou complementação.pdf',
        'Averbações Genéricas' => 'documentos/Manacapuru/Averbações genéricas.pdf',
        'Cancelamento de Garantias' => 'documentos/Manacapuru/Cancelamento de garantias.pdf',
        'Certidões Diversas' => 'documentos/Manacapuru/Certidões.pdf',
        'Construção e Demolição' => 'documentos/Manacapuru/Construção e demolição.pdf',
        'Declaração SFH' => 'documentos/Manacapuru/Declaração SFH.pdf',
        'União Estável - Declaração Negativa' => 'documentos/Manacapuru/Declaração união estável negativa.pdf',
        'União Estável - Declaração Positiva' => 'documentos/Manacapuru/Declaração união estável positiva.pdf',
        'Incorporação Imobiliária' => 'documentos/Manacapuru/Incorporação imobiliária.pdf',
        'Integralização de Capital' => 'documentos/Manacapuru/Integralização de capital.pdf',
        'Alienação Fiduciária: Intimação e Leilões' => 'documentos/Manacapuru/Intimação e leilões alienação fiduciária.pdf',
        'Condomínio com Incorporação' => 'documentos/Manacapuru/Instituição de condomínio com incorporação.pdf',
        'Condomínio sem Incorporação' => 'documentos/Manacapuru/Instituição de condomínio sem incorporação.pdf',
        'Parcelamento do Solo Rural' => 'documentos/Manacapuru/Parcelamento do solo rural.pdf',
        'Parcelamento do Solo Urbano' => 'documentos/Manacapuru/Parcelamento do solo urbano.pdf',
        'Retificação de Medidas Perimetrais - PDF' => 'documentos/Manacapuru/Retificação de medidas perimetrais.pdf',
        'Retificação de Medidas Perimetrais - DOCX' => 'documentos/Manacapuru/Retificação de medidas perimetrais.docx',
        'Título Definitivo INCRA' => 'documentos/Manacapuru/Título definitivo INCRA.pdf',
        'Transferência de Matrícula' => 'documentos/Manacapuru/Transferência de matrícula.pdf',
        'Unificação ou Fusão' => 'documentos/Manacapuru/Unificação ou Fusão.pdf',
        'Usucapião Extrajudicial' => 'documentos/Manacapuru/Usucapião Extrajudicial.pdf',
    ],
];
?>

<section class="page-header service-page-header">
    <div class="container">
        <span class="page-eyebrow">Atribuição registral</span>
        <h1>Registro de Imóveis</h1>
        <p>Segurança, publicidade e eficácia para os direitos sobre imóveis.</p>
    </div>
</section>

<main class="container service-page">
    <section class="service-overview" aria-labelledby="sobre-ri">
        <div class="service-overview-copy">
            <span class="resource-kicker">Conheça a especialidade</span>
            <h2 id="sobre-ri">Sobre o Registro de Imóveis</h2>
            <p>O Registro de Imóveis conserva o histórico jurídico dos imóveis. Nele são registrados e averbados os atos que alteram a propriedade e outros direitos reais, garantindo publicidade e segurança às transações.</p>
        </div>
        <div class="service-list-card">
            <h3>Principais serviços</h3>
            <ul class="service-list">
                <li><i class="fa-solid fa-check"></i> Escrituras de compra e venda</li>
                <li><i class="fa-solid fa-check"></i> Construção e demolição</li>
                <li><i class="fa-solid fa-check"></i> Certidões de matrícula, ônus e ações</li>
                <li><i class="fa-solid fa-check"></i> Loteamentos e incorporações</li>
                <li><i class="fa-solid fa-check"></i> Hipotecas e alienação fiduciária</li>
            </ul>
        </div>
    </section>

    <?php renderEmolumentsSection('ri'); ?>
    <?php renderRiUnifiedRanges(); ?>
    <?php renderRiFixedActs(); ?>
    <?php renderDocumentDownloads($riDocuments); ?>

    <section class="service-cta" aria-label="Solicitar serviços de Registro de Imóveis">
        <div>
            <span class="resource-kicker">Atendimento eletrônico</span>
            <h2>Solicitar Serviços Online</h2>
            <p>Os serviços eletrônicos de Registro de Imóveis são solicitados diretamente pela plataforma nacional do ONR (Operador Nacional do Registro de Imóveis Eletrônico).</p>
        </div>
        <a href="https://ridigital.org.br/" target="_blank" rel="noopener noreferrer" class="btn-primary">Solicitar Serviços no ONR <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
    </section>
</main>

<?php include 'components/footer.php'; ?>
