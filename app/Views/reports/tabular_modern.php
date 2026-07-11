<?php
/**
 * MODERN TABULAR REPORT VIEW
 * Data table reports with export functionality
 */
$page_title = $title ?? 'Report';
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
        <button class="btn btn-secondary" onclick="exportReport('excel')">
            <i class="bi bi-file-earmark-excel"></i>
            <span>Excel</span>
        </button>
        <button class="btn btn-secondary" onclick="exportReport('pdf')">
            <i class="bi bi-file-pdf"></i>
            <span>PDF</span>
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

<!-- Summary Cards -->
<?php if (!empty($summary_data)): ?>
<div class="stats-grid u-margin-bottom-space-6">
    <?php $colors = ['primary', 'success', 'warning', 'info']; $index = 0; ?>
    <?php foreach ($summary_data as $key => $value): ?>
        <?php $display_value = is_array($value) ? (reset($value) ?: '') : $value; ?>
        <div class="stat-card" >
            <div class="stat-card-icon u-background-rgba255-255-255-02">
                <i class="bi bi-<?= $index === 0 ? 'calculator' : ($index === 1 ? 'graph-up' : ($index === 2 ? 'currency-dollar' : 'bar-chart')) ?>" ></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-label u-color-rgba255-255-255-09_text-transfor">
                    <?= esc(str_replace('_', ' ', $key)) ?>
                </div>
                <div class="stat-card-value" >
                    <?= esc($display_value) ?>
                </div>
            </div>
        </div>
        <?php $index++; ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Report Table -->
<div class="card">
    <div class="card-header u-display-flex_justify-content-space-bet-3">
        <div>
            <h2 class="u-margin-0_font-size-text-lg_font-weight">Report Data</h2>
            <p class="u-margin-space-1000_font-size-text-sm_co">
                <?= !empty($data) ? count($data) : '0' ?> records found
            </p>
        </div>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search in table..." id="tableSearch" onkeyup="filterReportTable()">
        </div>
    </div>
    <div class="card-body u-padding-0">
        <div class="table-responsive">
            <table class="data-table" id="report_table">
                <thead>
                    <tr>
                        <?php foreach ($headers as $index => $header): ?>
                            <?php
                                // Headers from getDataColumns() are arrays like ['sale_date' => 'Date', 'sortable' => false]
                                if (is_array($header)) {
                                    $header_label = '';
                                    foreach ($header as $k => $v) {
                                        if (is_string($v)) { $header_label = $v; break; }
                                    }
                                } else {
                                    $header_label = (string) $header;
                                }
                            ?>
                            <th onclick="sortTable(<?= $index ?>)" style="cursor: pointer;">
                                <?= esc($header_label) ?>
                                <i class="bi bi-arrow-down-up u-font-size-12px_opacity-05"></i>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data)): ?>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <?php foreach ($row as $cell): ?>
                                    <td><?= is_array($cell) ? esc(reset($cell) ?: '') : esc($cell) ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= count($headers) ?>">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <h3>No Data Available</h3>
                                    <p>Try adjusting your date range or filters</p>
                                    <a href="<?= base_url('reports') ?>" class="btn btn-primary" style="margin-top: var(--space-4);">
                                        <i class="bi bi-arrow-left"></i>
                                        <span>Back to Reports</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>




<script>
// Export functionality
function exportReport(format) {
    const table = document.getElementById('report_table');
    const rows = Array.from(table.querySelectorAll('tbody tr:not(:has(.empty-state))'));

    if (rows.length === 0) {
        alert('No data to export');
        return;
    }

    if (window.shopsuiteApp) {
        window.shopsuiteApp.showToast('Info', `Preparing ${format.toUpperCase()} export...`, 'info');
    }

    if (format === 'excel') {
        exportToCSV();
    } else if (format === 'pdf') {
        window.print();
    }
}

function exportToCSV() {
    const table = document.getElementById('report_table');
    // Start with UTF-8 BOM so Excel correctly renders unicode currency symbols (৳, €, ¥, etc.)
    let csv = '\uFEFF';

    // Headers — strip the sort icon text
    const headers = Array.from(table.querySelectorAll('thead th'));
    csv += headers.map(h => {
        // Get only the text, not the icon element text
        const clone = h.cloneNode(true);
        const icons = clone.querySelectorAll('i');
        icons.forEach(i => i.remove());
        return `"${clone.textContent.trim().replace(/"/g, '""')}"`;
    }).join(',') + '\n';

    // Data rows
    const rows = Array.from(table.querySelectorAll('tbody tr:not(:has(.empty-state))'));
    rows.forEach(row => {
        const cells = Array.from(row.querySelectorAll('td'));
        csv += cells.map(c => `"${c.textContent.trim().replace(/"/g, '""')}"`).join(',') + '\n';
    });

    // Download with proper encoding
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `report_${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(link.href);

    if (window.shopsuiteApp) {
        window.shopsuiteApp.showToast('Success', 'CSV exported successfully', 'success');
    }
}

// Search/Filter
function filterReportTable() {
    const input = document.getElementById('tableSearch');
    const filter = input.value.toUpperCase();
    const table = document.getElementById('report_table');
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        const td = tr[i].getElementsByTagName('td');
        let found = false;

        for (let j = 0; j < td.length; j++) {
            if (td[j].textContent.toUpperCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }

        tr[i].style.display = found ? '' : 'none';
    }
}

// Sort table
let sortDirection = {};
function sortTable(columnIndex) {
    const table = document.getElementById('report_table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr:not(:has(.empty-state))'));

    if (rows.length === 0) return;

    // Toggle direction
    sortDirection[columnIndex] = sortDirection[columnIndex] === 'asc' ? 'desc' : 'asc';
    const direction = sortDirection[columnIndex];

    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();

        // Try to parse as numbers
        const aNum = parseFloat(aText.replace(/[^0-9.-]/g, ''));
        const bNum = parseFloat(bText.replace(/[^0-9.-]/g, ''));

        if (!isNaN(aNum) && !isNaN(bNum)) {
            return direction === 'asc' ? aNum - bNum : bNum - aNum;
        }

        return direction === 'asc' ?
            aText.localeCompare(bText) :
            bText.localeCompare(aText);
    });

    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));

    // Update sort icons
    const headers = table.querySelectorAll('thead th');
    headers.forEach((h, i) => {
        const icon = h.querySelector('i');
        if (icon) {
            if (i === columnIndex) {
                icon.className = direction === 'asc' ? 'bi bi-arrow-up' : 'bi bi-arrow-down';
                icon.style.opacity = '1';
            } else {
                icon.className = 'bi bi-arrow-down-up';
                icon.style.opacity = '0.5';
            }
        }
    });
}
</script>

<?= view('layouts/modern_footer') ?>
