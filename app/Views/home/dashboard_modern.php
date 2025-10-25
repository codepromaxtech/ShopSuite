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
<div class="stats-grid" style="margin-bottom: var(--space-8);">
    <!-- Today's Sales -->
    <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
        <div class="stat-card-icon" style="background: rgba(255,255,255,0.2);">
            <i class="bi bi-cart-check" style="color: white;"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label" style="color: rgba(255,255,255,0.9);">Today's Sales</div>
            <div class="stat-card-value" style="color: white;"><?= $stats['today_sales'] ?? 0 ?></div>
            <div style="font-size: var(--text-xs); color: rgba(255,255,255,0.8); margin-top: var(--space-1);">
                <i class="bi bi-clock"></i> Last 24 hours
            </div>
        </div>
    </div>
    
    <!-- Today's Revenue -->
    <div class="stat-card" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
        <div class="stat-card-icon" style="background: rgba(255,255,255,0.2);">
            <i class="bi bi-currency-dollar" style="color: white;"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label" style="color: rgba(255,255,255,0.9);">Today's Revenue</div>
            <div class="stat-card-value" style="color: white;">$<?= $stats['today_revenue'] ?? '0.00' ?></div>
            <div style="font-size: var(--text-xs); color: rgba(255,255,255,0.8); margin-top: var(--space-1);">
                <i class="bi bi-graph-up"></i> This month: $<?= $stats['month_revenue'] ?? '0.00' ?>
            </div>
        </div>
    </div>
    
    <!-- Total Customers -->
    <div class="stat-card" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
        <div class="stat-card-icon" style="background: rgba(255,255,255,0.2);">
            <i class="bi bi-people" style="color: white;"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label" style="color: rgba(255,255,255,0.9);">Total Customers</div>
            <div class="stat-card-value" style="color: white;"><?= number_format($stats['total_customers'] ?? 0) ?></div>
            <div style="font-size: var(--text-xs); color: rgba(255,255,255,0.8); margin-top: var(--space-1);">
                <i class="bi bi-person-plus"></i> Active customers
            </div>
        </div>
    </div>
    
    <!-- Inventory -->
    <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
        <div class="stat-card-icon" style="background: rgba(255,255,255,0.2);">
            <i class="bi bi-box-seam" style="color: white;"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label" style="color: rgba(255,255,255,0.9);">Products in Stock</div>
            <div class="stat-card-value" style="color: white;"><?= $stats['total_items'] ?? 0 ?></div>
            <div style="font-size: var(--text-xs); color: rgba(255,255,255,0.8); margin-top: var(--space-1);">
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
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: var(--space-6); margin-bottom: var(--space-6);">
    
    <!-- Sales Trend Chart -->
    <div class="card">
        <div class="card-header">
            <h2 style="margin: 0; font-size: var(--text-lg); font-weight: var(--font-semibold);">
                <i class="bi bi-graph-up"></i>
                Sales Trend (Last 7 Days)
            </h2>
        </div>
        <div class="card-body">
            <div style="position: relative; height: 300px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <h2 style="margin: 0; font-size: var(--text-lg); font-weight: var(--font-semibold);">
                <i class="bi bi-lightning-charge"></i>
                Quick Actions
            </h2>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: var(--space-3);">
                <button onclick="location.reload()" class="quick-action-btn" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); border: none; cursor: pointer;">
                    <i class="bi bi-arrow-clockwise"></i>
                    <span>Refresh Dashboard</span>
                </button>
                <a href="<?= base_url('sales/register') ?>" class="quick-action-btn" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="bi bi-cart-plus"></i>
                    <span>New Sale</span>
                </a>
                <a href="<?= base_url('customers/view/-1') ?>" class="quick-action-btn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <i class="bi bi-person-plus"></i>
                    <span>Add Customer</span>
                </a>
                <a href="<?= base_url('products/view/-1') ?>" class="quick-action-btn" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                    <i class="bi bi-box-seam"></i>
                    <span>Add Product</span>
                </a>
                <a href="<?= base_url('reports') ?>" class="quick-action-btn" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>View Reports</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Second Row -->
