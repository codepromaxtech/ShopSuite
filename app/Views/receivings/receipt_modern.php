<?php
/**
 * Modern Receivings Receipt
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#3b82f6">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/modern-pages.css') ?>">
    <title>Receiving #<?= $receiving_id ?> - Complete</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="stylesheet" href="<?= base_url('css/roboto-mono.css') ?>">
</head>
<body class="u-margin-0_padding-0_font-family--apple">

<div class="receipt-page">
    <div class="receipt-container">
        <!-- Success Header -->
        <div class="receipt-success-header print-hide">
            <div class="success-icon" style="background: var(--info-100); color: var(--info-600);">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <h1 class="u-margin-008px_font-size-32px_font-weigh">Receiving Complete!</h1>
            <p class="u-margin-0_font-size-16px_opacity-09">Inventory updated successfully</p>
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
                <div class="u-margin-top-1px_font-size-11px_font-wei">RECEIVINGS RECEIPT</div>
                <div class="u-font-size-9px_margin-top-1px"><?= date('M d, Y - h:i A', strtotime($transaction_time)) ?></div>
            </div>
            
            <!-- Information Grid -->
            <div class="receipt-info-grid">
                <div class="info-item">
                    <div class="info-label">Receiving ID</div>
                    <div class="info-value"><?= esc($receiving_id) ?></div>
                </div>
                <?php if (!empty($reference)): ?>
                <div class="info-item">
                    <div class="info-label">Reference</div>
                    <div class="info-value"><?= esc($reference) ?></div>
                </div>
                <?php endif; ?>
                <div class="info-item">
                    <div class="info-label">Date & Time</div>
                    <div class="info-value"><?= date('M d, Y - h:i A', strtotime($transaction_time)) ?></div>
                </div>
                <?php if (isset($supplier)): ?>
                <div class="info-item">
                    <div class="info-label">Supplier</div>
                    <div class="info-value"><?= esc($supplier) ?></div>
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
                <div class="section-title">Items Received</div>
                <?php foreach (array_reverse($cart, true) as $line => $item): ?>
                    <div class="receipt-item" style="border-left-color: var(--secondary-400);">
                        <div class="item-details">
                            <div class="item-name"><?= esc($item['name'] . ' ' . $item['attribute_values']) ?></div>
                            <div class="item-meta">
                                Qty: <?= to_quantity_decimals($item['quantity']) ?><?= $show_stock_locations ? ' [' . esc($item['stock_name']) . ']' : '' ?> 
                                <?php if ($item['receiving_quantity'] != 0): ?>× <?= to_quantity_decimals($item['receiving_quantity']) ?><?php endif; ?>
                                @ <?= to_currency($item['price']) ?>
                            </div>
                            <?php if (!empty($item['serialnumber'])): ?>
                                <div class="item-meta u-margin-top-4px">SN: <?= esc($item['serialnumber']) ?></div>
                            <?php endif; ?>
                            <?php if ($item['discount'] > 0): ?>
                                <div class="item-meta u-margin-top-4px" style="color: var(--warning-600);">
                                    <?php if ($item['discount_type'] == FIXED): ?>
                                        <?= to_currency($item['discount']) . ' ' . lang('Sales.discount') ?>
                                    <?php elseif ($item['discount_type'] == PERCENT): ?>
                                        <?= to_decimals($item['discount']) . ' ' . lang('Sales.discount_included') ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="item-price">
                            <?= to_currency($item['total']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Totals Section -->
            <div class="receipt-totals">
                <div class="total-row-main" style="border-color: rgba(255,255,255,0.1);">
                    <span>TOTAL</span>
                    <span><?= to_currency($total) ?></span>
                </div>
            </div>
            
            <!-- Payment Section -->
            <?php if ($mode != 'requisition'): ?>
            <div class="payment-section" style="border-color: var(--secondary-200);">
                <div class="payment-item">
                    <span class="payment-method"><?= esc($payment_type) ?></span>
                    <span class="payment-amount"><?= to_currency($total) ?></span>
                </div>
                
                <?php if (isset($amount_change)): ?>
                <div class="change-box" style="background: var(--secondary-50);">
                    <div style="flex: 1;">
                        <div class="change-label u-margin-bottom-4px">Amount Tendered</div>
                        <div class="u-font-weight-600"><?= to_currency($amount_tendered) ?></div>
                    </div>
                    <div style="flex: 1; text-align: right;">
                        <span class="change-label">Change Due</span>
                        <div class="change-amount" style="color: var(--primary-600);"><?= $amount_change ?></div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <!-- Barcode Section -->
            <?php if (!empty($barcode) && is_string($barcode)): ?>
            <div class="barcode-section">
                <div class="u-max-width-300px_margin-0auto"><?= $barcode ?></div>
                <div class="u-margin-top-8px_font-size-12px_font-wei"><?= esc($receiving_id) ?></div>
            </div>
            <?php endif; ?>
            
            <!-- Print Footer (visible only when printing) -->
            <div class="print-footer d-none">
                <div class="u-margin-bottom-2px_font-weight-600">Inventory Updated!</div>
                <div class="u-font-size-8px_line-height-13">
                    <?php if (!empty($config['return_policy'])): ?>
                        <?= esc($config['return_policy']) ?><br>
                    <?php endif; ?>
                    Powered by ShopSuite - <?= date('Y') ?>
                </div>
                <div class="u-margin-top-2px_font-size-8px">
                    Receiving #<?= esc($receiving_id) ?> | Employee: <?= esc($employee) ?>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="action-buttons print-hide">
                <button onclick="window.print()" class="btn-action btn-print" style="background: linear-gradient(135deg, var(--secondary-700) 0%, var(--secondary-900) 100%); color: white;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Receipt
                </button>
                
                <a href="<?= base_url('receivings') ?>" class="btn-action btn-new-sale" style="background: linear-gradient(135deg, var(--info-500) 0%, var(--info-700) 100%); color: white;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    New Receiving
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-print if enabled
<?php if (!empty($print_after_sale)): ?>
setTimeout(() => window.print(), 500);
<?php endif; ?>
</script>

</body>
</html>
