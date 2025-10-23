<?php
/**
 * Modern Bootstrap 5 Receivings Management View
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.receivings'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<?= view('components/page_header', [
    'title' => lang('Module.receivings'),
    'subtitle' => 'Manage stock receiving and purchase orders',
    'icon' => 'bi-box-arrow-in-down',
    'actions' => [
        [
            'label' => 'New Receiving',
            'url' => base_url('receivings/view/-1'),
            'color' => 'success',
            'icon' => 'bi-plus-circle',
            'size' => 'btn-lg'
        ]
    ]
]) ?>

<!-- Receiving Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-success bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Received</p>
                        <h4 class="mb-0 fw-bold text-success">$0.00</h4>
                    </div>
                    <i class="bi bi-box-arrow-in-down fs-1 text-success opacity-50"></i>
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
                        <p class="text-muted mb-1 small">Pending</p>
                        <h4 class="mb-0 fw-bold text-warning">0</h4>
                    </div>
                    <i class="bi bi-clock-history fs-1 text-warning opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-info bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">This Month</p>
                        <h4 class="mb-0 fw-bold text-info">$0.00</h4>
                    </div>
                    <i class="bi bi-calendar-check fs-1 text-info opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Receivings Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-list-ul"></i>
                    Receiving History
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
                           placeholder="Search receivings...">
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" 
                   id="receivings-table"
                   data-toggle="table"
                   data-search="true"
                   data-pagination="true"
                   data-page-size="25">
                <thead class="table-light">
                    <tr>
                        <th data-field="receiving_id" data-sortable="true">Receiving ID</th>
                        <th data-field="date" data-sortable="true">Date</th>
                        <th data-field="supplier" data-sortable="true">Supplier</th>
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
                            <i class="bi bi-box-arrow-in-down fs-1 text-muted d-block mb-3"></i>
                            <p class="text-muted mb-0">No receiving records yet</p>
                            <a href="<?= base_url('receivings/view/-1') ?>" class="btn btn-success mt-3">
                                <i class="bi bi-plus-circle me-2"></i>
                                Create First Receiving
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#receivings-table').bootstrapTable();
});
</script>

<?= view('layouts/bootstrap5_footer') ?>
