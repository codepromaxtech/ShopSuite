<?php
/**
 * Table View for Reports
 * Displays report data in table format
 */
?>

<div class="report-table-container">
    <?php 
    // Handle both formats: direct array or array with 'summary' key
    $tableData = $report_data['summary'] ?? $report_data;
    $totalsData = $summary_data ?? null; // Use summary_data from controller
    ?>
    
    <?php if (!empty($tableData) && is_array($tableData)): ?>
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <?php if (!empty($tableData)): ?>
                            <?php foreach (array_keys((array)$tableData[0]) as $column): ?>
                                <th><?= ucwords(str_replace('_', ' ', $column)) ?></th>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tableData as $row): ?>
                        <tr>
                            <?php foreach ((array)$row as $value): ?>
                                <td><?= is_numeric($value) ? number_format($value, 2) : htmlspecialchars($value) ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <?php if ($totalsData): ?>
                <tfoot>
                    <tr class="total-row">
                        <?php foreach ((array)$totalsData as $total): ?>
                            <td><strong><?= is_numeric($total) ? number_format($total, 2) : htmlspecialchars($total) ?></strong></td>
                        <?php endforeach; ?>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>No data available for this report</p>
        </div>
    <?php endif; ?>
</div>

<style>
/* Modern Table Styles */
.report-table-container {
    width: 100%;
    overflow-x: auto;
}

.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
    font-size: var(--text-sm);
}

.modern-table thead {
    background: var(--bg-secondary);
    position: sticky;
    top: 0;
    z-index: 10;
}

.modern-table th {
    padding: var(--space-3) var(--space-4);
    text-align: left;
    font-weight: var(--font-semibold);
    color: var(--text-primary);
    border-bottom: 2px solid var(--border-color);
    white-space: nowrap;
}

.modern-table td {
    padding: var(--space-3) var(--space-4);
    border-bottom: 1px solid var(--border-color);
}

.modern-table tbody tr {
    transition: background var(--transition-fast);
}

.modern-table tbody tr:hover {
    background: var(--bg-secondary);
}

.modern-table tfoot {
    background: var(--bg-secondary);
    font-weight: var(--font-semibold);
}

.modern-table tfoot td {
    border-top: 2px solid var(--border-color);
    border-bottom: none;
}

.empty-state {
    text-align: center;
    padding: var(--space-12);
    color: var(--text-tertiary);
}

.empty-state i {
    font-size: 64px;
    margin-bottom: var(--space-4);
}

/* Responsive */
@media (max-width: 768px) {
    .modern-table {
        font-size: var(--text-xs);
    }
    
    .modern-table th,
    .modern-table td {
        padding: var(--space-2) var(--space-3);
    }
}
</style>
