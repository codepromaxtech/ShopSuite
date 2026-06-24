<?php
/**
 * @var int $sale_id_num
 * @var bool $print_after_sale
 * @var array $config
 */

use App\Models\Employee;

// Check for errors
if (isset($error_message)) {
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Transaction Failed</title><link rel="icon" type="image/x-icon" href="' . base_url('favicon.ico') . '"></head><body class="u-margin-0_padding-0_font-family--apple-1">';
    echo '<div class="u-display-flex_align-items-center_justif">';
    echo '<div class="u-max-width-500px_padding-40px_border-ra">';
    echo '<svg class="u-margin-0auto20px" width="80" height="80" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
    echo '<h1 class="u-margin-bottom-16px">Transaction Failed</h1>';
    echo '<p class="u-margin-bottom-24px">' . esc($error_message) . '</p>';
    echo '<a class="u-padding-12px24px_border-radius-8px_tex" href="' . base_url('sales') . '">Back to POS</a>';
    echo '</div></div></body></html>';
    exit;
}

// Use modern receipt view
echo view('sales/receipt_modern', get_defined_vars());
?>
