<?php
require_once '../security.php';
startSecureSession();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}
requireCsrf();
session_unset();
session_destroy();
header("Location: ../../admin/login");
exit;
?>
