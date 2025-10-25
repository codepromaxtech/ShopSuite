<?php
/**
 * MODERN GRAPHICAL REPORT VIEW
 * Chart-based reports with interactive visualizations
 */
$page_title = $title ?? 'Graphical Report';
echo view('layouts/modern_header', ['title' => $page_title]);
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-text">
            <h1 class="page-header-title"><?= esc($title) ?></h1>
            <?php if (isset($subtitle)): ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="page-header-actions">
        <button class="btn btn-secondary" onclick="downloadChart()">
            <i class="bi bi-download"></i>
            <span>Download</span>
        </button>
        <button class="btn btn-secondary" onclick="window.print()">
            <i class="bi bi-printer"></i>
            <span>Print</span>
        </button>
        <a href="<?= base_url('reports') ?>" class="btn btn-outline">
            <i class="bi bi-arrow-left"></i>
            <span>Back</span>
        </a>
    </div>
</div>

<!-- Summary Stats -->
<?php if (!empty($summary_data)): ?>
<div class="stats-grid" style="margin-bottom: var(--space-6);">
    <?php $colors = ['primary', 'success', 'warning', 'info']; $index = 0; ?>
    <?php foreach ($summary_data as $key => $value): ?>
        <div class="stat-card" style="background: linear-gradient(135deg, var(--<?= $colors[$index % 4] ?>-500) 0%, var(--<?= $colors[$index % 4] ?>-600) 100%);">
            <div class="stat-card-icon" style="background: rgba(255,255,255,0.2);">
                <i class="bi bi-<?= $index === 0 ? 'currency-dollar' : ($index === 1 ? 'graph-up' : ($index === 2 ? 'bar-chart' : 'pie-chart')) ?>" style="color: white;"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-label" style="color: rgba(255,255,255,0.9); text-transform: capitalize;">
                    <?= esc(str_replace('_', ' ', $key)) ?>
                </div>
                <div class="stat-card-value" style="color: white;">
                    <?= esc($value) ?>
                </div>
            </div>
        </div>
        <?php $index++; ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Chart Container -->
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
        <div>
            <h2 style="margin: 0; font-size: var(--text-lg); font-weight: var(--font-semibold);">Visualization</h2>
            <p style="margin: var(--space-1) 0 0 0; font-size: var(--text-sm); color: var(--text-tertiary);">
                Interactive chart view
            </p>
        </div>
        <div style="display: flex; gap: var(--space-2);">
            <button class="btn btn-sm btn-outline" onclick="changeChartType('bar')">
                <i class="bi bi-bar-chart"></i> Bar
            </button>
            <button class="btn btn-sm btn-outline" onclick="changeChartType('line')">
                <i class="bi bi-graph-up"></i> Line
            </button>
            <button class="btn btn-sm btn-outline" onclick="changeChartType('pie')">
                <i class="bi bi-pie-chart"></i> Pie
            </button>
        </div>
    </div>
    <div class="card-body">
        <div style="position: relative; height: 400px;">
            <canvas id="reportChart"></canvas>
        </div>
    </div>
</div>

<!-- Data Table -->
<?php if (!empty($details) && !empty($headers)): ?>
<div class="card" style="margin-top: var(--space-6);">
    <div class="card-header">
        <h2 style="margin: 0; font-size: var(--text-lg); font-weight: var(--font-semibold);">
            <i class="bi bi-table"></i>
            Detailed Data
        </h2>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <?php foreach ($headers as $header): ?>
                            <th><?= esc($header) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($details as $row): ?>
                        <tr>
                            <?php foreach ($row as $cell): ?>
                                <td><?= esc($cell) ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Prepare chart data
const chartData = {
    labels: <?= json_encode($data['labels'] ?? []) ?>,
    datasets: [{
        label: '<?= esc($data['dataset_label'] ?? 'Value') ?>',
        data: <?= json_encode($data['data'] ?? []) ?>,
        backgroundColor: [
            'rgba(99, 102, 241, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(239, 68, 68, 0.8)',
            'rgba(139, 92, 246, 0.8)',
            'rgba(59, 130, 246, 0.8)',
            'rgba(236, 72, 153, 0.8)',
            'rgba(20, 184, 166, 0.8)'
        ],
        borderColor: [
            'rgb(99, 102, 241)',
            'rgb(16, 185, 129)',
            'rgb(245, 158, 11)',
            'rgb(239, 68, 68)',
            'rgb(139, 92, 246)',
            'rgb(59, 130, 246)',
            'rgb(236, 72, 153)',
            'rgb(20, 184, 166)'
        ],
        borderWidth: 2
    }]
};

// Chart options
const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: <?= ($graph_type ?? 'bar') === 'pie' ? 'true' : 'false' ?>,
            position: 'right'
        },
        tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
            titleFont: {
                size: 14
            },
            bodyFont: {
                size: 13
            }
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            display: <?= ($graph_type ?? 'bar') !== 'pie' ? 'true' : 'false' ?>,
            grid: {
                color: 'rgba(0, 0, 0, 0.05)'
            }
        },
        x: {
            display: <?= ($graph_type ?? 'bar') !== 'pie' ? 'true' : 'false' ?>,
            grid: {
                display: false
            }
        }
    }
};

// Create chart
const ctx = document.getElementById('reportChart').getContext('2d');
let reportChart = new Chart(ctx, {
    type: '<?= $graph_type ?? 'bar' ?>',
    data: chartData,
    options: chartOptions
});

// Change chart type
function changeChartType(type) {
    reportChart.destroy();
    
    const newOptions = {...chartOptions};
    newOptions.plugins.legend.display = (type === 'pie');
    newOptions.scales.y.display = (type !== 'pie');
    newOptions.scales.x.display = (type !== 'pie');
    
    reportChart = new Chart(ctx, {
        type: type,
        data: chartData,
        options: newOptions
    });
}

// Download chart
function downloadChart() {
    const link = document.createElement('a');
    link.download = 'chart_' + new Date().toISOString().split('T')[0] + '.png';
    link.href = document.getElementById('reportChart').toDataURL();
    link.click();
    
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showToast('Success', 'Chart downloaded', 'success');
    }
}

// Print styles
const printStyles = `
    @media print {
        .page-header-actions,
        .btn,
        button {
            display: none !important;
        }
        .card {
            break-inside: avoid;
        }
    }
`;

const styleSheet = document.createElement('style');
styleSheet.textContent = printStyles;
document.head.appendChild(styleSheet);
</script>

<?= view('layouts/modern_footer') ?>
