<?php
// system/utils/mailer.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . '/../libs/phpmailer/Exception.php';
require_once __DIR__ . '/../libs/phpmailer/PHPMailer.php';
require_once __DIR__ . '/../libs/phpmailer/SMTP.php';
require_once __DIR__ . '/../config.php';

function initMailer() {
    $mail = new PHPMailer(true);
    // Server settings
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL para porta 465 (Hostinger)
    $mail->Port       = SMTP_PORT; // 465
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom(SMTP_USER, SMTP_FROM);
    return $mail;
}

function montarTemplateHTML($titulo, $conteudo) {
    return "
    <html>
    <head>
        <style>
            body { font-family: 'Arial', sans-serif; background-color: #f4f6f9; color: #333; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
            .header { background-color: #091524; padding: 30px 20px; text-align: center; border-bottom: 3px solid #E6CE81; }
            .header h1 { color: #E6CE81; margin: 0; font-size: 24px; letter-spacing: 1px; }
            .content { padding: 30px; font-size: 16px; line-height: 1.6; }
            .content p { margin: 0 0 15px 0; }
            .highlight { background-color: #f8f9fa; border-left: 4px solid #E6CE81; padding: 15px; margin: 20px 0; border-radius: 4px; }
            .footer { background-color: #091524; color: #cbd5e1; padding: 20px; text-align: center; font-size: 13px; }
            .btn { display: inline-block; padding: 12px 25px; background-color: #E6CE81; color: #091524; text-decoration: none; font-weight: bold; border-radius: 5px; margin-top: 15px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>" . htmlspecialchars($titulo) . "</h1>
            </div>
            <div class='content'>
                " . $conteudo . "
            </div>
            <div class='footer'>
                Cartório 2º Ofício de Manacapuru/AM<br>
                Este é um e-mail automático, por favor não responda.
            </div>
        </div>
    </body>
    </html>
    ";
}

function enviarEmailClienteProtocolo($destinatario, $nome, $protocolo, $senha, $vencimento) {
    if(empty($destinatario)) return false;

    try {
        $mail = initMailer();
        $mail->addAddress($destinatario, $nome);
        $mail->isHTML(true);
        $mail->Subject = "Seu Pedido foi Registrado - Cartório 2º Ofício";

        $dataVenc = date('d/m/Y', strtotime($vencimento));
        
        $conteudo = "
            <p>Olá, <strong>" . htmlspecialchars($nome) . "</strong>,</p>
            <p>Sua solicitação de serviço foi recebida com sucesso e já está em nossa esteira de atendimento.</p>
            
            <div class='highlight'>
                <strong>Dados do seu Pedido:</strong><br><br>
                Protocolo de Acompanhamento: <strong style='font-size: 18px; color: #091524;'>" . $protocolo . "</strong><br>
                Senha de Acesso Secundária: <strong>" . $senha . "</strong><br>
                Prazo Máximo (SLA): <strong>" . $dataVenc . " (20 Dias Úteis)</strong>
            </div>

            <p>Você pode acompanhar o status completo da análise em tempo real acessando nossa central pelo botão abaixo:</p>
            <div style='text-align: center;'>
                <a href='" . BASE_URL . "acompanhar.php' class='btn'>Acompanhar meu Pedido</a>
            </div>
        ";

        $mail->Body = montarTemplateHTML("Confirmação de Solicitação", $conteudo);
        return $mail->send();
    } catch (Exception $e) {
        error_log("Erro no envio pro Cliente: " . $mail->ErrorInfo);
        return false;
    }
}

function enviarAlertaEquipe($conn, $dados) {
    try {
        // Buscar todos usuarios ativos
        $stmt = $conn->query("SELECT nome, email FROM usuarios WHERE ativo = 1");
        $equipe = $stmt->fetchAll();
        
        if (empty($equipe)) return false;

        $mail = initMailer();
        
        // Envia para o titular do SMTP so como remetente/destinatario dummy
        $mail->addAddress(SMTP_USER, 'Gestão do Cartório');

        // Adiciona toda a base ativa como CCO para privacidade ou recebimento em massa
        foreach($equipe as $user) {
            if(!empty($user['email'])) {
                $mail->addBCC($user['email'], $user['nome']);
            }
        }
        
        $mail->isHTML(true);
        $mail->Subject = "[ALERTA] Nova Entrada no Painel: " . $dados['protocolo'];

        $conteudo = "
            <p>Atenção Equipe,</p>
            <p>Uma nova solicitação foi cadastrada no sistema (" . ($dados['origem'] === 'admin' ? "Lançamento Manual" : "Solicitação Web") . ") e aguarda processamento e triagem.</p>
            
            <div class='highlight'>
                <strong>Resumo do Protocolo:</strong><br><br>
                Número: <strong>" . $dados['protocolo'] . "</strong><br>
                Cliente: <strong>" . $dados['nome'] . "</strong><br>
                Telefone/Contato: <strong>" . $dados['telefone'] . "</strong><br>
                Prazo de Entrega (SLA): <strong>" . date('d/m/Y', strtotime($dados['vencimento'])) . "</strong>
            </div>

            <div style='text-align: center;'>
                <a href='" . BASE_URL . "admin/' class='btn'>Acessar Painel Gerencial</a>
            </div>
        ";

        $mail->Body = montarTemplateHTML("Nova Solicitação Recebida", $conteudo);
        return $mail->send();

    } catch (Exception $e) {
        error_log("Erro no disparo de time CCO: " . $mail->ErrorInfo);
        return false;
    }
}
?>
