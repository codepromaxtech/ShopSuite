<?php
/**
 * MODERN TAXES PAGE - Bootstrap 5
 */
?>

<?= view('layouts/bootstrap5_header') ?>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2>
            <i class="bi bi-percent"></i>
            Tax Management
        </h2>
        <p class="page-header-subtitle">Manage tax rates, categories, and jurisdictions</p>
    </div>
    <div class="page-header-actions">
        <button class="btn btn-light" onclick="exportData()">
            <i class="bi bi-download me-1"></i>Export
        </button>
        <button class="btn btn-primary" onclick="addTaxRate()">
            <i class="bi bi-plus-circle me-1"></i>Add Tax Rate
        </button>
    </div>
</div>

<div class="container-fluid">
    <!-- Tax Overview Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-3">
            <div class="stat-item">
                <div class="stat-item-icon" style="background: #dbeafe; color: #1e40af;">
                    <i class="bi bi-percent"></i>
                </div>
                <div class="stat-item-content">
                    <div class="stat-item-label">Total Tax Rates</div>
                    <div class="stat-item-value"><?= count($tax_rates ?? []) ?></div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="stat-item">
                <div class="stat-item-icon" style="background: #d1fae5; color: #065f46;">
                    <i class="bi bi-tag"></i>
                </div>
                <div class="stat-item-content">
                    <div class="stat-item-label">Tax Categories</div>
                    <div class="stat-item-value"><?= count($tax_categories ?? []) ?></div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="stat-item">
                <div class="stat-item-icon" style="background: #fef3c7; color: #92400e;">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <div class="stat-item-content">
                    <div class="stat-item-label">Jurisdictions</div>
                    <div class="stat-item-value"><?= count($tax_jurisdictions ?? []) ?></div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="stat-item">
                <div class="stat-item-icon" style="background: #e0e7ff; color: #4338ca;">
                    <i class="bi bi-code"></i>
                </div>
                <div class="stat-item-content">
                    <div class="stat-item-label">Tax Codes</div>
                    <div class="stat-item-value"><?= count($tax_codes ?? []) ?></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Toolbar -->
    <div class="toolbar">
        <div class="toolbar-search">
            <input type="text" placeholder="Search tax rates..." id="searchInput" onkeyup="filterTable()">
        </div>
        <div class="toolbar-actions">
            <button class="btn btn-sm btn-outline-secondary" onclick="refreshData()">
                <i class="bi bi-arrow-clockwise"></i> Refresh
            </button>
        </div>
    </div>
    
    <!-- Tax Rates Table -->
    <div class="data-table-container">
        <table class="data-table" id="taxRatesTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Tax Name <i class="bi bi-arrow-down-up"></i></th>
                    <th onclick="sortTable(1)">Rate % <i class="bi bi-arrow-down-up"></i></th>
                    <th onclick="sortTable(2)">Category <i class="bi bi-arrow-down-up"></i></th>
                    <th onclick="sortTable(3)">Jurisdiction <i class="bi bi-arrow-down-up"></i></th>
                    <th onclick="sortTable(4)">Status <i class="bi bi-arrow-down-up"></i></th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tax_rates)): ?>
                    <?php foreach ($tax_rates as $tax): ?>
                        <tr>
                            <td class="fw-semibold"><?= esc($tax['tax_name'] ?? 'N/A') ?></td>
                            <td>
                                <span class="badge bg-primary"><?= number_format($tax['tax_rate'] ?? 0, 2) ?>%</span>
                            </td>
                            <td>
                                <span class="badge bg-info"><?= esc($tax['category'] ?? 'General') ?></span>
                            </td>
                            <td><?= esc($tax['jurisdiction'] ?? 'N/A') ?></td>
                            <td>
                                <?php if (($tax['is_active'] ?? 1) == 1): ?>
                                    <span class="badge-status active">Active</span>
                                <?php else: ?>
                                    <span class="badge-status inactive">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-icon-sm btn-action-edit" onclick="editTax(<?= $tax['tax_id'] ?? 0 ?>)" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-icon-sm btn-action-delete" onclick="deleteTax(<?= $tax['tax_id'] ?? 0 ?>)" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-percent"></i>
                                </div>
                                <div class="empty-state-title">No Tax Rates Found</div>
                                <div class="empty-state-description">Start by adding your first tax rate</div>
                                <button class="btn btn-primary" onclick="addTaxRate()">
                                    <i class="bi bi-plus-circle me-1"></i>Add Tax Rate
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function addTaxRate() {
    window.location.href = '<?= base_url("taxes/view/-1") ?>';
}

function editTax(taxId) {
    window.location.href = `<?= base_url("taxes/view/") ?>${taxId}`;
}

function deleteTax(taxId) {
    if (confirm('Are you sure you want to delete this tax rate?')) {
        // Add delete logic
        showNotification('Tax rate deleted', 'success');
    }
}

function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toUpperCase();
    const table = document.getElementById('taxRatesTable');
    const tr = table.getElementsByTagName('tr');
    
    for (let i = 1; i < tr.length; i++) {
        const td = tr[i].getElementsByTagName('td');
        let found = false;
        for (let j = 0; j < td.length; j++) {
            if (td[j].textContent.toUpperCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        tr[i].style.display = found ? '' : 'none';
    }
}

function sortTable(columnIndex) {
    // Add sorting logic
}

function refreshData() {
    location.reload();
}

function exportData() {
    showNotification('Exporting data...', 'info');
    // Add export logic
}
</script>

<?= view('layouts/bootstrap5_footer') ?>
