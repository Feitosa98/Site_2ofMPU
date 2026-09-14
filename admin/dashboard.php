<?php
$page_title = "Dashboard - Gestão Cartório";
include 'components/header_admin.php';
include 'components/sidebar_admin.php';
?>

<main class="main-content">
            <div class="header-dash">
                <h2>Olá, <?= htmlspecialchars($userName) ?></h2>
                <div class="user-info">
                    <span id="currentDate" style="color: #F2B705; font-weight: 600;">--/--/----</span>
                </div>
            </div>

            <!-- KPIs (Métricas de Gestão) -->
            <div class="kpi-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
                <div class="kpi-card andamento">
                    <div class="kpi-label"><i class="fa-solid fa-magnifying-glass" style="color: #3498db; margin-right: 8px;"></i>Em Análise</div>
                    <div class="kpi-value" id="countAnalise">--</div>
                    <div style="font-size: 0.8rem; color: #3498db;">Triagem em andamento</div>
                </div>
                <div class="kpi-card pendente">
                    <div class="kpi-label"><i class="fa-solid fa-money-bill-wave" style="color: #f39c12; margin-right: 8px;"></i>Ag. Pagamento</div>
                    <div class="kpi-value" id="countPagamento">--</div>
                    <div style="font-size: 0.8rem; color: #f39c12;">Aguardando confirmação</div>
                </div>
                <div class="kpi-card andamento" style="border-top-color: #e74c3c;">
                    <div class="kpi-label"><i class="fa-solid fa-stamp" style="color: #e74c3c; margin-right: 8px;"></i>Em Registro</div>
                    <div class="kpi-value" id="countAndamento">--</div>
                    <div style="font-size: 0.8rem; color: #e74c3c;">Tempo médio: 4.2h</div>
                </div>
                <div class="kpi-card concluido">
                    <div class="kpi-label"><i class="fa-solid fa-circle-check" style="color: #2ecc71; margin-right: 8px;"></i>Concluídos (Mês)</div>
                    <div class="kpi-value" id="countConcluido">--</div>
                    <div style="font-size: 0.8rem; color: #2ecc71;">Taxa: 98.2%</div>
                </div>
            </div>

            <!-- Tabela Recentes -->
            <div class="table-container" style="overflow-x: auto; margin-top: 30px;">
                <h3 class="mb-4">Solicitações Recentes</h3>
                <table style="width: 100%; min-width: 700px; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>Protocolo</th>
                            <th>Cliente</th>
                            <th>Serviço</th>
                            <th>Status</th>
                            <th>Prioridade</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="listaSolicitacoes">
                        <tr>
                            <td colspan="6" class="text-center">Carregando...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>

<?php ob_start(); ?>
<script>
        // Função para manter relógio e data vivos na dashboard
        function atualizarRelogio() {
            const dtElement = document.getElementById('currentDate');
            if (dtElement) {
                const now = new Date();
                dtElement.innerText = now.toLocaleDateString('pt-BR') + ' às ' + now.toLocaleTimeString('pt-BR', {hour: '2-digit', minute:'2-digit'});
            }
        }
        atualizarRelogio();
        setInterval(atualizarRelogio, 60000);

        // Função para carregar dados
        async function carregarDashboard() {
            try {
                const response = await fetch('../system/api/listar_solicitacoes.php');
                const data = await response.json();

                if (!data.sucesso) {
                    // Se não logado ou erro
                    if (data.erro && data.erro.includes('Acesso negado')) window.location.href = 'login.php';
                    return;
                }

                // Atualizar KPIs contanto filtragem por status
                const analise = data.solicitacoes.filter(s => s.status === 'analise' || s.status === 'pendente').length;
                const pagamento = data.solicitacoes.filter(s => s.status === 'aguardando_pagamento').length;
                const andamento = data.solicitacoes.filter(s => s.status === 'em_andamento').length;
                const concluidos = data.solicitacoes.filter(s => s.status === 'concluido').length;

                document.getElementById('countAnalise').innerText = analise;
                document.getElementById('countPagamento').innerText = pagamento;
                document.getElementById('countAndamento').innerText = andamento;
                document.getElementById('countConcluido').innerText = concluidos;

                // SLA Alerts
                const urgentes = data.solicitacoes.filter(s => {
                    if(!s.vencimento_em || s.status === 'concluido' || s.status === 'cancelado') return false;
                    const v = new Date(s.vencimento_em);
                    const q = new Date();
                    const diffDays = Math.ceil((v - q) / (1000 * 60 * 60 * 24)); 
                    return diffDays <= 5;
                });

                if(urgentes.length > 0 && !sessionStorage.getItem('aviso_urgencias_visto')) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Prazos Críticos!',
                            text: `Existem ${urgentes.length} protocolo(s) vencendo nos próximos 5 dias ou já atrasados!`,
                            background: '#091524',
                            color: '#fff',
                            confirmButtonColor: '#F2B705'
                        });
                    }
                    sessionStorage.setItem('aviso_urgencias_visto', 'true');
                }


                // Renderizar Tabela
                const tbody = document.getElementById('listaSolicitacoes');
                tbody.innerHTML = '';

                data.solicitacoes.forEach(s => {
                    let statusClass = 'bg-pendente';
                    if (s.status === 'em_andamento') statusClass = 'bg-andamento';
                    if (s.status === 'concluido') statusClass = 'bg-concluido';

                    // Lógica de Bloqueio
                    let trClass = '';
                    let lockIcon = '';
                    let btnDisabled = '';

                    if (s.bloqueado_para_mim) {
                        trClass = 'locked-row';
                        lockIcon = `<i class="fa-solid fa-lock lock-icon" title="Bloqueado por ${escapeHtml(s.bloqueado_por_nome)}"></i>`;
                        // Se for admin/supervisor, pode forçar. Se não, desabilita.
                        if (data.usuario_nivel === 'colaborador') {
                            btnDisabled = 'style="opacity:0.5; pointer-events:none;"';
                        }
                    }

                    const row = `
                        <tr class="${trClass}">
                            <td>${lockIcon} <strong>${escapeHtml(s.protocolo)}</strong></td>
                            <td>${escapeHtml(s.cliente_nome)}</td>
                            <td>${escapeHtml(s.servico_nome)}</td>
                            <td><span class="status-badge ${statusClass}">${escapeHtml(s.status.replace('_', ' ').toUpperCase())}</span></td>
                            <td>${s.prioridade === 'urgente' ? '<span style="color:red;font-weight:bold">URGENTE</span>' : 'Normal'}</td>
                            <td>
                                <a href="detalhes_solicitacao.php?id=${encodeURIComponent(s.id)}" class="btn-action btn-view" ${btnDisabled}>
                                    <i class="fa-solid fa-eye"></i> Abrir
                                </a>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });

            } catch (error) {
                console.error("Erro ao carregar dashboard:", error);
            }
        }

        // Iniciar
        carregarDashboard();

        // Auto-refresh a cada 30s
        setInterval(carregarDashboard, 30000);
    </script>

<?php $extra_js = ob_get_clean(); ?>

<?php include 'components/footer_admin.php'; ?>
