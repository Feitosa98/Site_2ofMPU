-- Banco de Dados - Sistema de Gestão de Solicitações
-- Cartório 2º Ofício de Manacapuru

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Tabela `usuarios`
--
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel` enum('admin','supervisor','colaborador') NOT NULL DEFAULT 'colaborador',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para `usuarios` (Senha padrão: admin123 - hash deve ser gerado)
--
INSERT INTO `usuarios` (`nome`, `email`, `senha`, `nivel`) VALUES
('Administrador', 'admin@cartorio.com', '$2y$10$YourHashedPasswordHere', 'admin'),
('Supervisor', 'supervisor@cartorio.com', '$2y$10$YourHashedPasswordHere', 'supervisor'),
('Colaborador', 'colaborador@cartorio.com', '$2y$10$YourHashedPasswordHere', 'colaborador');

-- --------------------------------------------------------

--
-- Tabela `servicos`
--
CREATE TABLE `servicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para `servicos`
--
INSERT INTO `servicos` (`categoria`, `nome`, `descricao`) VALUES
('Registro Civil', 'Certidão de Nascimento', 'Primeiro documento oficial que comprova o nascimento.'),
('Registro Civil', 'Certidão de Casamento', 'Registro oficial da união civil.'),
('Registro Civil', 'Certidão de Óbito', 'Documento indispensável após falecimento.'),
('Registro Civil', 'Emancipação', 'Ato que confere capacidade civil a menor.'),
('Registro Civil', 'Retificação de Registro Civil', 'Ajusta informações incorretas.'),
('Registro de Imóveis', 'Certidão de Matrícula do Imóvel', 'Comprova titularidade e histórico.'),
('Registro de Imóveis', 'Averbação de Construção', 'Registra alterações como construção/demolição.'),
('Registro de Imóveis', 'Registro de Escritura', 'Formaliza compra e venda.'),
('Registro de Imóveis', 'Certidão de Ônus Reais', 'Informa pendências financeiras.'),
('Registro de Imóveis', 'Retificação de Registro de Imóvel', 'Corrige informações do imóvel.'),
('Pessoas Jurídicas e Títulos', 'Registro Civil de Pessoas Jurídicas (RCPJ)', 'Registra contratos sociais e estatutos.'),
('Pessoas Jurídicas e Títulos', 'Registro de Títulos e Documentos (RTD)', 'Conservação de documentos diversos.');

-- --------------------------------------------------------

--
-- Tabela `solicitacoes`
--
CREATE TABLE `solicitacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `protocolo` varchar(20) NOT NULL,
  `senha_acesso` varchar(6) NOT NULL,
  `cliente_nome` varchar(100) NOT NULL,
  `cliente_cpf` varchar(14) NOT NULL,
  `cliente_email` varchar(100) NOT NULL,
  `cliente_telefone` varchar(20) NOT NULL,
  `servico_id` int(11) NOT NULL,
  `status` enum('pendente','analise','em_andamento','aguardando_pagamento','concluido','retirada','cancelado') NOT NULL DEFAULT 'pendente',
  `prioridade` enum('normal','urgente') NOT NULL DEFAULT 'normal',
  `colaborador_id` int(11) DEFAULT NULL,
  `bloqueado_por_id` int(11) DEFAULT NULL, -- ID do usuário que está mexendo agora
  `bloqueado_em` datetime DEFAULT NULL, -- Hora que começou a mexer (para auto-unlock)
  `observacoes_cliente` text DEFAULT NULL,
  `observacoes_internas` text DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `protocolo` (`protocolo`),
  KEY `servico_id` (`servico_id`),
  KEY `colaborador_id` (`colaborador_id`),
  KEY `bloqueado_por_id` (`bloqueado_por_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabela `historico_movimentacoes`
--
CREATE TABLE `historico_movimentacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `solicitacao_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL, -- Null se for alteração do sistema ou cliente
  `descricao` text NOT NULL,
  `data_movimentacao` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `solicitacao_id` (`solicitacao_id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabela `anexos`
--
CREATE TABLE `anexos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `solicitacao_id` int(11) NOT NULL,
  `nome_arquivo_original` varchar(255) NOT NULL,
  `nome_arquivo_salvo` varchar(255) NOT NULL,
  `caminho` varchar(255) NOT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `solicitacao_id` (`solicitacao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Restrições para tabelas
--

ALTER TABLE `solicitacoes`
  ADD CONSTRAINT `solicitacoes_ibfk_1` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`),
  ADD CONSTRAINT `solicitacoes_ibfk_2` FOREIGN KEY (`colaborador_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `solicitacoes_ibfk_3` FOREIGN KEY (`bloqueado_por_id`) REFERENCES `usuarios` (`id`);

ALTER TABLE `historico_movimentacoes`
  ADD CONSTRAINT `historico_movimentacoes_ibfk_1` FOREIGN KEY (`solicitacao_id`) REFERENCES `solicitacoes` (`id`) ON DELETE CASCADE;

ALTER TABLE `anexos`
  ADD CONSTRAINT `anexos_ibfk_1` FOREIGN KEY (`solicitacao_id`) REFERENCES `solicitacoes` (`id`) ON DELETE CASCADE;

COMMIT;
