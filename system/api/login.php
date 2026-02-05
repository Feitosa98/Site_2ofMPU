<?php
// system/api/login.php
header('Content-Type: application/json');
session_start();
require_once '../config.php';

// Habilitar CORS para desenvolvimento
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
    exit;
}

try {
    $conn = getDBConnection();

    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

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
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nome'] = $user['nome'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_level'] = $user['nivel'];

        echo json_encode([
            'sucesso' => true,
            'mensagem' => 'Login realizado com sucesso!',
            'redirect' => BASE_URL . 'admin/dashboard.html' // Redireciona para o dashboard
        ]);
    } else {
        // Para segurança, não especificar se é email ou senha incorretos
        // Mas para debug inicial pode ajudar
        // throw new Exception("Credenciais inválidas."); 

        // Simular hash temporário para admin temporário (apenas para primeiro acesso se banco estiver com hash placeholder)
        // REMOVER ISSO EM PRODUÇÃO
        if ($senha === 'admin123' && substr($user['senha'], 0, 1) === '$' && password_verify('admin123', $user['senha']) == false) {
            // Fallback para senha padrão nao hashada se eu tivesse inserido texto plano, mas inseri hash placeholder.
            // Como inseri '$2y$10$YourHashedPasswordHere', a senha 'admin123' não vai bater.
            // Vou precisar criar um script para gerar o hash correto ou atualizar o banco agora.
        }

        throw new Exception("Email ou senha incorretos.");
    }

} catch (Exception $e) {
    http_response_code(401);
    echo json_encode([
        'sucesso' => false,
        'erro' => $e->getMessage()
    ]);
}
?>