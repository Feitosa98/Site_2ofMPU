<?php
header('Content-Type: application/json');
require_once '../auth.php';
checkLevel(['admin', 'supervisor']);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['sucesso' => false, 'erro' => 'Método não permitido.']);
    exit;
}
requireCsrf();

$data = json_decode(file_get_contents("php://input"), true);
$nome = $data['nome'] ?? '';
$email = $data['email'] ?? '';
$nivel = $data['nivel'] ?? 'colaborador';
$senha_padrao = bin2hex(random_bytes(6));

if (empty($nome) || empty($email)) {
    echo json_encode(['sucesso' => false, 'erro' => 'Nome e e-mail são obrigatórios.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($nome) > 100) {
    echo json_encode(['sucesso' => false, 'erro' => 'Nome ou e-mail inválido.']);
    exit;
}
$niveisPermitidos = ['admin', 'supervisor', 'colaborador'];
if (!in_array($nivel, $niveisPermitidos, true)) {
    echo json_encode(['sucesso' => false, 'erro' => 'Nível de acesso inválido.']);
    exit;
}

// RBAC
if ($_SESSION['user_level'] === 'supervisor') {
    $nivel = 'colaborador';
}

try {
    $pdo = getDBConnection();
    
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(['sucesso' => false, 'erro' => 'Este e-mail já está em uso.']);
        exit;
    }

    $hash = password_hash($senha_padrao, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, nivel) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $email, $hash, $nivel]);
    
    echo json_encode(['sucesso' => true, 'mensagem' => 'Usuário criado. Entregue esta senha temporária por canal seguro: ' . $senha_padrao]);
} catch (Exception $e) {
    echo json_encode(['sucesso' => false, 'erro' => 'Erro interno do servidor.']);
}
?>
