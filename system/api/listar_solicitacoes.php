<?php
// system/api/listar_solicitacoes.php
header('Content-Type: application/json');
require_once '../auth.php'; // Protege API, exige login

// Habilitar CORS para desenvolvimento
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

try {
    checkLogin(); // Garante que e usuario logado

    $conn = getDBConnection();
    $nivel = $_SESSION['user_level'] ?? 'colaborador';
    $userId = $_SESSION['user_id'];

    // Filtros
    $status = $_GET['status'] ?? '';
    $protocolo = $_GET['protocolo'] ?? '';

    $sql = "SELECT s.*, svc.nome as servico_nome, u.nome as colaborador_nome, 
            bloq.nome as bloqueado_por_nome
            FROM solicitacoes s
            JOIN servicos svc ON s.servico_id = svc.id
            LEFT JOIN usuarios u ON s.colaborador_id = u.id
            LEFT JOIN usuarios bloq ON s.bloqueado_por_id = bloq.id
            WHERE 1=1";

    $params = [];

    if (!empty($status)) {
        $sql .= " AND s.status = ?";
        $params[] = $status;
    }

    if (!empty($protocolo)) {
        $sql .= " AND s.protocolo LIKE ?";
        $params[] = "%$protocolo%";
    }

    // Se for colaborador, vê apenas as suas OU as não atribuídas (opcional, dependendo da regra de negócio)
    // Regra atual: Supervisor e Admin veem tudo. Colaborador vê tudo também para poder pegar tarefas?
    // Vamos deixar Colaborador ver tudo por enquanto para poder "pegar" tarefas livres.

    $sql .= " ORDER BY s.prioridade DESC, s.criado_em DESC LIMIT 50";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $solicitacoes = $stmt->fetchAll();

    // Formatar dados para o frontend
    foreach ($solicitacoes as &$sol) {
        // Verificar se está bloqueado (Locking)
        $isLocked = !empty($sol['bloqueado_por_id']);

        // Auto-unlock se passou muito tempo? (Ex: 30 min) - Pode ser implementado aqui ou no cron
        /*
        if ($isLocked && (strtotime($sol['bloqueado_em']) < strtotime('-30 minutes'))) {
             // Lógica de desbloqueio automático
             $isLocked = false;
             // Update DB...
        }
        */

        $sol['bloqueado'] = $isLocked;

        // Se travado por OUTRA pessoa
        $sol['bloqueado_para_mim'] = ($isLocked && $sol['bloqueado_por_id'] != $userId);

        // Pode acessar? (Se livre, se é quem travou, ou se é Admin/Supervisor)
        $sol['pode_acessar'] = (!$sol['bloqueado_para_mim'] || in_array($nivel, ['admin', 'supervisor']));
    }

    echo json_encode([
        'sucesso' => true,
        'solicitacoes' => $solicitacoes,
        'usuario_nivel' => $nivel
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'erro' => $e->getMessage()]);
}
?>