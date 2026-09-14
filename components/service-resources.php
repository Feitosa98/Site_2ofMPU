<?php

function renderEmolumentsSection(string $specialty): void
{
    $tables = [
        'ri' => [
            'badge' => 'Tabela II (2025)',
            'title' => 'Registro de Imóveis — Tabela Base 2025',
            'description' => 'Atos dos Oficiais de Registro de Imóveis com base na Tabela Oficial de 2025 (permanece vigente e é complementada pela Lei 8.212/2026).',
            'url' => 'https://c0eefb8b-9ae0-4368-a636-a76df70f8076.filesusr.com/ugd/7a72e4_a25d1ddec8764236a3a899b79bbfbe47.pdf',
            'update' => true,
        ],
        'rtdpj' => [
            'badge' => 'Tabela IV (2025)',
            'title' => 'RTD e Registro Civil das Pessoas Jurídicas — Tabela Base 2025',
            'description' => 'Registro de Títulos e Documentos e Registro Civil das Pessoas Jurídicas (Tabela Oficial de 2025, complementada pela Lei 8.212/2026).',
            'url' => 'https://www.tjam.jus.br/index.php/ext-emolumentos/emolumentos-capital/16207-tabela-de-emolumentos-atos-dos-oficios-de-registro-de-titulos-e-documentos-e-civil-das-pj-s-capital/file',
            'update' => true,
        ],
        'rcpn' => [
            'badge' => 'Tabela V (2025)',
            'title' => 'Registro Civil das Pessoas Naturais — Tabela Base 2025',
            'description' => 'Atos do Registro Civil das Pessoas Naturais (Tabela Oficial de 2025), incluindo casamento, averbações e certidões.',
            'url' => 'https://www.tjam.jus.br/index.php/ext-emolumentos/emolumentos-capital/16210-tabela-de-emolumentos-atos-dos-oficiais-de-registro-civil-das-pessoas-naturais-capital/file',
            'update' => false,
        ],
    ];

    if (!isset($tables[$specialty])) {
        throw new InvalidArgumentException('Especialidade de emolumentos inválida.');
    }

    $table = $tables[$specialty];
    $update2026Url = 'https://www.tjam.jus.br/index.php/ext-emolumentos2/emolumentos-capital/63997-tabela-de-emolumentos-2026-lei-n-8-212-de-28-de-abril-de-2026/file';
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
                    <strong><?= htmlspecialchars($table['badge'] . ' — Tabela Base 2025', ENT_QUOTES, 'UTF-8') ?></strong>
                    <span>Documento oficial de 2025 (vigente como tabela principal)</span>
                </div>
                <a class="btn-resource" href="<?= htmlspecialchars($table['url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer">
                    Abrir Tabela 2025 Oficial <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </div>
            <details class="fee-preview-disclosure">
                <summary><i class="fa-regular fa-file-pdf"></i> Visualizar tabela 2025 nesta página <i class="fa-solid fa-chevron-down"></i></summary>
                <iframe class="fee-preview" src="<?= htmlspecialchars($table['url'], ENT_QUOTES, 'UTF-8') ?>" title="<?= htmlspecialchars($table['badge'] . ' - ' . $table['title'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy"></iframe>
            </details>
        </div>

        <?php if ($table['update']): ?>
            <div class="fee-update-card">
                <div class="fee-update-icon" aria-hidden="true"><i class="fa-solid fa-scale-balanced"></i></div>
                <div>
                    <strong>Tabela Complementar de 2026 (Lei Estadual nº 8.212/2026)</strong>
                    <p>A Lei Estadual nº 8.212, de 28 de abril de 2026, <strong>complementa a Tabela Base de 2025</strong> acrescentando novas faixas para atos superiores a R$ 1.055.700,00. As duas tabelas operam em conjunto.</p>
                </div>
                <a href="<?= htmlspecialchars($update2026Url, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" class="btn-resource">
                    Consultar Lei 2026 <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </div>
        <?php endif; ?>
        <?php if ($specialty === 'ri'): ?>
            <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 16px;">
                <a href="#tabela-unificada-ri" class="btn-resource"><i class="fa-solid fa-table-list"></i> Consultar Tabela Unificada de Faixas (R$ 0,01 a R$ 50M)</a>
            </div>
        <?php endif; ?>
        <p class="resource-note"><i class="fa-solid fa-circle-info"></i> Consulte a tabela correspondente à atribuição. Para atos de até R$ 1.055.700,00, aplica-se a Tabela de 2025; valores superiores utilizam o complemento de 2026.</p>
    </section>
    <?php
}

