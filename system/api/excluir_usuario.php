<?php
header('Content-Type: application/json');
require_once '../auth.php';
checkLevel(['admin', 'supervisor']);

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['sucesso' => false, 'erro' => 'Método inválido.']);
    exit;
}
requireCsrf();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', rtrim($uri, '/'));
$userIdFromUrl = end($parts);
$id = is_numeric($userIdFromUrl) ? $userIdFromUrl : ($_GET['id'] ?? null);

if (empty($id)) {
    echo json_encode(['sucesso' => false, 'erro' => 'ID do usuário não fornecido.']);
    exit;
}

if ($id == $_SESSION['user_id']) {
    echo json_encode(['sucesso' => false, 'erro' => 'Você não pode excluir sua própria conta!']);
    exit;
}

try {
    $pdo = getDBConnection();

    if ($_SESSION['user_level'] === 'supervisor') {
        $chk = $pdo->prepare("SELECT nivel FROM usuarios WHERE id = ?");
        $chk->execute([$id]);
        $target = $chk->fetch();
        if (!$target || $target['nivel'] !== 'colaborador') {
             echo json_encode(['sucesso' => false, 'erro' => 'Acesso negado. Você só pode apagar colaboradores.']);
             exit;
        }
    }
    
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['sucesso' => true, 'mensagem' => 'O usuário foi completamente removido do sistema.']);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => 'Usuário não encontrado ou já deletado.']);
    }
} catch (Exception $e) {
    echo json_encode(['sucesso' => false, 'erro' => 'Erro do servidor.']);
}
?>
