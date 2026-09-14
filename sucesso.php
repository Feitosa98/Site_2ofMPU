<?php
require_once __DIR__ . '/system/security.php';
startSecureSession();
$resultado = $_SESSION['protocol_result'] ?? null;
unset($_SESSION['protocol_result']);
if (!is_array($resultado) || ($resultado['created_at'] ?? 0) < time() - 900) {
    header('Location: solicitar');
    exit;
}
$protocolo = (string)($resultado['protocolo'] ?? '');
$senha = (string)($resultado['senha'] ?? '');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitação Enviada - Cartório 2º Ofício</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="images/logo.png">
    <style>
        body {
            padding-top: 90px;
            background: #091524;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-container {
            max-width: 600px;
            background: #07274D;
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(242, 183, 5, 0.2);
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #34d399, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: scaleIn 0.5s ease 0.2s both;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }

            to {
                transform: scale(1);
            }
        }

        .success-icon i {
            font-size: 3rem;
            color: white;
        }

        h1 {
            color: var(--secondary);
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .subtitle {
            color: rgba(242, 183, 5, 0.75);
            font-size: 1.1rem;
            margin-bottom: 40px;
        }

        .info-box {
            background: rgba(242, 183, 5, 0.05);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border: 2px solid rgba(242, 183, 5, 0.25);
        }

        .info-item {
            margin-bottom: 20px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-size: 0.9rem;
            color: rgba(242, 183, 5, 0.7);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--secondary);
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
        }

        .alert-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: left;
        }

        .alert-box i {
            color: #f59e0b;
            margin-right: 10px;
        }

        .alert-box p {
            margin: 0;
            color: #92400e;
            font-size: 0.95rem;
        }

        .actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: var(--secondary);
            color: white;
            padding: 14px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-primary:hover {
            background: #c29d2f;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(242, 183, 5, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--secondary);
            padding: 14px 30px;
            border-radius: 50px;
            border: 2px solid var(--secondary);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-outline:hover {
            background: var(--secondary);
            color: #07274D;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <a href="index">
                        <img src="images/logo.png" alt="Cartório 2º Ofício" style="height: 50px;">
                    </a>
                </div>
                <ul class="nav-links">
                    <li><a href="index">Início</a></li>
                    <li><a href="https://ridigital.org.br/" target="_blank" rel="noopener noreferrer">RI Digital</a></li>
                    <li><a href="index#contato" class="btn">Fale Conosco</a></li>
                </ul>
                <div class="mobile-toggle">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>

    <div class="success-container">
        <div class="success-icon">
            <i class="fa-solid fa-check"></i>
        </div>

        <h1>Solicitação Enviada com Sucesso!</h1>
        <p class="subtitle">Sua solicitação foi recebida e está sendo processada.</p>

        <div class="info-box">
            <div class="info-item">
                <div class="info-label">Seu Protocolo</div>
                <div class="info-value" id="protocolo"><?= htmlspecialchars($protocolo, ENT_QUOTES, 'UTF-8') ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Senha de Acesso</div>
                <div class="info-value" id="senha"><?= htmlspecialchars($senha, ENT_QUOTES, 'UTF-8') ?></div>
            </div>
        </div>

            </div>
        </div>

        <div class="alert-box">
            <i class="fa-solid fa-info-circle"></i>
            <p><strong>Importante:</strong> Anote ou tire uma foto destes dados para eventual contato com a serventia.</p>
        </div>

        <div class="actions">
            <a href="acompanhar" class="btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i> Acompanhar Pedido
            </a>
            <a href="index" class="btn-outline">
                <i class="fa-solid fa-home"></i> Voltar ao Início
            </a>
        </div>
    </div>

    <script src="script.js" defer></script>
</body>
</html>
