<?php
// system/api/consultar_protocolo.php
header('Content-Type: application/json');

require_once '../config.php';
require_once '../security.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
    exit;
}

try {
    enforceRateLimit('protocol:' . clientIp(), 10, 600);
    $conn = getDBConnection();
    // Receber dados
    $protocolo = $_POST['protocolo'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Validação básica
    if (empty($protocolo) || empty($senha)) {
        throw new Exception("Informe o protocolo e a senha de acesso.");
    }
    if (!preg_match('/^[A-Z0-9-]{6,20}$/i', $protocolo) || !preg_match('/^\d{6}$/', $senha)) {
        throw new Exception("Protocolo ou senha incorreta.");
    }

    // Buscar solicitação
    $sql = "SELECT s.*, srv.nome as servico_nome, srv.descricao as servico_descricao
            FROM solicitacoes s
            LEFT JOIN servicos srv ON s.servico_id = srv.id
            WHERE s.protocolo = ? AND s.senha_acesso = ?";

    $params = [$protocolo, $senha];

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $solicitacao = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$solicitacao) {
        throw new Exception("Protocolo não encontrado ou senha incorreta.");
    }

    // Buscar histórico de movimentações
    $sqlHist = "SELECT * FROM historico_movimentacoes 
                WHERE solicitacao_id = ? 
                ORDER BY data_movimentacao DESC";
    $stmtHist = $conn->prepare($sqlHist);
    $stmtHist->execute([$solicitacao['id']]);
    $historico = $stmtHist->fetchAll(PDO::FETCH_ASSOC);

    // Formatar datas do histórico
    foreach ($historico as &$item) {
        $data = new DateTime($item['data_movimentacao']);
        $item['data_formatada'] = $data->format('d/m/Y \à\s H:i');
    }

    // Retornar dados
    echo json_encode([
        'sucesso' => true,
        'dados' => [
            'protocolo' => $solicitacao['protocolo'],
            'status' => $solicitacao['status'],
            'servico' => $solicitacao['servico_nome'],
            'cliente_nome' => $solicitacao['cliente_nome'],
            'data_criacao' => (new DateTime($solicitacao['criado_em']))->format('d/m/Y \à\s H:i'),
            'observacoes_cliente' => $solicitacao['observacoes_cliente'],
            'historico' => $historico
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'sucesso' => false,
        'erro' => publicExceptionMessage($e)
    ]);
}
?>
