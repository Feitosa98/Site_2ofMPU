<?php

// As credenciais ficam fora de public_html para não entrarem em backups do site.
$privateConfigPath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'private_config.php';
$privateConfig = is_file($privateConfigPath) ? require $privateConfigPath : [];
if (!is_array($privateConfig)) {
    $privateConfig = [];
}

function configValue(string $key, string $default = ''): string
{
    global $privateConfig;
    $environmentValue = getenv($key);
    if ($environmentValue !== false && $environmentValue !== '') {
        return $environmentValue;
    }
    return isset($privateConfig[$key]) ? (string)$privateConfig[$key] : $default;
}

define('DB_HOST', configValue('DB_HOST', 'localhost'));
define('DB_NAME', configValue('DB_NAME'));
define('DB_USER', configValue('DB_USER'));
define('DB_PASS', configValue('DB_PASS'));

define('SMTP_HOST', configValue('SMTP_HOST', 'smtp.hostinger.com'));
define('SMTP_PORT', (int)configValue('SMTP_PORT', '465'));
define('SMTP_USER', configValue('SMTP_USER'));
define('SMTP_PASS', configValue('SMTP_PASS'));
define('SMTP_FROM', configValue('SMTP_FROM', 'Cartório 2º Ofício <sistema@registromanacapuru.com.br>'));

define('BASE_URL', configValue('BASE_URL', 'https://registromanacapuru.com.br/'));
define('TIMEZONE', 'America/Manaus');
date_default_timezone_set(TIMEZONE);

error_reporting(E_ALL);
ini_set('display_errors', '0');

function getDBConnection(): PDO
{
    if (DB_NAME === '' || DB_USER === '' || DB_PASS === '') {
        throw new RuntimeException('Configuração privada do banco de dados ausente.');
    }

    try {
        $conn = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
        return $conn;
    } catch (PDOException $error) {
        error_log($error->getMessage());
        throw new RuntimeException('Não foi possível conectar ao banco de dados.');
    }
}

