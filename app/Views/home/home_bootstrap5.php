<?php
/**
 * Modern Bootstrap 5 Dashboard for ShopSuite
 */

// Get data
$allowed_modules = $allowed_modules ?? [];
$user_info = $user_info ?? null;
$config = $config ?? [];
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => 'Dashboard',
    'allowed_modules' => $allowed_modules,
    'user_info' => $user_info,
    'config' => $config
]) ?>

<!-- Business Overview Header -->
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-1 fw-bold">Business Overview</h2>
        <p class="text-muted mb-0">
            <i class="bi bi-calendar-check"></i> <?= date('l, F j, Y') ?>
        </p>
    </div>
    <div class="col-md-4 text-md-end">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-sm btn-outline-primary active">Today</button>
            <button type="button" class="btn btn-sm btn-outline-primary">Week</button>
            <button type="button" class="btn btn-sm btn-outline-primary">Month</button>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Today's Sales</p>
                        <h3 class="mb-0 fw-bold">$0.00</h3>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i> 0%
                        </small>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded">
                        <i class="bi bi-currency-dollar text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Total Orders</p>
                        <h3 class="mb-0 fw-bold">0</h3>
                        <small class="text-info">
                            <i class="bi bi-dash"></i> 0%
                        </small>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded">
                        <i class="bi bi-cart text-info fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Customers</p>
                        <h3 class="mb-0 fw-bold">0</h3>
                        <small class="text-primary">
                            <i class="bi bi-arrow-up"></i> 0%
                        </small>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded">
                        <i class="bi bi-people text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Products</p>
                        <h3 class="mb-0 fw-bold">0</h3>
                        <small class="text-warning">
                            <i class="bi bi-dash"></i> 0%
                        </small>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded">
                        <i class="bi bi-box-seam text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales Chart & Top Products -->
<div class="row g-4 mb-4">
    <!-- Sales Trend Chart -->
    <div class="col-md-8">
        <div class="card border-0 h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-graph-up"></i>
                    Sales Trend
                </h5>
                <span class="badge bg-success">Live</span>
            </div>
            <div class="card-body">
                <div class="text-center text-muted py-5">
                    <i class="bi bi-bar-chart fs-1 mb-3 d-block"></i>
                    <p>Sales chart will be displayed here</p>
                    <small>Connect your sales data to see trends</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Top Selling Products -->
    <div class="col-md-4">
        <div class="card border-0 h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-trophy"></i>
                    Top Products
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center text-muted py-4">
                    <i class="bi bi-box-seam fs-1 mb-3 d-block"></i>
                    <p class="mb-0">No sales data yet</p>
                    <small>Start selling to see top products</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions & Alerts -->
<div class="row g-4 mb-4">
    <!-- Quick Actions -->
    <div class="col-md-6">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-lightning"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= base_url('sales') ?>" class="btn btn-lg btn-success text-start">
                        <i class="bi bi-cart-plus me-2"></i>
                        New Sale
                    </a>
                    <a href="<?= base_url('items') ?>" class="btn btn-lg btn-primary text-start">
                        <i class="bi bi-box-seam me-2"></i>
                        Add Product
                    </a>
                    <a href="<?= base_url('customers') ?>" class="btn btn-lg btn-warning text-start">
                        <i class="bi bi-person-plus me-2"></i>
                        New Customer
                    </a>
                    <a href="<?= base_url('reports') ?>" class="btn btn-lg btn-info text-start">
                        <i class="bi bi-file-earmark-bar-graph me-2"></i>
                        View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Alerts & Notifications -->
    <div class="col-md-6">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-bell"></i>
                    Alerts & Notifications
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning border-0 mb-3">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-exclamation-triangle fs-4 me-3"></i>
                        <div>
                            <strong>Low Stock Alert</strong>
                            <p class="mb-0 small">0 products are running low on stock</p>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info border-0 mb-3">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-info-circle fs-4 me-3"></i>
                        <div>
                            <strong>Pending Orders</strong>
                            <p class="mb-0 small">0 orders waiting for processing</p>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-success border-0 mb-0">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-check-circle fs-4 me-3"></i>
                        <div>
                            <strong>System Status</strong>
                            <p class="mb-0 small">All systems operational</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions & Performance -->
<div class="row g-4">
    <!-- Recent Transactions -->
    <div class="col-md-6">
        <div class="card border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-receipt"></i>
                    Recent Transactions
                </h5>
                <a href="<?= base_url('sales') ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="text-center text-muted py-4">
                    <i class="bi bi-receipt fs-1 mb-3 d-block"></i>
                    <p class="mb-0">No transactions yet</p>
                    <small>Start making sales to see recent transactions</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Performance Metrics -->
    <div class="col-md-6">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-speedometer2"></i>
                    Performance Metrics
                </h5>
            </div>
            <div class="card-body">
                <!-- Average Transaction Value -->
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <small class="text-muted d-block">Avg. Transaction Value</small>
                        <h5 class="mb-0 fw-bold">$0.00</h5>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-success">0%</span>
                    </div>
                </div>
                
                <!-- Conversion Rate -->
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <small class="text-muted d-block">Conversion Rate</small>
                        <h5 class="mb-0 fw-bold">0%</h5>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-info">0%</span>
                    </div>
                </div>
                
                <!-- Customer Satisfaction -->
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted d-block">Customer Satisfaction</small>
                        <h5 class="mb-0 fw-bold">N/A</h5>
                    </div>
                    <div class="text-end">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.module-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.module-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>

<?= view('layouts/bootstrap5_footer') ?>
