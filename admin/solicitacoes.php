<?php
$page_title = "Solicitações - Gestão Cartório";
include 'components/header_admin.php';
include 'components/sidebar_admin.php';
?>

<main class="main-content">
            <div class="header-dash">
                <h2>Gerenciar Solicitações</h2>
            </div>

            <!-- Search Section -->
            <div class="search-container">
                <div class="search-title">
                    <i class="fa-solid fa-magnifying-glass"></i> Filtros de Busca
                </div>
                <form id="filterForm">
                    <div class="row">
                        <div class="form-group">
                            <label>Número do Protocolo</label>
                            <input type="text" class="form-control" name="protocolo" placeholder="Ex: CART2024...">
                        </div>
                        <div class="form-group">
                            <label>Nome do Cliente</label>
                            <input type="text" class="form-control" name="cliente" placeholder="Burcar por nome...">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                            <option value="">Status...</option>
                            <option value="1">Em análise</option>
                            <option value="2">Aguardando pagamento</option>
                            <option value="3">Em registro/averbação/certidão</option>
                            <option value="4">Concluído</option>
                            <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-search">Filtrar</button>
                    </div>
                </form>

                </form>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Protocolo</th>
                            <th>Cliente</th>
                            <th>Serviço</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="fullList">
                        <tr>
                            <td colspan="6" style="text-align: center; color: rgba(224, 239, 255, 0.5);">Use os filtros para buscar solicitações...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>

<?php ob_start(); ?>
<script>
        // Example logic for search/filters
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // In a real system, this would fetch data from the API
            alert('Funcionalidade de filtro enviada ao servidor!');
        });
    </script>

<?php $extra_js = ob_get_clean(); ?>

<?php include 'components/footer_admin.php'; ?>