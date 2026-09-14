<?php
require_once __DIR__ . '/../system/auth.php';
checkLevel(['admin', 'supervisor']);
if (isset($_SESSION['user_level']) && $_SESSION['user_level'] === 'colaborador') { header("Location: dashboard"); exit; }
$page_title = "Gerenciar Usuários - Gestão Cartório";
include 'components/header_admin.php';
include 'components/sidebar_admin.php';
?>

<main class="main-content">
            <div class="header-dash">
                <h2>Gerenciar Usuários Internos</h2>
                <button class="btn-add" onclick="openModal()"><i class="fa-solid fa-user-plus"></i> Novo Usuário</button>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Nível</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="userList">
                        <tr><td colspan="5" style="text-align: center;">Carregando usuários...</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal Novo Usuario -->
            <div class="modal-overlay" id="userModal">
                <div class="modal-content">
                    <span class="close-modal" onclick="closeModal()">&times;</span>
                    <h3 style="color: #E6CE81; margin-bottom: 20px;">Cadastrar Novo Usuário</h3>
                    <form id="formNovoUsuario" onsubmit="salvarUsuario(event)">
                        <div class="form-group">
                            <label>Nome Completo</label>
                            <input type="text" id="novoNome" class="form-control" placeholder="Ex: João Silva" required>
                        </div>
                        <div class="form-group">
                            <label>E-mail (Login)</label>
                            <input type="email" id="novoEmail" class="form-control" placeholder="joao@cartorio.com" required>
                        </div>
                        <div class="form-group">
                            <label>Nível de Acesso</label>
                            <select id="novoNivel" class="form-control" required>
                                <option value="colaborador">Colaborador</option>
                                <?php if($_SESSION['user_level'] === 'admin'): ?>
                                <option value="supervisor">Supervisor</option>
                                <option value="admin">Administrador</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn-submit" style="width: 100%; margin-top: 20px;">Criar Conta</button>
                    </form>
                </div>
            </div>

            <!-- Modal Editar Usuario -->
            <div class="modal-overlay" id="editModal">
                <div class="modal-content">
                    <span class="close-modal" onclick="closeEditModal()">&times;</span>
                    <h3 style="color: #E6CE81; margin-bottom: 20px;">Editar Usuário</h3>
                    <form id="formEditarUsuario" onsubmit="salvarEdicao(event)">
                        <input type="hidden" id="editId">
                        <div class="form-group">
                            <label>Nome Completo</label>
                            <input type="text" id="editNome" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>E-mail (Login)</label>
                            <input type="email" id="editEmail" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nível de Acesso</label>
                            <select id="editNivel" class="form-control" required>
                                <option value="colaborador">Colaborador</option>
                                <?php if($_SESSION['user_level'] === 'admin'): ?>
                                <option value="supervisor">Supervisor</option>
                                <option value="admin">Administrador</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn-submit" style="width: 100%; margin-top: 20px;">Salvar Alterações</button>
                    </form>
                </div>
            </div>

        </main>

