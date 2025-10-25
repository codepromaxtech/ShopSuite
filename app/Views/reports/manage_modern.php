<?php
/**
 * MODERN REPORTS PAGE
 * Category card style like config page
 */
$title = 'Reports & Analytics';
echo view('layouts/modern_header', ['title' => $title]);
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-text">
            <h1 class="page-header-title">Reports & Analytics</h1>
        </div>
    </div>
    <div class="page-header-actions">
        <button class="btn btn-secondary" onclick="window.print()">
            <i class="bi bi-printer"></i>
            <span>Print</span>
        </button>
    </div>
</div>

<!-- Reports Categories Grid -->
<div class="config-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: var(--space-6);">
    
    <!-- Sales Reports -->
    <div class="config-category-card">
        <div class="config-category-header">
            <div class="config-category-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="config-category-title">
                <h3>
                    Sales Reports
                    <span class="badge badge-new">NEW</span>
                </h3>
                <p>Revenue and transaction analysis</p>
            </div>
        </div>
        <div class="config-category-links">
            <a href="<?= base_url('reports/sales') ?>" class="config-link config-link-featured">
                <i class="bi bi-lightning-fill"></i>
                <span><strong>Unified Sales Reports</strong> - All in one place!</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <div style="border-top: 1px solid var(--border-color); margin: var(--space-2) 0; padding-top: var(--space-2);">
                <small style="color: var(--text-tertiary); padding: 0 var(--space-4); display: block; margin-bottom: var(--space-2);">Legacy Reports:</small>
            </div>
            <a href="<?= base_url('reports/summary_sales') ?>" class="config-link config-link-legacy">
                <i class="bi bi-graph-up"></i>
                <span>Sales Summary</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('reports/detailed_sales') ?>" class="config-link config-link-legacy">
                <i class="bi bi-receipt"></i>
                <span>Detailed Sales</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('reports/summary_payments') ?>" class="config-link config-link-legacy">
                <i class="bi bi-credit-card"></i>
                <span>Payment Summary</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('reports/summary_taxes') ?>" class="config-link config-link-legacy">
                <i class="bi bi-percent"></i>
                <span>Tax Summary</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Product Reports -->
    <div class="config-category-card">
        <div class="config-category-header">
            <div class="config-category-icon" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
                <i class="bi bi-box-seam-fill"></i>
            </div>
            <div class="config-category-title">
                <h3>Product Reports</h3>
                <p>Inventory and product analysis</p>
            </div>
        </div>
        <div class="config-category-links">
            <a href="<?= base_url('reports/summary_items') ?>" class="config-link">
                <i class="bi bi-box"></i>
                <span>Items Summary</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('reports/summary_categories') ?>" class="config-link">
                <i class="bi bi-tags"></i>
                <span>Categories Summary</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('reports/summary_discounts') ?>" class="config-link">
                <i class="bi bi-tag"></i>
                <span>Discounts Summary</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('reports/inventory_summary') ?>" class="config-link">
                <i class="bi bi-clipboard-data"></i>
                <span>Inventory Summary</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Customer Reports -->
    <div class="config-category-card">
        <div class="config-category-header">
            <div class="config-category-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="config-category-title">
                <h3>Customer Reports</h3>
                <p>Customer behavior and insights</p>
            </div>
        </div>
        <div class="config-category-links">
            <a href="<?= base_url('reports/summary_customers') ?>" class="config-link">
                <i class="bi bi-person-badge"></i>
                <span>Customers Summary</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('reports/specific_customer') ?>" class="config-link">
                <i class="bi bi-person-check"></i>
                <span>Specific Customer</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('reports/summary_rewards') ?>" class="config-link">
                <i class="bi bi-gift"></i>
                <span>Rewards Summary</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Supplier Reports -->
    <div class="config-category-card">
        <div class="config-category-header">
            <div class="config-category-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <i class="bi bi-building"></i>
            </div>
            <div class="config-category-title">
                <h3>Supplier Reports</h3>
                <p>Purchase and supplier analysis</p>
            </div>
        </div>
        <div class="config-category-links">
            <a href="<?= base_url('reports/summary_suppliers') ?>" class="config-link">
                <i class="bi bi-shop"></i>
                <span>Suppliers Summary</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('reports/specific_supplier') ?>" class="config-link">
                <i class="bi bi-shop-window"></i>
                <span>Specific Supplier</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('reports/detailed_receivings') ?>" class="config-link">
                <i class="bi bi-truck"></i>
                <span>Detailed Receivings</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Employee Reports -->
    <div class="config-category-card">
        <div class="config-category-header">
            <div class="config-category-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                <i class="bi bi-person-workspace"></i>
            </div>
            <div class="config-category-title">
                <h3>Employee Reports</h3>
                <p>Staff performance tracking</p>
            </div>
        </div>
        <div class="config-category-links">
            <a href="<?= base_url('reports/summary_employees') ?>" class="config-link">
                <i class="bi bi-people"></i>
                <span>Employees Summary</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('reports/specific_employee') ?>" class="config-link">
                <i class="bi bi-person"></i>
                <span>Specific Employee</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('reports/timeclock') ?>" class="config-link">
                <i class="bi bi-clock"></i>
                <span>Time Clock Report</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Inventory Reports -->
    <div class="config-category-card">
        <div class="config-category-header">
            <div class="config-category-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                <i class="bi bi-boxes"></i>
            </div>
            <div class="config-category-title">
                <h3>Inventory Reports</h3>
                <p>Stock levels and movements</p>
            </div>
        </div>
        <div class="config-category-links">
            <a href="<?= base_url('reports/inventory_summary') ?>" class="config-link">
                <i class="bi bi-clipboard-data"></i>
                <span>Inventory Summary</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('reports/inventory_low') ?>" class="config-link">
                <i class="bi bi-exclamation-triangle"></i>
                <span>Low Inventory</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('reports/inventory_expiring') ?>" class="config-link">
                <i class="bi bi-calendar-x"></i>
                <span>Expiring Items</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
