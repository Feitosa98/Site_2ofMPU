<?php
require_once __DIR__ . '/../system/auth.php';
checkLogin();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
    <title>Detalhes da Solicitação - Admin</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: #07274D; /* Deep navy */
            color: #e0efff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }

        .top-nav {
            background: #0C4B8E; /* River Blue */
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            border-bottom: 2px solid #F2B705;
        }

        .container-fluid {
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .card-details {
            background: #0D3E72;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            padding: 35px;
            margin-bottom: 30px;
            border: 1px solid rgba(242, 183, 5, 0.1);
        }

        .card-details h2, .card-details h4 {
            color: #F2B705;
            font-family: 'Playfair Display', serif;
        }

        .status-badge {
            padding: 8px 18px;
            border-radius: 20px;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
            margin-top: 30px;
        }

        .info-group label {
            display: block;
            color: #F2B705;
            margin-bottom: 8px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .info-group strong {
            font-size: 1.2rem;
            color: white;
        }

        .timeline {
            border-left: 2px solid rgba(242, 183, 5, 0.2);
            padding-left: 25px;
            margin-top: 30px;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 25px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -31px;
            top: 5px;
            width: 12px;
            height: 12px;
            background: #F2B705;
            border: 2px solid #0D3E72;
            border-radius: 50%;
        }

        .timeline-item strong {
            color: #F2B705;
        }

        .timeline-item small {
            color: rgba(224, 239, 255, 0.6);
        }

        .action-bar {
            background: #0C4B8E;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.2);
            position: sticky;
            bottom: 20px;
            display: flex;
            gap: 20px;
            align-items: center;
            border: 1px solid rgba(242, 183, 5, 0.2);
        }

        .action-bar strong {
            color: #F2B705;
        }

        .form-control {
            background: #0A3566;
            border: 1px solid rgba(242, 183, 5, 0.3);
            color: white;
            border-radius: 5px;
            padding: 10px;
        }

        .form-control:focus {
            border-color: #F2B705;
            outline: none;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
        window.csrfHeaders = (headers = {}) => ({ ...headers, 'X-CSRF-Token': window.CSRF_TOKEN });
        window.escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, char => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;'
        })[char]);
    </script>
</head>

