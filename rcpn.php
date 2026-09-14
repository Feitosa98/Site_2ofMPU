<?php
$page_title = "Registro Civil das Pessoas Naturais - Cartório 2º Ofício de Manacapuru";
$is_home = false;
require_once __DIR__ . '/components/service-resources.php';
include 'components/header.php';

$rcpnDocuments = [
    'Registro Civil das Pessoas Naturais' => [
        'Alteração de Nome e Gênero' => 'documentos/Manacapuru/RCPN/Alteracao de nome e genero.pdf',
        'Alteração de Prenome' => 'documentos/Manacapuru/RCPN/Alteracao de prenome.pdf',
        'Alteração de Sobrenome' => 'documentos/Manacapuru/RCPN/Alteracao de sobrenome.pdf',
        'Certidão de Inteiro Teor' => 'documentos/Manacapuru/RCPN/Certidao de inteiro teor.pdf',
        'Declaração de Hipossuficiência' => 'documentos/Manacapuru/RCPN/Declaracao de Hipossuficiencia.pdf',
        'Habilitação de Casamento' => 'documentos/Manacapuru/RCPN/Habilitacao de casamento.pdf',
        'Reconhecimento de Parentalidade Socioafetiva' => 'documentos/Manacapuru/RCPN/Reconhecimento de parentalidade socioafetiva.pdf',
        'Reconhecimento de Paternidade Biológica' => 'documentos/Manacapuru/RCPN/Reconhecimento de paternidade biologica.pdf',
        'Registro de Nascimento Tardio' => 'documentos/Manacapuru/RCPN/Registro de nascimento tardio.pdf',
        'Registro de Nascimento de Indígena' => 'documentos/Manacapuru/RCPN/Registro de nascimento de indigena.pdf',
        'Registro de Óbito Tardio' => 'documentos/Manacapuru/RCPN/Registro de obito tardio.pdf',
        'Restauração de Registro' => 'documentos/Manacapuru/RCPN/Restauracao de registro.pdf',
        'Retificação Administrativa' => 'documentos/Manacapuru/RCPN/Retificacao administrativa.pdf',
        'Trasladação de Assento Ocorrido no Exterior' => 'documentos/Manacapuru/RCPN/Trasladacao de assento de brasileiro ocorrido no exterior.pdf',
    ],
];
?>

<section class="page-header service-page-header">
    <div class="container">
        <span class="page-eyebrow">Cidadania desde o nascimento</span>
        <h1>Registro Civil das Pessoas Naturais</h1>
        <p>Registro dos principais fatos da vida civil e garantia de direitos fundamentais.</p>
    </div>
</section>

<main class="container service-page">
    <section class="service-overview" aria-labelledby="sobre-rcpn">
        <div class="service-overview-copy">
            <span class="resource-kicker">Conheça a especialidade</span>
            <h2 id="sobre-rcpn">Sobre o Registro Civil</h2>
            <p>O Registro Civil documenta os fatos mais importantes da vida, do nascimento ao óbito. Esses registros garantem identidade, cidadania e o acesso a direitos perante o Estado e a sociedade.</p>
        </div>
        <div class="service-list-card">
            <h3>Principais serviços</h3>
            <ul class="service-list">
                <li><i class="fa-solid fa-check"></i> Nascimento</li>
                <li><i class="fa-solid fa-check"></i> Casamento e habilitação</li>
                <li><i class="fa-solid fa-check"></i> Óbito</li>
                <li><i class="fa-solid fa-check"></i> Interdições, tutelas e curatelas</li>
                <li><i class="fa-solid fa-check"></i> Averbações e reconhecimento de paternidade</li>
            </ul>
        </div>
    </section>

    <section class="resource-section" aria-labelledby="gratuidade-title">
        <div class="resource-heading">
            <div>
                <span class="resource-kicker">Direitos do cidadão</span>
                <h2 id="gratuidade-title">Gratuidades e isenções</h2>
            </div>
        </div>
        <div class="gratuidade-grid">
            <article class="gratuidade-card gratuidade-card-free">
                <div class="gratuidade-heading">
                    <span class="gratuidade-icon"><i class="fa-solid fa-award"></i></span>
                    <h3>Atos totalmente gratuitos</h3>
                </div>
                <p>Independentemente da condição financeira, não há custo para:</p>
                <ul>
                    <li>Registro de nascimento e primeira certidão</li>
                    <li>Registro de óbito e primeira certidão</li>
                    <li>Reconhecimento de paternidade biológica e certidão respectiva</li>
                </ul>
            </article>
            <article class="gratuidade-card gratuidade-card-exemptions">
                <div class="gratuidade-heading">
                    <span class="gratuidade-icon"><i class="fa-solid fa-circle-info"></i></span>
                    <h3>Isenções disponíveis</h3>
                </div>
                <p>Pessoas hipossuficientes podem obter gratuitamente:</p>
                <ul>
                    <li>Certidões atualizadas de nascimento, casamento e óbito, mediante declaração</li>
                    <li>Inclusão de etnia e alteração de nome indígena</li>
                    <li>Alterações ordenadas por decisão judicial com gratuidade</li>
                    <li>Demais atos necessários ao exercício da cidadania previstos em lei</li>
                </ul>
            </article>
        </div>
    </section>

    <?php renderEmolumentsSection('rcpn'); ?>
    <?php renderRcpnFeesTable(); ?>
    <?php renderDocumentDownloads($rcpnDocuments); ?>

    <section class="service-cta" aria-label="Solicitar serviço de Registro Civil">
        <div>
            <span class="resource-kicker">Atendimento eletrônico</span>
            <h2>Solicite pelo Meu Registro</h2>
            <p>O pedido será realizado diretamente na plataforma nacional do Registro Civil.</p>
        </div>
        <a href="https://registrocivil.org.br/" target="_blank" rel="noopener noreferrer" class="btn-primary">Acessar Meu Registro <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
    </section>
</main>

<?php include 'components/footer.php'; ?>
