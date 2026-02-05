<?php
// system/api/criar_solicitacao.php
header('Content-Type: application/json');
require_once '../config.php';
require_once '../utils/protocolo.php';

// Habilitar CORS se necessário (para testes locais com portas diferentes)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
    exit;
}

try {
    $conn = getDBConnection();

    // 1. Receber e validar dados
    $nome = $_POST['nome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $servicoNome = $_POST['servico'] ?? ''; // O formulário envia o nome, não ID. Precisamos ajustar isso ou buscar o ID.
    $observacoes = $_POST['observacoes'] ?? '';

    // Validação básica
    if (empty($nome) || empty($cpf) || empty($email) || empty($servicoNome)) {
        throw new Exception("Preencha todos os campos obrigatórios.");
    }

    // 2. Buscar ID do serviço pelo nome (simples) ou criar se não existir (opcional, melhor buscar)
    $stmt = $conn->prepare("SELECT id FROM servicos WHERE nome = ? LIMIT 1");
    $stmt->execute([$servicoNome]);
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

    // 4. Inserir no Banco
    $sql = "INSERT INTO solicitacoes (protocolo, senha_acesso, cliente_nome, cliente_cpf, cliente_email, cliente_telefone, servico_id, observacoes_cliente, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pendente')";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $protocolo,
        $senha,
        $nome,
        $cpf,
        $email,
        $telefone,
        $servico_id,
        $observacoes
    ]);

    $solicitacaoId = $conn->lastInsertId();

    // 5. Registrar no histórico
    $sqlHist = "INSERT INTO historico_movimentacoes (solicitacao_id, descricao) VALUES (?, ?)";
    $conn->prepare($sqlHist)->execute([$solicitacaoId, "Solicitação criada pelo cliente via site."]);

    // 6. Processar Anexos (Se houver)
    // TODO: Implementar upload de arquivos aqui

    // 7. Enviar Email (Simulado por enquanto, implementar mailer.php depois)
    // TODO: Chamar função enviarEmailConfirmacao($email, $protocolo, $senha);

    // 8. Retornar Sucesso
    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Solicitação criada com sucesso!',
        'dados' => [
            'protocolo' => $protocolo,
            'senha' => $senha
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400); // Bad Request
    echo json_encode([
        'sucesso' => false,
        'erro' => $e->getMessage()
    ]);
}
?>