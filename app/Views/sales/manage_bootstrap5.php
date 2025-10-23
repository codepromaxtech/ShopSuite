<?php
/**
 * Modern Bootstrap 5 Sales Management View
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.sales'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<?= view('components/page_header', [
    'title' => lang('Module.sales'),
    'subtitle' => 'Manage sales transactions and orders',
    'icon' => 'bi-cart-check',
    'actions' => [
        [
            'label' => 'New Sale',
            'url' => base_url('sales/register'),
            'color' => 'success',
            'icon' => 'bi-plus-circle',
            'size' => 'btn-lg'
        ]
    ]
]) ?>

<!-- Sales Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-success bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Today's Sales</p>
                        <h4 class="mb-0 fw-bold text-success">$0.00</h4>
                    </div>
                    <i class="bi bi-currency-dollar fs-1 text-success opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-primary bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Orders</p>
                        <h4 class="mb-0 fw-bold text-primary">0</h4>
                    </div>
                    <i class="bi bi-receipt fs-1 text-primary opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-warning bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Avg. Order Value</p>
                        <h4 class="mb-0 fw-bold text-warning">$0.00</h4>
                    </div>
                    <i class="bi bi-graph-up fs-1 text-warning opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-info bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Pending</p>
                        <h4 class="mb-0 fw-bold text-info">0</h4>
                    </div>
                    <i class="bi bi-clock-history fs-1 text-info opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-list-ul"></i>
                    Sales Transactions
                </h5>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           id="search" 
                           placeholder="Search sales...">
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" 
                   id="sales-table"
                   data-toggle="table"
                   data-search="true"
                   data-pagination="true"
                   data-page-size="25"
                   data-show-refresh="true"
                   data-show-columns="true"
                   data-show-export="true">
                <thead class="table-light">
                    <tr>
                        <th data-field="sale_id" data-sortable="true">Sale ID</th>
                        <th data-field="date" data-sortable="true">Date</th>
                        <th data-field="customer" data-sortable="true">Customer</th>
                        <th data-field="items">Items</th>
                        <th data-field="total" data-sortable="true">Total</th>
                        <th data-field="payment">Payment</th>
                        <th data-field="status">Status</th>
                        <th data-field="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                            <p class="text-muted mb-0">No sales transactions yet</p>
                            <a href="<?= base_url('sales/register') ?>" class="btn btn-success mt-3">
                                <i class="bi bi-plus-circle me-2"></i>
                                Make First Sale
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Actions Modal Trigger (Hidden buttons for keyboard shortcuts) -->
<div class="position-fixed bottom-0 end-0 p-4" style="z-index: 1000;">
    <div class="btn-group-vertical shadow-lg" role="group">
        <a href="<?= base_url('sales/register') ?>" 
           class="btn btn-success btn-lg rounded-circle mb-2" 
           style="width: 60px; height: 60px;"
           data-bs-toggle="tooltip" 
           title="New Sale (F2)">
            <i class="bi bi-plus-lg fs-4"></i>
        </a>
        <button type="button" 
                class="btn btn-primary btn-lg rounded-circle" 
                style="width: 60px; height: 60px;"
                data-bs-toggle="tooltip" 
                title="Quick Search (F3)">
            <i class="bi bi-search fs-4"></i>
        </button>
    </div>
</div>

<style>
.table-hover tbody tr:hover {
    background-color: rgba(79, 70, 229, 0.05);
    cursor: pointer;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}
</style>

<script>
// Initialize Bootstrap Table
$(document).ready(function() {
    $('#sales-table').bootstrapTable();
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.key === 'F2') {
            e.preventDefault();
            window.location.href = '<?= base_url('sales/register') ?>';
        }
        if (e.key === 'F3') {
            e.preventDefault();
            document.getElementById('search').focus();
        }
    });
});
</script>

<?= view('layouts/bootstrap5_footer') ?>
