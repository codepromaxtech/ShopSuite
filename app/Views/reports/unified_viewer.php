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
                <p class="u-font-size-text-sm_color-text-secondary-5"><?= $categoryConfig['description'] ?></p>
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
                
                <!-- Additional Options for Sales Reports -->
                <?php if ($category === 'sales' && in_array($selected_type, ['summary', 'detailed'])): ?>
                <div class="report-options u-margin-top-space-4">
                    <label class="u-display-flex_align-items-center_gap-sp-1">
                        <input type="checkbox" name="show_quantity" value="1" <?= (esc($_POST['show_quantity'] ?? '1')) === '1' ? 'checked' : '' ?>>
                        <span>Show Quantity Purchased column</span>
                    </label>
                </div>
                <?php endif; ?>
                
                <!-- View Mode (Table/Chart) -->
                <?php if ($typeConfig['supports_chart']): ?>
                <div class="view-mode-container">
                    <label class="form-label">
                        <i class="bi bi-eye"></i> View Mode
                    </label>
                    <div class="view-mode-toggle">
                        <label>
                            <input type="radio" name="view_mode" value="table" <?= ($view_mode ?? 'table') === 'table' ? 'checked' : '' ?>>
                            <i class="bi bi-table"></i> Table
                        </label>
                        <label>
                            <input type="radio" name="view_mode" value="chart" <?= ($view_mode ?? 'table') === 'chart' ? 'checked' : '' ?>>
                            <i class="bi bi-bar-chart-fill"></i> Chart
                        </label>
                    </div>
                    
                    <div class="chart-type-selector" class="mt-space-3 <?= ($view_mode ?? 'table') === 'chart' ? 'd-block' : 'd-none' ?>">
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
    <div class="card u-border-1pxsolidhexbae6fd">
        <div class="card-body">
            <h4 class="u-margin-00space-20">Debug Info:</h4>
            <pre class="u-font-size-12px_margin-0"><?php 
                echo "Request Method: " . strtoupper($_SERVER['REQUEST_METHOD']) . "\n";
                echo "POST Data: " . esc(print_r($_POST, true));
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
                        echo "Condition passes: " . (is_array($report_data) ? 'YES - SHOULD SHOW' : 'NO - WILL NOT SHOW') . "\n";
                        echo "Has data: " . (count($report_data) > 0 ? 'YES' : 'NO (will show empty state)') . "\n";
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
    <div class="card u-border-left-4pxsoliddanger-600">
        <div class="card-body">
            <div class="u-display-flex_align-items-center_gap-sp-2">
                <i class="bi bi-exclamation-triangle u-font-size-24px"></i>
                <div>
                    <h3 class="u-margin-0_color-danger-600">Error Generating Report</h3>
                    <p class="u-margin-space-2000_color-text-secondary"><?= $error ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Report Results -->
    <?php if (isset($report_data) && is_array($report_data)): ?>
    <div class="report-results card">
        <!-- Report Header (for print/PDF) -->
        <div class="report-header print-only d-none">
            <div class="u-text-align-center_margin-bottom-space">
                <h1 class="u-margin-0_font-size-24px_color-text-pri"><?= $config->company ?? 'Company Name' ?></h1>
                <p class="u-margin-space-2000_color-text-secondary"><?= $config->address ?? '' ?></p>
            </div>
            <hr class="u-border-0_border-top-2pxsolidborder-col">
            <div class="u-margin-bottom-space-4">
                <h2 class="u-margin-00space-20_font-size-20px"><?= $category_config['title'] ?> - <?= $type_config['label'] ?></h2>
                <p class="u-margin-0_color-text-secondary"><?= $report_subtitle ?? '' ?></p>
            </div>
        </div>
        
        <div class="card-header">
            <h3>
                <i class="bi bi-graph-up"></i> 
                <?= $typeConfig['label'] ?> Report
                <?php if (isset($report_subtitle)): ?>
                    <span class="u-font-size-text-sm_color-text-secondary-6">
                        <?= $report_subtitle ?>
                    </span>
                <?php endif; ?>
            </h3>
            <div class="card-actions">
                <button class="btn btn-outline btn-sm" onclick="exportReport('pdf')">
                    <i class="bi bi-file-pdf"></i> PDF
                </button>
                <button class="btn btn-outline btn-sm" onclick="exportReport('excel')">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Excel
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
        <div class="card-body u-text-align-center_padding-space-12">
            <i class="bi bi-inbox u-font-size-64px_color-text-tertiary"></i>
            <h3 class="u-margin-top-space-4_color-text-secondar">No Data Found</h3>
            <p class="u-color-text-tertiary">No results match your filter criteria. Try adjusting the date range or filters.</p>
        </div>
    </div>
    <?php endif; ?>
</div>



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
