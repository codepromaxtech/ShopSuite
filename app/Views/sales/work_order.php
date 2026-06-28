<?php
/**
 * Modern Sales Work Order
 * @var int $sale_id_num
 * @var bool $print_after_sale
 * @var string $sales_work_order
 * @var string $customer_info
 * @var string $company_info
 * @var string $work_order_number_label
 * @var string $work_order_number
 * @var string $transaction_date
 * @var bool $print_price_info
 * @var string $total
 * @var array $cart
 * @var float $subtotal
 * @var array $taxes
 * @var array $payments
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
    <title><?= esc($sales_work_order) ?> #<?= esc($work_order_number) ?> - Complete</title>
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
            <div class="success-icon sale-doc-icon-warning">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            <h1 class="u-margin-008px_font-size-32px_font-weigh"><?= esc($sales_work_order) ?> Created!</h1>
            <p class="u-margin-0_font-size-16px_opacity-09">Work order saved successfully</p>
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
                    <h1 class="sale-doc-title"><?= esc($sales_work_order) ?></h1>
                    
                    <table class="sale-doc-meta-table">
                        <tr>
                            <td class="sale-doc-meta-label"><?= esc($work_order_number_label) ?></td>
                            <td class="sale-doc-meta-value"><?= esc($work_order_number) ?></td>
                        </tr>
                        <tr>
                            <td class="sale-doc-meta-label"><?= lang('Common.date') ?></td>
                            <td class="sale-doc-meta-value"><?= esc($transaction_date) ?></td>
                        </tr>
                        <?php if ($print_price_info): ?>
                        <tr>
                            <td class="sale-doc-meta-label-total"><?= lang('Sales.amount_due') ?></td>
                            <td class="sale-doc-meta-value-total"><?= to_currency(esc($total)) ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <!-- Customer Details -->
            <?php if (isset($customer)): ?>
            <div class="sale-doc-customer-box">
                <div class="sale-doc-section-label">Customer</div>
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
                        <th class="sale-doc-th sale-doc-th-left"><?= lang('Sales.item_name') ?></th>
                        <th class="sale-doc-th sale-doc-th-center"><?= lang('Sales.quantity') ?></th>
                        <th class="sale-doc-th sale-doc-th-right"><?= lang('Sales.price') ?></th>
                        <th class="sale-doc-th sale-doc-th-right"><?= lang('Sales.discount') ?></th>
                        <th class="sale-doc-th sale-doc-th-right"><?= lang('Sales.total') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $line => $item): ?>
                        <?php if ($item['print_option'] == PRINT_YES): ?>
                        <tr class="sale-doc-row">
                            <td class="sale-doc-td"><?= esc($item['item_number']) ?></td>
                            <td class="sale-doc-td sale-doc-td-bold"><?= esc($item['name']) ?></td>
                            <td class="sale-doc-td sale-doc-td-center"><?= to_quantity_decimals($item['quantity']) ?></td>
                            <td class="sale-doc-td sale-doc-td-right"><?php if ($print_price_info) echo to_currency($item['price']); ?></td>
                            <td class="sale-doc-td sale-doc-td-right">
                                <?= ($item['discount_type'] == FIXED) ? to_currency($item['discount']) : to_decimals($item['discount']) . '%' ?>
                            </td>
                            <td class="sale-doc-td sale-doc-td-right sale-doc-td-total"><?php if ($print_price_info) echo to_currency($item['discounted_total']); ?></td>
                        </tr>
                        <?php if ($item['is_serialized'] || $item['allow_alt_description'] && !empty($item['description'])): ?>
                            <tr class="sale-doc-row-serial">
                                <td></td>
                                <td colspan="4" class="sale-doc-serial-cell">
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
            <?php if ($print_price_info): ?>
            <div class="sale-doc-totals-wrap">
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
                    foreach ($payments as $payment_id => $payment):
                        $splitpayment = explode(':', $payment['payment_type']);
                    ?>
                    <tr>
                        <td class="sale-doc-total-row-label"><?= esc($splitpayment[0]) ?></td>
                        <td class="sale-doc-total-row-value"><?= to_currency($payment['payment_amount']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php endif; ?>
            
            <!-- Terms and Barcode -->
            <div class="sale-doc-footer">
                <div class="sale-doc-terms">
                    <?php if (!empty($comments)): ?>
                        <div class="sale-doc-terms-block"><strong><?= lang('Sales.comments') ?>:</strong> <?= esc($comments) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="action-buttons print-hide sale-doc-actions">
                <button onclick="window.print()" class="btn-action btn-print">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Work Order
                </button>
                
                <?php if (isset($customer_email) && !empty($customer_email)): ?>
                <button onclick="sendEmail()" id="email_button" class="btn-action btn-email btn-email-default">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Email Work Order
                </button>
                <?php endif; ?>
                
                <a href="<?= base_url('sales') ?>" class="btn-action btn-new-sale">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    New Sale
                </a>
                
                <a href="<?= base_url('sales/discard_suspended_sale') ?>" class="btn-action" class="sale-doc-btn-discard">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Discard
                </a>
            </div>
        </div>
    </div>
</div>

<?php if (isset($customer_email) && !empty($customer_email)): ?>
<?= view('sales/partials/document_email_script', [
    'post_url' => base_url('sales/sendPdf/' . $sale_id_num . '/work_order'),
    'button_label' => '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> Email Work Order',
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
