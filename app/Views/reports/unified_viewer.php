<?php
/**
 * Unified Report Viewer
 * Dynamic interface for all report types
 */
$categoryConfig = $category_config;
$reportTypes = $categoryConfig['types'];
$selectedType = $selected_type ?? array_key_first($reportTypes);
$typeConfig = $reportTypes[$selectedType];

$title = $categoryConfig['title'];
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <div>
                <h1><?= $categoryConfig['title'] ?></h1>
                <p style="font-size: var(--text-sm); color: var(--text-secondary); margin: 0;"><?= $categoryConfig['description'] ?></p>
            </div>
        </div>
        
        <div class="page-header-actions">
            <a href="<?= base_url('reports') ?>" class="btn btn-outline">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Reports
            </a>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item"><a href="<?= base_url('reports') ?>">Reports</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active"><?= $categoryConfig['title'] ?></div>
    </div>
</div>

<div class="unified-report-container">
    <form id="reportForm" method="post" action="<?= current_url() ?>">
        <?= csrf_field() ?>
        
        <!-- Report Configuration Panel -->
        <div class="report-config-panel card">
            <div class="card-header">
                <h3><i class="bi bi-sliders"></i> Report Configuration</h3>
            </div>
            <div class="card-body">
                <!-- Report Type Selector -->
                <div class="form-group">
                    <label for="reportType" class="form-label">
                        <i class="bi bi-file-text"></i> Report Type
                    </label>
                    <select name="report_type" id="reportType" class="form-control" onchange="handleReportTypeChange()" required>
                        <?php foreach ($reportTypes as $typeKey => $typeData): ?>
                            <option value="<?= $typeKey ?>" <?= $typeKey === $selectedType ? 'selected' : '' ?>>
                                <?= $typeData['label'] ?> - <?= $typeData['description'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Dynamic Filters Container -->
                <div id="dynamicFilters">
                    <?= view('reports/partials/filters', [
                        'type_config' => $typeConfig,
                        'filter_configs' => $filter_configs,
                        'locations' => $locations ?? [],
                        'categories' => $categories ?? []
                    ]) ?>
                </div>
                
                <!-- View Mode (Table/Chart) -->
                <?php if ($typeConfig['supports_chart']): ?>
                <div class="view-mode-container">
                    <label class="form-label">
                        <i class="bi bi-eye"></i> View Mode
                    </label>
                    <div class="view-mode-toggle">
                        <input type="radio" name="view_mode" value="table" id="viewTable" <?= (!isset($view_mode) || $view_mode === 'table') ? 'checked' : '' ?>>
                        <label for="viewTable">
                            <i class="bi bi-table"></i> Table
                        </label>
                        
                        <input type="radio" name="view_mode" value="chart" id="viewChart" <?= (isset($view_mode) && $view_mode === 'chart') ? 'checked' : '' ?>>
                        <label for="viewChart">
                            <i class="bi bi-bar-chart"></i> Chart
                        </label>
                    </div>
                    
                    <!-- Chart Type (shown only when chart mode selected) -->
                    <div id="chartTypeContainer" style="display: <?= (isset($view_mode) && $view_mode === 'chart') ? 'block' : 'none' ?>; margin-top: var(--space-4);">
                        <label class="form-label">Chart Type</label>
                        <select name="chart_type" class="form-control">
                            <?php foreach ($typeConfig['chart_types'] ?? ['bar'] as $chartType): ?>
                                <option value="<?= $chartType ?>" <?= ($typeConfig['default_chart'] ?? 'bar') === $chartType ? 'selected' : '' ?>>
                                    <?= ucfirst($chartType) ?> Chart
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <?php else: ?>
                    <input type="hidden" name="view_mode" value="table">
                <?php endif; ?>
                
                <!-- Action Buttons -->
                <div class="report-actions">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-play-fill"></i>
                        Generate Report
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="resetFilters()">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </form>
    
    <!-- Debug Info (remove after testing) -->
    <?php if (ENVIRONMENT === 'development' && strtoupper($_SERVER['REQUEST_METHOD']) === 'POST'): ?>
    <div class="card" style="background: #f0f9ff; border: 1px solid #bae6fd;">
        <div class="card-body">
            <h4 style="margin: 0 0 var(--space-2) 0; color: #0369a1;">Debug Info:</h4>
            <pre style="font-size: 12px; margin: 0;"><?php 
                echo "Request Method: " . strtoupper($_SERVER['REQUEST_METHOD']) . "\n";
                echo "POST Data: " . print_r($_POST, true);
                echo "\nCategory: {$category}\n";
                echo "Selected Type: {$selected_type}\n";
                echo "Model: " . ($type_config['model'] ?? 'not set') . "\n";
                echo "Report Data Set: " . (isset($report_data) ? 'YES' : 'NO') . "\n";
                if (isset($report_data)) {
                    echo "Report Data Keys: " . implode(', ', array_keys($report_data)) . "\n";
                    if (isset($report_data['summary'])) {
                        echo "Summary Records: " . count($report_data['summary']) . "\n";
                    }
                }
                
                // Show execution flow
                echo "\n=== EXECUTION DEBUG ===\n";
                echo "Debug Info Variable Exists: " . (isset($debug_info) ? 'YES' : 'NO') . "\n";
                
                if (isset($debug_info)) {
                    echo "Last Step: " . ($debug_info['step'] ?? 'unknown') . "\n";
                    echo "Model Name: " . ($debug_info['model_name'] ?? 'not set') . "\n";
                    echo "Filters: " . print_r($debug_info['filters'] ?? [], true);
                    if (isset($debug_info['data_keys'])) {
                        echo "Data Keys: " . (is_array($debug_info['data_keys']) ? implode(', ', $debug_info['data_keys']) : $debug_info['data_keys']) . "\n";
                    }
                    if (isset($debug_info['data_summary_count'])) {
                        echo "Summary Count: " . $debug_info['data_summary_count'] . "\n";
                    }
                    if (isset($debug_info['exception'])) {
                        echo "\n!!! EXCEPTION !!!\n" . $debug_info['exception'] . "\n";
                    }
                    
                    // Display condition debug
                    echo "\n=== DISPLAY CONDITION ===\n";
                    echo "isset(report_data): " . (isset($report_data) ? 'YES' : 'NO') . "\n";
                    if (isset($report_data)) {
                        echo "is_array(report_data): " . (is_array($report_data) ? 'YES' : 'NO') . "\n";
                        echo "count(report_data): " . count($report_data) . "\n";
                        echo "Condition passes: " . ((is_array($report_data) && count($report_data) > 0) ? 'YES - SHOULD SHOW' : 'NO - WILL NOT SHOW') . "\n";
                    } else {
                        echo "report_data is not set - report not generated\n";
                    }
                }
            ?></pre>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Error Display -->
    <?php if (isset($error)): ?>
    <div class="card" style="border-left: 4px solid var(--danger-600);">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: var(--space-3); color: var(--danger-600);">
                <i class="bi bi-exclamation-triangle" style="font-size: 24px;"></i>
                <div>
                    <h3 style="margin: 0; color: var(--danger-600);">Error Generating Report</h3>
                    <p style="margin: var(--space-2) 0 0 0; color: var(--text-secondary);"><?= $error ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Report Results -->
    <?php if (isset($report_data) && is_array($report_data) && count($report_data) > 0): ?>
    <div class="report-results card">
        <!-- Report Header (for print/PDF) -->
        <div class="report-header print-only" style="display: none;">
            <div style="text-align: center; margin-bottom: var(--space-6);">
                <h1 style="margin: 0; font-size: 24px; color: var(--text-primary);"><?= $config->company ?? 'Company Name' ?></h1>
                <p style="margin: var(--space-2) 0 0 0; color: var(--text-secondary);"><?= $config->address ?? '' ?></p>
            </div>
            <hr style="border: 0; border-top: 2px solid var(--border-color); margin: var(--space-4) 0;">
            <div style="margin-bottom: var(--space-4);">
                <h2 style="margin: 0 0 var(--space-2) 0; font-size: 20px;"><?= $category_config['title'] ?> - <?= $type_config['label'] ?></h2>
                <p style="margin: 0; color: var(--text-secondary);"><?= $report_subtitle ?? '' ?></p>
            </div>
        </div>
        
        <div class="card-header">
            <h3>
                <i class="bi bi-graph-up"></i> 
                <?= $typeConfig['label'] ?> Report
                <?php if (isset($report_subtitle)): ?>
                    <span style="font-size: var(--text-sm); color: var(--text-secondary); font-weight: normal;">
                        <?= $report_subtitle ?>
                    </span>
                <?php endif; ?>
            </h3>
            <div class="card-actions">
                <button class="btn btn-outline btn-sm" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print
                </button>
                <button class="btn btn-outline btn-sm" onclick="exportReport('pdf')">
                    <i class="bi bi-file-pdf"></i> PDF
                </button>
                <button class="btn btn-outline btn-sm" onclick="exportReport('excel')">
                    <i class="bi bi-file-excel"></i> Excel
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php if ($view_mode === 'table'): ?>
                <!-- Table View -->
                <?= view('reports/partials/table_view', ['report_data' => $report_data, 'type_config' => $typeConfig]) ?>
            <?php else: ?>
                <!-- Chart View -->
                <?= view('reports/partials/chart_view', ['report_data' => $report_data, 'type_config' => $typeConfig, 'chart_type' => $chart_type ?? 'bar']) ?>
            <?php endif; ?>
        </div>
    </div>
    <?php elseif (isset($report_data)): ?>
    <div class="card">
        <div class="card-body" style="text-align: center; padding: var(--space-12);">
            <i class="bi bi-inbox" style="font-size: 64px; color: var(--text-tertiary);"></i>
            <h3 style="margin-top: var(--space-4); color: var(--text-secondary);">No Data Found</h3>
            <p style="color: var(--text-tertiary);">No results match your filter criteria. Try adjusting the date range or filters.</p>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
/* Unified Report Container */
.unified-report-container {
    display: grid;
    gap: var(--space-6);
    margin-bottom: var(--space-8);
}

/* Report Config Panel */
.report-config-panel {
    background: var(--bg-elevated);
    position: sticky;
    top: 20px;
    z-index: 10;
}

.report-config-panel .card-header {
    background: linear-gradient(135deg, <?= $categoryConfig['color'] ?? '#6366f1' ?> 0%, <?= $categoryConfig['color'] ?? '#6366f1' ?>dd 100%);
    color: white;
    padding: var(--space-4) var(--space-6);
    border-bottom: none;
}

.report-config-panel .card-header h3 {
    margin: 0;
    font-size: var(--text-lg);
    font-weight: var(--font-semibold);
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.report-config-panel .card-body {
    padding: var(--space-6);
}

/* Form Groups */
.form-group {
    margin-bottom: var(--space-5);
}

.form-label {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-weight: var(--font-medium);
    margin-bottom: var(--space-2);
    color: var(--text-primary);
}

/* View Mode Toggle */
.view-mode-container {
    margin-top: var(--space-6);
    padding-top: var(--space-6);
    border-top: 1px solid var(--border-color);
}

.view-mode-toggle {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-2);
}

.view-mode-toggle input[type="radio"] {
    display: none;
}

.view-mode-toggle label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-2);
    padding: var(--space-3);
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: all var(--transition-fast);
    font-weight: var(--font-medium);
}

