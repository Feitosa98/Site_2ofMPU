<?php
header('Content-Type: application/json');
require_once '../auth.php';
checkLevel(['admin', 'supervisor']);

try {
    $pdo = getDBConnection();

    if ($_SESSION['user_level'] === 'admin') {
        $stmt = $pdo->query("SELECT id, nome, email, nivel, ativo FROM usuarios ORDER BY nome ASC");
        $stmt->execute();
    } else if ($_SESSION['user_level'] === 'supervisor') {
        $stmt = $pdo->prepare("SELECT id, nome, email, nivel, ativo FROM usuarios WHERE nivel = 'colaborador' OR id = ? ORDER BY nome ASC");
        $stmt->execute([$_SESSION['user_id']]);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => 'Colaboradores não têm acesso.']);
        exit;
    }

    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['sucesso' => true, 'usuarios' => $usuarios]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'erro' => 'Erro interno ao listar usuários.']);
}
?>
