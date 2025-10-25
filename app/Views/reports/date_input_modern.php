<?php
/**
 * MODERN REPORT DATE INPUT FORM
 * Date range selector for generating reports
 */
$title = 'Generate Report';
echo view('layouts/modern_header', ['title' => $title]);
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-text">
            <h1 class="page-header-title">Generate Report</h1>
        </div>
    </div>
    <div class="page-header-actions">
        <a href="<?= base_url('reports') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Reports</span>
        </a>
    </div>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle"></i>
        <?= esc($error) ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 1fr 400px; gap: var(--space-6); max-width: 1400px;">
    <!-- Main Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-header-title">
                <i class="bi bi-sliders"></i>
                Report Parameters
            </h3>
        </div>
        <div class="card-body">
            <?= form_open('#', ['id' => 'report_form']) ?>
            
            <!-- Date Range -->
            <div class="form-group">
                <label class="form-label form-label-required">Date Range</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="form-label-small">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= date('Y-m-01') ?>" required>
                    </div>
                    <div>
                        <label for="end_date" class="form-label-small">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>
                
                <!-- Quick Date Buttons -->
                <div style="margin-top: var(--space-4); display: flex; flex-wrap: wrap; gap: var(--space-2);">
                    <button type="button" class="btn btn-sm btn-outline" onclick="setDateRange('today')">
                        <i class="bi bi-calendar-day"></i> Today
                    </button>
                    <button type="button" class="btn btn-sm btn-outline" onclick="setDateRange('yesterday')">
                        <i class="bi bi-calendar-minus"></i> Yesterday
                    </button>
                    <button type="button" class="btn btn-sm btn-outline" onclick="setDateRange('this_week')">
                        <i class="bi bi-calendar-week"></i> This Week
                    </button>
                    <button type="button" class="btn btn-sm btn-outline" onclick="setDateRange('last_week')">
                        Last Week
                    </button>
                    <button type="button" class="btn btn-sm btn-outline" onclick="setDateRange('this_month')">
                        <i class="bi bi-calendar-month"></i> This Month
                    </button>
                    <button type="button" class="btn btn-sm btn-outline" onclick="setDateRange('last_month')">
                        Last Month
                    </button>
                    <button type="button" class="btn btn-sm btn-outline" onclick="setDateRange('this_year')">
                        <i class="bi bi-calendar"></i> This Year
                    </button>
                </div>
            </div>

            <!-- Sale Type (if applicable) -->
            <?php if (!empty($mode)): ?>
                <div class="form-group">
                    <?php if ($mode == 'sale'): ?>
                        <label for="input_type" class="form-label form-label-required">Sale Type</label>
                        <?= form_dropdown('sale_type', $sale_type_options ?? [], 'complete', ['id' => 'input_type', 'class' => 'form-control']) ?>
                        <small class="form-text">Filter by sale completion status</small>
                    <?php elseif ($mode == 'receiving'): ?>
                        <label for="input_type" class="form-label form-label-required">Receiving Type</label>
                        <?= form_dropdown(
                            'receiving_type',
                            [
                                'all' => 'All Receivings',
                                'receiving' => 'Receivings Only',
                                'returns' => 'Returns Only',
                                'requisitions' => 'Requisitions Only'
                            ],
                            'all',
                            ['id' => 'input_type', 'class' => 'form-control']
                        ) ?>
                        <small class="form-text">Filter by receiving transaction type</small>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Discount Type -->
            <?php if (isset($discount_type_options)): ?>
                <div class="form-group">
                    <label for="discount_type_id" class="form-label">Discount Type</label>
                    <?= form_dropdown('discount_type', $discount_type_options, $config['default_sales_discount_type'] ?? 0, ['id' => 'discount_type_id', 'class' => 'form-control']) ?>
                    <small class="form-text">Filter discounts by percentage or fixed amount</small>
                </div>
            <?php endif; ?>

            <!-- Stock Location -->
            <?php if (isset($stock_locations)): ?>
                <div class="form-group">
                    <label for="stock_location" class="form-label">Stock Location</label>
                    <?= form_dropdown('stock_location', $stock_locations, 'all', ['id' => 'stock_location', 'class' => 'form-control']) ?>
                    <small class="form-text">Filter by warehouse or store location</small>
                </div>
            <?php endif; ?>

            <!-- Payment Type -->
            <?php if (isset($payment_type)): ?>
                <div class="form-group">
                    <label for="payment_type" class="form-label">Payment Type</label>
                    <?= form_dropdown('payment_type', $payment_type, 'all', ['id' => 'payment_type', 'class' => 'form-control']) ?>
                    <small class="form-text">Filter by payment method</small>
                </div>
            <?php endif; ?>

            <?= form_close() ?>
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Generate Button -->
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-block" onclick="generateReport()">
                    <i class="bi bi-play-circle"></i>
                    <span>Generate Report</span>
                </button>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card" style="margin-top: var(--space-4);">
            <div class="card-header">
                <h3 class="card-header-title">
                    <i class="bi bi-info-circle"></i>
                    Report Information
                </h3>
            </div>
            <div class="card-body">
                <div style="font-size: var(--text-sm); color: var(--text-secondary); line-height: 1.6;">
                    <div style="margin-bottom: var(--space-3);">
                        <strong style="color: var(--text-primary);">Date Range:</strong>
                        <div id="date_display" style="margin-top: var(--space-1); font-family: monospace;">
                            <?= date('Y-m-01') ?> to <?= date('Y-m-d') ?>
                        </div>
                    </div>
                    <div style="margin-bottom: var(--space-3);">
                        <strong style="color: var(--text-primary);">Output Formats:</strong>
                        <ul style="margin: var(--space-2) 0 0 var(--space-4); padding: 0;">
                            <li>View on screen</li>
                            <li>Export to Excel/CSV</li>
                            <li>Export to PDF</li>
                            <li>Print</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Tips -->
        <div class="card" style="margin-top: var(--space-4); background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);">
            <div class="card-body">
                <div style="display: flex; gap: var(--space-3);">
                    <div style="flex-shrink: 0;">
                        <i class="bi bi-lightbulb" style="font-size: 24px; color: var(--info-600);"></i>
                    </div>
                    <div style="font-size: var(--text-sm); color: var(--text-secondary);">
                        <strong style="color: var(--info-700); display: block; margin-bottom: var(--space-2);">Quick Tip</strong>
                        Use the quick date buttons for common date ranges, or select custom dates for specific periods.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-label-small {
    font-size: var(--text-xs);
    font-weight: var(--font-medium);
    color: var(--text-tertiary);
    margin-bottom: var(--space-1);
    display: block;
}

