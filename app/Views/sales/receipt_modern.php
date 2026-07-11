<?php
/**
 * Modern Sales Receipt
 * @var string $transaction_time
 * @var int $sale_id
 * @var string $invoice_number
 * @var string $employee
 * @var array $cart
 * @var float $discount
 * @var float $prediscount_subtotal
 * @var float $subtotal
 * @var array $taxes
 * @var float $total
 * @var array $payments
 * @var float $amount_change
 * @var string $barcode
 * @var array $config
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#10b981">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/modern-pages.css') ?>">
    <title>Receipt #<?= $sale_id ?> - Sale Complete</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="stylesheet" href="<?= base_url('css/roboto-mono.css') ?>">
    <?= view('sales/partials/document_csrf') ?>
</head>
<body class="u-margin-0_padding-0_font-family--apple">

<div class="receipt-page">
    <div class="receipt-container">
        <!-- Success Header -->
        <div class="receipt-success-header print-hide">
            <div class="success-icon">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="u-margin-008px_font-size-32px_font-weigh">Sale Complete!</h1>
<style>
        .receipt-success-header { padding: 20px 20px 16px !important; }
        .success-icon { width: 56px !important; height: 56px !important; margin: 0 auto 12px !important; }
        .success-icon svg { width: 32px; height: 32px; }
        h1.u-margin-008px_font-size-32px_font-weigh { font-size: 24px !important; }
        .action-buttons { padding: 0 !important; background: transparent !important; box-shadow: none !important; margin-top: 16px; margin-bottom: 0px !important; justify-content: center !important; gap: 8px; flex-wrap: wrap; }
        .btn-action { padding: 8px 12px !important; font-size: 13px !important; }
        .receipt-page { padding: 24px 16px !important; }
        .receipt-content { margin-top: 16px !important; }
    </style>
            <!-- Action Buttons -->
            <div class="action-buttons print-hide">
                <button onclick="window.print()" class="btn-action btn-print">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Receipt
                </button>
                
                <?php if (!empty($customer_email)): ?>
                <button onclick="sendEmail()" id="email_button" class="btn-action btn-email btn-email-default">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Email Receipt
                </button>
                <?php endif; ?>
                
                <a href="<?= base_url('sales') ?>" class="btn-action btn-new-sale">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    New Sale
                </a>
                
                <a href="<?= base_url('sales/manage') ?>" class="btn-action btn-sales">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Sales History
                </a>
            </div>
            <p class="u-margin-0_font-size-16px_opacity-09">Transaction processed successfully</p>
        </div>
        
        <!-- Receipt Content -->
        <div class="receipt-content">
            <!-- Print-Only Header (visible only when printing) -->
            <div class="print-receipt-header d-none">
                <div class="print-company-name"><?= esc($config['company']) ?></div>
                <div class="print-company-info">
                    <?= nl2br(esc($config['address'])) ?><br>
                    <?= esc($config['phone']) ?><?php if (!empty($config['email'])): ?><br><?= esc($config['email']) ?><?php endif; ?>
                </div>
                <div class="u-margin-top-1px_font-size-11px_font-wei">SALES RECEIPT</div>
                <div class="u-font-size-9px_margin-top-1px"><?= date('M d, Y - h:i A', strtotime($transaction_time)) ?></div>
            </div>
            
            <!-- Sale Information Grid -->
            <div class="receipt-info-grid">
                <div class="info-item">
                    <div class="info-label">Sale ID</div>
                    <div class="info-value"><?= esc($sale_id) ?></div>
                </div>
                <?php if (!empty($invoice_number)): ?>
                <div class="info-item">
                    <div class="info-label">Invoice Number</div>
                    <div class="info-value"><?= esc($invoice_number) ?></div>
                </div>
                <?php endif; ?>
                <div class="info-item">
                    <div class="info-label">Date & Time</div>
                    <div class="info-value"><?= date('M d, Y - h:i A', strtotime($transaction_time)) ?></div>
                </div>
                <?php if (isset($customer)): ?>
                <div class="info-item">
                    <div class="info-label">Customer</div>
                    <div class="info-value"><?= esc($customer) ?></div>
                </div>
                <?php endif; ?>
                <div class="info-item">
                    <div class="info-label">Employee</div>
                    <div class="info-value"><?= esc($employee) ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Location</div>
                    <div class="info-value"><?= esc($config['company']) ?></div>
                </div>
            </div>
            
            <!-- Items Section -->
            <div class="receipt-items-section">
                <div class="section-title">Items Purchased</div>
                <?php foreach ($cart as $line => $item): ?>
                    <?php if ($item['print_option'] == PRINT_YES): ?>
                    <div class="receipt-item">
                        <div class="item-details">
                            <div class="item-name"><?= esc($item['name']) ?></div>
                            <div class="item-meta">
                                Qty: <?= to_quantity_decimals($item['quantity']) ?> × <?= to_currency($item['price']) ?>
                            </div>
                        </div>
                        <div class="item-price">
                            <?= to_currency($item['discounted_total']) ?>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            
            <!-- Totals Section -->
            <div class="receipt-totals">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span class="total-amount"><?= to_currency($subtotal) ?></span>
                </div>
                <?php if ($discount > 0): ?>
                <div class="total-row total-row-discount">
                    <span>Discount</span>
                    <span class="total-amount">-<?= to_currency($discount) ?></span>
                </div>
                <?php endif; ?>
                <?php foreach ($taxes as $tax_name => $tax_value): ?>
                <div class="total-row">
                    <span><?= esc($tax_name) ?></span>
                    <span class="total-amount"><?= to_currency($tax_value) ?></span>
                </div>
                <?php endforeach; ?>
                <div class="total-row-main">
                    <span>TOTAL</span>
                    <span><?= to_currency($total) ?></span>
                </div>
            </div>
            
            <!-- Payment Section -->
            <?php if (!empty($payments) || $amount_change > 0): ?>
            <div class="payment-section">
                <?php foreach ($payments as $payment_type => $payment_info): ?>
                    <div class="payment-item">
                        <span class="payment-method"><?= esc($payment_type) ?></span>
                        <span class="payment-amount"><?= to_currency($payment_info['payment_amount']) ?></span>
                    </div>
                <?php endforeach; ?>
                
                <?php if ($amount_change > 0): ?>
                <div class="change-box">
                    <span class="change-label">Change Given</span>
                    <span class="change-amount"><?= to_currency($amount_change) ?></span>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <!-- Barcode Section -->
            <?php if (!empty($barcode) && is_string($barcode)): ?>
            <div class="barcode-section">
                <div class="u-max-width-300px_margin-0auto"><?= $barcode ?></div>
            </div>
            <?php endif; ?>
            
            <!-- Print Footer (visible only when printing) -->
            <div class="print-footer d-none">
                <div class="u-margin-bottom-2px_font-weight-600">Thank You For Your Business!</div>
                <div class="u-font-size-8px_line-height-13">
                    <?php if (!empty($config['return_policy'])): ?>
                        <?= esc($config['return_policy']) ?><br>
                    <?php endif; ?>
                    Powered by ShopSuite - <?= date('Y') ?>
                </div>
                <div class="u-margin-top-2px_font-size-8px">
                    Receipt #<?= esc($sale_id) ?> | Employee: <?= esc($employee) ?>
                </div>
            </div>

</div>
    </div>
</div>

<?php if (!empty($customer_email)): ?>
<?= view('sales/partials/document_email_script', [
    'post_url' => base_url('sales/sendPdf/' . $sale_id . '/receipt'),
    'button_label' => '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> Email Receipt',
    'auto_send' => !empty($email_receipt),
]) ?>
<?php endif; ?>

<?php if (!empty($print_after_sale)): ?>
<script>
setTimeout(() => window.print(), 500);
</script>
<?php endif; ?>

</body>
</html>
