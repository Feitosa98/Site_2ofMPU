<?php
$page_title = "Solicitar Serviço - Cartório 2º Ofício de Manacapuru";
$is_home = false;
include 'components/header.php';
?>

    <div class="page-header service-page-header">
        <div class="container">
            <span class="page-eyebrow">Atendimento Eletrônico</span>
            <h1>Solicitar Serviço Online</h1>
            <p>Preencha os dados abaixo para iniciar seu atendimento e dar entrada na sua solicitação.</p>
        </div>
    </div>

    <div class="container service-page">
        <div class="form-container">
            <!-- Steps -->
            <div class="step-indicator">
                <div class="step active">
                    1
                    <span class="step-label">Seus Dados</span>
                </div>
                <div class="step">
                    2
                    <span class="step-label">Serviço</span>
                </div>
                <div class="step">
                    3
                    <span class="step-label">Conclusão</span>
                </div>
            </div>

            <form id="solicitacaoForm" action="system/api/criar_solicitacao.php" method="POST"
                enctype="multipart/form-data">
                <input type="hidden" name="_csrf" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                
                <!-- Etapa 1: Dados Pessoais -->
                <div class="form-section" id="step1">
                    <h3 class="mb-4"
                        style="color: #E6CE81; border-bottom: 1px solid rgba(230,206,129,0.3); padding-bottom: 10px; margin-bottom: 20px;">
                        Seus Dados</h3>
                    <div class="form-group">
                        <label class="form-label">Título / Assunto (Ex: Solicitação de Certidão X)</label>
                        <input type="text" class="form-control" name="titulo" required placeholder="Ex: Certidão de Casamento em nome de Fulano">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" name="nome" required placeholder="Seu nome completo">
                    </div>
                    <div class="row" style="display:flex; gap: 20px; flex-wrap: wrap;">
                        <div class="form-group" style="flex:1; min-width: 220px;">
                            <label class="form-label">CPF</label>
                            <input type="text" class="form-control" name="cpf" id="cpf" required
                                placeholder="000.000.000-00">
                        </div>
                        <div class="form-group" style="flex:1; min-width: 220px;">
                            <label class="form-label">Telefone/WhatsApp</label>
                            <input type="text" class="form-control" name="telefone" id="telefone" required
                                placeholder="(92) 00000-0000">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">E-mail</label>
                        <input type="email" class="form-control" name="email" required placeholder="seuemail@exemplo.com">
                    </div>

                    <button type="button" class="btn btn-primary w-100" style="margin-top: 20px; width: 100%;"
                        onclick="nextStep(1)">Próximo Passo <i class="fa-solid fa-arrow-right"></i></button>
                </div>

                <!-- Etapa 2: Serviço -->
                <div class="form-section" id="step2" style="display: none;">
                    <h3 class="mb-4"
                        style="color: #E6CE81; border-bottom: 1px solid rgba(230,206,129,0.3); padding-bottom: 10px; margin-bottom: 20px;">
                        Tipo de Serviço</h3>

                    <div class="form-group">
                        <label class="form-label">Categoria</label>
                        <select class="form-control" id="categoria" onchange="filterServices()">
                            <option value="">Selecione a categoria...</option>
                            <option value="rcpn">Registro Civil das Pessoas Naturais (RCPN)</option>
                            <option value="imoveis">Registro de Imóveis (RI)</option>
                            <option value="pj">Pessoas Jurídicas e Títulos (RTD / RCPJ)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Serviço Específico</label>
                        <select class="form-control" name="servico" id="servico" required>
                            <option value="">Selecione a categoria primeiro...</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Observações / Detalhes do Pedido</label>
                        <textarea class="form-control" name="observacoes" rows="4"
                            placeholder="Descreva os detalhes da sua solicitação, como números de termos, livros, matrículas ou outras informações relevantes..."></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Anexar Documentos (Opcional)</label>
                        <input type="file" class="form-control" name="anexos[]" multiple accept=".pdf,.jpg,.jpeg,.png">
                        <small style="color: #94a3b8;">Formatos aceitos: PDF, JPG, PNG. Máximo: 5MB por arquivo.</small>
                    </div>

                    <div class="d-flex gap-2" style="display:flex; gap:10px; margin-top: 20px;">
                        <button type="button" class="btn btn-outline" style="flex:1;"
                            onclick="prevStep(2)">Voltar</button>
                        <button type="submit" class="btn btn-primary" style="flex:1;">Enviar Solicitação</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom Modal -->
    <div class="custom-modal" id="validationModal">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fa-solid fa-exclamation-triangle"></i>
            </div>
            <h3 class="modal-title">Atenção!</h3>
            <p class="modal-message" id="modalMessage">Mensagem aqui</p>
            <button class="modal-btn" onclick="closeModal()">Entendi</button>
        </div>
    </div>

    <style>
        .custom-modal {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(9, 21, 36, 0.85);
            display: flex;
            align-items: center; justify-content: center;
            z-index: 99999;
            opacity: 0; pointer-events: none;
            transition: all 0.3s ease;
        }
        .custom-modal.show {
            opacity: 1; pointer-events: auto;
        }
        .modal-content {
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            text-align: center;
            max-width: 450px; width: 90%;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            border-top: 5px solid #F2B705;
        }
        .modal-icon i {
            font-size: 50px; color: #e74c3c; margin-bottom: 20px;
        }
        .modal-title { color: #091524; margin-bottom: 15px; font-size: 24px; font-weight: 700; }
        .modal-message { color: #334155; margin-bottom: 25px; line-height: 1.6; font-size: 16px; }
        .modal-btn {
            background: #E6CE81; color: #091524;
            border: none; padding: 12px 30px; border-radius: 6px;
            font-weight: bold; cursor: pointer; font-size: 16px;
            transition: background 0.3s;
        }
        .modal-btn:hover { background: #F2B705; }
    </style>

    <script>
        function showModal(msg) {
            document.getElementById('modalMessage').innerText = msg;
            document.getElementById('validationModal').classList.add('show');
        }
        function closeModal() {
            document.getElementById('validationModal').classList.remove('show');
        }
        function nextStep(step) {
            if (step === 1) {
                const t = document.querySelector('input[name="titulo"]').value.trim();
                const n = document.querySelector('input[name="nome"]').value.trim();
                const c = document.querySelector('input[name="cpf"]').value.trim();
                const tel = document.querySelector('input[name="telefone"]').value.trim();
                const e = document.querySelector('input[name="email"]').value.trim();
                
                if(!t || !n || !c || !tel || !e) {
                    showModal('Por favor, preencha todos os dados pessoais antes de avançar.');
                    return;
                }
                
                document.getElementById('step1').style.display = 'none';
                document.getElementById('step2').style.display = 'block';
                document.querySelectorAll('.step')[1].classList.add('active');
            }
        }
        function prevStep(step) {
            if (step === 2) {
                document.getElementById('step2').style.display = 'none';
                document.getElementById('step1').style.display = 'block';
                document.querySelectorAll('.step')[1].classList.remove('active');
            }
        }
        function filterServices() {
            const cat = document.getElementById('categoria').value;
            const serv = document.getElementById('servico');
            serv.innerHTML = '';
            if (cat === 'rcpn') {
                serv.innerHTML = '<option value="1">Certidão de Nascimento (2ª Via)</option><option value="2">Certidão de Casamento (2ª Via)</option><option value="3">Certidão de Óbito (2ª Via)</option><option value="4">Emancipação</option><option value="5">Retificação de Registro Civil</option>';
            } else if (cat === 'imoveis') {
                serv.innerHTML = '<option value="6">Certidão de Matrícula do Imóvel</option><option value="7">Averbação de Construção</option><option value="8">Registro de Escritura</option><option value="9">Certidão de Ônus Reais</option><option value="10">Retificação de Registro de Imóvel</option>';
            } else if (cat === 'pj') {
                serv.innerHTML = '<option value="11">Registro Civil de Pessoas Jurídicas (RCPJ)</option><option value="12">Registro de Títulos e Documentos (RTD)</option>';
            } else {
                serv.innerHTML = '<option value="">Selecione a categoria primeiro...</option>';
            }
        }

        document.getElementById('solicitacaoForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processando...';
            btn.disabled = true;
            try {
                const res = await fetch('system/api/criar_solicitacao.php', { method: 'POST', headers: csrfHeaders(), body: new FormData(this) });
                const data = await res.json();
                if(data.sucesso) {
                    window.location.href = data.redirect || 'sucesso';
                } else {
                    showModal(data.erro || 'Erro interno ao processar a solicitação.');
                    btn.innerHTML = 'Enviar Solicitação';
                    btn.disabled = false;
                }
            } catch(err) {
                showModal('Falha na comunicação com o servidor.');
                btn.innerHTML = 'Enviar Solicitação';
                btn.disabled = false;
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            var cpfEl = document.querySelector('input[name="cpf"]');
            var foneEl = document.querySelector('input[name="telefone"]');
            if(cpfEl && typeof IMask !== 'undefined'){ IMask(cpfEl, {mask: '000.000.000-00'}); }
            if(foneEl && typeof IMask !== 'undefined'){ IMask(foneEl, {mask: '(00) 00000-0000'}); }
        });
    </script>

<?php include 'components/footer.php'; ?>
