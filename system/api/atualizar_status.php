<?php
// system/api/atualizar_status.php
header('Content-Type: application/json');
require_once '../auth.php';
require_once '../utils/prazos.php'; // Adiciona prazos

checkLogin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['sucesso' => false, 'erro' => 'Método não permitido.']);
    exit;
}
requireCsrf();

try {
    $conn = getDBConnection();
    $userId = $_SESSION['user_id'];
    $userName = $_SESSION['user_nome'] ?? 'Colaborador';

    $id = $_POST['id'] ?? null;
    $novoStatus = $_POST['status'] ?? null;
    $observacao = $_POST['observacao'] ?? '';
    
    // Novo parametro de confirmacao de aviso do cliente
    $clienteAvisado = $_POST['cliente_avisado'] ?? 'false';

    if (!$id || !$novoStatus)
        throw new Exception("Dados inválidos");

    $statusPermitidos = ['pendente', 'analise', 'em_andamento', 'aguardando_pagamento', 'concluido', 'retirada', 'cancelado'];
    if (!in_array($novoStatus, $statusPermitidos, true)) {
        throw new Exception("Status inválido.");
    }
    if (mb_strlen($observacao) > 2000) {
        throw new Exception("A observação excede o tamanho permitido.");
    }

    // Lógica VOTO DE CONTATO OBRIGATORIO
    if ($clienteAvisado !== 'true' && $novoStatus !== 'pendente') {
        throw new Exception("Você precisa confirmar que enviou o contato ao cliente antes de salvar esta modificação de protocolo.");
    }

    // Buscar status anterior para o Motor de SLA
    $stmtAntigo = $conn->prepare("SELECT status, vencimento_em, bloqueado_por_id FROM solicitacoes WHERE id = ?");
    $stmtAntigo->execute([$id]);
    $sol = $stmtAntigo->fetch();

    if(!$sol) throw new Exception("Solicitação não encontrada.");
    if ($_SESSION['user_level'] === 'colaborador' && !empty($sol['bloqueado_por_id']) && (int)$sol['bloqueado_por_id'] !== (int)$userId) {
        throw new Exception("Esta solicitação está sendo editada por outro usuário.");
    }
    $statusAntigo = $sol['status'];
    $vencimentoAtual = $sol['vencimento_em'];

    // MOTOR DE SLA QUEDA PRA 10 DIAS UTEIS
    $novoVencimento = $vencimentoAtual; // Mantem o antigo por padrão
    $recalculou = false;
    
    if ($statusAntigo === 'aguardando_pagamento' && $novoStatus === 'em_andamento') {
        // Recalcular prazos para mais 10 dias uteis com base em HOJE (inicio do servico registral real)
        $novoVencimento = calcularDiasUteis(date("Y-m-d H:i:s"), 10);
        $recalculou = true;
    }

    // Atualizar Status, Vencimento e possivelmente atribuir colaborador se tiver 'livre'
    $sql = "UPDATE solicitacoes SET status = ?, vencimento_em = ?, colaborador_id = COALESCE(colaborador_id, ?) WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$novoStatus, $novoVencimento, $userId, $id]);

    // Gravar Histórico de Movimentações (Auditoria)
    $msgHistorico = "Status alterado de [" . strtoupper(str_replace('_', ' ', $statusAntigo)) . "] para [" . strtoupper(str_replace('_', ' ', $novoStatus)) . "] por " . $userName . ". Cliente notificado sob responsabilidade operacional.";
    
    // Anexa mensagem de recálculo se o Motor SLA ativou
    if ($recalculou) {
        $msgHistorico .= " | ALERTA DO SISTEMA: O prazo do protocolo foi reduzido para a regra de registro final (10 Dias Úteis) vencendo em " . date('d/m/Y', strtotime($novoVencimento)) . ".";
    }

    if (!empty($observacao)) {
        $msgHistorico .= " | Obs do Operador: " . $observacao;
    }

    $hist = $conn->prepare("INSERT INTO historico_movimentacoes (solicitacao_id, usuario_id, descricao) VALUES (?, ?, ?)");
    $hist->execute([$id, $userId, $msgHistorico]);

    echo json_encode(['sucesso' => true]);

} catch (Exception $e) {
    http_response_code(400); // Bad Request for UI to catch and display properly
    echo json_encode(['sucesso' => false, 'erro' => publicExceptionMessage($e)]);
}
?>
