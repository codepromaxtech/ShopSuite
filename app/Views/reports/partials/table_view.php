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
                            <?php 
                            foreach (array_keys((array)$tableData[0]) as $column):
                                $name = str_replace('_', ' ', $column);
                                $name = ucwords($name);
                                // Improve specific column names
                                $replacements = [
                                    'Sale Date' => 'Date',
                                    'Sale Time' => 'Date/Time',
                                    'Items Purchased' => 'Quantity',
                                    'Quantity Purchased' => 'Quantity',
                                    'Trans Amount' => 'Amount',
                                    'Trans Payments' => 'Payments',
                                    'Trans Refunded' => 'Refunded',
                                    'Trans Due' => 'Due',
                                    'Trans Sales' => 'Sales Count',
                                    'Trans Group' => 'Group',
                                    'Trans Type' => 'Type',
                                    'Type Code' => 'Type',
                                    'Employee Name' => 'Employee',
                                    'Customer Name' => 'Customer',
                                    'Payment Type' => 'Payment Method'
                                ];
                                $displayName = $replacements[$name] ?? $name;
                            ?>
                                <th><?= $displayName ?></th>
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
                        <?php 
                        // Get column keys from data to ensure alignment
                        $dataKeys = array_keys((array)$tableData[0]);
                        $isFirst = true;
                        foreach ($dataKeys as $key):
                            if ($isFirst):
                                // First column shows "TOTAL" label
                        ?>
                            <td><strong>TOTAL</strong></td>
                        <?php 
                                $isFirst = false;
                            else:
                                // Other columns show totals if they exist, empty otherwise
                                $value = $totalsData[$key] ?? '';
                        ?>
                            <td><strong><?= is_numeric($value) ? number_format($value, 2) : htmlspecialchars($value) ?></strong></td>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
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


