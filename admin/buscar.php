<?php
require_once __DIR__ . '/../system/auth.php';
checkLogin();
$page_title = "Caçador de Protocolos - Gestão Cartório";
include 'components/header_admin.php';
include 'components/sidebar_admin.php';
?>

<main class="main-content">
    <div class="header-dash">
        <h2><i class="fa-solid fa-magnifying-glass"></i> Central Submódulo de Busca</h2>
        <div class="user-profile">
            <span>Olá, <?= htmlspecialchars($_SESSION['user_nome'] ?? 'Equipe') ?></span>
        </div>
    </div>

    <!-- Filtros de Busca -->
    <div class="stats-summary" style="display: block; background: #0A1929; border: 1px solid rgba(224, 239, 255, 0.1); padding: 20px;">
        <h3 style="color: #E6CE81; margin-bottom: 20px;"><i class="fa-solid fa-filter"></i> Refinar Protocolos</h3>
        <form id="formBusca" style="display: flex; gap: 15px; flex-wrap: wrap;">
            
            <div style="flex: 1; min-width: 200px;">
                <label style="color: #cbd5e1; font-size: 13px;">Número do Protocolo</label>
                <input type="text" id="b_protocolo" name="protocolo" class="form-control" placeholder="Ex: CART123...">
            </div>

            <div style="flex: 1; min-width: 200px;">
                <label style="color: #cbd5e1; font-size: 13px;">CPF do Cidadão</label>
                <input type="text" id="b_cpf" name="cpf" class="form-control" placeholder="Apenas números ou formatado">
            </div>

            <div style="flex: 1; min-width: 200px;">
                <label style="color: #cbd5e1; font-size: 13px;">Texto Livre (Nome / Titulo)</label>
                <input type="text" id="b_livre" name="busca_livre" class="form-control" placeholder="Qualquer parte do nome...">
            </div>

            <div style="flex: 1; min-width: 200px;">
                <label style="color: #cbd5e1; font-size: 13px;">Status Fixo SLA</label>
                <select id="b_status" name="status" class="form-control">
                    <option value="">-- Todos os Status --</option>
                    <option value="pendente">Pendente / Nova Entrada</option>
                    <option value="analise">Em Análise / Triagem</option>
                    <option value="aguardando_pagamento">Aguardando Pagamento/Custas</option>
                    <option value="em_andamento">Em Registro / Produção</option>
                    <option value="concluido">Concluído / Entregue</option>
                    <option value="cancelado">Cancelado / Exigência Falha</option>
                </select>
            </div>

            <div style="display: flex; align-items: flex-end;">
                <button type="submit" class="btn-print" style="height: 48px;"><i class="fa-solid fa-search"></i> Executar Caça</button>
            </div>
        </form>
    </div>

    <!-- Tabela de Resultados -->
    <div class="recent-requests" style="margin-top: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0;">Resultados Encontrados: <span id="contadorResultados" style="color: #F2B705;">0</span></h3>
        </div>
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Protocolo</th>
                        <th>Título / Cliente</th>
                        <th>Status Atual</th>
                        <th>Prazo (Vencimento)</th>
                        <th>Abertura</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="resultadosBody">
                    <tr><td colspan="6" style="text-align: center; color: #cbd5e1; padding: 30px;">Utilize os filtros acima para iniciar a busca avançada.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    // Se o IMask já estiver disponivel no footer, tentamos formatar
    document.addEventListener('DOMContentLoaded', () => {
        if(typeof IMask !== 'undefined') {
            IMask(document.getElementById('b_cpf'), { mask: '000.000.000-00' });
        }
    });

    const form = document.getElementById('formBusca');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const tbody = document.getElementById('resultadosBody');
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; color: #F2B705; padding: 30px;"><i class="fa-solid fa-spinner fa-spin"></i> Vassourando o Banco de Dados...</td></tr>';
        
        const params = new URLSearchParams(new FormData(form)).toString();
        
        try {
            const res = await fetch(`../system/api/buscar_protocolos?${params}`);
            const data = await res.json();
            
            if(data.sucesso) {
                document.getElementById('contadorResultados').innerText = data.quantidade;
                tbody.innerHTML = '';
                
                if(data.quantidade === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; color: #e74c3c; padding: 30px;"><i class="fa-solid fa-ghost"></i> Nenhum protocolo cruzado nesses filtros.</td></tr>';
                    return;
                }

                data.dados.forEach(s => {
                    const statusClass = `status-${s.status.replace('_', '-')}`;
                    const statusText = s.status.replace('_', ' ').toUpperCase();
                    
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td style="font-family: monospace; font-weight: bold; color: #F2B705;">${escapeHtml(s.protocolo)}</td>
                        <td>
                            <strong style="color: #fff;">${escapeHtml(s.titulo || 'Sem Título')}</strong><br>
                            <small style="color: #cbd5e1;">${escapeHtml(s.cliente_nome)}</small>
                        </td>
                        <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                        <td>${s.vencimento_em ? new Date(s.vencimento_em).toLocaleDateString('pt-BR') : 'Indeterminado'}</td>
                        <td style="color: #cbd5e1;">${new Date(s.criado_em).toLocaleDateString('pt-BR')}</td>
                        <td><a href="detalhes_solicitacao?id=${encodeURIComponent(s.id)}" class="action-btn view-btn"><i class="fa-solid fa-eye"></i> Exame Profundo</a></td>
                    `;
                    tbody.appendChild(tr);
                });

            } else {
                tbody.innerHTML = `<tr><td colspan="6" style="text-align: center; color: #e74c3c;">Erro do Servidor: ${escapeHtml(data.erro)}</td></tr>`;
            }
        } catch(e) {
            tbody.innerHTML = `<tr><td colspan="6" style="text-align: center; color: #e74c3c;">Falha catastrófica de conexão!</td></tr>`;
        }
    });
</script>

<?php include 'components/footer_admin.php'; ?>