.view-mode-toggle input[type="radio"]:checked + label {
    background: var(--primary-600);
    border-color: var(--primary-600);
    color: white;
}

.view-mode-toggle label:hover {
    border-color: var(--primary-400);
}

/* Report Actions */
.report-actions {
    display: flex;
    gap: var(--space-3);
    margin-top: var(--space-6);
    padding-top: var(--space-6);
    border-top: 1px solid var(--border-color);
}

.report-actions .btn-lg {
    flex: 1;
}

/* Report Results */
.report-results {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Card Actions */
.card-actions {
    display: flex;
    gap: var(--space-2);
}

/* Responsive */
@media (max-width: 768px) {
    .report-config-panel {
        position: relative;
        top: 0;
    }
    
    .report-actions {
        flex-direction: column;
    }
    
    .card-actions {
        flex-direction: column;
        width: 100%;
    }
}

/* Print Styles */
@media print {
    /* Hide UI elements */
    .report-config-panel,
    .page-header,
    .btn,
    .card-actions,
    .breadcrumbs,
    .card-header,
    .debug-info {
        display: none !important;
    }
    
    /* Show print-only elements */
    .print-only {
        display: block !important;
    }
    
    /* Reset card styles for print */
    .card {
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
    }
    
    /* Table formatting */
    .modern-table {
        page-break-inside: auto;
    }
    
    .modern-table tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    
    .modern-table thead {
        display: table-header-group;
    }
    
    .modern-table tfoot {
        display: table-footer-group;
        font-weight: bold;
        border-top: 2px solid #000;
    }
    
    /* Page setup */
    @page {
        margin: 1.5cm;
    }
    
    body {
        background: white !important;
    }
}
</style>

<script>
// Report Type Change Handler
function handleReportTypeChange() {
    const form = document.getElementById('reportForm');
    const reportType = document.getElementById('reportType').value;
    
    // Reload page with new report type
    window.location.href = '<?= current_url() ?>?type=' + reportType;
}

// View Mode Toggle Handler
document.querySelectorAll('input[name="view_mode"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const chartContainer = document.getElementById('chartTypeContainer');
        if (chartContainer) {
            chartContainer.style.display = this.value === 'chart' ? 'block' : 'none';
        }
    });
});

// Reset Filters
function resetFilters() {
    document.getElementById('reportForm').reset();
}

// Export Report
function exportReport(format) {
    const form = document.getElementById('reportForm');
    const formData = new FormData(form);
    formData.append('export', format);
    
    // Create temporary form for export
    const exportForm = document.createElement('form');
    exportForm.method = 'POST';
    exportForm.action = '<?= base_url("reports/{$category}/export") ?>';
    
    for (let [key, value] of formData.entries()) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        exportForm.appendChild(input);
    }
    
    document.body.appendChild(exportForm);
    exportForm.submit();
    document.body.removeChild(exportForm);
}

// Auto-submit on load if coming from report generation
<?php if (isset($auto_submit) && $auto_submit): ?>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll to results
    document.querySelector('.report-results')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
});
<?php endif; ?>
</script>

<?= view('layouts/modern_footer') ?>
