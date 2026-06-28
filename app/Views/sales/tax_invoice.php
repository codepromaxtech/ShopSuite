<?php
/**
 * Modern Sales Tax Invoice
 * @var int $sale_id_num
 * @var bool $print_after_sale
 * @var string $customer_info
 * @var string $company_info
 * @var string $invoice_number
 * @var string $transaction_date
 * @var float $total
 * @var bool $include_hsn
 * @var string $discount
 * @var array $cart
 * @var float $subtotal
 * @var array $taxes
 * @var array $payments
 * @var string $amount_change
 * @var string $barcode
 * @var int $sale_id
 * @var array $config
 */

if (isset($error_message)) {
    echo view('sales/partials/document_error', ['error_message' => $error_message]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#3b82f6">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/modern-pages.css') ?>">
    <title><?= lang('Sales.tax_invoice') ?> #<?= esc($invoice_number) ?> - Complete</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Scripts for sending email -->
    <?= view('sales/partials/document_csrf') ?>
</head>
<body class="u-margin-0_padding-0_font-family--apple">

<div class="receipt-page">
    <div class="receipt-container sale-doc-container">
        <!-- Success Header -->
        <div class="receipt-success-header print-hide">
            <div class="success-icon sale-doc-icon-primary">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h1 class="u-margin-008px_font-size-32px_font-weigh">Tax Invoice Created!</h1>
            <p class="u-margin-0_font-size-16px_opacity-09">Tax invoice record stored successfully</p>
        </div>
        
        <!-- Document Content -->
        <div class="receipt-content">
            <!-- Header Grid for A4 scale -->
            <div class="sale-doc-header-row">
                <div class="sale-doc-company-col">
                    <?php if ($config['company_logo'] != ''): ?>
                        <img src="<?= base_url('uploads/' . $config['company_logo']) ?>" alt="Logo" class="sale-doc-logo">
                    <?php endif; ?>
                    <?php if ($config['receipt_show_company_name']): ?>
                        <h2 class="sale-doc-company-name"><?= esc($config['company']) ?></h2>
                    <?php endif; ?>
                    <div class="sale-doc-company-info">
                        <?= nl2br(esc($company_info)) ?>
                    </div>
                </div>
                <div class="sale-doc-meta-col">
                    <h1 class="sale-doc-title"><?= lang('Sales.tax_invoice') ?></h1>
                    
                    <table class="sale-doc-meta-table">
                        <tr>
                            <td class="sale-doc-meta-label"><?= lang('Sales.invoice_number') ?></td>
                            <td class="sale-doc-meta-value"><?= esc($invoice_number) ?></td>
                        </tr>
                        <tr>
                            <td class="sale-doc-meta-label"><?= lang('Common.date') ?></td>
                            <td class="sale-doc-meta-value"><?= esc($transaction_date) ?></td>
                        </tr>
                        <tr>
                            <td class="sale-doc-meta-label-total"><?= lang('Sales.amount_due') ?></td>
                            <td class="sale-doc-meta-value-total"><?= to_currency($total) ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Customer Details -->
            <?php if (isset($customer)): ?>
            <div class="sale-doc-customer-box">
                <div class="sale-doc-section-label">Billed To</div>
                <div class="sale-doc-customer-info">
                    <?= nl2br(esc($customer_info)) ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Items Table -->
            <table class="sale-doc-items-table">
                <thead class="sale-doc-items-thead">
                    <tr class="sale-doc-row">
                        <th class="sale-doc-th sale-doc-th-left"><?= lang('Sales.item_number') ?></th>
                        <?php if ($include_hsn): ?>
                            <th class="sale-doc-th sale-doc-th-center"><?= lang('Sales.hsn') ?></th>
                        <?php endif; ?>
                        <th class="sale-doc-th sale-doc-th-left"><?= lang('Sales.item_name') ?></th>
                        <th class="sale-doc-th sale-doc-th-center"><?= lang('Sales.quantity') ?></th>
                        <th class="sale-doc-th sale-doc-th-right"><?= lang('Sales.price') ?></th>
                        <th class="sale-doc-th sale-doc-th-right"><?= lang('Sales.discount') ?></th>
                        <?php if ($discount > 0): ?>
                            <th class="sale-doc-th sale-doc-th-right"><?= lang('Sales.customer_discount') ?></th>
                        <?php endif; ?>
                        <th class="sale-doc-th sale-doc-th-right"><?= lang('Sales.total') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $line => $item): ?>
                        <?php if ($item['print_option'] == PRINT_YES): ?>
                        <tr class="sale-doc-row">
                            <td class="sale-doc-td"><?= esc($item['item_number']) ?></td>
                            <?php if ($include_hsn): ?>
                                <td class="sale-doc-td sale-doc-td-center"><?= esc($item['hsn_code']) ?></td>
                            <?php endif; ?>
                            <td class="sale-doc-td sale-doc-td-bold"><?= esc($item['name']) ?></td>
                            <td class="sale-doc-td sale-doc-td-center"><?= to_quantity_decimals($item['quantity']) ?></td>
                            <td class="sale-doc-td sale-doc-td-right"><?= to_currency($item['price']) ?></td>
                            <td class="sale-doc-td sale-doc-td-right">
                                <?= ($item['discount_type'] == FIXED) ? to_currency($item['discount']) : to_decimals($item['discount']) . '%' ?>
                            </td>
                            <?php if ($discount > 0): ?>
                                <td class="sale-doc-td sale-doc-td-right"><?= to_currency($item['discounted_total'] / $item['quantity']) ?></td>
                            <?php endif; ?>
                            <td class="sale-doc-td sale-doc-td-right sale-doc-td-total"><?= to_currency($item['discounted_total']) ?></td>
                        </tr>
                        <?php if ($item['is_serialized'] || $item['allow_alt_description'] && !empty($item['description'])): ?>
                            <tr class="sale-doc-row-serial">
                                <td></td>
                                <?php if ($include_hsn): ?>
                                    <td class="sale-doc-hsn-cell"><?= esc($item['hsn_code']) ?></td>
                                <?php endif; ?>
                                <td colspan="<?= ($discount > 0) ? 5 : 4 ?>" class="sale-doc-serial-cell">
                                    <?= esc($item['description']) ?>
                                    <?php if (!empty($item['serialnumber'])): ?>
                                        <div class="sale-doc-serial-sn">SN: <?= esc($item['serialnumber']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td></td>
                            </tr>
                        <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <!-- Totals Section -->
            <div class="sale-doc-totals-with-signature">
                <div class="sale-doc-signature-col">
                    <?php if (!empty($payments)): ?>
                        <div class="sale-doc-signature-line">
                            <?= lang('Sales.authorized_signature') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <table class="sale-doc-totals-table">
                    <tr>
                        <td class="sale-doc-total-row-label"><?= lang('Sales.sub_total') ?></td>
                        <td class="sale-doc-total-row-value"><?= to_currency($subtotal) ?></td>
                    </tr>
                    
                    <?php foreach ($taxes as $tax_group_index => $tax): ?>
                    <tr>
                        <td class="sale-doc-total-row-label"><?= (float)$tax['tax_rate'] . '% ' . $tax['tax_group'] ?></td>
                        <td class="sale-doc-total-row-value"><?= to_currency_tax($tax['sale_tax_amount']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <tr>
                        <td class="sale-doc-grand-total-label"><?= lang('Sales.total') ?></td>
                        <td class="sale-doc-grand-total-value"><?= to_currency($total) ?></td>
                    </tr>
                    
                    <?php
                    $only_sale_check = false;
                    $show_giftcard_remainder = false;
                    foreach ($payments as $payment_id => $payment) {
                        $only_sale_check |= $payment['payment_type'] == lang('Sales.check');
                        $splitpayment = explode(':', $payment['payment_type']);
                        $show_giftcard_remainder |= $splitpayment[0] == lang('Sales.giftcard');
                    ?>
                    <tr>
                        <td class="sale-doc-total-row-label"><?= esc($splitpayment[0]) ?></td>
                        <td class="sale-doc-total-row-value"><?= to_currency($payment['payment_amount'] * -1) ?></td>
                    </tr>
                    <?php } ?>
                    
                    <?php if (isset($cur_giftcard_value) && $show_giftcard_remainder): ?>
                    <tr>
                        <td class="sale-doc-total-row-label"><?= lang('Sales.giftcard_balance') ?></td>
                        <td class="sale-doc-total-row-value"><?= to_currency($cur_giftcard_value) ?></td>
                    </tr>
                    <?php endif; ?>
                    
                    <?php if (!empty($payments)): ?>
                    <tr class="sale-doc-change-row">
                        <td class="sale-doc-change-label">
                            <?= lang($amount_change >= 0 ? ($only_sale_check ? 'Sales.check_balance' : 'Sales.change_due') : 'Sales.amount_due') ?>
                        </td>
                        <td class="sale-doc-change-value">
                            <?= to_currency($amount_change) ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
            
            <!-- Terms and Barcode -->
            <div class="sale-doc-footer">
                <div class="sale-doc-terms">
                    <div class="sale-doc-terms-title">
                        <?= nl2br(esc($config['payment_message'])) ?>
                    </div>
                    <?php if (!empty($comments)): ?>
                        <div class="sale-doc-terms-block"><strong><?= lang('Sales.comments') ?>:</strong> <?= esc($comments) ?></div>
                    <?php endif; ?>
                    <div class="sale-doc-terms-block"><?= esc($config['invoice_default_comments']) ?></div>
                    <div><?= nl2br(esc($config['return_policy'])) ?></div>
                </div>
                
                <div class="sale-doc-barcode-col">
                    <?php if (!empty($barcode) && is_string($barcode)): ?>
                        <div class="sale-doc-barcode-wrap">
                            <img alt="<?= esc($barcode) ?>" src="data:image/png;base64,<?= esc($barcode) ?>" class="sale-doc-barcode-img">
                        </div>
                        <div class="sale-doc-barcode-id"><?= esc($sale_id) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="action-buttons print-hide sale-doc-actions">
                <button onclick="window.print()" class="btn-action btn-print">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Invoice
                </button>
                
                <?php if (isset($customer_email) && !empty($customer_email)): ?>
                <button onclick="sendEmail()" id="email_button" class="btn-action btn-email btn-email-default">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Email Invoice
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

<?php if (isset($customer_email) && !empty($customer_email)): ?>
<?= view('sales/partials/document_email_script', [
    'post_url' => base_url('sales/sendPdf/' . $sale_id_num),
    'button_label' => '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> Email Invoice',
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
