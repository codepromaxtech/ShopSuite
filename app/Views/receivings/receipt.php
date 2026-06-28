<?php
/**
 * @var bool $print_after_sale
 * @var string $transaction_time
 * @var int $receiving_id
 * @var string $employee
 * @var array $cart
 * @var bool $show_stock_locations
 * @var float $total
 * @var string $mode
 * @var string $payment_type
 * @var float $amount_tendered
 * @var float $amount_change
 * @var string $barcode
 * @var array $config
 */

// Check for errors
if (isset($error_message)) {
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Transaction Failed</title><link rel="icon" type="image/x-icon" href="' . base_url('favicon.ico') . '"></head><body class="u-margin-0_padding-0_font-family--apple-1">';
    echo '<div class="u-display-flex_align-items-center_justif">';
    echo '<div class="u-max-width-500px_padding-40px_border-ra">';
    echo '<svg class="u-margin-0auto20px" width="80" height="80" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
    echo '<h1 class="u-margin-bottom-16px">Transaction Failed</h1>';
    echo '<p class="u-margin-bottom-24px">' . esc($error_message) . '</p>';
    echo '<a class="u-padding-12px24px_border-radius-8px_tex" style="background: var(--info-600); color: white; display: inline-block; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600;" href="' . base_url('receivings') . '">Back to Receivings</a>';
    echo '</div></div></body></html>';
    exit;
}

// Use modern receipt view
echo view('receivings/receipt_modern', get_defined_vars());
?>
