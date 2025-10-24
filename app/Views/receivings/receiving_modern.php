<?php
/**
 * MODERN RECEIVING REGISTER - Bootstrap 5
 * @var string $controller_name
 * @var array $modes
 * @var string $mode
 * @var bool $show_stock_locations
 * @var array $stock_locations
 * @var int $stock_source
 * @var string $stock_destination
 * @var array $cart
 * @var bool $items_module_allowed
 * @var float $total
 * @var string $comment
 * @var bool $print_after_sale
 * @var string $reference
 * @var array $payment_options
 * @var array $config
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.receivings'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<style>
.register-container {
    background: #f8f9fa;
    min-height: calc(100vh - 100px);
}
.register-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.cart-table th {
    background: #e9ecef;
    font-weight: 600;
    font-size: 0.875rem;
}
.cart-table td {
    vertical-align: middle;
}
.cart-empty {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}
.total-section {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1.5rem;
}
</style>

<div class="register-container py-3">
    <div class="container-fluid">
        
        <!-- Alerts -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <?= esc($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($warning)): ?>
            <div class="alert alert-warning alert-dismissible fade show">
                <i class="bi bi-exclamation-circle me-2"></i>
                <?= esc($warning) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>
                <?= esc($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Mode Selection -->
        <div class="register-card mb-3 p-3">
            <?= form_open("$controller_name/changeMode", ['id' => 'mode_form']) ?>
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label class="form-label mb-0 fw-bold">
                        <i class="bi bi-toggle-on me-1"></i>
                        <?= lang(ucfirst($controller_name) . '.mode') ?>
                    </label>
                </div>
                <div class="col-auto">
                    <?= form_dropdown('mode', $modes, $mode, [
                        'class' => 'form-select',
                        'onchange' => "document.getElementById('mode_form').submit();"
                    ]) ?>
                </div>
                
                <?php if ($show_stock_locations): ?>
                    <div class="col-auto">
                        <label class="form-label mb-0 fw-bold">
                            <?= lang(ucfirst($controller_name) . '.stock_source') ?>
                        </label>
                    </div>
                    <div class="col-auto">
                        <?= form_dropdown('stock_source', $stock_locations, $stock_source, [
                            'class' => 'form-select',
                            'onchange' => "document.getElementById('mode_form').submit();"
                        ]) ?>
                    </div>
                    
                    <?php if ($mode == 'requisition'): ?>
                        <div class="col-auto">
                            <label class="form-label mb-0 fw-bold">
                                <?= lang(ucfirst($controller_name) . '.stock_destination') ?>
                            </label>
                        </div>
                        <div class="col-auto">
                            <?= form_dropdown('stock_destination', $stock_locations, $stock_destination, [
                                'class' => 'form-select',
                                'onchange' => "document.getElementById('mode_form').submit();"
                            ]) ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?= form_close() ?>
        </div>

        <!-- Item Search -->
        <div class="register-card mb-3 p-3">
            <?= form_open("$controller_name/add", ['id' => 'add_item_form']) ?>
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="item" class="form-label mb-0 fw-bold">
                        <i class="bi bi-search me-1"></i>
                        <?php if ($mode == 'receive' or $mode == 'requisition'): ?>
                            <?= lang(ucfirst($controller_name) . '.find_or_scan_item') ?>
                        <?php else: ?>
                            <?= lang(ucfirst($controller_name) . '.find_or_scan_item_or_receipt') ?>
                        <?php endif; ?>
                    </label>
                </div>
                <div class="col">
                    <?= form_input([
                        'name' => 'item',
                        'id' => 'item',
                        'class' => 'form-control',
                        'placeholder' => 'Search by item name, SKU, or barcode...',
                        'tabindex' => '1',
                        'autocomplete' => 'off'
                    ]) ?>
                </div>
                <?php if ($items_module_allowed): ?>
                    <div class="col-auto">
                        <button type="button" class="btn btn-info" onclick="openModal('items/view/-1', 'Add New Item')">
                            <i class="bi bi-plus-circle me-1"></i>
                            <?= lang('Sales.new_item') ?>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
            <?= form_close() ?>
        </div>

        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="register-card p-3">
                    <h5 class="mb-3">
                        <i class="bi bi-cart3 me-2"></i>
                        Receiving Cart
                        <?php if (count($cart) > 0): ?>
                            <span class="badge bg-primary"><?= count($cart) ?> items</span>
                        <?php endif; ?>
                    </h5>
                    
                    <div class="table-responsive">
                        <table class="table table-hover cart-table">
                            <thead>
                                <tr>
                                    <th style="width: 40px;"></th>
                                    <th>Item</th>
                                    <th style="width: 100px;">Cost</th>
                                    <th style="width: 80px;">Qty</th>
                                    <th style="width: 90px;">Discount</th>
                                    <th style="width: 100px;">Total</th>
                                    <th style="width: 60px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($cart) == 0): ?>
                                    <tr>
                                        <td colspan="7" class="cart-empty">
                                            <i class="bi bi-cart-x" style="font-size: 3rem; opacity: 0.3;"></i>
                                            <p class="mt-2"><?= lang('Sales.no_items_in_cart') ?></p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach (array_reverse($cart, true) as $line => $item): ?>
                                        <?= form_open("$controller_name/editItem/$line", [
                                            'class' => 'cart-item-form',
                                            'id' => "cart_$line"
                                        ]) ?>
                                        <tr>
                                            <td>
                                                <a href="<?= base_url("$controller_name/deleteItem/$line") ?>" 
                                                   class="btn btn-sm btn-outline-danger"
                                                   title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="fw-bold"><?= esc($item['name']) ?></div>
                                                <small class="text-muted">
                                                    SKU: <?= esc($item['item_number']) ?>
                                                    <?php if (!empty($item['attribute_values'])): ?>
                                                        | <?= esc($item['attribute_values']) ?>
                                                    <?php endif; ?>
                                                </small>
                                                <br>
                                                <small class="badge bg-info text-dark">
                                                    <?= to_quantity_decimals($item['in_stock']) ?> in <?= $item['stock_name'] ?>
                                                </small>
                                                <?= form_hidden('location', (string)$item['item_location']) ?>
                                            </td>
                                            <td>
                                                <?php if ($items_module_allowed && $mode != 'requisition'): ?>
                                                    <?= form_input([
                                                        'name' => 'price',
                                                        'class' => 'form-control form-control-sm',
                                                        'value' => to_currency_no_money($item['price']),
                                                        'onClick' => 'this.select();'
                                                    ]) ?>
                                                <?php else: ?>
                                                    <?= to_currency($item['price']) ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= form_input([
                                                    'name' => 'quantity',
                                                    'class' => 'form-control form-control-sm',
                                                    'value' => to_quantity_decimals($item['quantity']),
                                                    'onClick' => 'this.select();'
                                                ]) ?>
                                            </td>
                                            <td>
                                                <?php if ($items_module_allowed): ?>
                                                    <?= form_input([
                                                        'name' => 'discount',
                                                        'class' => 'form-control form-control-sm',
                                                        'value' => $item['discount'],
                                                        'onClick' => 'this.select();'
                                                    ]) ?>
                                                <?php else: ?>
                                                    <?= $item['discount'] ?>%
                                                <?php endif; ?>
                                            </td>
                                            <td class="fw-bold">
                                                <?= to_currency($item['discounted_total']) ?>
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-sm btn-success" title="Update">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?= form_close() ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Totals & Actions -->
            <div class="col-lg-4">
                <!-- Total Section -->
                <div class="total-section mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Subtotal:</span>
                        <span class="h5 mb-0"><?= to_currency($total) ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Total:</span>
                        <span class="h3 mb-0 text-primary"><?= to_currency($total) ?></span>
                    </div>
                </div>

                <!-- Supplier Section -->
                <div class="register-card p-3 mb-3">
                    <h6 class="mb-3">
                        <i class="bi bi-building me-2"></i>
                        Supplier
                    </h6>
                    <div class="mb-2">
                        <input type="text" 
                               id="supplier" 
                               class="form-control" 
                               placeholder="Search supplier..."
                               autocomplete="off">
                    </div>
                    <?php if (isset($supplier)): ?>
                        <div class="alert alert-info py-2 px-3 mb-0">
                            <div class="fw-bold"><?= esc($supplier) ?></div>
                            <?php if (isset($supplier_email)): ?>
                                <small><?= esc($supplier_email) ?></small>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Payment & Notes -->
                <div class="register-card p-3 mb-3">
                    <h6 class="mb-3">
                        <i class="bi bi-credit-card me-2"></i>
                        Payment
                    </h6>
                    <?= form_dropdown('payment_type', $payment_options, 'cash', [
                        'class' => 'form-select mb-3'
                    ]) ?>
                    
                    <label class="form-label">Reference:</label>
                    <input type="text" 
                           name="reference" 
                           class="form-control mb-3" 
                           value="<?= esc($reference ?? '') ?>"
                           placeholder="PO Number, Invoice #, etc.">
                    
                    <label class="form-label">Comment:</label>
                    <textarea name="comment" 
                              class="form-control" 
                              rows="3" 
                              placeholder="Additional notes..."><?= esc($comment ?? '') ?></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-2">
                    <button type="button" 
                            class="btn btn-primary btn-lg"
                            onclick="completeReceiving()"
                            <?= count($cart) == 0 ? 'disabled' : '' ?>>
                        <i class="bi bi-check-circle me-2"></i>
                        Complete Receiving
                    </button>
                    <button type="button" 
                            class="btn btn-outline-secondary"
                            onclick="cancelReceiving()">
                        <i class="bi bi-x-circle me-2"></i>
                        Cancel
                    </button>
                    <a href="<?= base_url('receivings/manage') ?>" class="btn btn-outline-info">
                        <i class="bi bi-list-ul me-2"></i>
                        View History
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    console.log('🚀 Modern Receiving Register Loading...');
    
    // Item search autocomplete
    $('#item').autocomplete({
        source: '<?= base_url("receivings/item_search") ?>',
        minLength: 1,
        delay: 300,
        autoFocus: true,
        select: function(event, ui) {
            $(this).val(ui.item.value);
            $('#add_item_form').submit();
            return false;
        }
    });
    
    // Supplier search autocomplete
    $('#supplier').autocomplete({
        source: '<?= base_url("suppliers/suggest") ?>',
        minLength: 1,
        delay: 300,
        select: function(event, ui) {
            $.post('<?= base_url("receivings/setSupplier") ?>', {
                supplier_id: ui.item.value
            }, function() {
                location.reload();
            });
            return false;
        }
    });
    
    // Focus on item search
    $('#item').focus();
    
    // Auto-submit cart edit forms on blur
    $('.cart-item-form input').on('blur', function() {
        $(this).closest('form').submit();
    });
    
    // Handle Enter key in search
    $('#item').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#add_item_form').submit();
        }
    });
    
    console.log('✅ Modern Receiving Register Ready');
});

function completeReceiving() {
    if (confirm('Complete this receiving transaction?')) {
        window.location.href = '<?= base_url("$controller_name/complete") ?>';
    }
}

function cancelReceiving() {
    if (confirm('Cancel this receiving? All items will be removed from cart.')) {
        $.post('<?= base_url("$controller_name/cancelReceiving") ?>', function() {
            location.reload();
        });
    }
}
</script>

<?= view('layouts/bootstrap5_footer') ?>
