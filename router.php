<?php

// Roteador usado apenas pelo servidor PHP local.
// Em producao, o Apache continua usando as regras do arquivo .htaccess.
$requestPath = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
$requestPath = '/' . ltrim($requestPath, '/');
$publicPath = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, $requestPath);

if ($requestPath !== '/' && is_file($publicPath)) {
    return false;
}

if ($requestPath === '/') {
    require __DIR__ . '/index.php';
    return true;
}

$route = trim($requestPath, '/');

if ($route !== '' && preg_match('/^[a-z0-9_\-\/]+$/i', $route)) {
    $page = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $route) . '.php';

    if (is_file($page) && basename($page) !== 'router.php') {
        require $page;
        return true;
    }
}

http_response_code(404);
require __DIR__ . '/index.php';