<?php ob_start(); ?>
<script>
        function openModal() { document.getElementById('userModal').style.display = 'flex'; }
        function closeModal() { document.getElementById('userModal').style.display = 'none'; }
        
        function openEditModal(id, nome, email, nivel) {
            document.getElementById('editId').value = id;
            document.getElementById('editNome').value = nome;
            document.getElementById('editEmail').value = email;
            document.getElementById('editNivel').value = nivel;
            document.getElementById('editModal').style.display = 'flex';
        }
        function closeEditModal() { document.getElementById('editModal').style.display = 'none'; }

        async function carregarUsuarios() {
            try {
                const response = await fetch('../system/api/listar_usuarios.php');
                const data = await response.json();
                const tbody = document.getElementById('userList');
                tbody.innerHTML = '';
                
                if (data.sucesso && data.usuarios) {
                    data.usuarios.forEach(u => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${escapeHtml(u.nome)}</td>
                            <td>${escapeHtml(u.email)}</td>
                            <td><span class="user-level level-${escapeHtml(u.nivel)}">${escapeHtml(u.nivel.charAt(0).toUpperCase() + u.nivel.slice(1))}</span></td>
                            <td><span style="color: #2ecc71">Ativo</span></td>
                            <td>
                                <button class="btn-edit" type="button" title="Editar"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn-delete" type="button" title="Excluir"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        `;
                        tr.querySelector('.btn-edit').addEventListener('click', () => openEditModal(u.id, u.nome, u.email, u.nivel));
                        tr.querySelector('.btn-delete').addEventListener('click', () => excluirUsuario(u.id, u.nome));
                        tbody.appendChild(tr);
                    });
                } else {
                    tbody.innerHTML = `<tr><td colspan="5">${escapeHtml(data.erro || 'Sem permissão ou sem dados.')}</td></tr>`;
                }
            } catch (e) {
                console.log('Erro de rede: ', e);
            }
        }

        async function salvarUsuario(e) {
            e.preventDefault();
            const btn = e.target.querySelector('button');
            const btnT = btn.innerText;
            btn.innerText = 'Criando...';

            const payload = {
                nome: document.getElementById('novoNome').value,
                email: document.getElementById('novoEmail').value,
                nivel: document.getElementById('novoNivel').value
            };

            try {
                const response = await fetch('../system/api/criar_usuario.php', {
                    method: 'POST',
                    headers: csrfHeaders({ 'Content-Type': 'application/json' }),
                    body: JSON.stringify(payload)
                });
                const data = await response.json();

                if (data.sucesso) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuário Criado!',
                        text: data.mensagem,
                        background: '#091524',
                        color: '#E6CE81',
                        confirmButtonColor: '#F2B705'
                    });
                    closeModal();
                    e.target.reset();
                    carregarUsuarios();
                } else {
                    Swal.fire({ icon: 'error', title: 'Erro', text: data.erro, background: '#091524', color: '#fff', confirmButtonColor: '#ff6b6b' });
                }
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Erro', text: 'Erro de conexão.', background: '#091524', color: '#fff', confirmButtonColor: '#ff6b6b' });
            }
            btn.innerText = btnT;
        }

        async function salvarEdicao(e) {
            e.preventDefault();
            const btn = e.target.querySelector('button');
            const btnT = btn.innerText;
            btn.innerText = 'Salvando...';

            const payload = {
                id: document.getElementById('editId').value,
                nome: document.getElementById('editNome').value,
                email: document.getElementById('editEmail').value,
                nivel: document.getElementById('editNivel').value
            };

            try {
                const response = await fetch('../system/api/editar_usuario.php', {
                    method: 'POST',
                    headers: csrfHeaders({ 'Content-Type': 'application/json' }),
                    body: JSON.stringify(payload)
                });
                const data = await response.json();

                if (data.sucesso) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Atualizado!',
                        text: data.mensagem,
                        background: '#091524',
                        color: '#E6CE81',
                        confirmButtonColor: '#F2B705',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    closeEditModal();
                    carregarUsuarios();
                } else {
                    Swal.fire({ icon: 'error', title: 'Erro', text: data.erro, background: '#091524', color: '#fff', confirmButtonColor: '#ff6b6b' });
                }
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Erro', text: 'Erro de conexão.', background: '#091524', color: '#fff', confirmButtonColor: '#ff6b6b' });
            }
            btn.innerText = btnT;
        }

        async function excluirUsuario(id, nome) {
            const confirm = await Swal.fire({
                title: 'Atenção!',
                text: `Deseja realmente apagar o usuário ${nome}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b6b',
                cancelButtonColor: '#5a626d',
                confirmButtonText: 'Sim, Apagar!',
                cancelButtonText: 'Cancelar',
                background: '#091524',
                color: '#fff'
            });

            if (confirm.isConfirmed) {
                try {
                    const response = await fetch(`../system/api/excluir_usuario.php/${encodeURIComponent(id)}`, { method: 'DELETE', headers: csrfHeaders() });
                    const data = await response.json();
                    
                    if (data.sucesso) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deletado!',
                            text: data.mensagem,
                            background: '#091524',
                            color: '#e0efff',
                            confirmButtonColor: '#F2B705',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        carregarUsuarios();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Erro', text: data.erro, background: '#091524', color: '#fff', confirmButtonColor: '#ff6b6b' });
                    }
                } catch(e) {
                    Swal.fire({ icon: 'error', title: 'Erro', text: 'Falha na conexão', background: '#091524', color: '#fff', confirmButtonColor: '#ff6b6b' });
                }
            }
        }

        document.addEventListener('DOMContentLoaded', carregarUsuarios);
    </script>

<?php $extra_js = ob_get_clean(); ?>

<?php include 'components/footer_admin.php'; ?>
