# Cartório 2º Ofício de Manacapuru - AM

Portal Institucional e Sistema de Atendimento Eletrônico do **Ofício de Registro de Imóveis, Títulos e Documentos e Civil das Pessoas Naturais e Jurídicas da Comarca de Manacapuru / AM**.

---

## 📌 Sobre o Projeto

Este projeto compreende o site institucional e o sistema web de autoatendimento para cidadãos e operadores do direito que necessitam de serviços registrais extrajudiciais em Manacapuru. O portal reúne informações sobre todas as atribuições da serventia, orientações de custas e emolumentos, formulários oficiais para download e um sistema próprio de solicitação e rastreamento de protocolos.

---

## 🚀 Principais Funcionalidades

### 🏛️ Portal Institucional e Serviços Registrais
* **Registro de Imóveis (RI):** Histórico da matrícula, escrituras, regularização fundiária, usucapião, desmembramentos, certidões e tabela de emolumentos atualizada pela Lei Estadual nº 8.212/2026.
* **Registro Civil das Pessoas Naturais (RCPN):** Registro e certidões de nascimento, casamento e óbito, habilitações, reconhecimento de paternidade socioafetiva e biológica, e orientações sobre gratuidades e isenções legais.
* **Registro de Títulos e Documentos (RTD):** Notificações extrajudiciais, registro para conservação, contratos e declarações.
* **Registro Civil das Pessoas Jurídicas (RCPJ):** Registro e alterações estatutárias de sociedades simples, associações, fundações e organizações religiosas.
* **Central de Certidões:** Integração direta com as centrais eletrônicas nacionais oficiais:
  * **RI Digital (ONR):** Certidões imobiliárias eletrônicas.
  * **Meu Registro Civil (Arpen-Brasil):** 2ª via de certidões civis.
  * **RTDPJ Brasil / SERP:** Certidões de títulos, documentos e pessoas jurídicas.
* **Validação de Selo Digital:** Acesso rápido ao Portal do Selo do Tribunal de Justiça do Amazonas (TJAM) para verificação de autenticidade dos atos.
* **Repositório de Modelos e Checklists:** Download em PDF e DOCX de requerimentos prontos organizados por atribuição.

### 📝 Autoatendimento Online e Acompanhamento
* **Solicitação de Serviços:** Formulário com fluxo em etapas para abertura de pedidos com envio de dados pessoais, seleção da especialidade e upload de documentos comprobatórios.
* **Geração de Protocolo e Senha:** Protocolo exclusivo com código de verificação para o cliente acompanhar seu pedido com privacidade.
* **Acompanhamento em Tempo Real:** Consulta com linha do tempo de movimentações, prazos (SLA em dias úteis) e status da análise.
* **Notificações por E-mail:** Envio automático de recibos de protocolo ao cidadão e alertas à equipe do cartório via PHPMailer.

### 🔒 Painel Administrativo (`/admin`)
* **Dashboard Gerencial:** Métricas de solicitações abertas, em andamento, concluídas e pedidos com prazo próximo do vencimento.
* **Gestão de Protocolos:** Triagem, mudança de status, inserção de históricos de movimentação e download de anexos.
* **Controle de Usuários:** Gerenciamento de operadores com autenticação segura e controle de acesso.
* **Relatórios:** Filtros por período, especialidade e status.

