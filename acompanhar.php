<?php
// Função de consulta de protocolo desativada conforme determinação da serventia.
header("Location: /", true, 301);
exit;

$page_title = "Acompanhar Solicitação - Cartório 2º Ofício de Manacapuru";
$page_desc = "Consulte o status em tempo real da sua solicitação no Cartório 2º Ofício de Manacapuru utilizando o protocolo e a senha.";
$is_home = false;
include 'components/header.php';
?>

    <section class="page-header service-page-header">
        <div class="container">
            <span class="page-eyebrow">Consulta em Tempo Real</span>
            <h1>Acompanhar Pedido</h1>
            <p>Consulte o status e o histórico de andamento da sua solicitação utilizando o número do protocolo e a senha informada no momento do pedido.</p>
        </div>
    </section>

    <div class="container service-page">
        <div class="track-container">
            <form id="trackForm" action="system/api/consultar_protocolo.php" method="POST">
                <input type="hidden" name="_csrf" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                
                <div class="form-group">
                    <label class="form-label">Número do Protocolo</label>
                    <input type="text" class="form-control" name="protocolo" placeholder="Ex: CART2026..." required>
                </div>

                <div class="form-group">
                    <label class="form-label">Senha de Acesso (6 dígitos)</label>
                    <input type="password" class="form-control" name="senha" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" placeholder="Digite a senha de 6 dígitos" required>
                    <small style="color: #94a3b8; font-size: 0.85rem; margin-top: 5px; display: block;">
                        <i class="fa-solid fa-circle-info"></i> A senha foi gerada no momento da criação do pedido e enviada ao seu e-mail.
                    </small>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3" style="width: 100%;">
                    <i class="fa-solid fa-magnifying-glass"></i> Consultar Andamento
                </button>
            </form>

            <!-- Resultado -->
            <div id="trackResult"
                style="display: none; margin-top: 40px; border-top: 1px solid rgba(230,206,129,0.2); padding-top: 30px;">
            </div>
        </div>
    </div>

    <script>
        document.getElementById('trackForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const resultDiv = document.getElementById('trackResult');

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Consultando...';
            resultDiv.style.display = 'none';

            fetch('system/api/consultar_protocolo.php', {
                method: 'POST',
                headers: typeof csrfHeaders === 'function' ? csrfHeaders() : {},
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.sucesso) {
                        displayResult(data.dados);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Atenção',
                            text: data.erro || 'Não foi possível localizar o protocolo.',
                            background: '#091524',
                            color: '#fff',
                            confirmButtonColor: '#F2B705'
                        });
                    }
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> Consultar Andamento';
                })
                .catch(error => {
                    console.error('Erro:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Falha de Conexão',
                        text: 'Não foi possível conectar ao servidor. Tente novamente em instantes.',
                        background: '#091524',
                        color: '#fff',
                        confirmButtonColor: '#F2B705'
                    });
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> Consultar Andamento';
                });
        });

        function displayResult(dados) {
            const resultDiv = document.getElementById('trackResult');

            let statusClass = 'status-pendente';
            let statusText = 'Pendente';

            if (dados.status === 'em_andamento') {
                statusClass = 'status-andamento';
                statusText = 'Em Andamento';
            } else if (dados.status === 'concluido') {
                statusClass = 'status-concluido';
                statusText = 'Concluído';
            }

            let timelineHTML = '';
            if (dados.historico && dados.historico.length > 0) {
                dados.historico.forEach((item, index) => {
                    const activeClass = index === 0 ? 'active' : '';
                    timelineHTML += `
                        <div class="timeline-item ${activeClass}">
                            <h4>${escapeHtml(item.descricao)}</h4>
                            <p class="text-muted" style="color: #94a3b8;">${escapeHtml(item.data_formatada)}</p>
                        </div>
                    `;
                });
            } else {
                timelineHTML = '<p style="color: #94a3b8;">Nenhuma movimentação registrada até o momento.</p>';
            }

            resultDiv.innerHTML = `
                <h3 class="text-center mb-4" style="text-align: center; color: white; margin-bottom: 20px;">Protocolo: <span style="color: var(--secondary);">${escapeHtml(dados.protocolo)}</span></h3>
                
                <div class="text-center mb-4" style="text-align: center; margin-bottom: 25px;">
                    <span class="status-badge ${statusClass}">${statusText}</span>
                </div>
                
                <div style="background: rgba(0,0,0,0.3); border: 1px solid rgba(230,206,129,0.2); padding: 22px; border-radius: 12px; margin-bottom: 30px; color: #e0efff; line-height: 1.7;">
                    <p style="margin-bottom: 6px;"><strong>Serviço:</strong> ${escapeHtml(dados.servico)}</p>
                    <p style="margin-bottom: 6px;"><strong>Solicitante:</strong> ${escapeHtml(dados.cliente_nome)}</p>
                    <p style="margin-bottom: 6px;"><strong>Data da Solicitação:</strong> ${escapeHtml(dados.data_criacao)}</p>
                    ${dados.observacoes_cliente ? `<p style="margin-bottom: 0;"><strong>Observações:</strong> ${escapeHtml(dados.observacoes_cliente)}</p>` : ''}
                </div>
                
                <h4 style="color: var(--secondary); margin-bottom: 20px;">Histórico de Movimentações</h4>
                <div class="status-timeline">
                    ${timelineHTML}
                </div>
            `;

            resultDiv.style.display = 'block';
        }
    </script>

<?php include 'components/footer.php'; ?>
