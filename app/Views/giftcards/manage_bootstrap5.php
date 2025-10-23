<?php
/**
 * Modern Bootstrap 5 Giftcards Management View
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.giftcards'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<?= view('components/page_header', [
    'title' => lang('Module.giftcards'),
    'subtitle' => 'Manage gift cards and vouchers',
    'icon' => 'bi-gift',
    'actions' => [
        [
            'label' => 'New Gift Card',
            'url' => base_url('giftcards/view/-1'),
            'color' => 'primary',
            'icon' => 'bi-plus-circle',
            'size' => 'btn-lg'
        ]
    ]
]) ?>

<!-- Giftcard Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-primary bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Value</p>
                        <h4 class="mb-0 fw-bold text-primary">$0.00</h4>
                    </div>
                    <i class="bi bi-gift fs-1 text-primary opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-success bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Active Cards</p>
                        <h4 class="mb-0 fw-bold text-success">0</h4>
                    </div>
                    <i class="bi bi-check-circle fs-1 text-success opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 bg-warning bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Redeemed</p>
                        <h4 class="mb-0 fw-bold text-warning">$0.00</h4>
                    </div>
                    <i class="bi bi-cash-coin fs-1 text-warning opacity-50"></i>
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

<!-- Giftcards Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-list-ul"></i>
                    Gift Card List
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
                           placeholder="Search gift cards...">
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" 
                   id="giftcards-table"
                   data-toggle="table"
                   data-search="true"
                   data-pagination="true"
                   data-page-size="25">
                <thead class="table-light">
                    <tr>
                        <th data-field="card_number" data-sortable="true">Card Number</th>
                        <th data-field="value" data-sortable="true">Value</th>
                        <th data-field="balance" data-sortable="true">Balance</th>
                        <th data-field="customer">Customer</th>
                        <th data-field="issued_date">Issued Date</th>
                        <th data-field="expiry_date">Expiry Date</th>
                        <th data-field="status">Status</th>
                        <th data-field="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-gift fs-1 text-muted d-block mb-3"></i>
                            <p class="text-muted mb-0">No gift cards issued yet</p>
                            <a href="<?= base_url('giftcards/view/-1') ?>" class="btn btn-primary mt-3">
                                <i class="bi bi-plus-circle me-2"></i>
                                Issue First Gift Card
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
    $('#giftcards-table').bootstrapTable();
});
</script>

<?= view('layouts/bootstrap5_footer') ?>
