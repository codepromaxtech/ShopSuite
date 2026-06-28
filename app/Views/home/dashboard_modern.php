<?php
/**
 * MODERN COMPREHENSIVE DASHBOARD
 * Complete business overview at a glance
 */
$title = 'Dashboard';
echo view('layouts/modern_header', ['title' => $title]);

$stats = $stats ?? [];
?>

<!-- Welcome Banner with Quick Actions -->
<div class="welcome-banner-modern">
    <div class="welcome-banner-content">
        <h1 class="welcome-greeting">Welcome back!</h1>
        <p class="welcome-date"><?= date('l, F j, Y') ?></p>
    </div>
    <div class="header-quick-actions" style="position: relative; z-index: 1; display: flex; gap: var(--space-2); flex-wrap: wrap; justify-content: flex-end; align-items: center;">
        <a href="javascript:void(0);" onclick="location.reload()" class="btn btn-sm btn-outline" style="background: var(--bg-elevated); border-color: var(--border-color);">
            <i class="bi bi-arrow-clockwise"></i> <span class="hide-mobile">Refresh</span>
        </a>
        <a href="<?= base_url('sales/register') ?>" class="btn btn-sm btn-primary">
            <i class="bi bi-cart-plus"></i> <span class="hide-mobile">New Sale</span>
        </a>
        <a href="<?= base_url('customers/view/-1') ?>" class="btn btn-sm btn-outline" style="background: var(--bg-elevated); border-color: var(--border-color);">
            <i class="bi bi-person-plus"></i> <span class="hide-mobile">Add Customer</span>
        </a>
        <a href="<?= base_url('products/view/-1') ?>" class="btn btn-sm btn-outline" style="background: var(--bg-elevated); border-color: var(--border-color);">
            <i class="bi bi-box-seam"></i> <span class="hide-mobile">Add Product</span>
        </a>
        <a href="<?= base_url('reports') ?>" class="btn btn-sm btn-outline" style="background: var(--bg-elevated); border-color: var(--border-color);">
            <i class="bi bi-file-earmark-bar-graph"></i> <span class="hide-mobile">Reports</span>
        </a>
    </div>
</div>

<!-- Section: Overview -->
<div class="dashboard-section">
    <h2 class="section-title">Overview</h2>
    <div class="stats-grid u-margin-bottom-space-8">
        <!-- Today's Sales -->
        <div class="stat-card stat-card-sales">
            <div class="stat-card-header">
                <div class="stat-card-label">Today's Sales</div>
                <div class="stat-card-icon">
                    <i class="bi bi-cart-check"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= $stats['today_sales'] ?? 0 ?></div>
            <div class="stat-card-trend">
                <i class="bi bi-clock"></i> Last 24 hours
            </div>
        </div>
        
        <!-- Today's Revenue -->
        <div class="stat-card stat-card-revenue">
            <div class="stat-card-header">
                <div class="stat-card-label">Today's Revenue</div>
                <div class="stat-card-icon">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
            <div class="stat-card-value">$<?= $stats['today_revenue'] ?? '0.00' ?></div>
            <div class="stat-card-trend">
                <i class="bi bi-graph-up"></i> This month: $<?= $stats['month_revenue'] ?? '0.00' ?>
            </div>
        </div>
        
        <!-- Total Customers -->
        <div class="stat-card stat-card-customers">
            <div class="stat-card-header">
                <div class="stat-card-label">Total Customers</div>
                <div class="stat-card-icon">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= number_format($stats['total_customers'] ?? 0) ?></div>
            <div class="stat-card-trend">
                <i class="bi bi-person-plus"></i> Active customers
            </div>
        </div>
        
        <!-- Inventory -->
        <div class="stat-card stat-card-inventory">
            <div class="stat-card-header">
                <div class="stat-card-label">Products in Stock</div>
                <div class="stat-card-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= $stats['total_items'] ?? 0 ?></div>
            <div class="stat-card-trend <?= (($stats['low_stock'] ?? 0) > 0) ? 'trend-warning' : 'trend-success' ?>">
                <?php if (($stats['low_stock'] ?? 0) > 0): ?>
                    <i class="bi bi-exclamation-triangle"></i> <?= $stats['low_stock'] ?> low stock
                <?php else: ?>
                    <i class="bi bi-check-circle"></i> All items stocked
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Section: Analytics -->
<div class="dashboard-section">
    <h2 class="section-title">Analytics</h2>
    <div class="dashboard-main-grid" style="grid-template-columns: 1fr;">
        <!-- Sales Trend Chart -->
        <div class="card card-analytics">
            <div class="card-header border-bottom-0">
                <h2 class="card-title">
                    <i class="bi bi-graph-up-arrow"></i>
                    Sales Trend (7 Days)
                </h2>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height: 300px; position: relative;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section: Activity -->
