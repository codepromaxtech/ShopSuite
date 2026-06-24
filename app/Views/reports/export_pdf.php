<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    
</head>
<body>
    <!-- Header -->
    <div class="header">
        <table class="u-width-100pct_border-none">
            <tr>
                <td class="u-width-60pct_vertical-align-top_border">
                    <h1 class="u-margin-0_font-size-28px_font-weight-70">
                        <?= config('ShopSuite')->settings['company'] ?? config('App')->siteName ?? 'ShopSuite ERP' ?>
                    </h1>
                    <p class="u-margin-5px000_font-size-11px_line-heig">
                        <?php if (!empty(config('ShopSuite')->settings['address'])): ?>
                            <strong>Address:</strong> <?= htmlspecialchars(config('ShopSuite')->settings['address']) ?><br>
                        <?php endif; ?>
                        <?php if (!empty(config('ShopSuite')->settings['phone'])): ?>
                            <strong>Phone:</strong> <?= htmlspecialchars(config('ShopSuite')->settings['phone']) ?><br>
                        <?php endif; ?>
                        <?php if (!empty(config('ShopSuite')->settings['email'])): ?>
                            <strong>Email:</strong> <?= htmlspecialchars(config('ShopSuite')->settings['email']) ?>
                        <?php endif; ?>
                    </p>
                </td>
                <td class="u-width-40pct_text-align-right_vertical">
                    <p class="u-margin-0_font-size-11px_line-height-18">
                        <strong>Report Generated:</strong><br>
                        <?= date('F d, Y') ?><br>
                        <?= date('h:i A') ?><br>
                        <br>
                        <strong>Report ID:</strong> <?= strtoupper(substr(md5($title . time()), 0, 8)) ?>
                    </p>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- Report Title -->
    <div class="report-title">
        <h2 class="u-border-bottom-3pxsolidhexb45309_paddin">
            <?= htmlspecialchars($title) ?>
        </h2>
        <p class="u-margin-top-10px_padding-10px_border-le">
            <strong >Report Period:</strong> <?= htmlspecialchars($subtitle) ?>
        </p>
    </div>
    
    <!-- Report Data Table -->
    <?php if (!empty($report_data)): ?>
    <table>
        <thead>
            <tr>
                <?php 
                foreach (array_keys($report_data[0]) as $column):
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
            </tr>
        </thead>
        <tbody>
            <?php foreach ($report_data as $row): ?>
                <tr>
                    <?php foreach ($row as $value): ?>
                        <td class="<?= is_numeric($value) ? 'numeric' : '' ?>">
                            <?= is_numeric($value) ? number_format($value, 2) : htmlspecialchars($value) ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
        
        <?php if ($summary_data): ?>
        <tfoot>
            <tr>
                <?php 
                // Get column keys from data to ensure alignment
                $dataKeys = array_keys($report_data[0]);
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
                        $value = $summary_data[$key] ?? '';
                ?>
                    <td class="<?= is_numeric($value) ? 'numeric' : '' ?>">
                        <strong><?= is_numeric($value) ? number_format($value, 2) : htmlspecialchars($value) ?></strong>
                    </td>
                <?php 
                    endif;
                endforeach; 
                ?>
            </tr>
        </tfoot>
        <?php endif; ?>
    </table>
    <?php else: ?>
        <p class="u-text-align-center_padding-40px">No data available for this report.</p>
    <?php endif; ?>
    
    <!-- Footer -->
    <div class="footer">
        <table class="u-width-100pct_border-none">
            <tr>
                <td class="u-width-50pct_text-align-left_border-non">
                    <p class="u-margin-0_font-size-10px">
                        &copy; <?= date('Y') ?> <?= config('ShopSuite')->settings['company'] ?? config('App')->siteName ?? 'ShopSuite ERP' ?>. All rights reserved.<br>
                        <span >Powered by ShopSuite v4.0</span>
                    </p>
                </td>
                <td class="u-width-50pct_text-align-right_border-no">
                    <p class="u-margin-0_font-size-10px">
                        <strong>Report Type:</strong> <?= htmlspecialchars($title) ?><br>
                        <span >Printed: <?= date('M d, Y h:i A') ?></span>
                    </p>
                </td>
            </tr>
        </table>
    </div>
    
    <script>
        // Auto-print when page loads (for PDF generation)
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
