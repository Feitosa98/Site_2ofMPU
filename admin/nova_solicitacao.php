<?php
$page_title = "Nova Solicitação - Gestão Cartório";
include 'components/header_admin.php';
include 'components/sidebar_admin.php';
?>

<main class="main-content">
            <div class="header-dash">
                <h2>Gerar Nova Solicitação Manual</h2>
            </div>

            <div class="form-card">
                <form id="manualSolicitacaoForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-group">
                            <label>Título do Protocolo</label>
                            <input type="text" class="form-control" name="titulo" placeholder="Ex: Averbação Lote 10" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>Nome do Cliente</label>
                            <input type="text" class="form-control" name="nome" placeholder="Nome completo" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>CPF/CNPJ</label>
                            <input type="text" class="form-control" name="cpf" placeholder="000.000.000-00" required>
                        </div>
                        <div class="form-group">
                            <label>Telefone</label>
                            <input type="text" class="form-control" name="telefone" placeholder="(92) 90000-0000">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label>Serviço</label>
                        <select class="form-control" name="servico" required>
                            <option value="">Selecione o serviço...</option>
                            <option value="1">Certidão de Nascimento</option>
                            <option value="6">Certidão de Matrícula</option>
                            <option value="11">Registro de PJ</option>
                        </select>
                    </div>
                    <div class="row" style="background: rgba(242, 183, 5, 0.05); padding: 20px; border-radius: 10px; border: 1px solid rgba(242, 183, 5, 0.2); margin-top: 20px;">
                        <div class="form-group">
                            <label>Protocolo (Manual)</label>
                            <div style="display: flex; gap: 10px;">
                                <input type="text" class="form-control" name="protocolo_manual" id="inputProtocolo" placeholder="Ex: CART123" required>
                                <button type="button" class="btn-submit" style="width: auto; margin-top: 0; padding: 0 15px;" onclick="gerarAutoProtocolo()" title="Gerar Automático"><i class="fa-solid fa-wand-magic-sparkles"></i></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Senha (Manual)</label>
                            <div style="display: flex; gap: 10px;">
                                <input type="text" class="form-control" name="senha_manual" id="inputSenha" placeholder="6 dígitos" required>
                                <button type="button" class="btn-submit" style="width: auto; margin-top: 0; padding: 0 15px;" onclick="gerarAutoSenha()" title="Gerar Automático"><i class="fa-solid fa-wand-magic-sparkles"></i></button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" style="margin-top: 30px;">Salvar Solicitação</button>
                </form>

                <div id="protocolResult">
                    <h3 style="color: #2ecc71; margin-bottom: 10px;">Solicitação Salva com Sucesso!</h3>
                    <p>Dados para o cliente:</p>
                    <div style="background: #0A3566; padding: 15px; border-radius: 8px; margin-top: 15px;">
                        <p style="font-size: 1.2rem; margin: 5px 0;">Protocolo: <strong id="resProtocol" style="color: #F2B705;">-</strong></p>
                        <p style="font-size: 1.2rem; margin: 5px 0;">Senha: <strong id="resSenha" style="color: #F2B705;">-</strong></p>
                    </div>
                </div>
            </div>
        </main>

<?php ob_start(); ?>
<script>
        function gerarAutoProtocolo() {
            document.getElementById('inputProtocolo').value = 'CART' + Math.floor(1000 + Math.random() * 9000);
        }

        function gerarAutoSenha() {
            document.getElementById('inputSenha').value = Math.floor(100000 + Math.random() * 900000);
        }

        document.getElementById('manualSolicitacaoForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = 'Salvando no Banco...';
            btn.disabled = true;

            const fd = new FormData(this);
            // Protocolo e senha manuais tem outro name no html, ajustando
            fd.append('protocolo', document.getElementById('inputProtocolo').value);
            fd.append('senha', document.getElementById('inputSenha').value);

            try {
                const res = await fetch('../system/api/criar_solicitacao_admin.php', {method: 'POST', headers: csrfHeaders(), body: fd});
                const data = await res.json();
                if(data.sucesso) {
                    document.getElementById('protocolResult').style.display = 'block';
                    document.getElementById('resProtocol').innerText = data.dados.protocolo;
                    document.getElementById('resSenha').innerText = data.dados.senha;
                    this.style.opacity = '0.5';
                    this.querySelectorAll('input, select, textarea, button').forEach(el => el.disabled = true);
                    Swal.fire({icon: 'success', title: 'Sucesso', text: 'Protocolo arquivado com Prazo de 20 Dias!', background: '#091524', color: '#fff', confirmButtonColor: '#F2B705'});
                } else {
                    Swal.fire({icon: 'error', title: 'Atenção', text: data.erro, background: '#091524', color: '#fff', confirmButtonColor: '#F2B705'});
                    btn.innerHTML = 'Salvar Solicitação';
                    btn.disabled = false;
                }
            } catch(e) {
                Swal.fire({icon: 'error', title: 'Erro', text: 'Falha de conexão', background: '#091524', color: '#fff', confirmButtonColor: '#F2B705'});
                btn.disabled = false;
            }
        });
    </script>

<?php $extra_js = ob_get_clean(); ?>

<?php include 'components/footer_admin.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var cpfEl = document.querySelector('input[name="cpf"]');
            var foneEl = document.querySelector('input[name="telefone"]');
            if(cpfEl){ IMask(cpfEl, {mask: '000.000.000-00'}); }
            if(foneEl){ IMask(foneEl, {mask: '(00) 00000-0000'}); }
        });
    </script>
