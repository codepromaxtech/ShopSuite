<?php
/**
 * MODERN TAX MANAGEMENT PAGE
 * Tabbed interface for managing tax codes, categories, jurisdictions, and rates
 */
$title = 'Tax Management';
echo view('layouts/modern_header', ['title' => $title]);
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-text">
            <h1 class="page-header-title">Tax Management</h1>
        </div>
    </div>
    <div class="page-header-actions">
        <button class="btn btn-secondary" onclick="window.print()">
            <i class="bi bi-printer"></i>
            <span>Print</span>
        </button>
        <button class="btn btn-primary" onclick="addTaxRate()">
            <i class="bi bi-plus-circle"></i>
            <span>Add Tax Rate</span>
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid" style="margin-bottom: var(--space-8);">
    <div class="stat-card" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
        <div class="stat-card-icon" style="background: rgba(255,255,255,0.2);">
            <i class="bi bi-percent" style="color: white;"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label" style="color: rgba(255,255,255,0.9);">Tax Rates</div>
            <div class="stat-card-value" style="color: white;"><?= count($tax_rates ?? []) ?></div>
            <div style="font-size: var(--text-xs); color: rgba(255,255,255,0.8); margin-top: var(--space-1);">Active rates</div>
        </div>
    </div>
    
    <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
        <div class="stat-card-icon" style="background: rgba(255,255,255,0.2);">
            <i class="bi bi-tag" style="color: white;"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label" style="color: rgba(255,255,255,0.9);">Categories</div>
            <div class="stat-card-value" style="color: white;"><?= count($tax_categories ?? []) ?></div>
            <div style="font-size: var(--text-xs); color: rgba(255,255,255,0.8); margin-top: var(--space-1);">Product types</div>
        </div>
    </div>
    
    <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
        <div class="stat-card-icon" style="background: rgba(255,255,255,0.2);">
            <i class="bi bi-geo-alt" style="color: white;"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label" style="color: rgba(255,255,255,0.9);">Jurisdictions</div>
            <div class="stat-card-value" style="color: white;"><?= count($tax_jurisdictions ?? []) ?></div>
            <div style="font-size: var(--text-xs); color: rgba(255,255,255,0.8); margin-top: var(--space-1);">Geographic areas</div>
        </div>
    </div>
    
    <div class="stat-card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
        <div class="stat-card-icon" style="background: rgba(255,255,255,0.2);">
            <i class="bi bi-code" style="color: white;"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label" style="color: rgba(255,255,255,0.9);">Tax Codes</div>
            <div class="stat-card-value" style="color: white;"><?= count($tax_codes ?? []) ?></div>
            <div style="font-size: var(--text-xs); color: rgba(255,255,255,0.8); margin-top: var(--space-1);">Identifiers</div>
        </div>
    </div>
</div>

<!-- Tabbed Interface -->
<div class="card">
    <div class="tabs-container">
        <div class="tabs-header">
            <button class="tab-btn active" onclick="switchTab('rates')" data-tab="rates">
                <i class="bi bi-percent"></i>
                <span>Tax Rates</span>
                <span class="tab-count"><?= count($tax_rates ?? []) ?></span>
            </button>
            <button class="tab-btn" onclick="switchTab('codes')" data-tab="codes">
                <i class="bi bi-code"></i>
                <span>Tax Codes</span>
                <span class="tab-count"><?= count($tax_codes ?? []) ?></span>
            </button>
            <button class="tab-btn" onclick="switchTab('categories')" data-tab="categories">
                <i class="bi bi-tag"></i>
                <span>Categories</span>
                <span class="tab-count"><?= count($tax_categories ?? []) ?></span>
            </button>
            <button class="tab-btn" onclick="switchTab('jurisdictions')" data-tab="jurisdictions">
                <i class="bi bi-geo-alt"></i>
                <span>Jurisdictions</span>
                <span class="tab-count"><?= count($tax_jurisdictions ?? []) ?></span>
            </button>
        </div>

        <!-- Tax Rates Tab -->
        <div id="tab-rates" class="tab-content active">
            <div class="tab-header">
                <div>
                    <h2>Tax Rates</h2>
                    <p>Manage tax rate percentages and assignments</p>
                </div>
                <div class="tab-actions">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Search rates..." id="searchRates" onkeyup="filterTable('ratesTable')">
                    </div>
                    <button class="btn btn-primary" onclick="addTaxRate()">
                        <i class="bi bi-plus-circle"></i>
                        <span>Add Rate</span>
                    </button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="data-table" id="ratesTable">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Tax Code</th>
                            <th style="width: 15%;">Rate</th>
                            <th style="width: 20%;">Category</th>
                            <th style="width: 20%;">Jurisdiction</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tax_rates)): ?>
                            <?php foreach ($tax_rates as $tax): ?>
                                <tr>
                                    <td>
                                        <div class="table-cell-with-icon">
                                            <div class="cell-icon" style="background: var(--primary-100); color: var(--primary-600);">
                                                <i class="bi bi-percent"></i>
                                            </div>
                                            <div>
                                                <div class="cell-title"><?= esc($tax['tax_name'] ?? 'N/A') ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: var(--primary-100); color: var(--primary-700); font-weight: 700; font-size: 14px; padding: 6px 12px;">
                                            <?= number_format($tax['tax_rate'] ?? 0, 2) ?>%
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary"><?= esc($tax['category'] ?? 'General') ?></span>
                                    </td>
                                    <td><?= esc($tax['jurisdiction'] ?? 'N/A') ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-primary" onclick="editTax(<?= $tax['tax_id'] ?? 0 ?>)" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteTax(<?= $tax['tax_id'] ?? 0 ?>)" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="bi bi-percent"></i>
                                        <h3>No Tax Rates Found</h3>
                                        <p>Start by adding your first tax rate</p>
                                        <button class="btn btn-primary" onclick="addTaxRate()">
                                            <i class="bi bi-plus-circle"></i>
                                            <span>Add Tax Rate</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tax Codes Tab -->
        <div id="tab-codes" class="tab-content">
            <div class="tab-header">
                <div>
                    <h2>Tax Codes</h2>
                    <p>Manage tax code identifiers</p>
                </div>
            </div>
            <div class="empty-state">
                <i class="bi bi-code"></i>
                <h3>Tax Codes Management</h3>
                <p>Tax codes configuration will be available here</p>
            </div>
        </div>

        <!-- Categories Tab -->
        <div id="tab-categories" class="tab-content">
            <div class="tab-header">
                <div>
                    <h2>Tax Categories</h2>
                    <p>Product and service tax categories</p>
                </div>
            </div>
            <div class="empty-state">
                <i class="bi bi-tag"></i>
                <h3>Tax Categories Management</h3>
                <p>Tax categories configuration will be available here</p>
            </div>
        </div>

        <!-- Jurisdictions Tab -->
        <div id="tab-jurisdictions" class="tab-content">
            <div class="tab-header">
                <div>
                    <h2>Tax Jurisdictions</h2>
                    <p>Geographic tax areas and regions</p>
                </div>
            </div>
            <div class="empty-state">
                <i class="bi bi-geo-alt"></i>
                <h3>Tax Jurisdictions Management</h3>
                <p>Tax jurisdictions configuration will be available here</p>
            </div>
        </div>
    </div>
