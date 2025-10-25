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
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th {
            background: #f0f0f0;
            border: 1px solid #ddd;
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
            background: linear-gradient(to bottom, #2563eb, #1e40af);
            color: white;
        }
        
        thead th {
            font-weight: 600;
            text-align: left;
            border-bottom: 2px solid #1e40af;
            color: white !important;
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
                    <h1 style="margin: 0; font-size: 28px; color: #2563eb;">
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
        <h2 style="color: #1e40af; border-bottom: 3px solid #2563eb; padding-bottom: 10px;">
            <?= htmlspecialchars($title) ?>
        </h2>
        <p style="margin-top: 10px; padding: 10px; background: #eff6ff; border-left: 4px solid #2563eb;">
            <strong>Report Period:</strong> <?= htmlspecialchars($subtitle) ?>
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
                <?php foreach ($summary_data as $key => $total): ?>
                    <td class="<?= is_numeric($total) ? 'numeric' : '' ?>">
                        <?php if ($key === array_key_first($summary_data)): ?>
                            <strong>TOTAL</strong>
                        <?php else: ?>
                            <strong><?= is_numeric($total) ? number_format($total, 2) : htmlspecialchars($total) ?></strong>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
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
