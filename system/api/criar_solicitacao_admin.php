<?php
// system/api/criar_solicitacao_admin.php
header('Content-Type: application/json');
require_once '../auth.php';
require_once '../utils/prazos.php';
require_once '../utils/mailer.php';
require_once '../utils/upload.php';

checkLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
    exit;
}

requireCsrf();

try {
    $conn = getDBConnection();

    // 1. Receber dados
    $nome = $_POST['nome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $servicoId = $_POST['servico'] ?? ''; 
    $titulo = $_POST['titulo'] ?? ''; 
    $protocolo = $_POST['protocolo'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Validação
    if (empty($nome) || empty($cpf) || empty($titulo) || empty($servicoId) || empty($protocolo) || empty($senha)) {
        throw new Exception("Preencha todos os campos obrigatórios (inclusive Título, Protocolo e Senha).");
    }
    if (!preg_match('/^[A-Z0-9-]{6,20}$/i', $protocolo) || !preg_match('/^\d{6}$/', $senha)) {
        throw new Exception("Protocolo ou senha em formato inválido.");
    }

    // Calcula Acordo de Nível de Serviço: 20 dias úteis saindo da data atual.
    $agora = date("Y-m-d H:i:s");
    $vencimento_em = calcularDiasUteis($agora, 20);

    // 4. Inserir no Banco
    $sql = "INSERT INTO solicitacoes (titulo, protocolo, senha_acesso, cliente_nome, cliente_cpf, cliente_telefone, cliente_email, servico_id, status, vencimento_em, colaborador_id) 
            VALUES (?, ?, ?, ?, ?, ?, '', ?, 'pendente', ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $titulo,
        $protocolo,
        $senha,
        $nome,
        $cpf,
        $telefone,
        $servicoId,
        $vencimento_em,
        $_SESSION['user_id'] // Colaborador que gerou
    ]);

    $solicitacaoId = $conn->lastInsertId();

    // 5. Registrar no histórico
    $sqlHist = "INSERT INTO historico_movimentacoes (solicitacao_id, usuario_id, descricao) VALUES (?, ?, ?)";
    $conn->prepare($sqlHist)->execute([$solicitacaoId, $_SESSION['user_id'], "Solicitação criada manualmente pela equipe interna. Prazo base de 20 Dias Úteis."]);

    // Registra Anexos se foi enviado lá do painel de Nova Solicitação
    if(isset($_FILES['anexos'])) { processarUploads($_FILES['anexos'], $solicitacaoId, $conn); }
    
    // 6. Emails
    $email = $_POST['email'] ?? '';
    // A) Cidadão (se o email foi coletado no painel)
    if (!empty($email)) {
        enviarEmailClienteProtocolo($email, $nome, $protocolo, $senha, $vencimento_em);
    }
    // B) Equipe em CCO
    $dados_alerta = [
        'origem' => 'admin',
        'protocolo' => $protocolo,
        'nome' => $nome,
        'telefone' => $telefone,
        'vencimento' => $vencimento_em
    ];
    enviarAlertaEquipe($conn, $dados_alerta);

    // Retornar Sucesso
    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Solicitação inserida com sucesso no Banco de Dados!',
        'dados' => [
            'protocolo' => $protocolo,
            'senha' => $senha,
            'vencimento' => $vencimento_em
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400); // Bad Request
    echo json_encode([
        'sucesso' => false,
        'erro' => publicExceptionMessage($e)
    ]);
}
?>
