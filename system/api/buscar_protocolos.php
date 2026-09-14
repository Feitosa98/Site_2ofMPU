<?php
// system/api/buscar_protocolos.php
header('Content-Type: application/json');
require_once '../auth.php';

try {
    checkLogin();
    $conn = getDBConnection();

    // Filtros do Caçador
    $protocolo = $_GET['protocolo'] ?? '';
    $cpf = $_GET['cpf'] ?? '';
    $status = $_GET['status'] ?? '';
    $busca_livre = $_GET['busca_livre'] ?? ''; // Nome do Cliente ou Título

    // Montando a Query Dinamicamente
    $sql = "SELECT id, protocolo, cliente_nome, servico_id, status, criado_em, vencimento_em, titulo 
            FROM solicitacoes WHERE 1=1";
    $params = [];

    if (!empty($protocolo)) {
        $sql .= " AND protocolo = ?";
        $params[] = $protocolo;
    }
    
    if (!empty($cpf)) {
        // Limpar pontuação da string pra garantir busca pura
        $cpfLimpo = preg_replace('/[^0-9]/', '', $cpf);
        $sql .= " AND (cliente_cpf = ? OR cliente_cpf = ?)";
        $params[] = $cpf; // com mascara
        $params[] = $cpfLimpo; // sem mascara
    }

    if (!empty($status)) {
        $sql .= " AND status = ?";
        $params[] = $status;
    }

    if (!empty($busca_livre)) {
        $sql .= " AND (cliente_nome LIKE ? OR titulo LIKE ?)";
        $termo = '%' . $busca_livre . '%';
        $params[] = $termo;
        $params[] = $termo;
    }

    // Ordenar do mais novo pro mais velho
    $sql .= " ORDER BY criado_em DESC LIMIT 100"; // Limite de Segurança

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $resultados = $stmt->fetchAll();

    echo json_encode([
        'sucesso' => true,
        'quantidade' => count($resultados),
        'dados' => $resultados
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'erro' => publicExceptionMessage($e)]);
}
?>
