<?php

function isHttpsRequest(): bool
{
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
}

function sendSecurityHeaders(): void
{
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
}

function startSecureSession(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => isHttpsRequest(),
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
    session_start();
}

function csrfToken(): string
{
    startSecureSession();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function requireCsrf(): void
{
    startSecureSession();
    $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['_csrf'] ?? '';
    $expected = $_SESSION['csrf_token'] ?? '';
    if (!is_string($token) || !is_string($expected) || $expected === '' || $token === '' || !hash_equals($expected, $token)) {
        http_response_code(403);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(['sucesso' => false, 'erro' => 'Sessão expirada. Recarregue a página e tente novamente.']);
        exit;
    }
}

function clientIp(): string
{
    return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}

function enforceRateLimit(string $scope, int $maxAttempts, int $windowSeconds): void
{
    $directory = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'cartorio_rate_limits';
    if (!is_dir($directory) && !@mkdir($directory, 0700, true) && !is_dir($directory)) {
        return;
    }

    $path = $directory . DIRECTORY_SEPARATOR . hash('sha256', $scope) . '.json';
    $handle = @fopen($path, 'c+');
    if (!$handle || !flock($handle, LOCK_EX)) {
        if ($handle) fclose($handle);
        return;
    }

    $raw = stream_get_contents($handle);
    $data = json_decode($raw ?: '', true);
    $now = time();
    if (!is_array($data) || ($data['started_at'] ?? 0) <= $now - $windowSeconds) {
        $data = ['started_at' => $now, 'attempts' => 0];
    }

    if (($data['attempts'] ?? 0) >= $maxAttempts) {
        flock($handle, LOCK_UN);
        fclose($handle);
        http_response_code(429);
        header('Content-Type: application/json; charset=UTF-8');
        header('Retry-After: ' . max(1, $windowSeconds - ($now - $data['started_at'])));
        echo json_encode(['sucesso' => false, 'erro' => 'Muitas tentativas. Aguarde alguns minutos e tente novamente.']);
        exit;
    }

    $data['attempts']++;
    rewind($handle);
    ftruncate($handle, 0);
    fwrite($handle, json_encode($data));
    fflush($handle);
    flock($handle, LOCK_UN);
    fclose($handle);
}

function resetRateLimit(string $scope): void
{
    $path = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR)
        . DIRECTORY_SEPARATOR . 'cartorio_rate_limits'
        . DIRECTORY_SEPARATOR . hash('sha256', $scope) . '.json';
    if (is_file($path)) {
        @unlink($path);
    }
}

function publicExceptionMessage(Throwable $error, string $fallback = 'Ocorreu um erro interno. Tente novamente mais tarde.'): string
{
    if ($error instanceof PDOException) {
        error_log($error->getMessage());
        return $fallback;
    }
    return $error->getMessage();
}

sendSecurityHeaders();