<div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: var(--space-6);">
    
    <!-- Recent Sales -->
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0; font-size: var(--text-lg); font-weight: var(--font-semibold);">
                <i class="bi bi-receipt"></i>
                Recent Sales
            </h2>
            <a href="<?= base_url('sales') ?>" class="btn btn-sm btn-outline">View All</a>
        </div>
        <div class="card-body" style="padding: 0;">
            <?php if (!empty($stats['recent_sales'])): ?>
                <div class="list-group">
                    <?php foreach ($stats['recent_sales'] as $sale): ?>
                        <div class="list-item">
                            <div class="list-item-icon" style="background: var(--success-100); color: var(--success-600);">
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
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0; font-size: var(--text-lg); font-weight: var(--font-semibold);">
                <i class="bi bi-star"></i>
                Top Products
            </h2>
            <a href="<?= base_url('products') ?>" class="btn btn-sm btn-outline">View All</a>
        </div>
        <div class="card-body" style="padding: 0;">
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
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0; font-size: var(--text-lg); font-weight: var(--font-semibold);">
                <i class="bi bi-exclamation-triangle"></i>
                Low Stock Alert
            </h2>
            <a href="<?= base_url('reports/inventory_low') ?>" class="btn btn-sm btn-outline">View All</a>
        </div>
        <div class="card-body">
            <?php if (($stats['low_stock'] ?? 0) > 0): ?>
                <div style="text-align: center; padding: var(--space-6) 0;">
                    <div style="width: 80px; height: 80px; margin: 0 auto var(--space-4); background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-exclamation-triangle" style="font-size: 32px; color: white;"></i>
                    </div>
                    <div style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--danger-600); margin-bottom: var(--space-2);">
                        <?= $stats['low_stock'] ?>
                    </div>
                    <div style="font-size: var(--text-sm); color: var(--text-secondary); margin-bottom: var(--space-4);">
                        Products below reorder level
                    </div>
                    <a href="<?= base_url('reports/inventory_low') ?>" class="btn btn-danger btn-sm">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Review Products</span>
                    </a>
                </div>
            <?php else: ?>
                <div class="empty-state-small">
                    <i class="bi bi-check-circle" style="color: var(--success-600);"></i>
                    <p style="color: var(--success-600);">All products well stocked!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* Quick Action Buttons */
.quick-action-btn {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-4);
    border-radius: var(--radius-md);
    color: white;
    text-decoration: none;
    transition: all var(--transition-fast);
    font-weight: var(--font-semibold);
}

.quick-action-btn:hover {
    transform: translateX(4px);
    box-shadow: var(--shadow-md);
}

.quick-action-btn i {
    font-size: 24px;
}

/* List Groups */
.list-group {
    display: flex;
    flex-direction: column;
}

.list-item {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-4);
    border-bottom: 1px solid var(--border-color);
}

.list-item:last-child {
    border-bottom: none;
}

.list-item-icon {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.list-item-rank {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--primary-100);
    color: var(--primary-700);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: var(--font-bold);
    font-size: var(--text-sm);
    flex-shrink: 0;
}

.list-item-content {
    flex: 1;
    min-width: 0;
}

.list-item-title {
    font-weight: var(--font-semibold);
    color: var(--text-primary);
    font-size: var(--text-sm);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.list-item-subtitle {
    font-size: var(--text-xs);
    color: var(--text-tertiary);
    margin-top: 2px;
}

.list-item-value {
    font-weight: var(--font-bold);
    color: var(--text-primary);
    font-size: var(--text-sm);
    flex-shrink: 0;
}

.empty-state-small {
    padding: var(--space-8) var(--space-4);
    text-align: center;
    color: var(--text-tertiary);
}

.empty-state-small i {
    font-size: 48px;
    opacity: 0.3;
    margin-bottom: var(--space-2);
}

.empty-state-small p {
    margin: 0;
    font-size: var(--text-sm);
}

/* Responsive */
@media (max-width: 1200px) {
    div[style*="grid-template-columns: 2fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
    
    div[style*="grid-template-columns: 1fr 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

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
