<?php
// system/api/criar_solicitacao.php
header('Content-Type: application/json');
require_once '../utils/protocolo.php';
require_once '../utils/prazos.php';
require_once '../utils/mailer.php';
require_once '../utils/upload.php';
require_once '../security.php';
startSecureSession();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
    exit;
}

requireCsrf();
enforceRateLimit('request:' . clientIp(), 5, 3600);

try {
    $conn = getDBConnection();

    // 1. Receber e validar dados
    $titulo = trim($_POST['titulo'] ?? '');
    $nome = $_POST['nome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $servicoId = $_POST['servico'] ?? ''; // O formulário envia o ID numérico, não ID. Precisamos ajustar isso ou buscar o ID.
    $observacoes = $_POST['observacoes'] ?? '';

    // Validação básica
    if (empty($titulo) || empty($nome) || empty($cpf) || empty($email) || empty($telefone) || empty($servicoId)) {
        throw new Exception("Preencha todos os campos obrigatórios.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Informe um e-mail válido.");
    }
    if (mb_strlen($titulo) > 255 || mb_strlen($nome) > 100 || mb_strlen($observacoes) > 5000) {
        throw new Exception("Um dos campos excede o tamanho permitido.");
    }

    // 2. Buscar ID do serviço pelo nome (simples) ou criar se não existir (opcional, melhor buscar)
    $stmt = $conn->prepare("SELECT id FROM servicos WHERE id = ? AND ativo = 1 LIMIT 1");
    $stmt->execute([$servicoId]);
    $servico = $stmt->fetch();

    if (!$servico) {
        // Se não achar, pode ser um erro ou um serviço novo. Vamos pegar um genérico ou erro.
        // Para simplificar, vou assumir erro por enquanto.
        throw new Exception("Serviço inválido selecionado.");
    }
    $servico_id = $servico['id'];

    // 3. Gerar Protocolo e Senha
    $protocolo = gerarProtocolo();
    $senha = gerarSenha();

    // 3.5 Calcula Prazos Vencimento Úteis
    $agora = date("Y-m-d H:i:s");
    $vencimento_em = calcularDiasUteis($agora, 20);

    // 4. Inserir no Banco
    $sql = "INSERT INTO solicitacoes (titulo, protocolo, senha_acesso, cliente_nome, cliente_cpf, cliente_email, cliente_telefone, servico_id, observacoes_cliente, status, vencimento_em) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pendente', ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $titulo,
        $protocolo,
        $senha,
        $nome,
        $cpf,
        $email,
        $telefone,
        $servico_id,
        $observacoes,
        $vencimento_em
    ]);

    $solicitacaoId = $conn->lastInsertId();

    // 5. Registrar no histórico
    $sqlHist = "INSERT INTO historico_movimentacoes (solicitacao_id, descricao) VALUES (?, ?)";
    $conn->prepare($sqlHist)->execute([$solicitacaoId, "Solicitação criada pelo cliente via site."]);

    // 6. Processar Anexos Ocultos de Documentação Legal (se houver)
    if(isset($_FILES['anexos'])) {
        processarUploads($_FILES['anexos'], $solicitacaoId, $conn);
    }

    // 7. Enviar Emails Reais Multicanais
    // A) Enviar Recibo ao Cidadão (Público)
    enviarEmailClienteProtocolo($email, $nome, $protocolo, $senha, $vencimento_em);
    
    // B) Disparo Geral CCO Equipe (Alerta Banco)
    $dados_alerta = [
        'origem' => 'web',
        'protocolo' => $protocolo,
        'nome' => $nome,
        'telefone' => $telefone,
        'vencimento' => $vencimento_em
    ];
    enviarAlertaEquipe($conn, $dados_alerta);

    $_SESSION['protocol_result'] = [
        'protocolo' => $protocolo,
        'senha' => $senha,
        'created_at' => time(),
    ];

    // 8. Retornar Sucesso sem expor a senha na URL ou no armazenamento local.
    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Solicitação criada com sucesso!',
        'redirect' => 'sucesso'
    ]);

} catch (Exception $e) {
    http_response_code(400); // Bad Request
    echo json_encode([
        'sucesso' => false,
        'erro' => publicExceptionMessage($e)
    ]);
}
?>
