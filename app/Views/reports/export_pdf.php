<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            padding: 20mm;
            background: white;
            color: #000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
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
        
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 11px;
        }
        
        tbody tr:nth-child(even) {
            background: #fafafa;
        }
        
        tfoot td {
            font-weight: bold;
            background: #e8e8e8;
            border-top: 2px solid #000;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
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
        <h1><?= config('App')->siteName ?? 'Company Name' ?></h1>
        <p>Generated: <?= date('F d, Y H:i:s') ?></p>
    </div>
    
    <!-- Report Title -->
    <div class="report-title">
        <h2><?= htmlspecialchars($title) ?></h2>
        <p><?= htmlspecialchars($subtitle) ?></p>
    </div>
    
    <!-- Report Data Table -->
    <?php if (!empty($report_data)): ?>
    <table>
        <thead>
            <tr>
                <?php foreach (array_keys($report_data[0]) as $column): ?>
                    <th><?= ucwords(str_replace('_', ' ', $column)) ?></th>
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
        <p>&copy; <?= date('Y') ?> <?= config('App')->siteName ?? 'Company Name' ?>. All rights reserved.</p>
        <p>Page <?= 1 ?> of <?= 1 ?></p>
    </div>
    
    <script>
        // Auto-print when page loads (for PDF generation)
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
