<?php
/**
 * MODERN REPORTS PAGE - Bootstrap 5
 */
?>

<?= view('layouts/bootstrap5_header') ?>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2>
            <i class="bi bi-graph-up"></i>
            Reports & Analytics
        </h2>
        <p class="page-header-subtitle">Generate comprehensive business reports</p>
    </div>
    <div class="page-header-actions">
        <button class="btn btn-light" onclick="window.print()">
            <i class="bi bi-printer me-1"></i>Print
        </button>
        <button class="btn btn-primary" onclick="generateReport()">
            <i class="bi bi-file-earmark-bar-graph me-1"></i>Generate Report
        </button>
    </div>
</div>

<div class="container-fluid">
    <!-- Report Categories -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <a href="<?= base_url('reports/sales') ?>" class="text-decoration-none">
                <div class="stat-item">
                    <div class="stat-item-icon" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
                        <i class="bi bi-cart-fill"></i>
                    </div>
                    <div class="stat-item-content">
                        <div class="stat-item-label">Sales Reports</div>
                        <div class="stat-item-value" style="font-size: 0.875rem;">Summary, Detailed, Trends</div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-12 col-md-6 col-lg-3">
            <a href="<?= base_url('reports/inventory') ?>" class="text-decoration-none">
                <div class="stat-item">
                    <div class="stat-item-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c); color: white;">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="stat-item-content">
                        <div class="stat-item-label">Inventory Reports</div>
                        <div class="stat-item-value" style="font-size: 0.875rem;">Stock, Low Stock, Valuation</div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-12 col-md-6 col-lg-3">
            <a href="<?= base_url('reports/customers') ?>" class="text-decoration-none">
                <div class="stat-item">
                    <div class="stat-item-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe); color: white;">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-item-content">
                        <div class="stat-item-label">Customer Reports</div>
                        <div class="stat-item-value" style="font-size: 0.875rem;">Analysis, Top Customers</div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-12 col-md-6 col-lg-3">
            <a href="<?= base_url('reports/financial') ?>" class="text-decoration-none">
                <div class="stat-item">
                    <div class="stat-item-icon" style="background: linear-gradient(135deg, #fa709a, #fee140); color: white;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="stat-item-content">
                        <div class="stat-item-label">Financial Reports</div>
                        <div class="stat-item-value" style="font-size: 0.875rem;">Revenue, Expenses, Profit</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
    <!-- Quick Report Generator -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h5 class="mb-4">Quick Report Generator</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Report Type</label>
                    <select class="form-select" id="reportType">
                        <option>Sales Summary</option>
                        <option>Detailed Sales</option>
                        <option>Inventory Summary</option>
                        <option>Customer Analysis</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date From</label>
                    <input type="date" class="form-control" id="dateFrom" value="<?= date('Y-m-01') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date To</label>
                    <input type="date" class="form-control" id="dateTo" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label d-block">&nbsp;</label>
                    <button class="btn btn-primary w-100" onclick="generateReport()">
                        <i class="bi bi-play-fill me-1"></i>Generate
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function generateReport() {
    const reportType = document.getElementById('reportType')?.value;
    const dateFrom = document.getElementById('dateFrom')?.value;
    const dateTo = document.getElementById('dateTo')?.value;
    
    showNotification('Generating report...', 'info');
    // Add report generation logic here
}
</script>

<?= view('layouts/bootstrap5_footer') ?>