function renderRiUnifiedRanges(): void
{
    static $rendered = false;
    if ($rendered) {
        return;
    }
    $rendered = true;

    $rows2025 = [
        ['R$ 0,01 a R$ 17.595,00', 'R$ 486,20', 'R$ 24,31', 'R$ 48,62', 'R$ 72,93', 'R$ 4,00', 'R$ 10,00', 'R$ 646,06'],
        ['R$ 17.595,01 a R$ 35.190,00', 'R$ 749,41', 'R$ 37,47', 'R$ 74,94', 'R$ 112,41', 'R$ 4,00', 'R$ 10,00', 'R$ 988,23'],
        ['R$ 35.190,01 a R$ 58.650,00', 'R$ 931,10', 'R$ 46,55', 'R$ 93,11', 'R$ 139,66', 'R$ 4,00', 'R$ 10,00', 'R$ 1.224,42'],
        ['R$ 58.650,01 a R$ 117.300,00', 'R$ 1.221,89', 'R$ 61,09', 'R$ 122,19', 'R$ 183,28', 'R$ 5,00', 'R$ 10,00', 'R$ 1.603,45'],
        ['R$ 117.300,01 a R$ 234.600,00', 'R$ 2.138,41', 'R$ 106,92', 'R$ 213,84', 'R$ 320,76', 'R$ 5,00', 'R$ 10,00', 'R$ 2.794,93'],
        ['R$ 234.600,01 a R$ 351.900,00', 'R$ 3.536,48', 'R$ 176,82', 'R$ 353,65', 'R$ 530,47', 'R$ 5,00', 'R$ 10,00', 'R$ 4.612,42'],
        ['R$ 351.900,01 a R$ 469.200,00', 'R$ 5.510,24', 'R$ 275,51', 'R$ 551,02', 'R$ 826,54', 'R$ 10,00', 'R$ 10,00', 'R$ 7.183,31'],
        ['R$ 469.200,01 a R$ 586.500,00', 'R$ 7.024,37', 'R$ 351,22', 'R$ 702,44', 'R$ 1.053,66', 'R$ 10,00', 'R$ 10,00', 'R$ 9.151,69'],
        ['R$ 586.500,01 a R$ 703.800,00', 'R$ 8.619,17', 'R$ 430,96', 'R$ 861,92', 'R$ 1.292,88', 'R$ 10,00', 'R$ 10,00', 'R$ 11.224,93'],
        ['R$ 703.800,01 a R$ 821.100,00', 'R$ 8.882,41', 'R$ 444,12', 'R$ 888,24', 'R$ 1.332,36', 'R$ 20,00', 'R$ 10,00', 'R$ 11.577,13'],
        ['R$ 821.100,01 a R$ 938.400,00', 'R$ 9.972,57', 'R$ 498,63', 'R$ 997,26', 'R$ 1.495,89', 'R$ 20,00', 'R$ 10,00', 'R$ 12.994,35'],
        ['R$ 938.400,01 a R$ 1.055.700,00', 'R$ 11.749,09', 'R$ 587,45', 'R$ 1.174,91', 'R$ 1.762,36', 'R$ 20,00', 'R$ 10,00', 'R$ 15.303,81'],
    ];

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

    $fixedActs = [
        ['Registro e Averbação sem valor declarado ou arbitrado', 'R$ 306,20', 'R$ 15,31', 'R$ 30,62', 'R$ 45,93', 'R$ 3,00', '—', 'R$ 401,06'],
        ['Registro de loteamento rural (por gleba lote)', 'R$ 158,80', 'R$ 7,94', 'R$ 15,88', 'R$ 23,82', 'R$ 3,00', '—', 'R$ 209,44'],
        ['Registro de loteamento urbano (por lote)', 'R$ 201,71', 'R$ 10,09', 'R$ 20,17', 'R$ 30,26', 'R$ 3,00', '—', 'R$ 265,23'],
        ['Certidão negativa / positiva de propriedade ou de ônus', 'R$ 53,63', 'R$ 2,68', 'R$ 5,36', 'R$ 8,04', 'R$ 2,00', '—', 'R$ 71,71'],
        ['Certidão de cadeia sucessória', 'R$ 53,63', 'R$ 2,68', 'R$ 5,36', 'R$ 8,04', 'R$ 2,00', '—', 'R$ 71,71'],
        ['Certidão de inteiro teor (por folha)', 'R$ 95,55', 'R$ 4,78', 'R$ 9,56', 'R$ 14,33', 'R$ 3,00', '—', 'R$ 127,22'],
        ['Convenção de condomínio (pela convenção)', 'R$ 950,00', 'R$ 47,50', 'R$ 95,00', 'R$ 142,50', 'R$ 4,00', '—', 'R$ 1.239,00'],
        ['Convenção de condomínio (por cada unidade integrante)', 'R$ 200,71', 'R$ 10,04', 'R$ 20,07', 'R$ 30,11', 'R$ 3,00', '—', 'R$ 263,93'],
        ['Constituição ou incorporação de condomínio (por unidade)', 'R$ 580,78', 'R$ 29,04', 'R$ 58,08', 'R$ 87,12', 'R$ 3,00', '—', 'R$ 758,02'],
        ['Baixa de hipoteca, penhora, cédula, pacto comissório e outros', 'R$ 630,78', 'R$ 31,54', 'R$ 63,08', 'R$ 94,62', 'R$ 3,00', '—', 'R$ 823,02'],
        ['Subdivisão e remembramento (por lote)', 'R$ 958,41', 'R$ 47,92', 'R$ 95,84', 'R$ 143,76', 'R$ 4,00', '—', 'R$ 1.249,93'],
        ['Prenotação de títulos (a requerimento do interessado)', 'R$ 263,13', 'R$ 13,16', 'R$ 26,31', 'R$ 39,47', 'R$ 3,00', '—', 'R$ 345,07'],
    ];
    ?>
    <section class="resource-section resource-panel" id="tabela-unificada-ri" aria-labelledby="unified-ri-ranges-title">
        <div class="resource-heading">
            <div>
                <span class="resource-kicker">Tabela Unificada de Emolumentos</span>
                <h2 id="unified-ri-ranges-title">Tabela Geral de Faixas de Valores — Registro de Imóveis (2025/2026)</h2>
                <p>Tabela contínua de valores do Registro de Imóveis: integração das faixas base de 2025 (de R$ 0,01 até R$ 1.055.700,00) com as faixas complementares da Lei Estadual nº 8.212/2026 (acima de R$ 1.055.700,00 até R$ 50.000.000,00).</p>
            </div>
            <span class="specialty-badge">2025 + Lei 8.212/2026</span>
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
                    <tr class="table-group-header">
                        <th colspan="8">
                            <i class="fa-solid fa-calendar-check"></i> Faixas da Tabela Base 2025 (Atos de R$ 0,01 até R$ 1.055.700,00)
                            <span class="badge-table-tag badge-table-2025">Tabela Base 2025</span>
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
                            <i class="fa-solid fa-scale-balanced"></i> Faixas Complementares 2026 — Lei Estadual nº 8.212/2026 (Atos acima de R$ 1.055.700,00 até R$ 50.000.000,00)
                            <span class="badge-table-tag badge-table-2026">Complemento Lei 8.212/2026</span>
                        </th>
                    </tr>
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

        <details class="checklist-card" style="margin-top: 18px;">
            <summary>
                <span><i class="fa-solid fa-list-check"></i> Demais Atos Fixos do Registro de Imóveis (Tabela Base 2025)</span>
                <i class="fa-solid fa-chevron-down checklist-arrow" aria-hidden="true"></i>
            </summary>
            <div class="fees-table-wrap" style="margin-top: 10px;">
                <table class="fees-table">
                    <thead>
                        <tr>
                            <th>Ato Registral</th>
                            <th>Emolumento</th>
                            <th>ISS (5%)</th>
                            <th>FIG-RCPN</th>
                            <th>Funjeam</th>
                            <th>Selo</th>
                            <th>Computação</th>
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
        </details>

        <p class="resource-note"><i class="fa-solid fa-circle-info"></i> <strong>Aplicação conjunta:</strong> Atos de valor até R$ 1.055.700,00 são calculados com base na Tabela Oficial de 2025. Atos com valores superiores aplicam o escalonamento instituído pela Lei Estadual nº 8.212/2026.</p>
    </section>
    <?php
}

function renderRiBaseRanges(): void
{
    renderRiUnifiedRanges();
}

function renderRiHighValueRanges(): void
{
    renderRiUnifiedRanges();
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
                <span class="resource-kicker">Orientações por serviço</span>
                <h2 id="document-downloads-title">Documentos necessários</h2>
                <p>Baixe o modelo de requerimento ou checklist correspondente ao seu caso. Os arquivos estão disponíveis para download imediato.</p>
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
