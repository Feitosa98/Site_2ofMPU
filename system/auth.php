<?php
// system/auth.php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/config.php';
startSecureSession();

// Função para verificar se está logado
function checkLogin()
{
    if (!isset($_SESSION['user_id'])) {
        if (strpos($_SERVER['REQUEST_URI'] ?? '', '/api/') !== false) {
            http_response_code(401);
            echo json_encode(['sucesso' => false, 'erro' => 'Acesso negado']);
            exit;
        } else {
            header('Location: ' . BASE_URL . 'admin/login');
            exit;
        }
    }
}

// Função para verificar nível de acesso
function checkLevel($levels)
{
    checkLogin();
    if (!in_array($_SESSION['user_level'], $levels)) {
        http_response_code(403);
        if (strpos($_SERVER['REQUEST_URI'] ?? '', '/api/') !== false) {
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(['sucesso' => false, 'erro' => 'Acesso negado. Nível de permissão insuficiente.']);
            exit;
        }
        die("Acesso negado. Nível de permissão insuficiente.");
    }
}

// Função para retornar dados do usuário logado
function currentUser()
{
    if (isset($_SESSION['user_id'])) {
        return [
            'id' => $_SESSION['user_id'],
            'nome' => $_SESSION['user_nome'],
            'email' => $_SESSION['user_email'],
            'nivel' => $_SESSION['user_level']
        ];
    }
    return null;
}
?>
