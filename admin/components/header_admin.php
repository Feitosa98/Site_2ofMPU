<?php
require_once __DIR__ . '/../../system/security.php';
startSecureSession();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../admin/login");
    exit;
}
$page_title = $page_title ?? "Admin - Gestão Cartório";
// Session logic and headers can go here later
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
    <title><?= htmlspecialchars($page_title) ?></title>
    <link rel="icon" type="image/png" href="../images/logo.png">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 para Alertas Elegantes -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/admin_style.css">
    <?= $extra_css ?? '' ?>
    <script>
        window.CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
        window.csrfHeaders = (headers = {}) => ({ ...headers, 'X-CSRF-Token': window.CSRF_TOKEN });
        window.escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, char => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;'
        })[char]);
    </script>
</head>

<body>
<?php if (!isset($hide_container) || !$hide_container): ?>
    <div class="dashboard-container">
<?php endif; ?>
