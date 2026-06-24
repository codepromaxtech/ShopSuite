<?php
/**
 * MODERN COMPREHENSIVE DASHBOARD
 * Complete business overview at a glance
 */
$title = 'Dashboard';
echo view('layouts/modern_header', ['title' => $title]);

$stats = $stats ?? [];
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-text">
            <h1 class="page-header-title">Dashboard</h1>
        </div>
    </div>
</div>

<!-- Key Metrics -->
<div class="stats-grid u-margin-bottom-space-8">
    <!-- Today's Sales -->
    <div class="stat-card" >
        <div class="stat-card-icon u-background-rgba255-255-255-02">
            <i class="bi bi-cart-check" ></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label u-color-rgba255-255-255-09">Today's Sales</div>
            <div class="stat-card-value" ><?= $stats['today_sales'] ?? 0 ?></div>
            <div class="u-font-size-text-xs_color-rgba255-255-25">
                <i class="bi bi-clock"></i> Last 24 hours
            </div>
        </div>
    </div>
    
    <!-- Today's Revenue -->
    <div class="stat-card" >
        <div class="stat-card-icon u-background-rgba255-255-255-02">
            <i class="bi bi-currency-dollar" ></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label u-color-rgba255-255-255-09">Today's Revenue</div>
            <div class="stat-card-value" >$<?= $stats['today_revenue'] ?? '0.00' ?></div>
            <div class="u-font-size-text-xs_color-rgba255-255-25">
                <i class="bi bi-graph-up"></i> This month: $<?= $stats['month_revenue'] ?? '0.00' ?>
            </div>
        </div>
    </div>
    
    <!-- Total Customers -->
    <div class="stat-card" >
        <div class="stat-card-icon u-background-rgba255-255-255-02">
            <i class="bi bi-people" ></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label u-color-rgba255-255-255-09">Total Customers</div>
            <div class="stat-card-value" ><?= number_format($stats['total_customers'] ?? 0) ?></div>
            <div class="u-font-size-text-xs_color-rgba255-255-25">
                <i class="bi bi-person-plus"></i> Active customers
            </div>
        </div>
    </div>
    
    <!-- Inventory -->
    <div class="stat-card" >
        <div class="stat-card-icon u-background-rgba255-255-255-02">
            <i class="bi bi-box-seam" ></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label u-color-rgba255-255-255-09">Products in Stock</div>
            <div class="stat-card-value" ><?= $stats['total_items'] ?? 0 ?></div>
            <div class="u-font-size-text-xs_color-rgba255-255-25">
                <?php if (($stats['low_stock'] ?? 0) > 0): ?>
                    <i class="bi bi-exclamation-triangle"></i> <?= $stats['low_stock'] ?> low stock
                <?php else: ?>
                    <i class="bi bi-check-circle"></i> All items stocked
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="u-display-grid_grid-template-columns-2fr">
    
    <!-- Sales Trend Chart -->
    <div class="card">
        <div class="card-header">
            <h2 class="u-margin-0_font-size-text-lg_font-weight">
                <i class="bi bi-graph-up"></i>
                Sales Trend (Last 7 Days)
            </h2>
        </div>
        <div class="card-body">
            <div class="u-position-relative_height-300px">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <h2 class="u-margin-0_font-size-text-lg_font-weight">
                <i class="bi bi-lightning-charge"></i>
                Quick Actions
            </h2>
        </div>
        <div class="card-body">
            <div class="u-display-flex_flex-direction-column_gap">
                <button onclick="location.reload()" class="quick-action-btn u-border-none_cursor-pointer">
                    <i class="bi bi-arrow-clockwise"></i>
                    <span>Refresh Dashboard</span>
                </button>
                <a href="<?= base_url('sales/register') ?>" class="quick-action-btn" >
                    <i class="bi bi-cart-plus"></i>
                    <span>New Sale</span>
                </a>
                <a href="<?= base_url('customers/view/-1') ?>" class="quick-action-btn" >
                    <i class="bi bi-person-plus"></i>
                    <span>Add Customer</span>
                </a>
                <a href="<?= base_url('products/view/-1') ?>" class="quick-action-btn" >
                    <i class="bi bi-box-seam"></i>
                    <span>Add Product</span>
                </a>
                <a href="<?= base_url('reports') ?>" class="quick-action-btn" >
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>View Reports</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Second Row -->
<div class="u-display-grid_grid-template-columns-1fr-1">
    
    <!-- Recent Sales -->
    <div class="card">
        <div class="card-header u-display-flex_justify-content-space-bet">
            <h2 class="u-margin-0_font-size-text-lg_font-weight">
                <i class="bi bi-receipt"></i>
                Recent Sales
            </h2>
            <a href="<?= base_url('sales') ?>" class="btn btn-sm btn-outline">View All</a>
        </div>
        <div class="card-body u-padding-0">
            <?php if (!empty($stats['recent_sales'])): ?>
                <div class="list-group">
                    <?php foreach ($stats['recent_sales'] as $sale): ?>
                        <div class="list-item">
                            <div class="list-item-icon u-background-success-100_color-success-6">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div class="list-item-content">
                                <div class="list-item-title">Sale #<?= $sale['sale_id'] ?></div>
                                <div class="list-item-subtitle">
                                    <?= $sale['customer_name'] ?: 'Walk-in Customer' ?>
                                </div>
                            </div>
                            <div class="list-item-value">
                                $<?= number_format($sale['total'] ?? 0, 2) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state-small">
                    <i class="bi bi-receipt"></i>
                    <p>No recent sales</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Top Products -->
    <div class="card">
        <div class="card-header u-display-flex_justify-content-space-bet">
            <h2 class="u-margin-0_font-size-text-lg_font-weight">
                <i class="bi bi-star"></i>
                Top Products
            </h2>
            <a href="<?= base_url('products') ?>" class="btn btn-sm btn-outline">View All</a>
        </div>
        <div class="card-body u-padding-0">
            <?php if (!empty($stats['top_products'])): ?>
                <div class="list-group">
                    <?php foreach ($stats['top_products'] as $index => $product): ?>
                        <div class="list-item">
                            <div class="list-item-rank">#<?= $index + 1 ?></div>
                            <div class="list-item-content">
                                <div class="list-item-title"><?= esc($product['name']) ?></div>
                                <div class="list-item-subtitle">
                                    <?= number_format($product['total_sold']) ?> sold
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state-small">
                    <i class="bi bi-star"></i>
                    <p>No sales data</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Low Stock Alert -->
    <div class="card">
        <div class="card-header u-display-flex_justify-content-space-bet">
            <h2 class="u-margin-0_font-size-text-lg_font-weight">
                <i class="bi bi-exclamation-triangle"></i>
                Low Stock Alert
            </h2>
            <a href="<?= base_url('reports/inventory_low') ?>" class="btn btn-sm btn-outline">View All</a>
        </div>
        <div class="card-body">
            <?php if (($stats['low_stock'] ?? 0) > 0): ?>
                <div class="u-text-align-center_padding-space-60">
                    <div class="u-width-80px_height-80px_margin-0autospa">
                        <i class="bi bi-exclamation-triangle u-font-size-32px"></i>
                    </div>
                    <div class="u-font-size-text-3xl_font-weight-font-bo-2">
                        <?= $stats['low_stock'] ?>
                    </div>
                    <div class="u-font-size-text-sm_color-text-secondary-4">
                        Products below reorder level
                    </div>
                    <a href="<?= base_url('reports/inventory_low') ?>" class="btn btn-danger btn-sm">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Review Products</span>
                    </a>
                </div>
            <?php else: ?>
                <div class="empty-state-small">
                    <i class="bi bi-check-circle u-color-success-600"></i>
                    <p class="u-color-success-600">All products well stocked!</p>
                </div>
            <?php endif; ?>
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