<body>
    <nav class="top-nav">
        <div>
            <a href="#" onclick="voltar()" class="text-white" style="text-decoration: none;">
                <i class="fa-solid fa-arrow-left"></i> Voltar
            </a>
        </div>
        <div>Protocolo: <strong id="headerProtocolo">...</strong></div>
    </nav>

    <div class="container-fluid">
        <div class="card-details">
            <div class="d-flex justify-content-between align-items-center mb-4"
                style="display: flex; justify-content: space-between;">
                <h2>Detalhes da Solicitação</h2>
                <span id="badgeStatus" class="status-badge">Carregando...</span>
            </div>

            <div class="info-grid">
                                <div class="info-group">
                    <label>Título / Assunto</label>
                    <strong id="solTitulo">-</strong>
                </div>
                <div class="info-group">
                    <label>Vencimento (SLA)</label>
                    <strong id="solVencimento">-</strong>
                </div>
                <div class="info-group">
                    <label>Cliente</label>
                    <strong id="clienteNome">-</strong>
                </div>
                <div class="info-group">
                    <label>CPF</label>
                    <strong id="clienteCpf">-</strong>
                </div>
                <div class="info-group">
                    <label>Contato</label>
                    <strong id="clienteContato">-</strong>
                </div>
                <div class="info-group">
                    <label>Serviço Solicitado</label>
                    <strong id="servicoNome">-</strong> (ID: <span id="servicoId">-</span>)
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

            <div class="mb-4">
                <h4>Observações do Cliente</h4>
                <p id="obsCliente" style="background: #f9f9f9; padding: 15px; border-radius: 5px;">-</p>
            </div>

            <div class="mb-4">
                <h4>Histórico de Movimentações</h4>
                <div class="timeline" id="timelineList">
                    <!-- JS Preenche -->
                </div>
            </div>
            <div class="mb-4">
                <h4>Anexos</h4>
                <div id="anexosList">Nenhum anexo.</div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
                <div class="action-bar" style="flex-direction: column; align-items: stretch;">
            <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 20px; background: rgba(0,0,0,0.2); padding: 15px; border-radius: 8px; border: 1px solid rgba(242, 183, 5, 0.3);">
                <input type="checkbox" id="chkAvisado" style="width: 20px; height: 20px; accent-color: #F2B705;">
                <label for="chkAvisado" style="color: #F2B705; margin: 0; cursor: pointer;">Declaro sob responsabilidade legal que o cliente foi oficialmente notificado desta atualização e todas as documentações emitidas na tabela Custas foram juntadas.</label>
            </div>
            <div style="display: flex; gap: 20px; align-items: center;">
                <strong>Ações:</strong>
            <select id="novoStatus" class="form-control" style="padding: 8px;">
                <option value="">Alterar Status...</option>
                <option value="analise">Em Análise</option>
                <option value="em_andamento">Em Andamento</option>
                <option value="aguardando_pagamento">Aguardando Pagamento</option>
                <option value="concluido">Concluído</option>
                <option value="cancelado">Cancelado</option>
            </select>
            <input type="text" id="obsInterna" placeholder="Observação interna (opcional)"
                style="flex-grow: 1; padding: 8px;">
            <button onclick="atualizarStatus()" class="btn-primary"
                style="padding: 8px 20px; background: var(--secondary-color); color: white; border: none; border-radius: 5px; cursor: pointer;">Salvar</button>
            </div>
        </div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        let force = urlParams.get('force') === 'true';

        async function carregarDetalhes() {
            if (!id) { alert('ID inválido'); window.location.href = 'dashboard.php'; return; }

            // Construir URL
            let url = `../system/api/detalhes_solicitacao.php?id=${id}`;
            if (force) url += '&force=true';

            try {
                const response = await fetch(url, { headers: csrfHeaders() });
                const data = await response.json();

                // Tratamento de Erros e Bloqueios
                if (!data.sucesso) {
                    if (data.erro === 'bloqueado') {
                        alert(`❌ ACESSO NEGADO\n\nEste protocolo está sendo editado por: ${data.bloqueado_por}.\n\nTente novamente mais tarde.`);
                        window.location.href = 'dashboard.php';
                        return;
                    }
                    if (data.erro === 'aviso_bloqueio') {
                        const confirmar = confirm(`🔒 ATENÇÃO DE SEGURANÇA\n\n${data.mensagem}\n\nDeseja assumir a edição forçadamente?`);
                        if (confirmar) {
                            window.location.href = `detalhes_solicitacao.php?id=${id}&force=true`;
                        } else {
                            window.location.href = 'dashboard.php';
                        }
                        return;
                    }
                    alert('Erro: ' + data.erro);
                    return;
                }

                const s = data.solicitacao;

                // Preencher Campos
                document.getElementById('headerProtocolo').innerText = s.protocolo;
                                document.getElementById('solTitulo').innerText = s.titulo || 'Não informado';
                document.getElementById('solVencimento').innerText = s.vencimento_em ? new Date(s.vencimento_em).toLocaleDateString('pt-BR') : 'Não definido';
                document.getElementById('clienteNome').innerText = s.cliente_nome;
                document.getElementById('clienteCpf').innerText = s.cliente_cpf;
                document.getElementById('clienteContato').innerText = s.cliente_telefone + ' / ' + s.cliente_email;
                document.getElementById('servicoId').innerText = s.servico_id;
                document.getElementById('servicoNome').innerText = s.servico_nome || 'Não identificado';
                document.getElementById('obsCliente').innerText = s.observacoes_cliente || 'Nenhuma observação.';

                // Status Badge
                const badge = document.getElementById('badgeStatus');
                badge.innerText = s.status.toUpperCase().replace('_', ' ');
                badge.className = 'status-badge ' + getStatusColor(s.status);

                // Histórico
                const timeline = document.getElementById('timelineList');
                timeline.innerHTML = '';
                data.historico.forEach(h => {
                    const item = `
                        <div class="timeline-item">
                            <strong>${escapeHtml(h.usuario_nome || 'Sistema')}</strong> - <small>${escapeHtml(new Date(h.data_movimentacao).toLocaleString())}</small><br>
                            ${escapeHtml(h.descricao)}
                        </div>
                    `;
                    timeline.innerHTML += item;
                });

                const anexosList = document.getElementById('anexosList');
                anexosList.replaceChildren();
                if (!data.anexos.length) {
                    anexosList.textContent = 'Nenhum anexo.';
                } else {
                    data.anexos.forEach(anexo => {
                        const link = document.createElement('a');
                        link.href = `../system/api/download_anexo.php?id=${encodeURIComponent(anexo.id)}`;
                        link.textContent = anexo.nome_arquivo_original;
                        link.style.display = 'block';
                        link.style.color = '#F2B705';
                        anexosList.appendChild(link);
                    });
                }

            } catch (error) {
                console.error(error);
                alert('Erro de conexão');
            }
        }

        async function atualizarStatus() {
            const novoStatus = document.getElementById('novoStatus').value;
            const obs = document.getElementById('obsInterna').value;

            if (!novoStatus) return alert('Selecione um status!');
            
            const aviso = document.getElementById('chkAvisado').checked;
            if(!aviso && novoStatus !== 'pendente') {
                if (typeof Swal !== 'undefined') Swal.fire({icon: 'error', title: 'Ação Bloqueada', text: 'Você precisa confirmar o aviso ao cliente marcando a caixa de seleção acima.', background: '#091524', color: '#fff'});
                else alert('Você precisa confirmar o aviso ao cliente marcando a caixa!');
                return;
            }

            const formData = new FormData();
            formData.append('cliente_avisado', aviso ? 'true' : 'false');
            formData.append('id', id);
            formData.append('status', novoStatus);
            formData.append('observacao', obs);

            try {
                const res = await fetch('../system/api/atualizar_status.php', { method: 'POST', headers: csrfHeaders(), body: formData });
                const data = await res.json();
                if (data.sucesso) {
                    alert('Status atualizado!');
                    location.reload();
                } else {
                    alert('Erro: ' + data.erro);
                }
            } catch (e) { alert('Erro ao salvar'); }
        }

        async function voltar() {
            // Desbloquear antes de sair
            if (id) {
                navigator.sendBeacon('../system/api/desbloquear_protocolo.php', new URLSearchParams({ id: id, _csrf: CSRF_TOKEN }));
            }
            window.location.href = 'dashboard.php';
        }

        function getStatusColor(status) {
            if (status === 'pendente') return 'bg-warning'; // Adapte cores css
            if (status === 'concluido') return 'bg-success';
            return 'bg-info';
        }

        // Bloqueio ao fechar aba
        window.addEventListener('beforeunload', function () {
            if (id) {
                navigator.sendBeacon('../system/api/desbloquear_protocolo.php', new URLSearchParams({ id: id, _csrf: CSRF_TOKEN }));
            }
        });

        carregarDetalhes();
    </script>

    <style>
        .bg-warning {
            background: #fff3cd;
            color: #856404;
        }

        .bg-success {
            background: #d4edda;
            color: #155724;
        }

        .bg-info {
            background: #cce5ff;
            color: #004085;
        }
    </style>
</body>

</html>
