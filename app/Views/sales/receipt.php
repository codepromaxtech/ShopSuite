<?php
/**
 * @var int $sale_id_num
 * @var bool $print_after_sale
 * @var array $config
 */

use App\Models\Employee;

// Check for errors
if (isset($error_message)) {
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Transaction Failed</title><link rel="icon" type="image/x-icon" href="' . base_url('favicon.ico') . '"></head><body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif;">';
    echo '<div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);">';
    echo '<div style="max-width: 500px; background: white; padding: 40px; border-radius: 16px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">';
    echo '<svg width="80" height="80" fill="none" stroke="#dc2626" viewBox="0 0 24 24" style="margin: 0 auto 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
    echo '<h1 style="color: #dc2626; margin-bottom: 16px;">Transaction Failed</h1>';
    echo '<p style="color: #6b7280; margin-bottom: 24px;">' . esc($error_message) . '</p>';
    echo '<a href="' . base_url('sales') . '" style="background: #dc2626; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; display: inline-block; font-weight: 600;">Back to POS</a>';
    echo '</div></div></body></html>';
    exit;
}

// Use modern receipt view
echo view('sales/receipt_modern', get_defined_vars());
?>
