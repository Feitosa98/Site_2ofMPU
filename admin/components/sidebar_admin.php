<?php
$current_page = basename($_SERVER['PHP_SELF']);
$userName = $_SESSION['user_nome'] ?? 'Administrador';
$userLevel = $_SESSION['user_level'] ?? 'admin';
$names = explode(' ', $userName);
$avatar = strtoupper(substr($names[0], 0, 1) . (isset($names[1]) ? substr($names[1], 0, 1) : ''));
$levelDisplay = ['admin' => 'Administrador', 'supervisor' => 'Supervisor', 'colaborador' => 'Colaborador'][$userLevel] ?? 'Colaborador';
?>
<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <a href="dashboard.php"><img src="../images/logo.png" alt="Logo"></a>
        <h4>Gestão Cartório</h4>
    </div>

    <div class="sidebar-nav">
        <div class="nav-label">Principal</div>
        <a href="dashboard" class="menu-item <?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
            <span class="icon-wrap"><i class="fa-solid fa-house-chimney"></i></span> Início
        </a>
        <a href="solicitacoes" class="menu-item <?= $current_page == 'solicitacoes.php' ? 'active' : '' ?>">
            <span class="icon-wrap"><i class="fa-solid fa-receipt"></i></span> Solicitações
        </a>
        <a href="nova_solicitacao" class="menu-item <?= $current_page == 'nova_solicitacao.php' ? 'active' : '' ?>">
            <span class="icon-wrap"><i class="fa-solid fa-circle-plus"></i></span> Novo Pedido
        </a>
        <a href="buscar" class="menu-item <?= $current_page == 'buscar.php' ? 'active' : '' ?>">
            <span class="icon-wrap"><i class="fa-solid fa-magnifying-glass"></i></span> Caçador / Busca
        </a>

        <?php if ($userLevel !== 'colaborador'): ?>
        <div class="nav-label">Gestão</div>
        <a href="usuarios" class="menu-item <?= $current_page == 'usuarios.php' ? 'active' : '' ?>">
            <span class="icon-wrap"><i class="fa-solid fa-user-gear"></i></span> Equipe
        </a>
        <a href="relatorios" class="menu-item <?= $current_page == 'relatorios.php' ? 'active' : '' ?>">
            <span class="icon-wrap"><i class="fa-solid fa-chart-pie"></i></span> Relatórios
        </a>
        <a href="configuracoes" class="menu-item <?= $current_page == 'configuracoes.php' ? 'active' : '' ?>">
            <span class="icon-wrap"><i class="fa-solid fa-gears"></i></span> Configurações
        </a>
        <?php endif; ?>
    </div>

    <div class="sidebar-spacer" style="flex-grow: 1;"></div>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar"><?= htmlspecialchars($avatar, ENT_QUOTES, 'UTF-8') ?></div>
            <div class="user-info-text">
                <strong><?= htmlspecialchars($userName) ?></strong>
                <span><?= $levelDisplay ?></span>
            </div>
        </div>
        <form action="../system/api/logout" method="post">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
            <button type="submit" class="btn-logout" style="width: 100%; border: 0; cursor: pointer;">
                <i class="fa-solid fa-power-off"></i> Sair do Sistema
            </button>
        </form>
    </div>
</aside>