[data-theme="dark"] .card[style*="background: linear-gradient"] {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.1) 100%) !important;
}
</style>

<script>
// Date range presets
function setDateRange(range) {
    const today = new Date();
    let startDate, endDate;
    
    switch(range) {
        case 'today':
            startDate = endDate = formatDate(today);
            break;
        case 'yesterday':
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 1);
            startDate = endDate = formatDate(yesterday);
            break;
        case 'this_week':
            startDate = formatDate(getMonday(today));
            endDate = formatDate(today);
            break;
        case 'last_week':
            const lastWeekEnd = new Date(getMonday(today));
            lastWeekEnd.setDate(lastWeekEnd.getDate() - 1);
            const lastWeekStart = getMonday(lastWeekEnd);
            startDate = formatDate(lastWeekStart);
            endDate = formatDate(lastWeekEnd);
            break;
        case 'this_month':
            startDate = formatDate(new Date(today.getFullYear(), today.getMonth(), 1));
            endDate = formatDate(today);
            break;
        case 'last_month':
            const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
            const lastMonthEnd = new Date(today.getFullYear(), today.getMonth(), 0);
            startDate = formatDate(lastMonth);
            endDate = formatDate(lastMonthEnd);
            break;
        case 'this_year':
            startDate = formatDate(new Date(today.getFullYear(), 0, 1));
            endDate = formatDate(today);
            break;
    }
    
    document.getElementById('start_date').value = startDate;
    document.getElementById('end_date').value = endDate;
    updateDateDisplay();
}

function formatDate(date) {
    return date.toISOString().split('T')[0];
}

function getMonday(d) {
    d = new Date(d);
    const day = d.getDay();
    const diff = d.getDate() - day + (day == 0 ? -6 : 1);
    return new Date(d.setDate(diff));
}

function updateDateDisplay() {
    const start = document.getElementById('start_date').value;
    const end = document.getElementById('end_date').value;
    document.getElementById('date_display').textContent = `${start} to ${end}`;
}

// Update display on date change
document.getElementById('start_date').addEventListener('change', updateDateDisplay);
document.getElementById('end_date').addEventListener('change', updateDateDisplay);

// Generate report
function generateReport() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    if (!startDate || !endDate) {
        alert('Please select both start and end dates');
        return;
    }
    
    if (new Date(startDate) > new Date(endDate)) {
        alert('Start date must be before end date');
        return;
    }
    
    // Get current URL path
    const path = window.location.pathname;
    
    // Build parameters
    let params = '';
    const inputType = document.getElementById('input_type');
    if (inputType) {
        params = inputType.value;
    } else {
        params = 'all';
    }
    
    // Navigate to report
    window.location.href = path.replace('_input', '') + `/${startDate}/${endDate}/${params}/all`;
}

// Initialize
updateDateDisplay();
</script>

<?= view('layouts/modern_footer') ?>
