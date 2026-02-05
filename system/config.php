<?php
// Configuração do Banco de Dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'cartorio_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configuração de Email (SMTP Gmail)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587); // ou 465 com SSL
define('SMTP_USER', 'seu_email@gmail.com');
define('SMTP_PASS', 'sua_senha_de_app_gmail'); // Senha de App do Google (Não a do email)
define('SMTP_FROM', 'Cartório 2º Ofício <noreply@cartorio.com>');

// Configurações Gerais
define('BASE_URL', 'http://localhost/Site_2ofMPU/'); // Mudar em produção
define('TIMEZONE', 'America/Manaus');

// Tratamento de erros
error_reporting(E_ALL);
ini_set('display_errors', 0); // 0 em produção, 1 em dev

// Função de Conexão
function getDBConnection() {
    try {
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
    } catch(PDOException $e) {
        die("Erro de conexão: " . $e->getMessage());
    }
}
?>
