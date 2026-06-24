<?php
/**
 * @var string $transaction_time
 * @var int $sale_id
 * @var string $employee
 * @var array $cart
 * @var float $discount
 * @var float $subtotal
 * @var array $taxes
 * @var float $total
 * @var array $payments
 * @var float $amount_change
 * @var string $barcode
 * @var array $config
 */
?>

<div class="u-width-100pct" id="receipt_wrapper">
    <div id="receipt_header" class="text-center">
        <?php if ($config['company_logo'] != '') { ?>
            <div id="company_name">
                <img id="image" src="data:image/png;base64,<?= base64_encode(file_get_contents('uploads/' . $config['company_logo'])) ?>" alt="company_logo">
            </div>
        <?php } ?>

        <?php if ($config['receipt_show_company_name']) { ?>
            <div class="u-font-size-150pct_font-weight-bold" id="company_name"><?= esc($config['company']) ?></div>
        <?php } ?>

        <div id="company_address"><?= nl2br(esc($config['address'])) ?></div>
        <div id="company_phone"><?= esc($config['phone']) ?></div>
        <br>
        <div id="sale_receipt"><?= lang('Sales.receipt') ?></div>
        <div id="sale_time"><?= esc($transaction_time) ?></div>
    </div>

    <br>

    <div id="receipt_general_info" class="text-left">
        <?php if (isset($customer)) { ?>
            <div id="customer"><?= lang('Customers.customer') . esc(": $customer") ?></div>
        <?php } ?>

        <div id="sale_id"><?= lang('Sales.id') . esc(": $sale_id") ?></div>
        <div id="employee"><?= lang('Employees.employee') . esc(": $employee") ?></div>
    </div>

    <br>

    <table class="u-text-align-left_width-100pct" id="receipt_items">
        <tr>
            <th class="u-width-40pct"><?= lang('Sales.description_abbrv') ?></th>
            <th class="u-width-20pct"><?= lang('Sales.price') ?></th>
            <th class="u-width-20pct"><?= lang('Sales.quantity') ?></th>
            <th class="u-width-20pct_text-align-right"><?= lang('Sales.total') ?></th>
        </tr>
        <?php
        foreach ($cart as $line => $item) {
            if ($item['print_option'] == PRINT_YES) {
        ?>
                <tr>
                    <td><?= esc(ucfirst($item['name'] . ' ' . $item['attribute_values'])) ?></td>
                    <td><?= to_currency($item['price']) ?></td>
                    <td><?= to_quantity_decimals($item['quantity']) ?></td>
                    <td class="text-right"><?= to_currency($item[($config['receipt_show_total_discount'] ? 'total' : 'discounted_total')]) ?></td>
                </tr>
                <tr>
                    <?php if ($config['receipt_show_description']) { ?>
                        <td colspan="2"><?= esc($item['description']) ?></td>
                    <?php } ?>

                    <?php if ($config['receipt_show_serialnumber']) { ?>
                        <td><?= esc($item['serialnumber']) ?></td>
                    <?php } ?>
                </tr>
                <?php if ($item['discount'] > 0) { ?>
                    <tr>
                        <?php if ($item['discount_type'] == FIXED) { ?>
                            <td colspan="3" class="discount"><?= to_currency($item['discount']) . " " . lang('Sales.discount') ?></td>
                        <?php } elseif ($item['discount_type'] == PERCENT) { ?>
                            <td colspan="3" class="discount"><?= to_decimals($item['discount']) . " " . lang('Sales.discount_included') ?></td>
                        <?php } ?>
                        <td class="total-value text-right"><?= to_currency($item['discounted_total']) ?></td>
                    </tr>
        <?php
                }
            }
        }
        ?>

        <?php if ($config['receipt_show_total_discount'] && $discount > 0) { ?>
            <tr>
                <td class="u-text-align-right_border-top-2pxsolidhe" colspan="3"><?= lang('Sales.sub_total') ?></td>
                <td class="u-text-align-right_border-top-2pxsolidhe"><?= to_currency($subtotal) ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right"><?= lang('Sales.discount') ?>:</td>
                <td class="text-right"><?= to_currency($discount * -1) ?></td>
            </tr>
        <?php } ?>

        <?php if ($config['receipt_show_taxes']) { ?>
            <tr>
                <td class="u-text-align-right_border-top-2pxsolidhe" colspan="3"><?= lang('Sales.sub_total') ?></td>
                <td class="u-text-align-right_border-top-2pxsolidhe"><?= to_currency($subtotal) ?></td>
            </tr>
            <?php foreach ($taxes as $tax_group_index => $tax) { ?>
                <tr>
                    <td colspan="3" class="text-right"><?= (float)$tax['tax_rate'] . '% ' . $tax['tax_group'] ?>:</td>
                    <td class="text-right"><?= to_currency_tax($tax['sale_tax_amount']) ?></td>
                </tr>
        <?php
            }
        }
        ?>

        <tr></tr>

        <?php $border = (!$config['receipt_show_taxes'] && !($config['receipt_show_total_discount'] && $discount > 0)) ?>
        <tr>
            <td colspan="3" class="text-right <?= $border ? 'border-top-black' : '' ?>"><?= lang('Sales.total') ?></td>
            <td class="text-right <?= $border ? 'border-top-black' : '' ?>"><?= to_currency($total) ?></td>
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
                <td colspan="3" class="text-right"><?= $splitpayment[0] ?> </td>
                <td class="text-right"><?= to_currency($payment['payment_amount'] * -1) ?></td>
            </tr>
        <?php } ?>

        <?php if (isset($cur_giftcard_value) && $show_giftcard_remainder) { ?>
            <tr>
                <td colspan="3" class="text-right"><?= lang('Sales.giftcard_balance') ?></td>
                <td class="text-right"><?= to_currency($cur_giftcard_value) ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="3" class="text-right"> <?= lang($amount_change >= 0 ? ($only_sale_check ? 'Sales.check_balance' : 'Sales.change_due') : 'Sales.amount_due') ?> </td>
            <td class="text-right"><?= to_currency($amount_change) ?></td>
        </tr>

        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
    </table>

    <div id="terms">
        <div id="sale_return_policy" class="text-center">
            <?= nl2br(esc($config['return_policy'])) ?>
        </div>

        <div id="barcode" class="text-center">
            <img alt=<?= '$sale_id' ?> src="data:image/svg+xml;base64,<?= base64_encode($barcode) ?>"><br>
            <?= $sale_id ?>
        </div>
    </div>
</div>
