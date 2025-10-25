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
    <title>Receipt #<?= $sale_id ?> - Sale Complete</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">

<style>
/* Modern Receipt Styles */
.receipt-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.receipt-container {
    max-width: 800px;
    width: 100%;
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    overflow: hidden;
}

.receipt-success-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 40px 30px;
    text-align: center;
}

.success-icon {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    animation: scaleIn 0.5s ease-out;
}

@keyframes scaleIn {
    from { transform: scale(0); }
    to { transform: scale(1); }
}

.receipt-content {
    padding: 30px;
}

.receipt-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 30px;
    padding: 20px;
    background: #f9fafb;
    border-radius: 12px;
}

.info-item {
    display: flex;
    flex-direction: column;
}

.info-label {
    font-size: 12px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.info-value {
    font-size: 15px;
    color: #111827;
    font-weight: 600;
}

.receipt-items-section {
    margin-bottom: 30px;
}

.section-title {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 16px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.receipt-item {
    display: flex;
    justify-content: space-between;
    padding: 16px;
    background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
    border-radius: 8px;
    margin-bottom: 8px;
    border-left: 3px solid #667eea;
    transition: all 0.2s;
}

.receipt-item:hover {
    transform: translateX(4px);
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
}

.item-details {
    flex: 1;
}

.item-name {
    font-size: 15px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 4px;
}

.item-meta {
    font-size: 13px;
    color: #6b7280;
}

.item-price {
    font-size: 16px;
    font-weight: 700;
    color: #667eea;
    text-align: right;
}

.receipt-totals {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 4px 16px rgba(102, 126, 234, 0.2);
}

.total-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.9);
}

.total-row span {
    color: rgba(255, 255, 255, 0.9);
}

.total-amount {
    font-weight: 600;
}

.total-row-discount {
    color: #dc2626 !important;
}

.total-row-discount span {
    color: #dc2626 !important;
}

.total-row-main {
    display: flex;
    justify-content: space-between;
    padding: 16px 0;
    border-top: 2px solid rgba(255, 255, 255, 0.3);
    margin-top: 8px;
    font-size: 20px;
    font-weight: 700;
    color: white;
}

.total-row-main span {
    color: white;
}

.payment-section {
    background: #f0f9ff;
    border: 2px solid #bae6fd;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 30px;
}

.payment-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 14px;
}

.payment-method {
    color: #0369a1;
    font-weight: 600;
}

.payment-amount {
    color: #0891b2;
    font-weight: 700;
}

.change-box {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 16px 20px;
    border-radius: 12px;
    margin-top: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.change-label {
    font-size: 14px;
    font-weight: 600;
}

.change-amount {
    font-size: 24px;
    font-weight: 700;
}

.barcode-section {
    text-align: center;
    padding: 20px;
{{ ... }}
    background: #f9fafb;
    border-radius: 12px;
    margin-bottom: 30px;
}

.barcode-section svg {
    max-width: 300px;
    height: auto;
    margin: 0 auto;
    display: block;
}

.barcode-section > div:first-of-type {
    margin-bottom: 10px;
}

.action-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 12px;
}

.btn-action {
    padding: 14px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
}

.btn-print {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-print:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.btn-email {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}

.btn-email:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
}

.btn-new-sale {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.btn-new-sale:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
}

.btn-sales {
    background: white;
    border: 2px solid #e5e7eb;
    color: #374151;
}

.btn-sales:hover {
    border-color: #667eea;
    color: #667eea;
}

