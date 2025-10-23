<?php
/**
 * Modern Bootstrap 5 Sales Management View with Full Functionality
 * @var string $controller_name
 * @var string $table_headers
 * @var array $filters
 * @var array $selected_filters
 * @var array $config
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.sales'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<script type="text/javascript">
    $(document).ready(function() {
        console.log('🚀 Sales - Initializing Modern Table...');
        
        // Load the preset daterange picker
        <?= view('partial/daterangepicker') ?>
        <?= view('partial/bootstrap_tables_locale') ?>

        // Initialize Modern Table Manager with custom query params
        window.tableManager = new ModernTableManager({
            selector: '#table',
            toolbarSelector: '#toolbar',
            resource: '<?= esc($controller_name) ?>',
            headers: <?= $table_headers ?>,
            pageSize: <?= $config['lines_per_page'] ?>,
            uniqueId: 'sale_id',
            employeeId: '<?= $user_info->person_id ?? '' ?>',
            queryParams: function(params) {
                return {
                    limit: params.limit,
                    offset: params.offset,
                    search: params.search,
                    sort: params.sort,
                    order: params.order,
                    start_date: window.start_date || '',
                    end_date: window.end_date || '',
                    filters: $("#filters").val() || []
                };
            },
            onLoadSuccess: function(data) {
                console.log('✅ Sales table loaded:', data.total, 'sales');
                
                // Update payment summary if exists
                if (data.payment_summary && $("#table tbody tr").length > 1) {
                    $("#payment_summary").html(data.payment_summary);
                    $("#table tbody tr:last td:first").html("");
                    $("#table tbody tr:last").css('font-weight', 'bold');
                }
                
                // Reinitialize modal triggers
                setTimeout(() => initializeModalTriggers(), 100);
            }
        });
        
        window.tableManager.init();
        
        // Refresh when filters change
        $('#filters').on('hidden.bs.select', function(e) {
            console.log('🔄 Filters changed, refreshing...');
            window.tableManager.refresh();
        });

        // Refresh when date range changes
        $("#daterangepicker").on('apply.daterangepicker', function(ev, picker) {
            console.log('📅 Date range changed, refreshing...');
            window.tableManager.refresh();
        });
        
        console.log('✅ Sales initialized successfully');
    });
    
    // Print selected sales
    function printSelected() {
        const selections = window.tableManager?.getSelections();
        if (!selections || selections.length === 0) {
            showNotification('Please select sales to print', 'warning');
            return;
        }
        
        // Print the current table view
        window.print();
    }
    
    // Quick filter functions
    function filterToday() {
        const today = new Date();
        const dateStr = today.toISOString().split('T')[0];
        window.start_date = dateStr;
        window.end_date = dateStr;
        $('#daterangepicker').val('Today');
        window.tableManager?.refresh();
        showNotification('Showing today\'s sales', 'info');
    }
    
    function filterThisWeek() {
        const today = new Date();
        const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
        window.start_date = weekAgo.toISOString().split('T')[0];
        window.end_date = today.toISOString().split('T')[0];
        $('#daterangepicker').val('Last 7 days');
        window.tableManager?.refresh();
        showNotification('Showing this week\'s sales', 'info');
    }
    
    function filterThisMonth() {
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        window.start_date = firstDay.toISOString().split('T')[0];
        window.end_date = today.toISOString().split('T')[0];
        $('#daterangepicker').val('This month');
        window.tableManager?.refresh();
        showNotification('Showing this month\'s sales', 'info');
    }
</script>

<?= view('partial/print_receipt', ['print_after_sale' => false, 'selected_printer' => 'takings_printer']) ?>

<!-- Title Bar -->
<div class="mb-4 slide-up">
    <div class="d-flex justify-content-between align-items-center print_hide">
        <div>
            <h2 class="mb-1 fw-bold d-flex align-items-center">
                <i class="bi bi-cart-check me-2 text-primary"></i>
                <?= lang('Module.sales') ?>
            </h2>
            <p class="text-muted mb-0 small">View and manage all sales transactions</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="javascript:printdoc()" class="btn btn-info">
                <i class="bi bi-printer me-1"></i><span class="d-none d-md-inline"><?= lang('Common.print') ?></span>
            </button>
            <?= anchor("sales", '<i class="bi bi-cart-plus me-1"></i><span class="d-none d-md-inline">' . lang('Sales.register') . '</span>', ['class' => 'btn btn-success', 'id' => 'show_sales_button']) ?>
        </div>
    </div>
</div>

<!-- Enhanced Toolbar with Filters and Export -->
<div id="toolbar" class="card border-0 shadow-sm mb-3 slide-up">
    <div class="card-body">
        <div class="row g-3">
            <!-- Bulk Actions -->
            <div class="col-12 col-md-6 col-lg-4">
                <label class="form-label small fw-semibold text-muted">Actions</label>
                <div class="d-flex gap-2">
                    <button id="delete" class="btn btn-danger print_hide">
                        <i class="bi bi-trash me-1"></i><?= lang('Common.delete') ?>
                    </button>
                    <button class="btn btn-info print_hide" onclick="printSelected()">
                        <i class="bi bi-printer me-1"></i>Print
                    </button>
                </div>
            </div>
            
            <!-- Export Options -->
            <div class="col-12 col-md-6 col-lg-4">
                <label class="form-label small fw-semibold text-muted">Export Data</label>
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-export no-disable" onclick="exportToExcel()" title="Export to Excel">
                        <i class="bi bi-file-earmark-excel"></i>
                        <span class="d-none d-lg-inline">Excel</span>
                    </button>
                    <button class="btn btn-danger btn-export no-disable" onclick="exportToPDF()" title="Export to PDF">
                        <i class="bi bi-file-earmark-pdf"></i>
                        <span class="d-none d-lg-inline">PDF</span>
                    </button>
                    <button class="btn btn-info btn-export no-disable" onclick="exportToCSV()" title="Export to CSV">
                        <i class="bi bi-file-earmark-text"></i>
                        <span class="d-none d-lg-inline">CSV</span>
                    </button>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="col-12 col-lg-4">
                <label class="form-label small fw-semibold text-muted">Filters & Date Range</label>
                <div class="d-flex gap-2 flex-wrap">
                    <?= form_input(['name' => 'daterangepicker', 'class' => 'form-control no-disable', 'id' => 'daterangepicker', 'style' => 'max-width: 200px', 'placeholder' => 'Select date range']) ?>
                    
                    <?= form_multiselect('filters[]', $filters, $selected_filters, [
                        'id'                        => 'filters',
                        'data-none-selected-text'   => lang('Common.none_selected_text'),
                        'class'                     => 'selectpicker show-menu-arrow no-disable',
                        'data-selected-text-format' => 'count > 1',
                        'data-style'                => 'btn-default',
                        'data-width'                => 'fit'
                    ]) ?>
                </div>
            </div>
        </div>
        
        <!-- Quick Date Filters -->
        <div class="border-top pt-3 mt-3">
            <label class="form-label small fw-semibold text-muted">Quick Filters</label>
            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-sm btn-outline-primary no-disable" onclick="filterToday()">
                    <i class="bi bi-calendar-day me-1"></i>Today
                </button>
                <button class="btn btn-sm btn-outline-primary no-disable" onclick="filterThisWeek()">
                    <i class="bi bi-calendar-week me-1"></i>This Week
                </button>
                <button class="btn btn-sm btn-outline-primary no-disable" onclick="filterThisMonth()">
                    <i class="bi bi-calendar-month me-1"></i>This Month
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Sales Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div id="table_holder" class="table-responsive">
            <table id="table"></table>
        </div>
    </div>
</div>

<!-- Payment Summary -->
<div id="payment_summary" class="mt-3 card border-0 shadow-sm">
    <!-- Summary will be populated by AJAX -->
</div>


<?= view('layouts/bootstrap5_footer') ?>
