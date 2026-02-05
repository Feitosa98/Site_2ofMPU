<?php
// system/api/atualizar_status.php
header('Content-Type: application/json');
require_once '../auth.php';

try {
    checkLogin();
    $conn = getDBConnection();
    $userId = $_SESSION['user_id'];

    $id = $_POST['id'] ?? null;
    $novoStatus = $_POST['status'] ?? null;
    $observacao = $_POST['observacao'] ?? '';

    if (!$id || !$novoStatus)
        throw new Exception("Dados inválidos");

    // Atualizar Status e possivelmente atribuir colaborador se tiver 'livre'
    $sql = "UPDATE solicitacoes SET status = ?, colaborador_id = COALESCE(colaborador_id, ?) WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$novoStatus, $userId, $id]);

    // Gravar Histórico
    $msgHistorico = "Status alterado para " . strtoupper(str_replace('_', ' ', $novoStatus));
    if (!empty($observacao)) {
        $msgHistorico .= ". Obs: " . $observacao;
    }

    $hist = $conn->prepare("INSERT INTO historico_movimentacoes (solicitacao_id, usuario_id, descricao) VALUES (?, ?, ?)");
    $hist->execute([$id, $userId, $msgHistorico]);

    echo json_encode(['sucesso' => true]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'erro' => $e->getMessage()]);
}
?>