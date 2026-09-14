<?php
require_once __DIR__ . '/../system/auth.php';
checkLevel(['admin', 'supervisor']);
if (isset($_SESSION['user_level']) && $_SESSION['user_level'] === 'colaborador') { header("Location: dashboard"); exit; }
$page_title = "Relatórios - Gestão Cartório";
include 'components/header_admin.php';
include 'components/sidebar_admin.php';
?>

<main class="main-content">
            <div class="header-dash">
                <h2>Relatórios e Métricas</h2>
                <button class="btn-print" onclick="window.print()"><i class="fa-solid fa-print"></i> Exportar PDF</button>
            </div>

            <!-- Summary Stats -->
            <div class="stats-summary">
                <div class="stat-box">
                    <span class="value">1,280</span>
                    <span class="label">Total Pedidos</span>
                </div>
                <div class="stat-box">
                    <span class="value">98.5%</span>
                    <span class="label">Taxa Sucesso</span>
                </div>
                <div class="stat-box">
                    <span class="value">4.2h</span>
                    <span class="label">Tempo Médio</span>
                </div>
            </div>

            <!-- Row 1: Volume + Status -->
            <div class="report-grid">
                <div class="chart-card">
                    <h3><i class="fa-solid fa-chart-line"></i> Volume Mensal</h3>
                    <canvas id="volumeChart"></canvas>
                </div>
                <div class="chart-card">
                    <h3><i class="fa-solid fa-chart-pie"></i> Distribuição por Status</h3>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <!-- Row 2: Category + Time -->
            <div class="report-grid">
                <div class="chart-card">
                    <h3><i class="fa-solid fa-list-ul"></i> Solicitações por Categoria</h3>
                    <canvas id="categoryChart"></canvas>
                </div>
                <div class="chart-card">
                    <h3><i class="fa-solid fa-clock"></i> Tempo de Conclusão (Serviço)</h3>
                    <canvas id="timeChart"></canvas>
                </div>
            </div>

            <!-- Row 3: User Full Width -->
            <div class="report-grid-full">
                <div class="chart-card">
                    <h3><i class="fa-solid fa-users-viewfinder"></i> Desempenho por Usuário</h3>
                    <canvas id="userChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </main>

<?php ob_start(); ?>
<script>
        // Setup Charts
        Chart.defaults.color = 'rgba(224, 239, 255, 0.7)';
        Chart.defaults.borderColor = 'rgba(224, 239, 255, 0.1)';

        // Volume Chart
        new Chart(document.getElementById('volumeChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                datasets: [{
                    label: 'Solicitações',
                    data: [120, 150, 180, 160, 210, 250],
                    borderColor: '#F2B705',
                    backgroundColor: 'rgba(242, 183, 5, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            }
        });

        // Status Chart
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Concluídos', 'Em Análise', 'Aguardando Pagamento', 'Em Registro', 'Cancelado'],
                datasets: [{
                    data: [60, 15, 10, 10, 5],
                    backgroundColor: ['#2ecc71', '#3498db', '#f39c12', '#e74c3c', '#95a5a6'],
                    borderWidth: 0
                }]
            }
        });

        // Category Chart
        new Chart(document.getElementById('categoryChart'), {
            type: 'bar',
            data: {
                labels: ['Nascimento', 'Casamento', 'Imóveis', 'Empresarial'],
                datasets: [{
                    label: 'Volume',
                    data: [450, 320, 580, 140],
                    backgroundColor: '#0C4B8E',
                    borderRadius: 5
                }]
            }
        });

        // Time Chart
        new Chart(document.getElementById('timeChart'), {
            type: 'bar',
            indexAxis: 'y',
            data: {
                labels: ['Reg. Civil', 'Reg. Imóveis', 'Títulos'],
                datasets: [{
                    label: 'Horas Médias',
                    data: [2, 8, 3],
                    backgroundColor: '#F2B705',
                    borderRadius: 5
                }]
            }
        });

        // User Performance Chart
        new Chart(document.getElementById('userChart'), {
            type: 'bar',
            data: {
                labels: ['Admin', 'Sérgio Santos', 'Ana Oliveira', 'Marcos Lima'],
                datasets: [{
                    label: 'Solicitações Concluídas',
                    data: [450, 380, 420, 310],
                    backgroundColor: '#2ecc71',
                    borderRadius: 5
                }]
            }
        });
    </script>

<?php $extra_js = ob_get_clean(); ?>

<?php include 'components/footer_admin.php'; ?>
