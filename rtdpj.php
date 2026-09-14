<?php
$page_title = "RTD e RCPJ - Cartório 2º Ofício de Manacapuru";
$is_home = false;
require_once __DIR__ . '/components/service-resources.php';
include 'components/header.php';

$rtdpjDocuments = [
    'Registro de Títulos e Documentos' => [
        'Declaração de Posse de Animal Doméstico' => 'documentos/Manacapuru/RTD/Declaracao de Posse de Animal Domestico.pdf',
        'Registro para Mera Conservação' => 'documentos/Manacapuru/RTD/Registro mera conservacao generico.pdf',
    ],
    'Registro Civil das Pessoas Jurídicas' => [
        'Adequação ao Código Civil de 2002' => 'documentos/Manacapuru/RCPJ/Adequacao ao Codigo Civil de 2002.pdf',
        'Alteração Estatutária e Criação ou Transferência de Filial' => 'documentos/Manacapuru/RCPJ/Alteracao estatutaria e filial.pdf',
        'Atas de Eleição, Posse e Assuntos Ordinários' => 'documentos/Manacapuru/RCPJ/Atas de eleicao posse e assuntos ordinarios.pdf',
        'Criação de Filial em Manacapuru' => 'documentos/Manacapuru/RCPJ/Criacao de filial em Manacapuru.pdf',
        'Extinção ou Dissolução da Pessoa Jurídica' => 'documentos/Manacapuru/RCPJ/Extincao e Dissolucao da pessoa juridica.pdf',
        'Registro de Associação ou Organização Religiosa' => 'documentos/Manacapuru/RCPJ/Registro de associacao ou organizacao religiosa.pdf',
        'Registro de Sociedade Simples' => 'documentos/Manacapuru/RCPJ/Registro de sociedade simples.pdf',
        'Transferência de Sede para Manacapuru' => 'documentos/Manacapuru/RCPJ/Transferencia de sede para Manacapuru.pdf',
    ],
];
?>

<section class="page-header service-page-header">
    <div class="container">
        <span class="page-eyebrow">Duas atribuições, uma consulta organizada</span>
        <h1>RTD e RCPJ</h1>
        <p>Registro de Títulos e Documentos e Registro Civil das Pessoas Jurídicas.</p>
    </div>
</section>

<main class="container service-page">
    <section class="service-overview" aria-labelledby="sobre-rtdpj">
        <div class="service-overview-copy">
            <span class="resource-kicker">Conheça as especialidades</span>
            <h2 id="sobre-rtdpj">Sobre o RTD e o RCPJ</h2>
            <p>O RTD garante autenticidade, conservação e eficácia jurídica a contratos e documentos pessoais em geral (como notificações extrajudiciais e declarações). O RCPJ é competente para registrar os atos constitutivos e alterações de pessoas jurídicas de natureza <strong>não empresarial</strong> — tais como sociedades simples, associações civis, fundações e organizações religiosas.</p>
        </div>
        <div class="service-list-card">
            <h3>Principais serviços</h3>
            <ul class="service-list">
                <li><i class="fa-solid fa-check"></i> Contratos, locações e parcerias</li>
                <li><i class="fa-solid fa-check"></i> Notificações extrajudiciais</li>
                <li><i class="fa-solid fa-check"></i> Estatutos e atas de associações</li>
                <li><i class="fa-solid fa-check"></i> Sociedades simples e fundações</li>
                <li><i class="fa-solid fa-check"></i> Conservação integral de documentos</li>
            </ul>
        </div>
    </section>

    <?php renderEmolumentsSection('rtdpj'); ?>
    <?php renderRtdpjUnifiedRanges(); ?>
    <?php renderRtdpjFixedActs(); ?>
    <?php renderDocumentDownloads($rtdpjDocuments); ?>

    <section class="service-cta" aria-label="Solicitar serviços de RTD ou RCPJ">
        <div>
            <span class="resource-kicker">Atendimento eletrônico</span>
            <h2>Solicitar Serviços Online</h2>
            <p>Os serviços eletrônicos de Títulos e Documentos e Registro Civil de Pessoas Jurídicas são solicitados diretamente pela plataforma oficial RTDPJ Brasil / SERP.</p>
        </div>
        <a href="https://serp.registros.org.br/" target="_blank" rel="noopener noreferrer" class="btn-primary">Solicitar Serviços no RTDPJ Brasil <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
    </section>
</main>

<?php include 'components/footer.php'; ?>