<div class="dashboard-section">
    <h2 class="section-title">Activity Timeline</h2>
    <div class="dashboard-sub-grid">
        <!-- Recent Sales -->
        <div class="card">
            <div class="card-header u-display-flex_justify-content-space-bet">
                <h2 class="card-title"><i class="bi bi-receipt"></i> Recent Sales</h2>
                <a href="<?= base_url('sales') ?>" class="btn btn-sm btn-outline">View All</a>
            </div>
            <div class="card-body u-padding-0">
                <?php if (!empty($stats['recent_sales'])): ?>
                    <div class="list-group">
                        <?php foreach ($stats['recent_sales'] as $sale): ?>
                            <div class="list-item">
                                <div class="list-item-icon bg-success-light text-success">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div class="list-item-content">
                                    <div class="list-item-title">Sale #<?= $sale['sale_id'] ?></div>
                                    <div class="list-item-subtitle"><?= $sale['customer_name'] ?: 'Walk-in Customer' ?></div>
                                </div>
                                <div class="list-item-value">$<?= number_format($sale['total'] ?? 0, 2) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state-modern">
                        <i class="bi bi-receipt"></i>
                        <p>No recent sales</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Top Products -->
        <div class="card">
            <div class="card-header u-display-flex_justify-content-space-bet">
                <h2 class="card-title"><i class="bi bi-star"></i> Top Products</h2>
                <a href="<?= base_url('products') ?>" class="btn btn-sm btn-outline">View All</a>
            </div>
            <div class="card-body u-padding-0">
                <?php if (!empty($stats['top_products'])): ?>
                    <div class="list-group">
                        <?php foreach ($stats['top_products'] as $index => $product): ?>
                            <div class="list-item">
                                <div class="list-item-rank rank-<?= $index + 1 ?>">#<?= $index + 1 ?></div>
                                <div class="list-item-content">
                                    <div class="list-item-title"><?= esc($product['name']) ?></div>
                                    <div class="list-item-subtitle"><?= number_format($product['total_sold']) ?> units sold</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state-modern">
                        <i class="bi bi-star"></i>
                        <p>No sales data</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Low Stock Alert -->
        <div class="card">
            <div class="card-header u-display-flex_justify-content-space-bet">
                <h2 class="card-title"><i class="bi bi-exclamation-triangle"></i> Inventory Alert</h2>
                <a href="<?= base_url('reports/inventory_low') ?>" class="btn btn-sm btn-outline">View All</a>
            </div>
            <div class="card-body">
                <?php if (($stats['low_stock'] ?? 0) > 0): ?>
                    <div class="alert-box-modern">
                        <div class="alert-icon-large pulse-animation">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div class="alert-count"><?= $stats['low_stock'] ?></div>
                        <div class="alert-text">Products below reorder level</div>
                        <a href="<?= base_url('reports/inventory_low') ?>" class="btn btn-danger btn-modern mt-3">
                            <i class="bi bi-clipboard-check"></i> Review Now
                        </a>
                    </div>
                <?php else: ?>
                    <div class="empty-state-modern success-state">
                        <i class="bi bi-check-circle-fill"></i>
                        <p>All products well stocked!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Prepare sales trend data
const salesData = <?= json_encode($stats['sales_trend'] ?? []) ?>;
const labels = salesData.map(d => {
    const date = new Date(d.date);
    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
});
const revenueData = salesData.map(d => parseFloat(d.revenue));
const countData = salesData.map(d => parseInt(d.count));

// Create chart
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Revenue ($)',
                data: revenueData,
                borderColor: 'rgb(99, 102, 241)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y'
            },
            {
                label: 'Sales Count',
                data: countData,
                borderColor: 'rgb(16, 185, 129)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y1'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 15
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 }
            }
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                },
                ticks: {
                    callback: function(value) {
                        return '$' + value.toFixed(0);
                    }
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                beginAtZero: true,
                grid: {
                    drawOnChartArea: false
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Auto-refresh every 5 minutes
setTimeout(() => {
    location.reload();
}, 300000);
</script>

<?= view('layouts/modern_footer') ?>
