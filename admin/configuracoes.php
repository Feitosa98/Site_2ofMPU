<?php
require_once __DIR__ . '/../system/auth.php';
checkLevel(['admin', 'supervisor']);
if (isset($_SESSION['user_level']) && $_SESSION['user_level'] === 'colaborador') { header("Location: dashboard"); exit; }
$page_title = "Configurações - Gestão Cartório";
include 'components/header_admin.php';
include 'components/sidebar_admin.php';
?>

<main class="main-content">
            <div class="header-dash">
                <h2>Ajustes do Sistema</h2>
            </div>

            <form id="configForm">
                <!-- General Identity -->
                <div class="config-card">
                    <h3><i class="fa-solid fa-building"></i> Identidade do Cartório</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nome Fantasia</label>
                            <input type="text" class="form-control" value="Cartório 2º Ofício de Manacapuru">
                        </div>
                        <div class="form-group">
                            <label>Cidade / Unidade</label>
                            <input type="text" class="form-control" value="Manacapuru - AM">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Telefone de Contato</label>
                            <input type="text" class="form-control" value="(92) 3361-XXXX">
                        </div>
                        <div class="form-group">
                            <label>E-mail Oficial</label>
                            <input type="email" class="form-control" value="contato@cartorio2oficio.com">
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="config-card">
                    <h3><i class="fa-solid fa-shield-halved"></i> Segurança e Acesso</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Tempo de Sessão (Inatividade)</label>
                            <select class="form-control">
                                <option>30 Minutos</option>
                                <option selected>1 Hora</option>
                                <option>4 Horas</option>
                                <option>Nunca expirar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nível de Senha</label>
                            <select class="form-control">
                                <option>Simples (6+ caracteres)</option>
                                <option selected>Forte (Letras, Números e Símbolos)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Maintenance -->
                <div class="config-card">
                    <h3><i class="fa-solid fa-screwdriver-wrench"></i> Manutenção</h3>
                    <div class="maint-item">
                        <div class="maint-text">
                            <h4>Backup do Banco de Dados</h4>
                            <p>Último backup realizado há 12 horas.</p>
                        </div>
                        <button type="button" class="btn-maint"><i class="fa-solid fa-download"></i> Baixar Agora</button>
                    </div>
                    <div class="maint-item">
                        <div class="maint-text">
                            <h4>Limpar Logs do Sistema</h4>
                            <p>Excluir registros de acesso com mais de 90 dias.</p>
                        </div>
                        <button type="button" class="btn-maint" style="color: #ff6b6b; border-color: #ff6b6b">Executar Limpeza</button>
                    </div>
                </div>

                <div style="text-align: right; margin-bottom: 50px;">
                    <button type="submit" class="btn-save">Salvar Alterações</button>
                </div>
            </form>
        </main>

<?php ob_start(); ?>
<script>
        document.getElementById('configForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Configurações salvas com sucesso no sistema!');
        });
    </script>

<?php $extra_js = ob_get_clean(); ?>

<?php include 'components/footer_admin.php'; ?>