---

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP 8.2+
* **Banco de Dados:** MySQL / MariaDB (conexão via PDO)
* **Frontend:** HTML5, CSS3 Moderno (CSS Grid, Flexbox, Custom Properties), JavaScript Vanilla
* **Bibliotecas Client-side:**
  * [IMask](https://imask.js.org/) (máscaras de CPF, telefone e moeda)
  * [SweetAlert2](https://sweetalert2.github.io/) (modais e alertas amigáveis)
  * [Font Awesome 6](https://fontawesome.com/) (iconografia vetorial)
  * [Google Fonts](https://fonts.google.com/) (fontes Inter e Playfair Display)
* **Bibliotecas Server-side:**
  * [PHPMailer](https://github.com/PHPMailer/PHPMailer) (disparos SMTP transacionais)
* **Servidor Web:** Apache com `mod_rewrite` e cabeçalhos de segurança (CSP, HSTS, X-Frame-Options).

---

## 📁 Estrutura de Diretórios

```
Site_2ofMPU/
│
├── admin/                      # Painel administrativo interno
│   ├── assets/                 # Estilos e scripts exclusivos do painel
│   ├── components/             # Header, sidebar e footer administrativos
│   ├── dashboard.php           # Visão geral de métricas
│   ├── solicitacoes.php        # Listagem e triagem de pedidos
│   ├── detalhes_solicitacao.php# Visualização detalhada e atualização de status
│   └── login.php               # Autenticação de operadores
│
├── components/                 # Componentes globais reutilizáveis
│   ├── header.php              # Cabeçalho e navegação principal
│   ├── footer.php              # Rodapé institucional e links rápidos
│   └── service-resources.php   # Renderizadores de tabelas e downloads
│
├── documentos/                 # Modelos de requerimento e checklists em PDF/DOCX
│   └── Manacapuru/             # Arquivos divididos por especialidade (RI, RCPN, RCPJ, RTD)
│
├── images/                     # Logotipos, ícones e imagens institucionais
├── videos/                     # Vídeos institucionais incorporados
│
├── system/                     # Núcleo de regras de negócio e segurança
│   ├── api/                    # Endpoints REST/JSON (consulta, criação, login, etc.)
│   ├── libs/                   # Bibliotecas de terceiros (PHPMailer)
│   ├── utils/                  # Utilitários (protocolo, prazos úteis, uploads, mailer)
│   ├── config.php              # Gerenciador de configurações e variáveis de ambiente
│   ├── database.sql            # Script de criação do banco de dados e dados iniciais
│   └── security.php            # Proteção CSRF, sanitização, sessões seguras e rate limit
│
├── certidoes.php               # Central oficial de certidões eletrônicas
├── imoveis.php                 # Página da especialidade Registro de Imóveis
├── rcpn.php                    # Página da especialidade Registro Civil
├── rtdpj.php                   # Página da especialidade RTD e RCPJ
├── solicitar.php               # Formulário público de solicitação online
├── acompanhar.php              # Consulta pública de status por protocolo
├── sucesso.php                 # Confirmação de abertura de pedido
├── router.php                  # Roteador para servidor de desenvolvimento PHP
├── style.css                   # Estilos globais e identidade visual
├── script.js                   # Scripts de interatividade da página
└── index.php                   # Página inicial institucional
```

---

## ⚙️ Instalação e Execução Local

### Pré-requisitos
* PHP 8.2 ou superior com extensões `pdo_mysql`, `mbstring`, `openssl` e `fileinfo` habilitadas.
* MySQL 5.7+ ou MariaDB 10.4+.
* Servidor Apache (ou uso do servidor embutido do PHP).

### 1. Clonar o repositório
```bash
git clone https://github.com/Feitosa98/Site_2ofMPU.git
cd Site_2ofMPU
```

### 2. Configurar o Banco de Dados
1. Crie um banco de dados no seu gerenciador MySQL (ex.: `cartorio_2oficio`):
   ```sql
   CREATE DATABASE cartorio_2oficio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Importe a estrutura e dados iniciais localizados em `system/database.sql`.

### 3. Configurar Credenciais
Crie o arquivo `private_config.php` um nível acima da pasta pública (ou configure as variáveis de ambiente equivalentes):
```php
<?php
return [
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'cartorio_2oficio',
    'DB_USER' => 'seu_usuario',
    'DB_PASS' => 'sua_senha',
    
    'SMTP_HOST' => 'smtp.seuservidor.com',
    'SMTP_PORT' => 465,
    'SMTP_USER' => 'sistema@seudominio.com.br',
    'SMTP_PASS' => 'senha_do_email',
    'SMTP_FROM' => 'Cartório 2º Ofício <sistema@seudominio.com.br>',
];
```

### 4. Iniciar o Servidor Local
Para desenvolvimento local rápido sem Apache/XAMPP, utilize o roteador embutido:
```bash
php -S 127.0.0.1:8000 router.php
```
Acesse no navegador:
* Site público: `http://127.0.0.1:8000/`
* Painel administrativo: `http://127.0.0.1:8000/admin/login`

---

## 🛡️ Segurança

* **CSRF:** Validação de tokens via cabeçalho `X-CSRF-Token` e campo oculto `_csrf`.
* **Rate Limiting:** Proteção contra força bruta em consultas de protocolo e criação de chamados.
* **Sessões Blindadas:** Parâmetros `HttpOnly`, `SameSite=Lax`, regeneração de ID e tempo de expiração restrito.
* **Proteção de Arquivos:** Regras de `.htaccess` impedem a listagem de diretórios e bloqueiam acesso direto a extensões sensíveis (`.sql`, `.log`, `.env`, `.ini`, etc.).

---

## 📞 Contato e Atendimento

* **Endereço:** Av. Ribeiro Júnior, 373 - Centro, Manacapuru - AM, CEP: 69400-336
* **Horário:** Segunda a Sexta, das 08h às 17h (sem intervalo)
* **Telefones:**
  * RCPN: (92) 98536-6100
  * RI e TDPJ: (92) 98425-4805
* **Desenvolvimento:** [Feitosa Soluções em Informática](https://feitosasolucoes.com.br/)