@media print {
    * {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    body {
        margin: 0;
        padding: 0;
        background: white !important;
    }
    
    .receipt-page {
        background: white !important;
        padding: 0 !important;
        min-height: auto !important;
        display: block !important;
    }
    
    .receipt-container {
        box-shadow: none !important;
        max-width: 80mm !important;
        width: 80mm !important;
        margin: 0 auto !important;
        border-radius: 0 !important;
        page-break-after: always;
    }
    
    .receipt-success-header {
        display: none !important;
    }
    
    .receipt-content {
        padding: 3mm !important;
    }
    
    /* Print-specific receipt header */
    .print-receipt-header {
        display: block !important;
        text-align: center;
        border-bottom: 1px dashed #000;
        padding-bottom: 2px;
        margin-bottom: 3px;
    }
    
    .print-company-name {
        font-size: 13px !important;
        font-weight: 700 !important;
        margin-bottom: 1px;
        line-height: 1.1;
    }
    
    .print-company-info {
        font-size: 9px !important;
        line-height: 1.2;
    }
    
    .receipt-info-grid {
        display: block !important;
        background: white !important;
        padding: 0 !important;
        margin-bottom: 2px !important;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0 !important;
        padding: 0.5px 0 !important;
        font-size: 10px;
    }
    
    .info-label {
        font-weight: 600;
        text-transform: none;
        font-size: 10px;
        color: #000 !important;
    }
    
    .info-value {
        font-size: 10px;
        color: #000 !important;
        text-align: right;
    }
    
    .section-title {
        font-size: 10px !important;
        font-weight: 700 !important;
        margin: 2px 0 1px 0 !important;
        border-bottom: 1px solid #000;
        padding-bottom: 1px;
    }
    
    .receipt-item {
        background: white !important;
        border: none !important;
        padding: 1px 0 !important;
        margin: 0 !important;
        border-bottom: 1px dashed #ddd !important;
    }
    
    .item-name {
        font-size: 10px !important;
        font-weight: 600 !important;
        color: #000 !important;
        line-height: 1.2;
    }
    
    .item-meta {
        font-size: 8px !important;
        color: #666 !important;
        margin-top: 0.5px;
        line-height: 1.2;
    }
    
    .item-price {
        font-size: 10px !important;
        font-weight: 700 !important;
        color: #000 !important;
    }
    
    .receipt-totals {
        background: white !important;
        border: none !important;
        border-top: 1px solid #000 !important;
        padding: 2px 0 !important;
        margin: 2px 0 !important;
    }
    
    .total-row {
        font-size: 10px !important;
        padding: 0.5px 0 !important;
        color: #000 !important;
    }
    
    .total-row span {
        color: #000 !important;
    }
    
    .total-amount {
        font-weight: 600 !important;
    }
    
    .total-row-discount {
        color: #000 !important;
    }
    
    .total-row-discount span {
        color: #000 !important;
    }
    
    .total-row-main {
        font-size: 11px !important;
        font-weight: 700 !important;
        padding: 2px 0 !important;
        border-top: 1px solid #000 !important;
        margin-top: 1px !important;
        color: #000 !important;
    }
    
    .total-row-main span {
        color: #000 !important;
    }
    
    .payment-section {
        background: white !important;
        border: none !important;
        border-top: 1px dashed #000 !important;
        padding: 2px 0 !important;
        margin: 1px 0 !important;
    }
    
    .payment-item {
        display: flex !important;
        justify-content: space-between !important;
        font-size: 10px !important;
        padding: 0.5px 0 !important;
    }
    
    .payment-method {
        color: #000 !important;
        font-size: 10px !important;
        font-weight: 600 !important;
    }
    
    .payment-amount {
        color: #000 !important;
        font-size: 10px !important;
        font-weight: 700 !important;
    }
    
    .change-box {
        display: flex !important;
        justify-content: space-between !important;
        background: white !important;
        border: none !important;
        border-top: 1px dashed #000 !important;
        padding: 1px 0 !important;
        margin-top: 1px !important;
    }
    
    .change-label {
        color: #000 !important;
        font-size: 10px !important;
        font-weight: 600 !important;
    }
    
    .change-amount {
        color: #000 !important;
        font-size: 10px !important;
        font-weight: 700 !important;
    }
    
    .barcode-section {
        text-align: center !important;
        padding: 0 !important;
        background: white !important;
        border: none !important;
        margin: 2px 0 !important;
    }
    
    .barcode-section svg {
        max-width: 60mm !important;
        height: 15mm !important;
        margin: 0 auto !important;
        display: block !important;
    }
    
    .barcode-section > div {
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .print-footer {
        display: block !important;
        text-align: center;
        font-size: 8px;
        line-height: 1.3;
        margin-top: 2px;
        padding-top: 2px;
        border-top: 1px dashed #000;
    }
    
    .action-buttons,
    .print-hide {
        display: none !important;
    }
    
    /* Page settings */
    @page {
        size: 80mm auto;
        margin: 1mm;
    }
}

@media (max-width: 768px) {
    .receipt-info-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    
    .action-buttons {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="receipt-page">
    <div class="receipt-container">
        <!-- Success Header -->
        <div class="receipt-success-header print-hide">
            <div class="success-icon">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 style="margin: 0 0 8px; font-size: 32px; font-weight: 700;">Sale Complete!</h1>
            <p style="margin: 0; font-size: 16px; opacity: 0.9;">Transaction processed successfully</p>
        </div>
        
        <!-- Receipt Content -->
        <div class="receipt-content">
            <!-- Print-Only Header (visible only when printing) -->
            <div class="print-receipt-header" style="display: none;">
                <div class="print-company-name"><?= esc($config['company']) ?></div>
                <div class="print-company-info">
                    <?= nl2br(esc($config['address'])) ?><br>
                    <?= esc($config['phone']) ?><?php if (!empty($config['email'])): ?><br><?= esc($config['email']) ?><?php endif; ?>
                </div>
                <div style="margin-top: 1px; font-size: 11px; font-weight: 600;">SALES RECEIPT</div>
                <div style="font-size: 9px; margin-top: 1px;"><?= date('M d, Y - h:i A', strtotime($transaction_time)) ?></div>
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
                <div style="max-width: 300px; margin: 0 auto;"><?= $barcode ?></div>
            </div>
            <?php endif; ?>
            
            <!-- Print Footer (visible only when printing) -->
            <div class="print-footer" style="display: none;">
                <div style="margin-bottom: 2px; font-weight: 600;">Thank You For Your Business!</div>
                <div style="font-size: 8px; color: #666; line-height: 1.3;">
                    <?php if (!empty($config['return_policy'])): ?>
                        <?= esc($config['return_policy']) ?><br>
                    <?php endif; ?>
                    Powered by ShopSuite - <?= date('Y') ?>
                </div>
                <div style="margin-top: 2px; font-size: 8px; color: #999;">
                    Receipt #<?= esc($sale_id) ?> | Employee: <?= esc($employee) ?>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="action-buttons print-hide">
                <button onclick="window.print()" class="btn-action btn-print">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Receipt
                </button>
                
                <?php if (!empty($customer_email)): ?>
                <button onclick="sendEmail()" id="email_button" class="btn-action btn-email">
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
        </div>
    </div>
</div>

<script>
<?php if (!empty($customer_email)): ?>
function sendEmail() {
    const btn = document.getElementById('email_button');
    btn.disabled = true;
    btn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Sending...';
    
    fetch('<?= base_url("sales/sendPdf/$sale_id_num/receipt") ?>')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                btn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Sent!';
                btn.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> Email Receipt';
                    btn.style.background = 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)';
                }, 3000);
            } else {
                btn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Failed';
                btn.disabled = false;
            }
        })
        .catch(() => {
            btn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Error';
            btn.disabled = false;
        });
}

<?php if (!empty($email_receipt)): ?>
// Auto-send email if requested
sendEmail();
<?php endif; ?>
<?php endif; ?>

// Auto-print if enabled
<?php if (!empty($print_after_sale)): ?>
setTimeout(() => window.print(), 500);
<?php endif; ?>
</script>

</body>
</html>
