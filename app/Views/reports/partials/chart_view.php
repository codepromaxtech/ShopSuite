<?php
/**
 * Chart View for Reports
 * Displays report data in chart format using Chart.js
 */
$chartType = $chart_type ?? 'bar';
?>

<div class="report-chart-container">
    <canvas id="reportChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Prepare chart data - handle both formats
const reportData = <?= json_encode($report_data['summary'] ?? $report_data) ?>;

// Extract labels and values
const labels = reportData.map(item => Object.values(item)[0]); // First column as labels
const dataValues = reportData.map(item => Object.values(item)[1]); // Second column as values

// Chart configuration
const ctx = document.getElementById('reportChart').getContext('2d');
const chart = new Chart(ctx, {
    type: '<?= $chartType ?>',
    data: {
        labels: labels,
        datasets: [{
            label: 'Value',
            data: dataValues,
            backgroundColor: [
                'rgba(16, 185, 129, 0.8)',  // green
                'rgba(99, 102, 241, 0.8)',  // indigo
                'rgba(59, 130, 246, 0.8)',  // blue
                'rgba(245, 158, 11, 0.8)',  // amber
                'rgba(139, 92, 246, 0.8)',  // purple
                'rgba(239, 68, 68, 0.8)',   // red
                'rgba(236, 72, 153, 0.8)',  // pink
                'rgba(20, 184, 166, 0.8)',  // teal
            ],
            borderColor: [
                'rgba(16, 185, 129, 1)',
                'rgba(99, 102, 241, 1)',
                'rgba(59, 130, 246, 1)',
                'rgba(245, 158, 11, 1)',
                'rgba(139, 92, 246, 1)',
                'rgba(239, 68, 68, 1)',
                'rgba(236, 72, 153, 1)',
                'rgba(20, 184, 166, 1)',
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: {
                display: <?= $chartType === 'pie' ? 'true' : 'false' ?>,
                position: 'top',
            },
            title: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed.y !== null) {
                            label += new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'USD'
                            }).format(context.parsed.y);
                        }
                        return label;
                    }
                }
            }
        },
        scales: <?= $chartType !== 'pie' ? `{
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'USD',
                            minimumFractionDigits: 0
                        }).format(value);
                    }
                }
            }
        }` : '{}' ?>
    }
});
</script>


