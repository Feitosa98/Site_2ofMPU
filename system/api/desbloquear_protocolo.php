<?php
// system/api/desbloquear_protocolo.php
header('Content-Type: application/json');
require_once '../auth.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

try {
    checkLogin();
    $conn = getDBConnection();
    $userId = $_SESSION['user_id'];
    $userLevel = $_SESSION['user_level'];

    $id = $_POST['id'] ?? null;
    if (!$id)
        throw new Exception("ID inválido");

    // Lógica para desbloquear
    // Colaborador só desbloqueia se for dele.
    // Admin desbloqueia de qualquer um.

    $sql = "UPDATE solicitacoes SET bloqueado_por_id = NULL, bloqueado_em = NULL WHERE id = ?";
    $params = [$id];

    if ($userLevel === 'colaborador') {
        $sql .= " AND bloqueado_por_id = ?";
        $params[] = $userId;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    echo json_encode(['sucesso' => true]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'erro' => $e->getMessage()]);
}
?>