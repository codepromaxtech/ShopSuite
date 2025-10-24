<?php
/**
 * MODERN DASHBOARD - Bootstrap 5
 * Responsive dashboard with cards, stats, and charts
 */
?>

<?= view('layouts/bootstrap5_header') ?>

<style>
/* Dashboard-specific styles */
.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 1.5rem;
    border-radius: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 0.75rem;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
    transition: all 0.3s;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 500;
}

.stat-trend {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    display: inline-block;
    margin-top: 0.5rem;
}

.stat-trend.up {
    background: #d1fae5;
    color: #065f46;
}

.stat-trend.down {
    background: #fee2e2;
    color: #991b1b;
}

.quick-action-card {
    background: white;
    border-radius: 0.75rem;
    padding: 1.25rem;
    border: 2px solid #e2e8f0;
    text-align: center;
    transition: all 0.2s;
    cursor: pointer;
    text-decoration: none;
    color: inherit;
    display: block;
}

.quick-action-card:hover {
    border-color: #4f46e5;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    transform: translateY(-2px);
}

.quick-action-icon {
    width: 56px;
    height: 56px;
    margin: 0 auto 1rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
}

.recent-activity {
    background: white;
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.activity-item {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .dashboard-header {
        padding: 1.5rem 1rem;
    }
    
    .stat-card {
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .stat-value {
        font-size: 1.5rem;
    }
}
</style>

<div class="container-fluid">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1 class="h3 mb-2">Welcome back, <?= esc($user_info->first_name ?? 'User') ?>! 👋</h1>
        <p class="mb-0 opacity-75">Here's what's happening with your business today</p>
    </div>

    <!-- Stats Overview -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: #dbeafe; color: #1e40af;">
                    <i class="bi bi-cart-fill"></i>
                </div>
                <div class="stat-value">
                    <?= number_format($stats['today_sales'] ?? 0) ?>
                </div>
                <div class="stat-label">Today's Sales</div>
                <span class="stat-trend up">
                    <i class="bi bi-arrow-up"></i> +12.5%
                </span>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: #d1fae5; color: #065f46;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="stat-value">
                    $<?= number_format($stats['today_revenue'] ?? 0, 2) ?>
                </div>
                <div class="stat-label">Today's Revenue</div>
                <span class="stat-trend up">
                    <i class="bi bi-arrow-up"></i> +8.2%
                </span>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: #fef3c7; color: #92400e;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-value">
                    <?= number_format($stats['total_customers'] ?? 0) ?>
                </div>
                <div class="stat-label">Total Customers</div>
                <span class="stat-trend up">
                    <i class="bi bi-arrow-up"></i> +23
                </span>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: #e0e7ff; color: #4338ca;">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
                <div class="stat-value">
                    <?= number_format($stats['total_items'] ?? 0) ?>
                </div>
                <div class="stat-label">Products in Stock</div>
                <span class="stat-trend down">
                    <i class="bi bi-arrow-down"></i> -5
                </span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-4">
        <h5 class="mb-3 fw-semibold">Quick Actions</h5>
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="<?= base_url('sales') ?>" class="quick-action-card">
                    <div class="quick-action-icon" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                    <div class="fw-semibold">New Sale</div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="<?= base_url('customers/view/-1') ?>" class="quick-action-card">
                    <div class="quick-action-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c); color: white;">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <div class="fw-semibold">Add Customer</div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="<?= base_url('items/view/-1') ?>" class="quick-action-card">
                    <div class="quick-action-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe); color: white;">
                        <i class="bi bi-box"></i>
                    </div>
                    <div class="fw-semibold">Add Product</div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="<?= base_url('reports') ?>" class="quick-action-card">
                    <div class="quick-action-icon" style="background: linear-gradient(135deg, #fa709a, #fee140); color: white;">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="fw-semibold">View Reports</div>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Chart -->
    <div class="row g-4">
        <!-- Recent Activity -->
        <div class="col-12 col-lg-6">
            <h5 class="mb-3 fw-semibold">Recent Activity</h5>
            <div class="recent-activity">
                <div class="activity-item">
                    <div class="activity-icon" style="background: #dbeafe; color: #1e40af;">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold" style="font-size: 0.875rem;">New sale completed</div>
                        <small class="text-muted">Invoice #1234 - $125.50</small>
                    </div>
                    <small class="text-muted">2m ago</small>
                </div>
                <div class="activity-item">
                    <div class="activity-icon" style="background: #d1fae5; color: #065f46;">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold" style="font-size: 0.875rem;">New customer added</div>
                        <small class="text-muted">John Smith</small>
                    </div>
                    <small class="text-muted">15m ago</small>
                </div>
                <div class="activity-item">
                    <div class="activity-icon" style="background: #fef3c7; color: #92400e;">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold" style="font-size: 0.875rem;">Product updated</div>
                        <small class="text-muted">Laptop Pro - Stock adjusted</small>
                    </div>
                    <small class="text-muted">1h ago</small>
                </div>
                <div class="activity-item">
                    <div class="activity-icon" style="background: #fee2e2; color: #991b1b;">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold" style="font-size: 0.875rem;">Low stock alert</div>
                        <small class="text-muted">5 items below minimum</small>
                    </div>
                    <small class="text-muted">2h ago</small>
                </div>
                <div class="activity-item">
                    <div class="activity-icon" style="background: #e0e7ff; color: #4338ca;">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold" style="font-size: 0.875rem;">Receiving completed</div>
                        <small class="text-muted">PO #456 - 50 items</small>
                    </div>
                    <small class="text-muted">3h ago</small>
                </div>
            </div>
        </div>

        <!-- Sales Chart Placeholder -->
        <div class="col-12 col-lg-6">
            <h5 class="mb-3 fw-semibold">Sales Overview</h5>
            <div class="card border-0 shadow-sm" style="height: 350px;">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <i class="bi bi-graph-up" style="font-size: 3rem; color: #cbd5e1;"></i>
                        <p class="text-muted mt-3">Chart will appear here<br><small>Integrate Chart.js or similar</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('layouts/bootstrap5_footer') ?>
