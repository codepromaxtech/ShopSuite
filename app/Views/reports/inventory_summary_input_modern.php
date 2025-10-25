<?php
/**
 * MODERN INVENTORY SUMMARY INPUT FORM
 * Generate inventory summary reports
 */
$title = 'Inventory Summary Report';
echo view('layouts/modern_header', ['title' => $title]);
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-text">
            <h1 class="page-header-title">Inventory Summary Report</h1>
        </div>
    </div>
    <div class="page-header-actions">
        <a href="<?= base_url('reports') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Reports</span>
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 400px; gap: var(--space-6); max-width: 1400px;">
    <!-- Main Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-header-title">
                <i class="bi bi-funnel"></i>
                Filter Options
            </h3>
        </div>
        <div class="card-body">
            <?= form_open('#', ['id' => 'inventory_form']) ?>
            
            <!-- Stock Location -->
            <div class="form-group">
                <label for="stock_location" class="form-label form-label-required">Stock Location</label>
                <select class="form-control" id="stock_location" name="stock_location" required>
                    <?php if (!empty($stock_locations)): ?>
                        <?php foreach ($stock_locations as $id => $name): ?>
                            <option value="<?= esc($id) ?>"><?= esc($name) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <small class="form-text">Select warehouse or store location</small>
            </div>

            <!-- Inventory Status Filter -->
            <div class="form-group">
                <label for="inventory_filter" class="form-label">Inventory Status</label>
                <select class="form-control" id="inventory_filter" name="inventory_filter">
                    <option value="all">All Items</option>
                    <option value="in_stock">In Stock Only</option>
                    <option value="low_stock">Low Stock Items</option>
                    <option value="out_of_stock">Out of Stock Items</option>
                </select>
                <small class="form-text">Filter by stock availability</small>
            </div>

            <!-- Category Filter -->
            <?php if (!empty($categories)): ?>
                <div class="form-group">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-control" id="category" name="category">
                        <option value="all">All Categories</option>
                        <?php foreach ($categories as $id => $name): ?>
                            <option value="<?= esc($id) ?>"><?= esc($name) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-text">Filter by product category</small>
                </div>
            <?php endif; ?>

            <!-- Export Options -->
            <div class="form-group">
                <label class="form-label">Export Format</label>
                <div style="display: flex; gap: var(--space-3); flex-wrap: wrap;">
                    <label style="display: flex; align-items: center; gap: var(--space-2); cursor: pointer;">
                        <input type="radio" name="export_format" value="screen" checked>
                        <span>View on Screen</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: var(--space-2); cursor: pointer;">
                        <input type="radio" name="export_format" value="excel">
                        <span>Export to Excel</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: var(--space-2); cursor: pointer;">
                        <input type="radio" name="export_format" value="pdf">
                        <span>Export to PDF</span>
                    </label>
                </div>
            </div>

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

        <!-- Report Info -->
        <div class="card" style="margin-top: var(--space-4);">
            <div class="card-header">
                <h3 class="card-header-title">
                    <i class="bi bi-info-circle"></i>
                    Report Details
                </h3>
            </div>
            <div class="card-body">
                <div style="font-size: var(--text-sm); color: var(--text-secondary); line-height: 1.8;">
                    <div style="margin-bottom: var(--space-3);">
                        <i class="bi bi-check-circle" style="color: var(--success-600);"></i>
                        <strong style="margin-left: var(--space-2);">Current stock levels</strong>
                    </div>
                    <div style="margin-bottom: var(--space-3);">
                        <i class="bi bi-check-circle" style="color: var(--success-600);"></i>
                        <strong style="margin-left: var(--space-2);">Item costs & values</strong>
                    </div>
                    <div style="margin-bottom: var(--space-3);">
                        <i class="bi bi-check-circle" style="color: var(--success-600);"></i>
                        <strong style="margin-left: var(--space-2);">Reorder points</strong>
                    </div>
                    <div>
                        <i class="bi bi-check-circle" style="color: var(--success-600);"></i>
                        <strong style="margin-left: var(--space-2);">Location details</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Preview -->
        <div class="card" style="margin-top: var(--space-4); background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
            <div class="card-body">
                <div style="display: flex; gap: var(--space-3);">
                    <div style="flex-shrink: 0;">
                        <i class="bi bi-box-seam" style="font-size: 32px; color: var(--warning-600);"></i>
                    </div>
                    <div>
                        <div style="font-size: var(--text-xs); color: var(--warning-700); font-weight: var(--font-semibold); margin-bottom: var(--space-1);">
                            INVENTORY VALUE
                        </div>
                        <div style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--warning-800);">
                            View Report
                        </div>
                        <div style="font-size: var(--text-xs); color: var(--warning-700); margin-top: var(--space-1);">
                            Generate to see total value
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
[data-theme="dark"] .card[style*="background: linear-gradient"] {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%) !important;
}
</style>

<script>
function generateReport() {
    const location = document.getElementById('stock_location').value;
    const filter = document.getElementById('inventory_filter')?.value || 'all';
    const category = document.getElementById('category')?.value || 'all';
    const exportFormat = document.querySelector('input[name="export_format"]:checked').value;
    
    if (!location) {
        alert('Please select a stock location');
        return;
    }
    
    // Build URL
    let url = '<?= base_url("reports/inventory_summary") ?>/' + location;
    
    if (filter !== 'all') {
        url += '?filter=' + filter;
    }
    if (category !== 'all') {
        url += (url.includes('?') ? '&' : '?') + 'category=' + category;
    }
    if (exportFormat !== 'screen') {
        url += (url.includes('?') ? '&' : '?') + 'export=' + exportFormat;
    }
    
    // Navigate
    window.location.href = url;
}

// Allow Enter key to submit
document.getElementById('inventory_form').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        generateReport();
    }
});
</script>

<?= view('layouts/modern_footer') ?>
