<?php
header('Content-Type: application/json; charset=UTF-8');
require_once '../auth.php';
require_once '../utils/upload.php';
checkLogin();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'erro' => 'Anexo inválido.']);
    exit;
}

$conn = getDBConnection();
$stmt = $conn->prepare('SELECT nome_arquivo_original, nome_arquivo_salvo, caminho FROM anexos WHERE id = ?');
$stmt->execute([$id]);
$anexo = $stmt->fetch();
if (!$anexo) {
    http_response_code(404);
    echo json_encode(['sucesso' => false, 'erro' => 'Anexo não encontrado.']);
    exit;
}

$safeName = basename((string)$anexo['nome_arquivo_salvo']);
$path = diretorioUploadsPrivados() . DIRECTORY_SEPARATOR . $safeName;
if (!is_file($path)) {
    // Compatibilidade temporária com anexos gravados pela versão anterior.
    $legacy = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'documentos' . DIRECTORY_SEPARATOR . $safeName;
    $path = is_file($legacy) ? $legacy : $path;
}
if (!is_file($path) || !is_readable($path)) {
    http_response_code(404);
    echo json_encode(['sucesso' => false, 'erro' => 'Arquivo indisponível.']);
    exit;
}

$mime = (new finfo(FILEINFO_MIME_TYPE))->file($path) ?: 'application/octet-stream';
$downloadName = preg_replace('/[^\pL\pN._ -]/u', '_', basename((string)$anexo['nome_arquivo_original']));
header_remove('Content-Type');
header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($path));
header("Content-Disposition: attachment; filename*=UTF-8''" . rawurlencode($downloadName));
header('Cache-Control: private, no-store');
readfile($path);
exit;

