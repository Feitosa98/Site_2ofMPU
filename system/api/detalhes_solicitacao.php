<?php
// system/api/detalhes_solicitacao.php
header('Content-Type: application/json');
require_once '../auth.php';

// CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");

try {
    checkLogin();
    $conn = getDBConnection();
    $userId = $_SESSION['user_id'];
    $userLevel = $_SESSION['user_level'];

    $id = $_GET['id'] ?? null;
    $force = isset($_GET['force']) && $_GET['force'] === 'true'; // Para Admin forçar entrada

    if (!$id)
        throw new Exception("ID inválido");

    // 1. Buscar Informações e Status de Bloqueio
    $sql = "SELECT s.*, u.nome as bloqueado_por_nome 
            FROM solicitacoes s 
            LEFT JOIN usuarios u ON s.bloqueado_por_id = u.id 
            WHERE s.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $solicitacao = $stmt->fetch();

    if (!$solicitacao)
        throw new Exception("Solicitação não encontrada");

    // 2. Verificar Bloqueio
    if ($solicitacao['bloqueado_por_id'] && $solicitacao['bloqueado_por_id'] != $userId) {
        // Está bloqueado por outra pessoa
        if ($userLevel === 'colaborador') {
            // Colaborador é barrado
            echo json_encode([
                'sucesso' => false,
                'erro' => 'bloqueado',
                'mensagem' => "Protocolo em uso por " . $solicitacao['bloqueado_por_nome'],
                'bloqueado_por' => $solicitacao['bloqueado_por_nome']
            ]);
            exit;
        } else {
            // Admin/Supervisor: Só entra se passar flag force=true, senão avisa
            if (!$force) {
                echo json_encode([
                    'sucesso' => false,
                    'erro' => 'aviso_bloqueio',
                    'mensagem' => "ATENÇÃO: Este protocolo está sendo editado por " . $solicitacao['bloqueado_por_nome'] . ". Deseja forçar o acesso?",
                    'bloqueado_por' => $solicitacao['bloqueado_por_nome']
                ]);
                exit;
            }
            // Se force=true, continua para lockar para si mesmo (roubar lock)
        }
    }

    // 3. Bloquear para o usuário atual (Locking)
    // Atualiza timestamp também para saber timeout
    $updateLock = $conn->prepare("UPDATE solicitacoes SET bloqueado_por_id = ?, bloqueado_em = NOW() WHERE id = ?");
    $updateLock->execute([$userId, $id]);

    // 4. Buscar Detalhes Completos (com nomes de serviços, etc)
    // Re-query para garantir dados atualizados ou usar o array já buscado se for suficiente
    // Vamos buscar anexos e histórico também

    // Histórico
    $stmtHist = $conn->prepare("SELECT h.*, u.nome as usuario_nome 
                               FROM historico_movimentacoes h 
                               LEFT JOIN usuarios u ON h.usuario_id = u.id 
                               WHERE h.solicitacao_id = ? 
                               ORDER BY h.criado_em DESC"); // Oops, schema db usa data_movimentacao ou criado_em? Verifiquei schema: data_movimentacao
    // Correção: schema usa data_movimentacao
    $stmtHist = $conn->prepare("SELECT h.*, u.nome as usuario_nome 
                               FROM historico_movimentacoes h 
                               LEFT JOIN usuarios u ON h.usuario_id = u.id 
                               WHERE h.solicitacao_id = ? 
                               ORDER BY h.data_movimentacao DESC");
    $stmtHist->execute([$id]);
    $historico = $stmtHist->fetchAll();

    echo json_encode([
        'sucesso' => true,
        'solicitacao' => $solicitacao,
        'historico' => $historico,
        'usuario_nivel' => $userLevel
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'erro' => $e->getMessage()]);
}
?>