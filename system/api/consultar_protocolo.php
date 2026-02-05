<?php
// system/api/consultar_protocolo.php
header('Content-Type: application/json');
require_once '../config.php';

// Habilitar CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
    exit;
}

try {
    $conn = getDBConnection();

    // Receber dados
    $protocolo = $_POST['protocolo'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Validação básica
    if (empty($protocolo)) {
        throw new Exception("Informe o número do protocolo.");
    }

    // Buscar solicitação
    $sql = "SELECT s.*, srv.nome as servico_nome, srv.descricao as servico_descricao
            FROM solicitacoes s
            LEFT JOIN servicos srv ON s.servico_id = srv.id
            WHERE s.protocolo = ?";

    $params = [$protocolo];

    // Se senha foi fornecida, validar também
    if (!empty($senha)) {
        $sql .= " AND s.senha_acesso = ?";
        $params[] = $senha;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $solicitacao = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$solicitacao) {
        throw new Exception("Protocolo não encontrado ou senha incorreta.");
    }

    // Buscar histórico de movimentações
    $sqlHist = "SELECT * FROM historico_movimentacoes 
                WHERE solicitacao_id = ? 
                ORDER BY data_hora DESC";
    $stmtHist = $conn->prepare($sqlHist);
    $stmtHist->execute([$solicitacao['id']]);
    $historico = $stmtHist->fetchAll(PDO::FETCH_ASSOC);

    // Formatar datas do histórico
    foreach ($historico as &$item) {
        $data = new DateTime($item['data_hora']);
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
            'data_criacao' => (new DateTime($solicitacao['data_criacao']))->format('d/m/Y \à\s H:i'),
            'observacoes_cliente' => $solicitacao['observacoes_cliente'],
            'observacoes_internas' => $solicitacao['observacoes_internas'],
            'historico' => $historico
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'sucesso' => false,
        'erro' => $e->getMessage()
    ]);
}
?>