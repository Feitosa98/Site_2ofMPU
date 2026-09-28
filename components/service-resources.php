<?php

function renderEmolumentsSection(string $specialty): void
{
    $tables = [
        'ri' => [
            'badge' => 'Tabela II — 2026',
            'title' => 'Registro de Imóveis — Tabela Oficial Vigente',
            'description' => 'Tabela II consolidada com as alterações da Lei Estadual nº 8.212/2026, incluindo as faixas de valores até R$ 50 milhões e as certidões eletrônicas.',
            'url' => 'Tabela de Emolumentos 2026 - Lei 8.212.pdf',
            'document_label' => 'Tabela de Emolumentos 2026 — Lei nº 8.212/2026',
            'document_caption' => 'Documento oficial vigente publicado pelo TJAM',
            'button_label' => 'Abrir Tabela Oficial 2026',
        ],
        'rtdpj' => [
            'badge' => 'Tabela IV — 2026',
            'title' => 'RTD e Registro Civil das Pessoas Jurídicas — Tabela Oficial Vigente',
            'description' => 'Tabela IV consolidada com as alterações da Lei Estadual nº 8.212/2026 para Registro de Títulos e Documentos e Registro Civil das Pessoas Jurídicas.',
            'url' => 'Tabela de Emolumentos 2026 - Lei 8.212.pdf',
            'document_label' => 'Tabela de Emolumentos 2026 — Lei nº 8.212/2026',
            'document_caption' => 'Documento oficial vigente publicado pelo TJAM',
            'button_label' => 'Abrir Tabela Oficial 2026',
        ],
        'rcpn' => [
            'badge' => 'Tabela V — vigente',
            'title' => 'Registro Civil das Pessoas Naturais — Tabela Oficial Vigente',
            'description' => 'Tabela V aplicável aos atos do Registro Civil das Pessoas Naturais, incluindo casamento, averbações e certidões.',
            'url' => 'Tabela de Registro Civil.pdf',
            'document_label' => 'Tabela V — Registro Civil das Pessoas Naturais',
            'document_caption' => 'Documento oficial vigente do TJAM',
            'button_label' => 'Abrir Tabela V Oficial',
        ],
    ];

    if (!isset($tables[$specialty])) {
        throw new InvalidArgumentException('Especialidade de emolumentos inválida.');
    }

    $table = $tables[$specialty];
    ?>
    <section class="resource-section resource-panel" aria-labelledby="emolumentos-title-<?= htmlspecialchars($specialty, ENT_QUOTES, 'UTF-8') ?>">
        <div class="resource-heading">
            <div>
                <span class="resource-kicker">Custas e emolumentos</span>
                <h2 id="emolumentos-title-<?= htmlspecialchars($specialty, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($table['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                <p><?= htmlspecialchars($table['description'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <span class="specialty-badge"><?= htmlspecialchars($table['badge'], ENT_QUOTES, 'UTF-8') ?></span>
        </div>

        <div class="fee-document">
            <div class="fee-document-heading">
                <div>
                    <strong><?= htmlspecialchars($table['document_label'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <span><?= htmlspecialchars($table['document_caption'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <a class="btn-resource" href="<?= htmlspecialchars($table['url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer">
                    <?= htmlspecialchars($table['button_label'], ENT_QUOTES, 'UTF-8') ?> <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </div>
            <details class="fee-preview-disclosure">
                <summary><i class="fa-regular fa-file-pdf"></i> Visualizar tabela oficial nesta página <i class="fa-solid fa-chevron-down"></i></summary>
                <iframe class="fee-preview" src="<?= htmlspecialchars($table['url'], ENT_QUOTES, 'UTF-8') ?>" title="<?= htmlspecialchars($table['badge'] . ' - ' . $table['title'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy"></iframe>
            </details>
        </div>

        <?php if ($specialty === 'ri'): ?>
            <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 16px;">
                <a href="#tabela-unificada-ri" class="btn-resource"><i class="fa-solid fa-table-list"></i> Tabela Geral de Faixas (R$ 0,01 a R$ 50M)</a>
                <a href="#atos-fixos-ri" class="btn-resource"><i class="fa-solid fa-list-check"></i> Demais Atos Fixos</a>
            </div>
        <?php elseif ($specialty === 'rtdpj'): ?>
            <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 16px;">
                <a href="#tabela-faixas-rtdpj" class="btn-resource"><i class="fa-solid fa-table-list"></i> Tabela de Faixas (RTD com valor)</a>
                <a href="#atos-fixos-rtdpj" class="btn-resource"><i class="fa-solid fa-list-check"></i> Demais Atos Fixos (RTD e RCPJ)</a>
            </div>
        <?php elseif ($specialty === 'rcpn'): ?>
            <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 16px;">
                <a href="#tabela-atos-rcpn" class="btn-resource"><i class="fa-solid fa-table-list"></i> Tabela Oficial de Atos do Registro Civil (RCPN)</a>
            </div>
        <?php endif; ?>
        <?php if ($specialty === 'rcpn'): ?>
            <p class="resource-note"><i class="fa-solid fa-circle-info"></i> A Lei Estadual nº 8.212/2026 alterou as Tabelas I a IV. Para o Registro Civil das Pessoas Naturais, permanece aplicável a Tabela V vigente.</p>
        <?php else: ?>
            <p class="resource-note"><i class="fa-solid fa-circle-info"></i> Valores vigentes conforme a Lei Estadual nº 8.212, de 28 de abril de 2026, com ISS de 5% aplicável em Manacapuru.</p>
        <?php endif; ?>
    
        <details class="checklist-card" style="margin-top: 22px;">
            <summary>
                <span><i class="fa-solid fa-circle-info"></i> Notas Oficiais e Regras Gerais de Aplicação (TJAM)</span>
                <i class="fa-solid fa-chevron-down checklist-arrow" aria-hidden="true"></i>
            </summary>
            <ul style="margin-top: 8px;">
                <?php foreach ($notes as $note): ?>
                    <li><i class="fa-solid fa-check"></i> <?= htmlspecialchars($note, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </details>

    </section>
    <?php
}


function renderRiUnifiedRanges(): void
{
    // Faixas 2025
    $rows2025 = [
        ['R$ 0,01 a R$ 17.595,00', 'R$ 486,20', 'R$ 24,31', 'R$ 48,62', 'R$ 72,93', 'R$ 4,00', 'R$ 10,00', 'R$ 646,06'],
        ['R$ 17.595,01 a R$ 35.190,00', 'R$ 749,41', 'R$ 37,47', 'R$ 74,94', 'R$ 112,41', 'R$ 4,00', 'R$ 10,00', 'R$ 988,23'],
        ['R$ 35.190,01 a R$ 58.650,00', 'R$ 931,10', 'R$ 46,55', 'R$ 93,11', 'R$ 139,66', 'R$ 4,00', 'R$ 10,00', 'R$ 1.224,42'],
        ['R$ 58.650,01 a R$ 117.300,00', 'R$ 1.221,89', 'R$ 61,09', 'R$ 122,18', 'R$ 183,28', 'R$ 4,00', 'R$ 10,00', 'R$ 1.603,45'],
        ['R$ 117.300,01 a R$ 234.600,00', 'R$ 2.138,41', 'R$ 106,92', 'R$ 213,84', 'R$ 320,76', 'R$ 4,00', 'R$ 10,00', 'R$ 2.794,93'],
        ['R$ 234.600,01 a R$ 351.900,00', 'R$ 3.536,48', 'R$ 176,82', 'R$ 353,64', 'R$ 530,47', 'R$ 4,00', 'R$ 10,00', 'R$ 4.612,42'],
        ['R$ 351.900,01 a R$ 469.200,00', 'R$ 5.510,24', 'R$ 275,51', 'R$ 551,02', 'R$ 826,53', 'R$ 20,00', 'R$ 10,00', 'R$ 7.193,30'],
        ['R$ 469.200,01 a R$ 586.500,00', 'R$ 7.024,37', 'R$ 351,21', 'R$ 702,43', 'R$ 1.053,65', 'R$ 20,00', 'R$ 10,00', 'R$ 9.161,66'],
        ['R$ 586.500,01 a R$ 703.800,00', 'R$ 8.619,17', 'R$ 430,95', 'R$ 861,91', 'R$ 1.292,87', 'R$ 20,00', 'R$ 10,00', 'R$ 11.234,90'],
        ['R$ 703.800,01 a R$ 821.100,00', 'R$ 8.882,41', 'R$ 444,12', 'R$ 888,24', 'R$ 1.332,36', 'R$ 20,00', 'R$ 10,00', 'R$ 11.577,13'],
        ['R$ 821.100,01 a R$ 938.400,00', 'R$ 9.972,57', 'R$ 498,62', 'R$ 997,25', 'R$ 1.495,88', 'R$ 20,00', 'R$ 10,00', 'R$ 12.994,32'],
        ['R$ 938.400,01 a R$ 1.055.700,00', 'R$ 11.749,09', 'R$ 587,45', 'R$ 1.174,91', 'R$ 1.762,36', 'R$ 20,00', 'R$ 10,00', 'R$ 15.303,81'],
    ];

    // Faixas 2026
    $rows2026 = [
        ['R$ 1.055.700,01 a R$ 4.055.700,00', 'R$ 13.749,09', 'R$ 687,45', 'R$ 1.374,91', 'R$ 2.062,36', 'R$ 20,00', 'R$ 10,00', 'R$ 17.903,81'],
        ['R$ 4.055.700,01 a R$ 7.055.700,00', 'R$ 15.749,09', 'R$ 787,45', 'R$ 1.574,91', 'R$ 2.362,36', 'R$ 20,00', 'R$ 10,00', 'R$ 20.503,81'],
        ['R$ 7.055.700,01 a R$ 10.055.700,00', 'R$ 17.749,09', 'R$ 887,45', 'R$ 1.774,91', 'R$ 2.662,36', 'R$ 20,00', 'R$ 10,00', 'R$ 23.103,81'],
        ['R$ 10.055.700,01 a R$ 13.055.700,00', 'R$ 19.749,09', 'R$ 987,45', 'R$ 1.974,91', 'R$ 2.962,36', 'R$ 20,00', 'R$ 10,00', 'R$ 25.703,81'],
        ['R$ 13.055.700,01 a R$ 16.055.700,00', 'R$ 21.749,09', 'R$ 1.087,45', 'R$ 2.174,91', 'R$ 3.262,36', 'R$ 20,00', 'R$ 10,00', 'R$ 28.303,81'],
        ['R$ 16.055.700,01 a R$ 19.055.700,00', 'R$ 23.749,09', 'R$ 1.187,45', 'R$ 2.374,91', 'R$ 3.562,36', 'R$ 20,00', 'R$ 10,00', 'R$ 30.903,81'],
        ['R$ 19.055.700,01 a R$ 22.055.700,00', 'R$ 25.749,09', 'R$ 1.287,45', 'R$ 2.574,91', 'R$ 3.862,36', 'R$ 20,00', 'R$ 10,00', 'R$ 33.503,81'],
        ['R$ 22.055.700,01 a R$ 25.055.700,00', 'R$ 27.749,09', 'R$ 1.387,45', 'R$ 2.774,91', 'R$ 4.162,36', 'R$ 20,00', 'R$ 10,00', 'R$ 36.103,81'],
        ['R$ 25.055.700,01 a R$ 28.055.700,00', 'R$ 29.749,09', 'R$ 1.487,45', 'R$ 2.974,91', 'R$ 4.462,36', 'R$ 20,00', 'R$ 10,00', 'R$ 38.703,81'],
        ['R$ 28.055.700,01 a R$ 31.055.700,00', 'R$ 31.749,09', 'R$ 1.587,45', 'R$ 3.174,91', 'R$ 4.762,36', 'R$ 20,00', 'R$ 10,00', 'R$ 41.303,81'],
        ['R$ 31.055.700,01 a R$ 34.055.700,00', 'R$ 33.749,09', 'R$ 1.687,45', 'R$ 3.374,91', 'R$ 5.062,36', 'R$ 20,00', 'R$ 10,00', 'R$ 43.903,81'],
        ['R$ 34.055.700,01 a R$ 37.055.700,00', 'R$ 35.749,09', 'R$ 1.787,45', 'R$ 3.574,91', 'R$ 5.362,36', 'R$ 20,00', 'R$ 10,00', 'R$ 46.503,81'],
        ['R$ 37.055.700,01 a R$ 40.055.700,00', 'R$ 37.749,09', 'R$ 1.887,45', 'R$ 3.774,91', 'R$ 5.662,36', 'R$ 20,00', 'R$ 10,00', 'R$ 49.103,81'],
        ['R$ 40.055.700,01 a R$ 43.055.700,00', 'R$ 39.749,09', 'R$ 1.987,45', 'R$ 3.974,91', 'R$ 5.962,36', 'R$ 20,00', 'R$ 10,00', 'R$ 51.703,81'],
        ['R$ 43.055.700,01 a R$ 46.055.700,00', 'R$ 41.749,09', 'R$ 2.087,45', 'R$ 4.174,91', 'R$ 6.262,36', 'R$ 20,00', 'R$ 10,00', 'R$ 54.303,81'],
        ['R$ 46.055.700,01 a R$ 49.055.700,00', 'R$ 43.749,09', 'R$ 2.187,45', 'R$ 4.374,91', 'R$ 6.562,36', 'R$ 20,00', 'R$ 10,00', 'R$ 56.903,81'],
        ['R$ 49.055.700,01 a R$ 50.000.000,00', 'R$ 45.749,09', 'R$ 2.287,45', 'R$ 4.574,91', 'R$ 6.862,36', 'R$ 20,00', 'R$ 10,00', 'R$ 59.503,81'],
    ];


    $notes = [
        'Todos os atos dos ofícios notariais e de registro para habitação popular terão redução de metade das custas a pagar, desde a aquisição do terreno até a averbação ou registro da habitação construída.',
        'Para a fixação dos emolumentos será considerado o maior valor, conforme declarado no ato ou negócio jurídico, ou o valor de avaliação fiscal ou judicial.',
        'As custas dos Registros de Contrato ou documentos em que os valores venham expressos em moeda estrangeira deverão ser calculadas após conversão em moeda nacional em vigor.',
        'As custas dos Registros de Contrato de Locação ou Arrendamento serão calculadas com base na soma total das mensalidades.',
        'As custas dos Registros de Contratos em unidade monetária fora de circulação deverão ser corrigidas para valores vigentes.',
        'Nos Registros de Títulos envolvendo negócios com mais de um imóvel, as custas serão cobradas tomando-se por base o valor maior de cada imóvel objeto do contrato.',
        'Pelos serviços de computação será cobrado o valor de R$ 10,00, somente incidentes em atos de valor declarado.',
        'Nas incorporações, averbações de construções e instituições de condomínio, com valores declarados, aplica-se o item I e demais valores do item VII da Tabela II.',
        'Todos os serviços notariais e de registro do Estado do Amazonas recolhem 5% de ISS (Lei Municipal nº 714/03), especificado e apartado no importe de emolumentos.',
    ];

    // Atos Fixos
    $fixedActs = [
        ['II - Registro e Averbação não prevista no item 1, e sem valor declarado ou arbitrado', 'R$ 306,20', 'R$ 15,31', 'R$ 30,62', 'R$ 45,93', 'R$ 3,00', '—', 'R$ 401,06'],
        ['III - Registro de loteamento rural, por gleba lote', 'R$ 158,80', 'R$ 7,94', 'R$ 15,88', 'R$ 23,82', 'R$ 3,00', '—', 'R$ 209,44'],
        ['IV - Registro de loteamento urbano, por lote', 'R$ 201,71', 'R$ 10,09', 'R$ 20,17', 'R$ 30,26', 'R$ 3,00', '—', 'R$ 265,23'],
        ['V.a) negativa de propriedade por nome', 'R$ 53,63', 'R$ 2,68', 'R$ 5,36', 'R$ 8,04', 'R$ 2,00', '—', 'R$ 71,71'],
        ['V.b) positiva de propriedade, com negativa ou positiva de ônus, por imóvel', 'R$ 53,63', 'R$ 2,68', 'R$ 5,36', 'R$ 8,04', 'R$ 2,00', '—', 'R$ 71,71'],
        ['V.c) de cadeia sucessória, por imóvel ou negativa ou positiva de ônus, por folha', 'R$ 53,63', 'R$ 2,68', 'R$ 5,36', 'R$ 8,04', 'R$ 2,00', '—', 'R$ 71,71'],
        ['V.d) de outra natureza ou de inteiro teor, por folha', 'R$ 95,55', 'R$ 4,78', 'R$ 9,56', 'R$ 14,33', 'R$ 3,00', '—', 'R$ 127,22'],
        ['V.e.1) Certidão Eletrônica: de matrícula', 'R$ 111,55', 'R$ 5,58', 'R$ 11,16', 'R$ 16,73', 'R$ 3,00', '—', 'R$ 148,02'],
        ['V.e.2) Certidão Eletrônica: de Transcrição', 'R$ 223,10', 'R$ 11,16', 'R$ 22,31', 'R$ 33,47', 'R$ 3,00', '—', 'R$ 293,04'],
        ['V.e.3) Certidão Eletrônica: vintenária, da matrícula e/ou transcrição', 'R$ 95,55', 'R$ 4,78', 'R$ 9,56', 'R$ 14,33', 'R$ 3,00', '—', 'R$ 127,22'],
        ['V.e.4) Certidão Eletrônica: de cadeia dominial, da matrícula e/ou transcrição', 'R$ 223,10', 'R$ 11,16', 'R$ 22,31', 'R$ 33,47', 'R$ 3,00', '—', 'R$ 293,04'],
        ['V.e.5) Certidão Eletrônica: negativa/positiva, por pessoa', 'R$ 53,63', 'R$ 2,68', 'R$ 5,36', 'R$ 8,04', 'R$ 2,00', '—', 'R$ 71,71'],
        ['V.e.5) Certidão Eletrônica: negativa/positiva, por endereço', 'R$ 95,55', 'R$ 4,78', 'R$ 9,56', 'R$ 14,33', 'R$ 3,00', '—', 'R$ 127,22'],
        ['V.e.6) Certidão Eletrônica: por quesitos, por imóvel e/ou matrícula', 'R$ 223,10', 'R$ 11,16', 'R$ 22,31', 'R$ 33,47', 'R$ 3,00', '—', 'R$ 293,04'],
        ['V.e.7) Certidão Eletrônica: de ônus reais da matrícula e/ou transcrição', 'R$ 95,55', 'R$ 4,78', 'R$ 9,56', 'R$ 14,33', 'R$ 3,00', '—', 'R$ 127,22'],
        ['V.e.8) Certidão Eletrônica: de ações reais, pessoais reipersecutórias, da matrícula e/ou transcrição', 'R$ 95,55', 'R$ 4,78', 'R$ 9,56', 'R$ 14,33', 'R$ 3,00', '—', 'R$ 127,22'],
        ['V.f) SIDOC - Sistema de Informação de Documentos', 'R$ 51,85', 'R$ 2,59', 'R$ 5,19', 'R$ 7,78', 'R$ 3,00', 'R$ 51,85', 'R$ 122,26'],
        ['VI.a) Registro de convenção de condomínio: pela convenção', 'R$ 950,00', 'R$ 47,50', 'R$ 95,00', 'R$ 142,50', 'R$ 4,00', '—', 'R$ 1.239,00'],
        ['VI.b) Registro de convenção de condomínio: para cada unidade integrante do condomínio', 'R$ 200,71', 'R$ 10,04', 'R$ 20,07', 'R$ 30,11', 'R$ 3,00', '—', 'R$ 263,93'],
        ['VII - Constituição ou incorporação de condomínio por unidade', 'R$ 580,78', 'R$ 29,04', 'R$ 58,08', 'R$ 87,12', 'R$ 3,00', '—', 'R$ 758,02'],
        ['VIII - Baixa: pacto comissório, hipoteca, penhora, cédula e outros', 'R$ 630,78', 'R$ 31,54', 'R$ 63,08', 'R$ 94,62', 'R$ 3,00', '—', 'R$ 823,02'],
        ['IX - Subdivisão e remembramento por lote', 'R$ 958,41', 'R$ 47,92', 'R$ 95,84', 'R$ 143,76', 'R$ 4,00', '—', 'R$ 1.249,93'],
        ['X - Prenotação de títulos, a requerimento do interessado para registro ou averbação', 'R$ 263,13', 'R$ 13,16', 'R$ 26,31', 'R$ 39,47', 'R$ 3,00', '—', 'R$ 345,07'],
        ['XI - Apostilamento de Haia', 'R$ 57,15', 'R$ 2,86', 'R$ 5,72', 'R$ 8,57', 'R$ 3,00', '—', 'R$ 77,30'],
    ];
    ?>
    <section class="resource-section resource-panel" id="tabela-unificada-ri" aria-labelledby="unified-ri-ranges-title">
        <div class="resource-heading">
            <div>
                <span class="resource-kicker">Tabela Unificada de Emolumentos</span>
                <h2 id="unified-ri-ranges-title">Tabela Geral — Registro de Imóveis (2026)</h2>
                <p>Tabela contínua de valores do Registro de Imóveis: integração das faixas vigentes e dos atos fixos da Lei Estadual nº 8.212/2026.</p>
            </div>
            <span class="specialty-badge">Lei 8.212/2026</span>
        </div>
        <div class="mobile-table-hint">
            <i class="fa-solid fa-arrows-left-right"></i> Arraste para os lados para visualizar todas as colunas
        </div>
        <div class="fees-table-wrap">
            <table class="fees-table">
                <thead>
                    <tr>
                        <th>Faixa de valores do ato / Tipos de atos</th>
                        <th>Emolumento</th>
                        <th>ISS (5%)</th>
                        <th>FIGRCPN</th>
                        <th>Funjeam Extrajudicial</th>
                        <th>Selo</th>
                        <th>Computação</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-group-header">
                        <th colspan="8">
                            <i class="fa-solid fa-calendar-check"></i> Faixas de Valores (Atos de R$ 0,01 até R$ 1.055.700,00)
                        </th>
                    </tr>
                    <?php foreach ($rows2025 as $row): ?>
                        <tr>
                            <?php foreach ($row as $cell): ?>
                                <td><?= htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-group-header">
                        <th colspan="8">
                            <i class="fa-solid fa-calendar-check"></i> Novas Faixas (Lei 8.212/2026 - Acima de R$ 1.055.700,00)
                        </th>
                    </tr>
                    <?php foreach ($rows2026 as $row): ?>
                        <tr>
                            <?php foreach ($row as $cell): ?>
                                <td><?= htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-group-header">
                        <th colspan="8">
                            <i class="fa-solid fa-list-check"></i> Demais Atos Fixos do Registro de Imóveis
                        </th>
                    </tr>
                    <tr class="table-group-header" style="font-size: 0.9em; opacity: 0.9;">
                        <th>Tipos de atos</th>
                        <th>Emolumento</th>
                        <th>ISS</th>
                        <th>FIGRCPN</th>
                        <th>Funjeam Extrajudicial</th>
                        <th>Selo</th>
                        <th>Computação</th>
                        <th>Total</th>
                    </tr>
                    <?php foreach ($fixedActs as $row): ?>
                        <tr>
                            <?php foreach ($row as $cell): ?>
                                <td><?= htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <p class="resource-note"><i class="fa-solid fa-circle-info"></i> <strong>Tabela consolidada:</strong> Apresenta todos os valores do Registro de Imóveis aplicáveis em Manacapuru com ISS a 5%.</p>
    </section>
    <?php
}

function renderRiFixedActs(): void
{
    // Removido a pedido do usuário (Tabela unificada)
}


function renderRtdpjUnifiedRanges(): void
{
    static $rendered = false;
    if ($rendered) return;
    $rendered = true;

    $rows2025 = [
        ['R$ 0,01 a R$ 17.595,00', 'R$ 160,23', 'R$ 8,39', 'R$ 8,39', 'R$ 25,16', 'R$ 3,00', 'R$ 7,53', 'R$ 212,70'],
        ['R$ 17.595,01 a R$ 35.190,00', 'R$ 480,68', 'R$ 24,41', 'R$ 24,41', 'R$ 73,23', 'R$ 3,00', 'R$ 7,53', 'R$ 613,26'],
        ['R$ 35.190,01 a R$ 58.650,00', 'R$ 640,90', 'R$ 32,42', 'R$ 32,42', 'R$ 97,26', 'R$ 4,00', 'R$ 7,53', 'R$ 814,53'],
        ['R$ 58.650,01 a R$ 117.300,00', 'R$ 801,13', 'R$ 40,43', 'R$ 40,43', 'R$ 121,30', 'R$ 4,00', 'R$ 7,53', 'R$ 1.014,82'],
        ['R$ 117.300,01 a R$ 234.600,00', 'R$ 1.121,58', 'R$ 56,46', 'R$ 56,46', 'R$ 169,37', 'R$ 6,00', 'R$ 7,53', 'R$ 1.417,40'],
        ['R$ 234.600,01 a R$ 351.900,00', 'R$ 2.803,94', 'R$ 140,57', 'R$ 140,57', 'R$ 421,72', 'R$ 7,00', 'R$ 7,53', 'R$ 3.521,33'],
        ['R$ 351.900,01 a R$ 469.200,00', 'R$ 3.925,51', 'R$ 196,65', 'R$ 196,65', 'R$ 589,96', 'R$ 8,00', 'R$ 7,53', 'R$ 4.924,30'],
        ['R$ 469.200,01 a R$ 586.500,00', 'R$ 5.047,09', 'R$ 252,73', 'R$ 252,73', 'R$ 758,19', 'R$ 8,00', 'R$ 7,53', 'R$ 6.326,27'],
        ['R$ 586.500,01 a R$ 703.800,00', 'R$ 6.168,66', 'R$ 308,81', 'R$ 308,81', 'R$ 926,43', 'R$ 8,00', 'R$ 7,53', 'R$ 7.728,24'],
        ['R$ 703.800,01 a R$ 821.100,00', 'R$ 7.290,25', 'R$ 364,89', 'R$ 364,89', 'R$ 1.094,67', 'R$ 10,00', 'R$ 7,53', 'R$ 9.132,23'],
        ['R$ 821.100,01 a R$ 938.400,00', 'R$ 7.851,03', 'R$ 392,93', 'R$ 392,93', 'R$ 1.178,78', 'R$ 10,00', 'R$ 7,53', 'R$ 9.833,20'],
        ['R$ 938.400,01 a R$ 1.055.700,00', 'R$ 8.411,83', 'R$ 420,97', 'R$ 420,97', 'R$ 1.262,90', 'R$ 10,00', 'R$ 7,53', 'R$ 10.534,20'],
    ];

    $rows2026 = [
        ['R$ 1.055.700,01 a R$ 4.055.700,00', 'R$ 13.649,09', 'R$ 682,45', 'R$ 1.364,91', 'R$ 2.047,36', 'R$ 20,00', 'R$ 10,00', 'R$ 17.773,81'],
        ['R$ 4.055.700,01 a R$ 7.055.700,00', 'R$ 15.649,09', 'R$ 782,45', 'R$ 1.564,91', 'R$ 2.347,36', 'R$ 20,00', 'R$ 10,00', 'R$ 20.373,81'],
        ['R$ 7.055.700,01 a R$ 10.055.700,00', 'R$ 17.649,09', 'R$ 882,45', 'R$ 1.764,91', 'R$ 2.647,36', 'R$ 20,00', 'R$ 10,00', 'R$ 22.973,81'],
        ['R$ 10.055.700,01 a R$ 13.055.700,00', 'R$ 19.649,09', 'R$ 982,45', 'R$ 1.964,91', 'R$ 2.947,36', 'R$ 20,00', 'R$ 10,00', 'R$ 25.573,81'],
        ['R$ 13.055.700,01 a R$ 16.055.700,00', 'R$ 21.649,09', 'R$ 1.082,45', 'R$ 2.164,91', 'R$ 3.247,36', 'R$ 20,00', 'R$ 10,00', 'R$ 28.173,81'],
        ['R$ 16.055.700,01 a R$ 19.055.700,00', 'R$ 23.649,09', 'R$ 1.182,45', 'R$ 2.364,91', 'R$ 3.547,36', 'R$ 20,00', 'R$ 10,00', 'R$ 30.773,81'],
        ['R$ 19.055.700,01 a R$ 22.055.700,00', 'R$ 25.649,09', 'R$ 1.282,45', 'R$ 2.564,91', 'R$ 3.847,36', 'R$ 20,00', 'R$ 10,00', 'R$ 33.373,81'],
        ['R$ 22.055.700,01 a R$ 25.055.700,00', 'R$ 27.649,09', 'R$ 1.382,45', 'R$ 2.764,91', 'R$ 4.147,36', 'R$ 20,00', 'R$ 10,00', 'R$ 35.973,81'],
        ['R$ 25.055.700,01 a R$ 28.055.700,00', 'R$ 29.649,09', 'R$ 1.482,45', 'R$ 2.964,91', 'R$ 4.447,36', 'R$ 20,00', 'R$ 10,00', 'R$ 38.573,81'],
        ['R$ 28.055.700,01 a R$ 31.055.700,00', 'R$ 31.649,09', 'R$ 1.582,45', 'R$ 3.164,91', 'R$ 4.747,36', 'R$ 20,00', 'R$ 10,00', 'R$ 41.173,81'],
        ['R$ 31.055.700,01 a R$ 34.055.700,00', 'R$ 33.649,09', 'R$ 1.682,45', 'R$ 3.364,91', 'R$ 5.047,36', 'R$ 20,00', 'R$ 10,00', 'R$ 43.773,81'],
        ['R$ 34.055.700,01 a R$ 37.055.700,00', 'R$ 35.649,09', 'R$ 1.782,45', 'R$ 3.564,91', 'R$ 5.347,36', 'R$ 20,00', 'R$ 10,00', 'R$ 46.373,81'],
        ['R$ 37.055.700,01 a R$ 40.055.700,00', 'R$ 37.649,09', 'R$ 1.882,45', 'R$ 3.764,91', 'R$ 5.647,36', 'R$ 20,00', 'R$ 10,00', 'R$ 48.973,81'],
        ['R$ 40.055.700,01 a R$ 43.055.700,00', 'R$ 39.649,09', 'R$ 1.982,45', 'R$ 3.964,91', 'R$ 5.947,36', 'R$ 20,00', 'R$ 10,00', 'R$ 51.573,81'],
        ['R$ 43.055.700,01 a R$ 46.055.700,00', 'R$ 41.649,09', 'R$ 2.082,45', 'R$ 4.164,91', 'R$ 6.247,36', 'R$ 20,00', 'R$ 10,00', 'R$ 54.173,81'],
        ['R$ 46.055.700,01 a R$ 49.055.700,00', 'R$ 43.649,09', 'R$ 2.182,45', 'R$ 4.364,91', 'R$ 6.547,36', 'R$ 20,00', 'R$ 10,00', 'R$ 56.773,81'],
        ['R$ 49.055.700,01 a R$ 50.000.000,00', 'R$ 45.649,09', 'R$ 2.282,45', 'R$ 4.564,91', 'R$ 6.847,36', 'R$ 20,00', 'R$ 10,00', 'R$ 59.373,81'],
    ];

    $notes = [
        'No registro de Contratos de Alienação Fiduciária, a base de cálculo será o valor do crédito principal concedido.',
        'No registro de Recibo de Sinal de Venda e Compra, a base de cálculo será o valor do próprio sinal.',
        'Nos Contratos de Leasing, a base de cálculo incidirá sobre o valor da aquisição do bem objeto do contrato.',
        'Nas Cessões de Crédito, a base de cálculo será sobre o valor total das garantias oferecidas sem consideração de qualquer outro acréscimo.',
        'Nos Contratos de Prestação de Serviço com prazo determinado, o cálculo incidirá sobre a soma das parcelas pactuadas (se prazo indeterminado, toma-se a soma de doze parcelas mensais).',
    ];
    ?>
    <section class="resource-section resource-panel" id="tabela-faixas-rtdpj" aria-labelledby="rtdpj-ranges-title">
        <div class="resource-heading">
            <div>
                <span class="resource-kicker">Tabela IV TJAM</span>
                <h2 id="rtdpj-ranges-title">Registro com Valor Declarado — RTD (2026)</h2>
                <p>Faixas vigentes e as 17 novas faixas incluídas pela Lei Estadual nº 8.212/2026.</p>
            </div>
            <span class="specialty-badge">Tabela IV — RTD</span>
        </div>
        <div class="mobile-table-hint">
            <i class="fa-solid fa-arrows-left-right"></i> Arraste para os lados para visualizar todas as colunas
        </div>
        <div class="fees-table-wrap">
            <table class="fees-table">
                <thead>
                    <tr>
                        <th>Faixa de valores do ato</th>
                        <th>Emolumento</th>
                        <th>ISS (5%)</th>
                        <th>FIG-RCPN</th>
                        <th>Funjeam Extrajudicial</th>
                        <th>Selo</th>
                        <th>Computação</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-group-header"><th colspan="8">Faixas da Tabela Oficial 2026</th></tr>
                    <?php foreach ($rows2025 as $row): ?>
                        <tr>
                            <?php foreach ($row as $cell): ?>
                                <td><?= htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-group-header"><th colspan="8">Novas faixas — Lei Estadual nº 8.212/2026</th></tr>
                    <?php foreach ($rows2026 as $row): ?>
                        <tr>
                            <?php foreach ($row as $cell): ?>
                                <td><?= htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <details class="checklist-card" style="margin-top: 22px;">
            <summary>
                <span><i class="fa-solid fa-circle-info"></i> Regras Específicas de Base de Cálculo (RTD)</span>
                <i class="fa-solid fa-chevron-down checklist-arrow" aria-hidden="true"></i>
            </summary>
            <ul style="margin-top: 8px;">
                <?php foreach ($notes as $note): ?>
                    <li><i class="fa-solid fa-check"></i> <?= htmlspecialchars($note, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </details>

        <p class="resource-note"><i class="fa-solid fa-circle-info"></i> Atos com valor superior a R$ 1.055.700,00 seguem a legislação complementar vigente (Lei Estadual nº 8.212/2026).</p>
    </section>
    <?php
}

function renderRtdpjFixedActs(): void
{
    static $rendered = false;
    if ($rendered) return;
    $rendered = true;

    $fixedActs = [
        ['II.a - Registro integral sem valor declarado (até 1 lauda)', 'R$ 153,11', 'R$ 7,66', 'R$ 15,31', 'R$ 22,97', 'R$ 3,00', '—', 'R$ 202,05'],
        ['II.b - Registro integral sem valor declarado (por lauda que acrescer)', 'R$ 77,25', 'R$ 3,86', 'R$ 7,73', 'R$ 11,59', 'R$ 0,00', '—', 'R$ 100,43'],
        ['III.a - Registro resumido de contratos e títulos (até 1 lauda)', 'R$ 84,43', 'R$ 4,22', 'R$ 8,44', 'R$ 12,66', 'R$ 3,00', '—', 'R$ 112,75'],
        ['III.b - Registro resumido de contratos e títulos (por lauda que acrescer)', 'R$ 47,21', 'R$ 2,36', 'R$ 4,72', 'R$ 7,08', 'R$ 0,00', '—', 'R$ 61,37'],
        ['IV.a - Notificação extrajudicial na Zona Urbana (até 3 diligências)', 'R$ 158,80', 'R$ 7,94', 'R$ 15,88', 'R$ 23,82', 'R$ 3,00', '—', 'R$ 209,44'],
        ['IV.b - Notificação extrajudicial fora da Zona Urbana (até 3 diligências)', 'R$ 258,95', 'R$ 12,95', 'R$ 25,90', 'R$ 38,84', 'R$ 3,00', '—', 'R$ 339,64'],
        ['IV.c - Notificação extrajudicial (acima de 3 diligências, por ato praticado)', 'R$ 62,94', 'R$ 3,15', 'R$ 6,29', 'R$ 9,44', 'R$ 2,00', '—', 'R$ 83,82'],
        ['V - Averbação de títulos ou documentos quando o ato tiver valor próprio', '—', '—', '—', '—', '—', '—', 'Metade do ato primitivo'],
        ['VI.a - Inscrição de Pessoas Jurídicas (incluindo processo e arquivamento - até 1 lauda)', 'R$ 529,29', 'R$ 26,46', 'R$ 52,93', 'R$ 79,39', 'R$ 3,00', '—', 'R$ 691,07'],
        ['VI.b - Inscrição de Pessoas Jurídicas (por lauda que acrescer)', 'R$ 62,94', 'R$ 3,15', 'R$ 6,29', 'R$ 9,44', 'R$ 0,00', '—', 'R$ 81,82'],
        ['VII - Matrícula de oficina impressora, jornal e outros periódicos', 'R$ 557,54', 'R$ 27,88', 'R$ 55,75', 'R$ 83,63', 'R$ 3,00', '—', 'R$ 727,80'],
        ['VIII.a - Certidão por peça reproduzida e/ou por folha', 'R$ 153,11', 'R$ 7,66', 'R$ 15,31', 'R$ 22,97', 'R$ 3,00', '—', 'R$ 202,05'],
        ['VIII.b - Certidão negativa de pessoa jurídica ou de títulos e documentos', 'R$ 153,11', 'R$ 7,66', 'R$ 15,31', 'R$ 22,97', 'R$ 3,00', '—', 'R$ 202,05'],
        ['VIII.c - SIDOC — Sistema de Informação de Documentos', 'R$ 81,56', 'R$ 4,08', 'R$ 8,16', 'R$ 12,23', 'R$ 3,00', 'R$ 81,56', 'R$ 190,59'],
        ['IX - Cancelamento de registro (inclusive busca e certidão)', 'R$ 167,40', 'R$ 8,37', 'R$ 16,74', 'R$ 25,11', 'R$ 3,00', '—', 'R$ 220,62'],
        ['X - Autenticação de livros contábeis obrigatórios das sociedades civis', 'R$ 121,62', 'R$ 6,08', 'R$ 12,16', 'R$ 18,24', 'R$ 3,00', '—', 'R$ 161,10'],
        ['XI.a - Buscas em livros ou papéis arquivados (até dez anos)', 'R$ 57,21', 'R$ 2,86', 'R$ 5,72', 'R$ 8,58', 'R$ 2,00', '—', 'R$ 76,37'],
        ['XI.b - Buscas em livros arquivados (acima de dez anos por ano, até máx. R$ 230,78)', 'R$ 30,04', 'R$ 1,50', 'R$ 3,00', 'R$ 4,51', 'R$ 2,00', '—', 'R$ 41,05'],
        ['XII - Apostilamento de Haia (RTD e RCPJ)', 'R$ 57,15', 'R$ 2,86', 'R$ 5,72', 'R$ 8,57', 'R$ 3,00', '—', 'R$ 77,30'],
    ];
    ?>
    <section class="resource-section resource-panel" id="atos-fixos-rtdpj" aria-labelledby="rtdpj-fixed-title">
        <div class="resource-heading">
            <div>
                <span class="resource-kicker">Tabela Base Oficial</span>
                <h2 id="rtdpj-fixed-title">Demais Atos de RTD e RCPJ (Tabela IV TJAM)</h2>
                <p>Valores oficiais para atos sem valor declarado, notificações extrajudiciais, registro de pessoas jurídicas, certidões e averbações:</p>
            </div>
            <span class="specialty-badge">Atos Fixos RTD/RCPJ</span>
        </div>
        <div class="mobile-table-hint">
            <i class="fa-solid fa-arrows-left-right"></i> Arraste para os lados para visualizar todas as colunas
        </div>
        <div class="fees-table-wrap">
            <table class="fees-table">
                <thead>
                    <tr>
                        <th>Tipo de Ato / Serviço Registral</th>
                        <th>Emolumento</th>
                        <th>ISS (5%)</th>
                        <th>Funjeam RCPN</th>
                        <th>Funjeam Ext.</th>
                        <th>Selo</th>
                        <th>Extras</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fixedActs as $act): ?>
                        <tr>
                            <?php foreach ($act as $cell): ?>
                                <td><?= htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <p class="resource-note"><i class="fa-solid fa-circle-info"></i> Valores fixados pela Corregedoria-Geral de Justiça do TJAM (Tabela IV) vigentes para a Capital e Interior.</p>
    </section>
    <?php
}

function renderRcpnFeesTable(): void
{
    static $rendered = false;
    if ($rendered) return;
    $rendered = true;
    $rcpnActs = [
        ['I.a - Casamento nos auditórios ou cartórios', 'R$ 382,04', 'R$ 19,10', 'R$ 2,00', 'R$ 403,14'],
        ['I.b - Casamento em domicílio (excluídas despesas com condução)', 'R$ 582,38', 'R$ 29,12', 'R$ 4,00', 'R$ 615,50'],
        ['I.c - Casamento realizado após as 18:00 horas', 'R$ 582,38', 'R$ 29,12', 'R$ 4,00', 'R$ 615,50'],
        ['I.d - Dispensa total ou parcial do prazo de proclamas', 'R$ 196,03', 'R$ 9,80', 'R$ 3,00', 'R$ 208,83'],
        ['I.e - Registro e afixação de edital de proclamas de outro cartório', 'R$ 121,62', 'R$ 6,08', 'R$ 3,00', 'R$ 130,70'],
        ['I.f - Casamento à vista de habilitação processada em outro cartório', 'R$ 196,03', 'R$ 9,80', 'R$ 3,00', 'R$ 208,83'],
        ['I.g - Reconhecimento de firma de precedentes, testemunhas e outros', 'R$ 4,31', 'R$ 0,22', 'R$ 2,00', 'R$ 6,53'],
        ['II.a - Assento de nascimento no prazo', 'R$ 62,94', 'R$ 3,15', 'R$ 2,00', 'Gratuito (Lei 9.534/97)'],
        ['II.b - Assento de nascimento fora do prazo', 'R$ 110,82', 'R$ 5,54', 'R$ 2,00', 'Gratuito (Lei 9.534/97)'],
        ['II.c - Assento de nascimento fora do prazo a pedido do Juiz', 'R$ 111,62', 'R$ 5,58', 'R$ 2,00', 'Gratuito (Lei 9.534/97)'],
        ['III - Assento de óbito e guia de sepultamento', 'R$ 111,62', 'R$ 5,58', 'R$ 3,00', 'Gratuito (Lei 9.534/97)'],
        ['IV - Registro de sentenças (emancipação, interdição, tutela, divórcio, união estável no Livro E)', 'R$ 111,62', 'R$ 5,58', 'R$ 3,00', 'R$ 120,20'],
        ['V - Transcrição de registro no estrangeiro (nascimento, casamento, óbito)', 'R$ 25,76', 'R$ 1,29', 'R$ 2,00', 'R$ 29,05'],
        ['VI - Retificação administrativa ou erro de grafia', 'R$ 74,43', 'R$ 3,72', 'R$ 2,00', 'R$ 80,15'],
        ['VII - Averbação no Registro Civil (por averbação)', 'R$ 133,78', 'R$ 6,69', 'R$ 3,00', 'R$ 143,47'],
        ['VIII.a - Certidão de Registro Civil (até 10 anos)', 'R$ 88,42', 'R$ 4,42', 'R$ 4,00', 'R$ 96,84'],
        ['VIII.b - Certidão de Registro Civil (acima de 10 até 20 anos)', 'R$ 90,58', 'R$ 4,53', 'R$ 4,00', 'R$ 99,11'],
        ['VIII.c - Certidão de Registro Civil (acima de 20 anos)', 'R$ 101,38', 'R$ 5,07', 'R$ 4,00', 'R$ 110,45'],
        ['VIII.d - Certidão de inteiro teor (verbo ad-verbum)', 'R$ 133,78', 'R$ 6,69', 'R$ 4,00', 'R$ 144,47'],
        ['VIII.e - Certidão negativa de Registro Civil', 'R$ 88,42', 'R$ 4,42', 'R$ 4,00', 'R$ 96,84'],
        ['VIII.f - SIDOC - Sistema de Informação de Documentos', 'R$ 66,89', 'R$ 3,34', 'R$ 4,00', 'R$ 141,12'],
        ['IX.a - Notificação, intimação ou anotação por determinação judicial', 'R$ 37,21', 'R$ 1,86', 'R$ 2,00', 'R$ 41,07'],
        ['IX.b - Elaboração de petição, atestado ou declaração exigida por lei', 'R$ 37,21', 'R$ 1,86', 'R$ 2,00', 'R$ 41,07'],
        ['X - Autenticação e cópia reprográfica', 'R$ 5,73', 'R$ 0,29', 'R$ 2,00', 'R$ 8,02'],
        ['XI - Busca em processos, livros e documentos arquivados', 'R$ 37,21', 'R$ 1,86', 'R$ 2,00', 'R$ 41,07'],
        ['XII - Diligência fora do expediente', 'R$ 37,21', 'R$ 1,86', 'R$ 2,00', 'R$ 41,07'],
        ['XIII.a - Termo Declaratório de União Estável', 'R$ 186,02', 'R$ 9,30', 'R$ 3,00', 'R$ 198,32'],
        ['XIII.b - Termo Dissolução de União Estável (sem partilha)', 'R$ 186,02', 'R$ 9,30', 'R$ 3,00', 'R$ 198,32'],
        ['XIII.c - Termo Dissolução de União Estável (com partilha)', 'R$ 257,58', 'R$ 12,88', 'R$ 3,00', 'R$ 273,46'],
        ['XIII.d - Alteração de Regime de Bens do Registro da União Estável', 'R$ 372,04', 'R$ 18,60', 'R$ 3,00', 'R$ 393,64'],
        ['XIII.e - Termo de Certificação Eletrônica de União Estável', 'R$ 186,02', 'R$ 9,30', 'R$ 3,00', 'R$ 198,32'],
        ['XIV - Apostilamento de Haia', 'R$ 57,15', 'R$ 2,86', 'R$ 2,00', 'R$ 76,30'],
    ];

    $gratuidades = [
        'São inteiramente gratuitos os registros de nascimento, os assentos de óbito e a primeira via da respectiva certidão, nos termos da Lei Federal nº 9.534/1997.',
        'Pessoas comprovadamente hipossuficientes têm direito à gratuidade na habilitação para o casamento civil e na emissão de segundas vias de certidões, mediante declaração.',
        'O reconhecimento de paternidade voluntário e a respectiva averbação são isentos de custas cartorárias.',
    ];
    ?>
    <section class="resource-section resource-panel" id="tabela-atos-rcpn" aria-labelledby="rcpn-table-title">
        <div class="resource-heading">
            <div>
                <span class="resource-kicker">Tabela Base Oficial</span>
                <h2 id="rcpn-table-title">Tabela de Emolumentos — Registro Civil das Pessoas Naturais (Tabela V TJAM)</h2>
                <p>Valores oficiais para casamentos, certidões, averbações, retificações e demais atos do Registro Civil:</p>
            </div>
            <span class="specialty-badge">Tabela V — RCPN</span>
        </div>
        <div class="mobile-table-hint">
            <i class="fa-solid fa-arrows-left-right"></i> Arraste para os lados para visualizar todas as colunas
        </div>
        <div class="fees-table-wrap">
            <table class="fees-table fees-table-rcpn">
                <thead>
                    <tr>
                        <th>Ato Registral ou Certidão</th>
                        <th>Emolumento</th>
                        <th>ISS (5%)</th>
                        <th>Selo</th>
                        <th>Total Oficial</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rcpnActs as $act): ?>
                        <tr>
                            <?php foreach ($act as $cell): ?>
                                <td><?= htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <details class="checklist-card" style="margin-top: 22px;">
            <summary>
                <span><i class="fa-solid fa-scale-balanced"></i> Gratuidades Legais e Isenções do Registro Civil</span>
                <i class="fa-solid fa-chevron-down checklist-arrow" aria-hidden="true"></i>
            </summary>
            <ul style="margin-top: 8px;">
                <?php foreach ($gratuidades as $item): ?>
                    <li><i class="fa-solid fa-check"></i> <?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </details>

        <p class="resource-note"><i class="fa-solid fa-circle-info"></i> Tabela V aprovada pela Corregedoria-Geral de Justiça do TJAM. Assegurada a gratuidade dos atos previstos na legislação federal e estadual.</p>
    </section>
    <?php
}

function renderRiBaseRanges(): void
{
    renderRiUnifiedRanges();
    renderRiFixedActs();
}

function renderRiHighValueRanges(): void
{
    renderRiUnifiedRanges();
    renderRiFixedActs();
}

function renderServiceChecklists(array $checklists): void
{
    ?>
    <section class="resource-section" aria-labelledby="checklists-title">
        <h2 id="checklists-title">Documentos Necessários — Checklists</h2>
        <p>Selecione o serviço para consultar a relação inicial de documentos. Conforme o caso concreto, documentos complementares poderão ser solicitados.</p>
        <div class="checklist-grid">
            <?php foreach ($checklists as $title => $items): ?>
                <details class="checklist-card">
                    <summary>
                        <span><i class="fa-regular fa-rectangle-list"></i> <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></span>
                        <i class="fa-solid fa-chevron-down checklist-arrow" aria-hidden="true"></i>
                    </summary>
                    <ul>
                        <?php foreach ($items as $item): ?>
                            <li><i class="fa-solid fa-check"></i> <?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                </details>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
}

function renderDocumentDownloads(array $groups): void
{
    ?>
    <section class="resource-section resource-panel" aria-labelledby="document-downloads-title">
        <div class="resource-heading">
            <div>
                <span class="resource-kicker">Orientações e Checklists</span>
                <h2 id="document-downloads-title">Relação de Documentos e Checklists por Serviço</h2>
                <p>Consulte a relação de documentos e baixe o modelo de requerimento ou checklist correspondente ao seu caso. Os arquivos estão disponíveis para download imediato em PDF e DOCX.</p>
            </div>
        </div>
        <?php foreach ($groups as $groupTitle => $documents): ?>
            <?php if (count($groups) > 1): ?>
                <h3 class="document-group-title"><?= htmlspecialchars($groupTitle, ENT_QUOTES, 'UTF-8') ?></h3>
            <?php endif; ?>
            <div class="document-download-grid">
                <?php foreach ($documents as $label => $path): ?>
                    <?php $isWord = strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'docx'; ?>
                    <a href="<?= htmlspecialchars($path, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" class="document-download-link">
                        <i class="fa-regular <?= $isWord ? 'fa-file-word' : 'fa-file-pdf' ?>" aria-hidden="true"></i>
                        <span><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></span>
                        <i class="fa-solid fa-download document-download-icon" aria-hidden="true"></i>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <p class="resource-note"><i class="fa-solid fa-circle-info"></i> Os documentos serão analisados conforme o caso concreto e poderão ser solicitados esclarecimentos ou documentos complementares.</p>
    </section>
    <?php
}
