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
$id = $data['id'] ?? '';
$nome = $data['nome'] ?? '';
$email = $data['email'] ?? '';
$nivel = $data['nivel'] ?? '';

if (empty($id) || empty($nome) || empty($email) || empty($nivel)) {
    echo json_encode(['sucesso' => false, 'erro' => 'Todos os campos são obrigatórios.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !in_array($nivel, ['admin', 'supervisor', 'colaborador'], true)) {
    echo json_encode(['sucesso' => false, 'erro' => 'Dados inválidos.']);
    exit;
}

try {
    $pdo = getDBConnection();

    if ($_SESSION['user_level'] === 'supervisor') {
        if ($id != $_SESSION['user_id']) {
            $chk = $pdo->prepare("SELECT nivel FROM usuarios WHERE id = ?");
            $chk->execute([$id]);
            $target = $chk->fetch();
            if (!$target || $target['nivel'] !== 'colaborador') {
                 echo json_encode(['sucesso' => false, 'erro' => 'Acesso negado. Você só pode editar colaboradores.']);
                 exit;
            }
        }
        $chk = $pdo->prepare("SELECT nivel FROM usuarios WHERE id = ?");
        $chk->execute([$id]);
        $nivel = $chk->fetchColumn(); 
    }

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
    $stmt->execute([$email, $id]);
    if ($stmt->fetch()) {
        echo json_encode(['sucesso' => false, 'erro' => 'Este e-mail já está sendo usado.']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, nivel = ? WHERE id = ?");
    $stmt->execute([$nome, $email, $nivel, $id]);
    
    echo json_encode(['sucesso' => true, 'mensagem' => 'Usuário atualizado com sucesso!']);
} catch (Exception $e) {
    echo json_encode(['sucesso' => false, 'erro' => 'Erro interno do servidor.']);
}
?>
