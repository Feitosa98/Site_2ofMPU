<?php
// system/api/login.php
header('Content-Type: application/json');
require_once '../security.php';
startSecureSession();
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
    exit;
}

requireCsrf();

try {
    $conn = getDBConnection();

    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $ipRateScope = 'login-ip:' . clientIp();
    $rateScope = 'login-account:' . clientIp() . ':' . strtolower(trim($email));
    enforceRateLimit($ipRateScope, 20, 900);
    enforceRateLimit($rateScope, 5, 900);

    if (empty($email) || empty($senha)) {
        throw new Exception("Email e senha são obrigatórios.");
    }

    $stmt = $conn->prepare("SELECT id, nome, email, senha, nivel, ativo FROM usuarios WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($senha, $user['senha'])) {
        if (!$user['ativo']) {
            throw new Exception("Usuário desativado. Contate o administrador.");
        }

        // Login sucesso
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nome'] = $user['nome'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_level'] = $user['nivel'];
        resetRateLimit($ipRateScope);
        resetRateLimit($rateScope);

        echo json_encode([
            'sucesso' => true,
            'mensagem' => 'Login realizado com sucesso!',
            'redirect' => '../admin/dashboard' // Redireciona para o dashboard
        ]);
    } else {
        // Caso as credenciais não batam
        throw new Exception("Email ou senha incorretos.");
    }

} catch (Exception $e) {
    http_response_code(401);
    echo json_encode([
        'sucesso' => false,
        'erro' => publicExceptionMessage($e)
    ]);
}
?>