</div>

<style>
/* Tabs Container */
.tabs-container {
    overflow: hidden;
}

.tabs-header {
    display: flex;
    background: var(--bg-secondary);
    border-bottom: 2px solid var(--border-color);
    padding: var(--space-2);
    gap: var(--space-2);
    overflow-x: auto;
}

.tab-btn {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-3) var(--space-5);
    background: transparent;
    border: none;
    border-radius: var(--radius-md);
    font-size: var(--text-sm);
    font-weight: var(--font-medium);
    color: var(--text-secondary);
    cursor: pointer;
    transition: all var(--transition-fast);
    white-space: nowrap;
}

.tab-btn:hover {
    background: var(--bg-tertiary);
    color: var(--text-primary);
}

.tab-btn.active {
    background: var(--primary-600);
    color: white;
}

.tab-btn i {
    font-size: 18px;
}

.tab-count {
    padding: 2px 8px;
    background: rgba(0,0,0,0.1);
    border-radius: var(--radius-full);
    font-size: var(--text-xs);
    font-weight: var(--font-bold);
}

.tab-btn.active .tab-count {
    background: rgba(255,255,255,0.2);
    color: white;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.tab-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-6);
    border-bottom: 1px solid var(--border-color);
    gap: var(--space-4);
    flex-wrap: wrap;
}

.tab-header h2 {
    margin: 0;
    font-size: var(--text-xl);
    font-weight: var(--font-semibold);
    color: var(--text-primary);
}

.tab-header p {
    margin: var(--space-1) 0 0 0;
    font-size: var(--text-sm);
    color: var(--text-tertiary);
}

.tab-actions {
    display: flex;
    gap: var(--space-3);
    align-items: center;
}

.table-cell-with-icon {
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.cell-icon {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.cell-title {
    font-weight: var(--font-semibold);
    color: var(--text-primary);
}

.table-responsive {
    overflow-x: auto;
}

/* Dark Mode */
[data-theme="dark"] .tabs-header {
    background: var(--bg-secondary);
}

[data-theme="dark"] .tab-btn:hover {
    background: var(--bg-primary);
}
</style>

<script>
// Tab Switching
function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Remove active from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById('tab-' + tabName).classList.add('active');
    
    // Activate button
    document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
}

// Navigation
function addTaxRate() {
    window.location.href = '<?= base_url("taxes/view/-1") ?>';
}

function editTax(taxId) {
    window.location.href = `<?= base_url("taxes/view/") ?>${taxId}`;
}

// Delete Tax
async function deleteTax(taxId) {
    if (!confirm('Are you sure you want to delete this tax rate?')) return;
    
    try {
        const response = await fetch(`<?= base_url('taxes/delete/') ?>${taxId}`, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        
        const result = await response.json();
        
        if (result.success) {
            window.shopsuiteApp?.showToast?.('Success', 'Tax rate deleted', 'success') || alert('Tax rate deleted');
            setTimeout(() => location.reload(), 1000);
        } else {
            window.shopsuiteApp?.showToast?.('Error', result.message || 'Failed to delete', 'error') || alert('Error');
        }
    } catch (error) {
        window.shopsuiteApp?.showToast?.('Error', 'Failed to delete tax rate', 'error') || alert('Error');
    }
}

// Filter Table
function filterTable(tableId) {
    const input = document.getElementById('searchRates');
    const filter = input.value.toUpperCase();
    const table = document.getElementById(tableId);
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
</script>

<?= view('layouts/modern_footer') ?>
