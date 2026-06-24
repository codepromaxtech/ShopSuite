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
<div class="config-grid u-display-grid_grid-template-columns-rep-1">
    
    <!-- Sales Reports -->
    <div class="config-category-card">
        <div class="config-category-header">
            <div class="config-category-icon" >
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
            <div class="u-border-top-1pxsolidborder-color_margin">
                <small class="u-color-text-tertiary_padding-0space-4_d">Legacy Reports:</small>
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
            <div class="config-category-icon" >
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
            <div class="config-category-icon" >
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
            <div class="config-category-icon" >
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
            <div class="config-category-icon" >
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
            <div class="config-category-icon" >
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



<?= view('layouts/modern_footer') ?>
