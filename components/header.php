<?php
require_once __DIR__ . '/../system/security.php';
startSecureSession();
$page_title = $page_title ?? "Cartório 2º Ofício de Manacapuru - AM";
$page_desc = $page_desc ?? "Site oficial do Cartório 2º Ofício de Manacapuru. Registro de Imóveis, Títulos e Documentos e Pessoas Jurídicas.";
$is_home = $is_home ?? false;
$base_url = "https://registromanacapuru.com.br";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_desc) ?>">
    
    <!-- Open Graph SEO Tags -->
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>" />
    <meta property="og:description" content="<?= htmlspecialchars($page_desc) ?>" />
    <meta property="og:image" content="<?= $base_url ?>/images/logo.png" />
    <meta property="og:type" content="website" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    <?= $extra_css ?? '' ?>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/logo.png">
    <link rel="shortcut icon" type="image/png" href="images/logo.png">
    
    <?php if (isset($inline_css)): ?>
    <style>
        <?= $inline_css ?>
    </style>
    <?php endif; ?>
    <!-- Form Automations -->
    <script src="https://unpkg.com/imask"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
        window.csrfHeaders = (headers = {}) => ({ ...headers, 'X-CSRF-Token': window.CSRF_TOKEN });
        window.escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, char => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;'
        })[char]);
    </script>
</head>

<body>
    <!-- Header/Nav -->
    <header class="site-header">
        <div class="container">
            <nav>
                <div class="logo">
                    <a href="/">
                        <img src="images/logo.png" alt="Cartório 2º Ofício Manacapuru" style="height: 60px;">
                    </a>
                </div>
                <ul class="nav-links">
                <?php if ($is_home): ?>
                    <li><a href="#inicio">Início</a></li>
                    <li><a href="#missao">Missão e Valores</a></li>
                    <li><a href="#servicos">Atribuições</a></li>
                    <li><a href="#contato">Contato</a></li>
                    <li><a href="#localizacao" class="btn">Localização</a></li>
                <?php else: ?>
                    <li><a href="/">Início</a></li>
                    <li><a href="imoveis">Imóveis</a></li>
                    <li><a href="rcpn">Registro Civil</a></li>
                    <li><a href="rtdpj">RTD / PJ</a></li>
                    <li><a href="certidoes">Certidões</a></li>
                    <li><a href="acompanhar">Acompanhar</a></li>
                    <li><a href="/#contato" class="btn">Fale Conosco</a></li>
                <?php endif; ?>
                </ul>
                <div class="mobile-toggle">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>
