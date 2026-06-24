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
<div class="stats-grid u-margin-bottom-space-8">
    <div class="stat-card" >
        <div class="stat-card-icon u-background-rgba255-255-255-02">
            <i class="bi bi-percent" ></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label u-color-rgba255-255-255-09">Tax Rates</div>
            <div class="stat-card-value" ><?= count($tax_rates ?? []) ?></div>
            <div class="u-font-size-text-xs_color-rgba255-255-25">Active rates</div>
        </div>
    </div>
    
    <div class="stat-card" >
        <div class="stat-card-icon u-background-rgba255-255-255-02">
            <i class="bi bi-tag" ></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label u-color-rgba255-255-255-09">Categories</div>
            <div class="stat-card-value" ><?= count($tax_categories ?? []) ?></div>
            <div class="u-font-size-text-xs_color-rgba255-255-25">Product types</div>
        </div>
    </div>
    
    <div class="stat-card" >
        <div class="stat-card-icon u-background-rgba255-255-255-02">
            <i class="bi bi-geo-alt" ></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label u-color-rgba255-255-255-09">Jurisdictions</div>
            <div class="stat-card-value" ><?= count($tax_jurisdictions ?? []) ?></div>
            <div class="u-font-size-text-xs_color-rgba255-255-25">Geographic areas</div>
        </div>
    </div>
    
    <div class="stat-card" >
        <div class="stat-card-icon u-background-rgba255-255-255-02">
            <i class="bi bi-code" ></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label u-color-rgba255-255-255-09">Tax Codes</div>
            <div class="stat-card-value" ><?= count($tax_codes ?? []) ?></div>
            <div class="u-font-size-text-xs_color-rgba255-255-25">Identifiers</div>
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
                            <th class="u-width-30pct">Tax Code</th>
                            <th class="u-width-15pct">Rate</th>
                            <th class="u-width-20pct">Category</th>
                            <th class="u-width-20pct">Jurisdiction</th>
                            <th class="u-width-15pct">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tax_rates)): ?>
                            <?php foreach ($tax_rates as $tax): ?>
                                <tr>
                                    <td>
                                        <div class="table-cell-with-icon">
                                            <div class="cell-icon u-background-primary-100_color-primary-6">
                                                <i class="bi bi-percent"></i>
                                            </div>
                                            <div>
                                                <div class="cell-title"><?= esc($tax['tax_name'] ?? 'N/A') ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge u-background-primary-100_color-primary-7">
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
