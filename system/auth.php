<?php
// system/auth.php
session_start();
require_once 'config.php';

// Função para verificar se está logado
function checkLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . 'admin/login.html');
        exit;
    }
}

// Função para verificar nível de acesso
function checkLevel($levels)
{
    checkLogin();
    if (!in_array($_SESSION['user_level'], $levels)) {
        http_response_code(403);
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