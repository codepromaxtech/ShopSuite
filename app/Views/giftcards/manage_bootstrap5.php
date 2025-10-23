<?php
/**
 * Modern Bootstrap 5 Giftcards Management View with Full Functionality
 * @var string $controller_name
 * @var string $table_headers
 * @var array $config
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.giftcards'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<script type="text/javascript">
    $(document).ready(function() {
        <?= view('partial/bootstrap_tables_locale') ?>

        table_support.init({
            resource: '<?= esc($controller_name) ?>',
            headers: <?= $table_headers ?>,
            pageSize: <?= $config['lines_per_page'] ?>,
            uniqueId: 'giftcard_id'
        });
        
        // Initialize modal dialog support for buttons
        dialog_support.init("button.modal-dlg");
    });
    
    // Filter Functions
    function filterRecent() {
        const lastWeek = new Date();
        lastWeek.setDate(lastWeek.getDate() - 7);
        $('#table').bootstrapTable('filterBy', {
            date: { $gte: lastWeek.toISOString().split('T')[0] }
        });
        showNotification('Showing gift cards from last 7 days', 'info');
    }
    
    function filterActive() {
        $('#table').bootstrapTable('filterBy', {
            status: 'active'
        });
        showNotification('Showing active gift cards only', 'info');
    }
    
    function clearFilters() {
        $('#table').bootstrapTable('clearFilter');
        $('#filter-number, #filter-value, #filter-date-from, #filter-date-to').val('');
        showNotification('Filters cleared', 'success');
    }
    
    function applyAdvancedFilters() {
        const filters = {};
        const number = $('#filter-number').val();
        const value = $('#filter-value').val();
        const dateFrom = $('#filter-date-from').val();
        const dateTo = $('#filter-date-to').val();
        
        if (number) filters.giftcard_number = number;
        if (value) filters.value = value;
        if (dateFrom) filters.date_from = dateFrom;
        if (dateTo) filters.date_to = dateTo;
        
        $('#table').bootstrapTable('refreshOptions', {
            queryParams: function(params) {
                return $.extend(params, filters);
            }
        });
        $('#table').bootstrapTable('refresh');
        showNotification('Filters applied', 'success');
    }
    
    function resetAdvancedFilters() {
        $('#filter-number, #filter-value, #filter-date-from, #filter-date-to').val('');
        $('#table').bootstrapTable('refresh');
        showNotification('Filters reset', 'info');
    }
    
    async function bulkPrint() {
        const selected = $('#table').bootstrapTable('getSelections');
        if (selected.length === 0) {
            showNotification('Please select gift cards first', 'warning');
            return;
        }
        showNotification('Print feature coming soon!', 'info');
    }
    
    async function bulkEmail() {
        const selected = $('#table').bootstrapTable('getSelections');
        if (selected.length === 0) {
            showNotification('Please select gift cards first', 'warning');
            return;
        }
        showNotification('Email feature coming soon!', 'info');
    }
</script>

<!-- Modern Title Bar -->
<div class="d-flex justify-content-between align-items-center mb-3 slide-down">
    <div>
        <h2 class="mb-0"><?= lang('Module.giftcards') ?></h2>
        <p class="text-muted mb-0 small">Manage gift cards and vouchers</p>
    </div>
    <div class="d-flex gap-2 print_hide">
        <button class="btn btn-primary modal-dlg" data-btn-new="<?= lang('Common.new') ?>" data-btn-submit="<?= lang('Common.submit') ?>" data-href="<?= "$controller_name/view" ?>" title="<?= lang(ucfirst($controller_name) . '.new') ?>">
            <i class="bi bi-gift me-2"></i><?= lang(ucfirst($controller_name) . '.new') ?>
        </button>
    </div>
</div>

<!-- Enhanced Toolbar -->
<div class="card border-0 shadow-sm mb-3 slide-up">
    <div class="card-body">
        <div class="row g-3">
            <!-- Bulk Actions -->
            <div class="col-12 col-md-6 col-lg-4">
                <label class="form-label small fw-semibold text-muted">Bulk Actions</label>
                <div class="d-flex gap-2">
                    <button id="delete" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i><?= lang('Common.delete') ?>
                    </button>
                    <button class="btn btn-secondary" onclick="bulkPrint()">
                        <i class="bi bi-printer me-1"></i>Print
                    </button>
                    <button class="btn btn-secondary" onclick="bulkEmail()">
                        <i class="bi bi-envelope me-1"></i>Email
                    </button>
                </div>
            </div>
            
            <!-- Export Options -->
            <div class="col-12 col-md-6 col-lg-4">
                <label class="form-label small fw-semibold text-muted">Export Data</label>
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-export" onclick="exportToExcel()" title="Export to Excel">
                        <i class="bi bi-file-earmark-excel"></i>
                        <span class="d-none d-lg-inline">Excel</span>
                    </button>
                    <button class="btn btn-danger btn-export" onclick="exportToPDF()" title="Export to PDF">
                        <i class="bi bi-file-earmark-pdf"></i>
                        <span class="d-none d-lg-inline">PDF</span>
                    </button>
                    <button class="btn btn-info btn-export" onclick="exportToCSV()" title="Export to CSV">
                        <i class="bi bi-file-earmark-text"></i>
                        <span class="d-none d-lg-inline">CSV</span>
                    </button>
                </div>
            </div>
            
            <!-- Quick Filters -->
            <div class="col-12 col-lg-4">
                <label class="form-label small fw-semibold text-muted">Quick Filters</label>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary" onclick="filterRecent()">
                        <i class="bi bi-clock-history me-1"></i>Recent
                    </button>
                    <button class="btn btn-sm btn-outline-primary" onclick="filterActive()">
                        <i class="bi bi-check-circle me-1"></i>Active
                    </button>
                    <button class="btn btn-sm btn-outline-secondary" onclick="clearFilters()">
                        <i class="bi bi-x-circle me-1"></i>Clear
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Advanced Filters -->
        <div class="mt-3">
            <button class="btn btn-sm btn-link text-decoration-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#advancedFilters">
                <i class="bi bi-funnel me-1"></i>Advanced Filters
                <i class="bi bi-chevron-down"></i>
            </button>
            
            <div class="collapse mt-2" id="advancedFilters">
                <div class="border-top pt-3">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small">Gift Card Number</label>
                            <input type="text" class="form-control" id="filter-number" placeholder="Search number...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Value</label>
                            <input type="text" class="form-control" id="filter-value" placeholder="Min value...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Date From</label>
                            <input type="date" class="form-control" id="filter-date-from">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Date To</label>
                            <input type="date" class="form-control" id="filter-date-to">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" onclick="applyAdvancedFilters()">
                                <i class="bi bi-search me-1"></i>Apply Filters
                            </button>
                            <button class="btn btn-secondary" onclick="resetAdvancedFilters()">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Giftcards Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div id="table_holder" class="table-responsive">
            <table id="table"></table>
        </div>
    </div>
</div>

<?= view('layouts/bootstrap5_footer') ?>