</div>

<style>
/* Config Category Cards (from config page) */
.config-category-card {
    background: var(--bg-elevated);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: all var(--transition-normal);
}

.config-category-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.config-category-header {
    padding: var(--space-6);
    display: flex;
    align-items: center;
    gap: var(--space-4);
    border-bottom: 1px solid var(--border-color);
}

.config-category-icon {
    width: 64px;
    height: 64px;
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.config-category-icon i {
    font-size: 32px;
    color: white;
}

.config-category-title h3 {
    font-size: var(--text-lg);
    font-weight: var(--font-semibold);
    color: var(--text-primary);
    margin: 0 0 var(--space-1) 0;
}

.config-category-title p {
    font-size: var(--text-sm);
    color: var(--text-tertiary);
    margin: 0;
}

.config-category-links {
    padding: var(--space-2);
}

.config-link {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-4);
    color: var(--text-primary);
    text-decoration: none;
    border-radius: var(--radius-md);
    transition: all var(--transition-fast);
}

.config-link:hover {
    background: var(--bg-secondary);
    color: var(--primary-600);
    transform: translateX(4px);
}

.config-link i:first-child {
    font-size: 20px;
    color: var(--text-tertiary);
    transition: color var(--transition-fast);
}

.config-link:hover i:first-child {
    color: var(--primary-600);
}

.config-link span {
    flex: 1;
    font-weight: var(--font-medium);
}

.config-link i:last-child {
    font-size: 14px;
    color: var(--text-tertiary);
}

/* Featured Link (New Unified Reports) */
.config-link-featured {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
    border: 2px solid var(--primary-600);
    font-weight: var(--font-semibold);
}

.config-link-featured:hover {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.1) 100%);
    border-color: var(--primary-700);
    transform: translateX(8px);
}

.config-link-featured i:first-child {
    color: var(--primary-600) !important;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* Legacy Links (Old Reports) */
.config-link-legacy {
    opacity: 0.7;
    font-size: var(--text-sm);
}

.config-link-legacy:hover {
    opacity: 1;
}

/* NEW Badge */
.badge-new {
    display: inline-block;
    padding: 2px 8px;
    font-size: 10px;
    font-weight: var(--font-bold);
    text-transform: uppercase;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border-radius: 4px;
    margin-left: var(--space-2);
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-2px); }
}

/* Responsive */
@media (max-width: 768px) {
    .config-grid {
        grid-template-columns: 1fr !important;
    }
}

/* Dark Mode */
[data-theme="dark"] .config-category-card {
    background: var(--bg-elevated);
    border-color: var(--border-color);
}

[data-theme="dark"] .config-link:hover {
    background: var(--bg-secondary);
}
</style>

<?= view('layouts/modern_footer') ?>
