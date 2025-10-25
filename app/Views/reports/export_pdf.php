<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        * {
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            color: #1e293b;
            background: #fff;
        }
        
        .header {
            margin-bottom: 30px;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 20px;
            background: linear-gradient(to right, #f8fafc, #ffffff);
            padding: 20px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 12px;
            color: #666;
        }
        
        .report-title {
            margin-bottom: 20px;
        }
        
        .report-title h2 {
            font-size: 20px;
            margin-bottom: 5px;
        }
        
        .report-title p {
            font-size: 14px;
            color: #666;
        }
        
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
        }
        }
        
        tbody tr:nth-child(even) {
            background: #fafafa;
        }
        
        thead {
            background: linear-gradient(to bottom, #1e3a8a, #1e40af);
            color: white;
        }
        
        thead th {
            font-weight: 600;
            text-align: left;
            border-bottom: 2px solid #b45309;
            color: white !important;
        }
        
        tfoot {
            background: linear-gradient(to bottom, #fef3c7, #fde68a);
            font-weight: bold;
            border-top: 3px solid #b45309;
        }
        
        tfoot td {
            color: #78350f;
            font-weight: 700;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        
        .numeric {
            text-align: right;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            @page {
                margin: 15mm;
            }
            
            thead {
                display: table-header-group;
            }
            
            tfoot {
                display: table-footer-group;
            }
            
            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 60%; vertical-align: top; border: none;">
                    <h1 style="margin: 0; font-size: 28px; color: #1e3a8a; font-weight: 700;">
                        <?= config('ShopSuite')->settings['company'] ?? config('App')->siteName ?? 'ShopSuite ERP' ?>
                    </h1>
                    <p style="margin: 5px 0 0 0; font-size: 11px; line-height: 1.5;">
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
                <td style="width: 40%; text-align: right; vertical-align: top; border: none;">
                    <p style="margin: 0; font-size: 11px; line-height: 1.8;">
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
        <h2 style="color: #1e3a8a; border-bottom: 3px solid #b45309; padding-bottom: 10px; font-weight: 700;">
            <?= htmlspecialchars($title) ?>
        </h2>
        <p style="margin-top: 10px; padding: 10px; background: #fef3c7; border-left: 4px solid #b45309; color: #78350f;">
            <strong style="color: #1e3a8a;">Report Period:</strong> <?= htmlspecialchars($subtitle) ?>
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
        <p style="text-align: center; padding: 40px; color: #999;">No data available for this report.</p>
    <?php endif; ?>
    
    <!-- Footer -->
    <div class="footer">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 50%; text-align: left; border: none;">
                    <p style="margin: 0; font-size: 10px;">
                        &copy; <?= date('Y') ?> <?= config('ShopSuite')->settings['company'] ?? config('App')->siteName ?? 'ShopSuite ERP' ?>. All rights reserved.<br>
                        <span style="color: #666;">Powered by ShopSuite v4.0</span>
                    </p>
                </td>
                <td style="width: 50%; text-align: right; border: none;">
                    <p style="margin: 0; font-size: 10px;">
                        <strong>Report Type:</strong> <?= htmlspecialchars($title) ?><br>
                        <span style="color: #666;">Printed: <?= date('M d, Y h:i A') ?></span>
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
