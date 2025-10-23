<?php
/**
 * Modern Bootstrap 5 Reports Module View
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.reports'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<?= view('components/page_header', [
    'title' => lang('Module.reports'),
    'subtitle' => 'Business analytics and insights',
    'icon' => 'bi-graph-up-arrow',
    'actions' => [
        [
            'label' => 'Export PDF',
            'url' => '#',
            'color' => 'danger',
            'icon' => 'bi-file-pdf'
        ],
        [
            'label' => 'Export Excel',
            'url' => '#',
            'color' => 'success',
            'icon' => 'bi-file-excel'
        ]
    ]
]) ?>

<!-- Report Categories -->
<div class="row g-4 mb-4">
    <!-- Sales Reports -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-cart-check fs-3 text-success"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Sales Reports</h5>
                        <small class="text-muted">Revenue & transactions</small>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= base_url('reports/sales_summary') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Sales Summary
                    </a>
                    <a href="<?= base_url('reports/detailed_sales') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Detailed Sales
                    </a>
                    <a href="<?= base_url('reports/sales_by_customer') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Sales by Customer
                    </a>
                    <a href="<?= base_url('reports/sales_by_item') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Sales by Item
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Inventory Reports -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-box-seam fs-3 text-primary"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Inventory Reports</h5>
                        <small class="text-muted">Stock & products</small>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= base_url('reports/inventory_summary') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Inventory Summary
                    </a>
                    <a href="<?= base_url('reports/low_stock') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Low Stock Items
                    </a>
                    <a href="<?= base_url('reports/inventory_valuation') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Inventory Valuation
                    </a>
                    <a href="<?= base_url('reports/item_movement') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Item Movement
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Financial Reports -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-currency-dollar fs-3 text-warning"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Financial Reports</h5>
                        <small class="text-muted">Profit & expenses</small>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= base_url('reports/profit_loss') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Profit & Loss
                    </a>
                    <a href="<?= base_url('reports/expenses') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Expenses Report
                    </a>
                    <a href="<?= base_url('reports/tax_summary') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Tax Summary
                    </a>
                    <a href="<?= base_url('reports/payments') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Payment Methods
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- More Report Categories -->
<div class="row g-4 mb-4">
    <!-- Customer Reports -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-people fs-3 text-info"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Customer Reports</h5>
                        <small class="text-muted">Customer analytics</small>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= base_url('reports/customer_summary') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Customer Summary
                    </a>
                    <a href="<?= base_url('reports/customer_sales') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Customer Sales
                    </a>
                    <a href="<?= base_url('reports/customer_rewards') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Rewards Program
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Employee Reports -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-purple bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-person-badge fs-3 text-purple"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Employee Reports</h5>
                        <small class="text-muted">Staff performance</small>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= base_url('reports/employee_sales') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Employee Sales
                    </a>
                    <a href="<?= base_url('reports/employee_hours') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Work Hours
                    </a>
                    <a href="<?= base_url('reports/commissions') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Commissions
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Supplier Reports -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-secondary bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-truck fs-3 text-secondary"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Supplier Reports</h5>
                        <small class="text-muted">Purchase analytics</small>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= base_url('reports/supplier_summary') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Supplier Summary
                    </a>
                    <a href="<?= base_url('reports/receivings') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Receivings Report
                    </a>
                    <a href="<?= base_url('reports/purchase_orders') ?>" class="list-group-item list-group-item-action border-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>Purchase Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Report Generator -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-lightning"></i>
            Quick Report Generator
        </h5>
    </div>
    <div class="card-body">
        <form class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Report Type</label>
                <select class="form-select">
                    <option>Sales Summary</option>
                    <option>Inventory Summary</option>
                    <option>Customer Report</option>
                    <option>Financial Report</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Date Range</label>
                <select class="form-select">
                    <option>Today</option>
                    <option>Yesterday</option>
                    <option>This Week</option>
                    <option>This Month</option>
                    <option>Custom Range</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Format</label>
                <select class="form-select">
                    <option>PDF</option>
                    <option>Excel</option>
                    <option>CSV</option>
                    <option>Print</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-file-earmark-arrow-down me-2"></i>
                    Generate Report
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.list-group-item-action:hover {
    background-color: rgba(79, 70, 229, 0.05);
    border-left: 3px solid #4f46e5;
}

.text-purple {
    color: #8b5cf6;
}

.bg-purple {
    background-color: #8b5cf6;
}
</style>

<?= view('layouts/bootstrap5_footer') ?>
