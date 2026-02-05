-- Arquivo de Seed (Dados de Teste) - Cartório 2º Ofício
-- Importe este arquivo APÓS o database.sql para ter dados para testar

-- Garantindo usuários (caso não existam ou para referência de IDs)
-- ID 1: Admin, ID 2: Supervisor, ID 3: Colaborador

-- 1. Solicitação Pendente (Recém chegada)
INSERT INTO `solicitacoes` (`protocolo`, `senha_acesso`, `cliente_nome`, `cliente_cpf`, `cliente_email`, `cliente_telefone`, `servico_id`, `status`, `prioridade`, `observacoes_cliente`, `criado_em`) 
VALUES 
('CART2024A1B2', '123456', 'João da Silva', '123.456.789-00', 'joao@email.com', '(92) 99123-4567', 1, 'pendente', 'normal', 'Preciso da segunda via da certidão de nascimento do meu filho.', NOW());

INSERT INTO `historico_movimentacoes` (`solicitacao_id`, `descricao`, `data_movimentacao`)
VALUES (LAST_INSERT_ID(), 'Solicitação criada pelo cliente via site.', NOW());


-- 2. Solicitação Em Análise (Urgente)
INSERT INTO `solicitacoes` (`protocolo`, `senha_acesso`, `cliente_nome`, `cliente_cpf`, `cliente_email`, `cliente_telefone`, `servico_id`, `status`, `prioridade`, `observacoes_cliente`, `criado_em`) 
VALUES 
('CART2024U9X1', '654321', 'Maria Oliveira', '987.654.321-11', 'maria@email.com', '(92) 98111-2222', 6, 'analise', 'urgente', 'Tenho urgência para financiamento bancário.', DATE_SUB(NOW(), INTERVAL 1 DAY));

SET @id_sol2 = LAST_INSERT_ID();
INSERT INTO `historico_movimentacoes` (`solicitacao_id`, `descricao`, `data_movimentacao`) VALUES 
(@id_sol2, 'Solicitação criada pelo cliente.', DATE_SUB(NOW(), INTERVAL 1 DAY)),
(@id_sol2, 'Status alterado para EM ANÁLISE por Supervisor.', NOW());


-- 3. Solicitação Em Andamento (Atribuída ao Colaborador ID 3)
INSERT INTO `solicitacoes` (`protocolo`, `senha_acesso`, `cliente_nome`, `cliente_cpf`, `cliente_email`, `cliente_telefone`, `servico_id`, `status`, `colaborador_id`, `observacoes_cliente`, `criado_em`) 
VALUES 
('CART2024M5K8', '112233', 'Construtora Norte Ltda', '12.345.678/0001-90', 'contato@norte.com.br', '(92) 3333-4444', 12, 'em_andamento', 3, 'Registro de atas de assembleia.', DATE_SUB(NOW(), INTERVAL 2 DAY));

SET @id_sol3 = LAST_INSERT_ID();
INSERT INTO `historico_movimentacoes` (`solicitacao_id`, `usuario_id`, `descricao`, `data_movimentacao`) VALUES 
(@id_sol3, NULL, 'Solicitação criada.', DATE_SUB(NOW(), INTERVAL 2 DAY)),
(@id_sol3, 2, 'Atribuído ao Colaborador.', DATE_SUB(NOW(), INTERVAL 1 DAY)),
(@id_sol3, 3, 'Iniciando análise dos documentos.', NOW());


-- 4. Solicitação BLOQUEADA (Simulando que o Colaborador está mexendo AGORA)
-- Para testar o Lock: Se você logar como Admin, vai ver o cadeado.
INSERT INTO `solicitacoes` (`protocolo`, `senha_acesso`, `cliente_nome`, `cliente_cpf`, `cliente_email`, `cliente_telefone`, `servico_id`, `status`, `colaborador_id`, `bloqueado_por_id`, `bloqueado_em`, `observacoes_cliente`, `criado_em`) 
VALUES 
('CART2024LOCK', '999888', 'Pedro Sampaio', '555.444.333-22', 'pedro@email.com', '(92) 99999-8888', 2, 'em_andamento', 3, 3, NOW(), 'Certidão de casamento com averbação de divórcio.', DATE_SUB(NOW(), INTERVAL 3 HOUR));

SET @id_sol4 = LAST_INSERT_ID();
INSERT INTO `historico_movimentacoes` (`solicitacao_id`, `descricao`) VALUES (@id_sol4, 'Solicitação criada.');


-- 5. Solicitação Concluída
INSERT INTO `solicitacoes` (`protocolo`, `senha_acesso`, `cliente_nome`, `cliente_cpf`, `cliente_email`, `cliente_telefone`, `servico_id`, `status`, `colaborador_id`, `criado_em`) 
VALUES 
('CART2024FIN1', '777777', 'Ana Beatriz', '111.222.333-44', 'ana@email.com', '(92) 98888-7777', 3, 'concluido', 3, DATE_SUB(NOW(), INTERVAL 5 DAY));

SET @id_sol5 = LAST_INSERT_ID();
INSERT INTO `historico_movimentacoes` (`solicitacao_id`, `usuario_id`, `descricao`, `data_movimentacao`) VALUES 
(@id_sol5, NULL, 'Criado.', DATE_SUB(NOW(), INTERVAL 5 DAY)),
(@id_sol5, 3, 'Documento emitido e enviado.', NOW());
