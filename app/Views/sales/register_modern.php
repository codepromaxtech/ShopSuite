<?php
$title = 'POS Register - ShopSuite';
echo view('layouts/modern_header', ['title' => $title, 'extra_css' => ['css/pos-next.css']]);
?>

<script>document.querySelector('.app-shell')?.classList.add('pos-shell-active');</script>

<div class="pos-shell" id="posShell">
    <!-- ===== TOP BAR ===== -->
    <div class="pos-topbar">
        <!-- Mode Switch (hidden form) -->
        <?= form_open("sales/changeMode", ['id' => 'mode_form', 'style' => 'display:none']) ?>
        <input type="hidden" name="mode" id="mode_input" value="<?= $mode ?? 'sale' ?>">
        <?= form_close() ?>

        <div class="pos-topbar-left">
            <div class="pos-mode-tabs">
                <button class="pos-mode-tab <?= ($mode ?? 'sale') == 'sale' ? 'active' : '' ?>" onclick="changeMode('sale')">Sale</button>
                <button class="pos-mode-tab <?= ($mode ?? '') == 'return' ? 'active' : '' ?>" onclick="changeMode('return')">Return</button>
                <button class="pos-mode-tab <?= ($mode ?? '') == 'sale_invoice' ? 'active' : '' ?>" onclick="changeMode('sale_invoice')">Invoice</button>
                <button class="pos-mode-tab <?= ($mode ?? '') == 'sale_quote' ? 'active' : '' ?>" onclick="changeMode('sale_quote')">Quote</button>
                <button class="pos-mode-tab <?= ($mode ?? '') == 'sale_work_order' ? 'active' : '' ?>" onclick="changeMode('sale_work_order')">Work Order</button>
            </div>

            <div class="pos-toolbar-divider"></div>

            <div class="pos-action-bar">
                <button class="pos-action-btn" onclick="quickAddGiftCard()" title="Sell Gift Card">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Gift Card</span>
                </button>
                <button class="pos-action-btn" onclick="suspendSale()" title="Hold Sale">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Hold</span>
                </button>
                <button class="pos-action-btn" onclick="window.location.href='<?= base_url('sales/returnExchange') ?>'" title="Return / Exchange">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                    <span>Return</span>
                </button>
                <button class="pos-action-btn" onclick="clearCart()" title="Clear Cart">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    <span>Clear</span>
                </button>
                <button class="pos-action-btn" onclick="window.location.href='<?= base_url('sales/suspended') ?>'" title="Suspended Sales">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span>Suspended</span>
                </button>
                <button class="pos-action-btn" onclick="window.location.href='<?= base_url('sales/manage') ?>'" title="Sales History">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>History</span>
                </button>
                <button class="pos-action-btn" onclick="window.location.href='<?= base_url('home') ?>'" title="Dashboard">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Home</span>
                </button>
                <button class="pos-action-btn" onclick="addComment()" title="Add Note">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <span>Note</span>
                </button>
            </div>
        </div>

        <div class="pos-topbar-actions">
            <?php if (!empty($active_cashup_id)): ?>
            <a href="<?= base_url('cashups/view/' . (int) $active_cashup_id) ?>" class="pos-cashup-live" title="Active Cashup">
                <span class="pos-cashup-dot"></span>
                Cashup #<?= (int) $active_cashup_id ?>
            </a>
            <?php elseif (!empty($cashups_allowed)): ?>
            <a href="<?= base_url('cashups/view/-1') ?>" class="pos-topbar-link">Open Cashup</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- ===== MAIN BODY ===== -->
    <div class="pos-body">
        
        <!-- ===== LEFT PANE: Search & Cart ===== -->
        <div class="pos-left-pane">
            <div class="pos-search-area">
                <?= form_open("sales/add", ['id' => 'add_item_form']) ?>
                <div class="pos-search-wrap">
                    <svg class="pos-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" class="pos-search-input" name="item" id="item" placeholder="Scan barcode or search products..." autocomplete="off" autofocus>
                </div>
                <div id="item_autocomplete" class="pos-autocomplete" style="width: calc(100% - 64px); left: 32px;"></div>
                <?= form_close() ?>
            </div>

            <!-- Cart Items (moved from right pane) -->
            <div style="padding: 8px 24px 0; flex-shrink: 0; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 13px; font-weight: 700; color: var(--pos-text);">
                    Cart
                </span>
                <span style="font-size: 12px; color: var(--pos-text-muted); font-weight: 500;">
                    <?= $item_count ?? count($cart ?? []) ?> items · <?= $total_units ?? count($cart ?? []) ?> units
                </span>
            </div>
            <div class="pos-cart-area" id="cartItemsContainer">
                <?php if (empty($cart)): ?>
                    <div class="pos-empty-cart">
                        <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>Cart is Empty</span>
                    </div>
                <?php else: ?>
                    <?php foreach ($cart as $line => $item): ?>
                        <?php 
                        $inStock = isset($item['in_stock']) ? (float)$item['in_stock'] : 'null';
                        $price = (float)$item['price'];
                        $discount = (float)($item['discount'] ?? 0);
                        $qty = (float)$item['quantity'];
                        ?>
                        <div class="pos-cart-item">
                            <div class="pos-cart-item-main">
                                <a href="#" class="pos-cart-item-name" style="text-decoration: none; cursor: pointer; color: var(--pos-primary);" title="Click to edit item" onclick="editCartItem('<?= esc($line) ?>', <?= $qty ?>, <?= $price ?>, <?= $discount ?>, <?= $inStock ?>); return false;">
                                    <?= esc($item['name']) ?>
                                </a>
                                <div class="pos-cart-item-price">$<?= number_format($price * $qty, 2) ?></div>
                            </div>
                            <?php if (!empty($item['discount']) && $item['discount'] > 0): ?>
                                <div style="margin-top: 4px;">
                                    <span class="pos-discount-badge" style="font-size: 11px; margin-left: 0;">-<?= esc($item['discount']) ?>%</span>
                                </div>
                            <?php endif; ?>
                            <div class="pos-cart-item-controls">
                                <div class="pos-stepper">
                                    <button type="button" class="pos-stepper-btn" onclick="updateQty('<?= esc($line) ?>', <?= $qty - 1 ?>, <?= $price ?>, <?= $discount ?>, <?= $inStock ?>)">-</button>
                                    <div class="pos-stepper-value"><?= esc($qty) ?></div>
                                    <button type="button" class="pos-stepper-btn" onclick="updateQty('<?= esc($line) ?>', <?= $qty + 1 ?>, <?= $price ?>, <?= $discount ?>, <?= $inStock ?>)">+</button>
                                </div>
                                <button type="button" class="pos-cart-item-delete" onclick="removeCartItem('<?= esc($line) ?>')">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- ===== RIGHT PANE: Cart & Checkout ===== -->
        <div class="pos-right-pane">
            
            <!-- Header (Customer & Actions) -->
            <div class="pos-right-header">
                <?php if (!empty($customer_required)): ?>
                    <div style="color: var(--pos-danger); font-size: 12px; font-weight: 600; margin-bottom: 8px;">⚠ <?= esc($customer_required) ?></div>
                <?php endif; ?>

                <?php if (!empty($invoice_number) && ($mode ?? '') === 'sale_invoice'): ?>
                <div style="display: flex; justify-content: space-between; padding: 8px 12px; background: #F9FAFB; border-radius: 10px; font-size: 12px; margin-bottom: 12px; border: 1px solid var(--pos-border);">
                    <span style="color: var(--pos-text-muted); font-weight: 600;">Invoice #</span>
                    <span style="font-weight: 700;"><?= esc($invoice_number) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($quote_number) && ($mode ?? '') === 'sale_quote'): ?>
                <div style="display: flex; justify-content: space-between; padding: 8px 12px; background: #F9FAFB; border-radius: 10px; font-size: 12px; margin-bottom: 12px; border: 1px solid var(--pos-border);">
                    <span style="color: var(--pos-text-muted); font-weight: 600;">Quote #</span>
                    <span style="font-weight: 700;"><?= esc($quote_number) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($work_order_number) && ($mode ?? '') === 'sale_work_order'): ?>
                <div style="display: flex; justify-content: space-between; padding: 8px 12px; background: #F9FAFB; border-radius: 10px; font-size: 12px; margin-bottom: 12px; border: 1px solid var(--pos-border);">
                    <span style="color: var(--pos-text-muted); font-weight: 600;">Work Order #</span>
                    <span style="font-weight: 700;"><?= esc($work_order_number) ?></span>
                </div>
                <?php endif; ?>

                <!-- ===== MODE-SPECIFIC PANELS ===== -->

                <?php if (($mode ?? 'sale') === 'return'): ?>
                <!-- Return Mode: Sale Lookup -->
                <div class="pos-mode-panel" style="padding: 10px 12px; background: rgba(239,68,68,0.06); border: 1px solid rgba(239,68,68,0.2); border-radius: 10px; margin-bottom: 12px;">
                    <div style="font-size: 11px; font-weight: 700; color: #ef4444; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">🔄 Return Mode</div>
                    <div style="font-size: 12px; color: var(--pos-text-muted); margin-bottom: 8px;">Search for a previous sale to load items for return.</div>
                    <input type="text" id="return_sale_search" class="pos-search-input" style="padding: 10px 12px; font-size: 13px; width: 100%; box-sizing: border-box;" placeholder="Search by receipt #, customer, or item...">
                    <div id="return_sale_autocomplete" class="pos-autocomplete"></div>
                </div>
                <?php endif; ?>

                <?php if (($mode ?? 'sale') === 'sale_invoice' && !empty($config['invoice_enable'])): ?>
                <!-- Invoice Mode: Invoice Number Input -->
                <div class="pos-mode-panel" style="padding: 10px 12px; background: rgba(59,130,246,0.06); border: 1px solid rgba(59,130,246,0.2); border-radius: 10px; margin-bottom: 12px;">
                    <div style="font-size: 11px; font-weight: 700; color: #3b82f6; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">📋 Invoice Mode</div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <label for="sales_invoice_number" style="font-size: 12px; font-weight: 600; color: var(--pos-text); white-space: nowrap;">Invoice #</label>
                        <input type="text" id="sales_invoice_number" name="sales_invoice_number" class="pos-form-input" style="padding: 8px 10px; font-size: 13px; flex: 1;" value="<?= esc($invoice_number ?? '') ?>" placeholder="Auto or enter manually">
                    </div>
                </div>
                <?php endif; ?>

                <?php if (($mode ?? 'sale') === 'sale_quote'): ?>
                <!-- Quote Mode: Info Banner -->
                <div class="pos-mode-panel" style="padding: 10px 12px; background: rgba(168,85,247,0.06); border: 1px solid rgba(168,85,247,0.2); border-radius: 10px; margin-bottom: 12px;">
                    <div style="font-size: 11px; font-weight: 700; color: #a855f7; text-transform: uppercase; letter-spacing: 0.5px;">📝 Quote Mode</div>
                    <div style="font-size: 12px; color: var(--pos-text-muted); margin-top: 4px;">Items will be saved as a quote. No payment is required.</div>
                </div>
                <?php endif; ?>

                <?php if (($mode ?? 'sale') === 'sale_work_order'): ?>
                <!-- Work Order Mode: Price Toggle -->
                <div class="pos-mode-panel" style="padding: 10px 12px; background: rgba(245,158,11,0.06); border: 1px solid rgba(245,158,11,0.2); border-radius: 10px; margin-bottom: 12px;">
                    <div style="font-size: 11px; font-weight: 700; color: #f59e0b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">🔧 Work Order Mode</div>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13px; color: var(--pos-text);">
                        <input type="checkbox" id="price_work_orders" name="price_work_orders" value="1" <?= !empty($price_work_orders) ? 'checked' : '' ?> style="width: 16px; height: 16px; accent-color: #f59e0b;">
                        Include Prices on Work Order
                    </label>
                </div>
                <?php endif; ?>

                <?php if (isset($customer_id) && $customer_id > 0): ?>
                    <div class="pos-customer-card">
                        <div class="pos-customer-info">
                            <div class="pos-customer-avatar"><?= esc(strtoupper(substr($customer ?? 'C', 0, 1))) ?></div>
                            <div class="pos-customer-name"><?= esc($customer ?? 'Customer') ?></div>
                        </div>
                        <button type="button" class="pos-customer-remove" onclick="removeCustomer()" title="Remove Customer">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                <?php else: ?>
                    <div style="position: relative; margin-bottom: 12px;">
                        <input type="text" id="customer_search_input" class="pos-search-input" style="padding: 12px 14px; font-size: 13px;" placeholder="Search customer...">
                        <div id="customer_autocomplete" class="pos-autocomplete"></div>
                    </div>
                    <button type="button" class="pos-walkin-btn" onclick="quickAddCustomer()">+ New Customer</button>
                <?php endif; ?>
            </div>



            <!-- Checkout Board (Bottom Fixed) -->
            <div class="pos-checkout-board">
                <div class="pos-total-row">
                    <span>Subtotal</span>
                    <span>$<?= number_format($subtotal ?? 0, 2) ?></span>
                </div>
                <?php if (!empty($taxes) && is_array($taxes)): ?>
                    <?php foreach ($taxes as $tax_name => $tax_info): ?>
                    <div class="pos-total-row"><span><?= esc($tax_name) ?></span><span>$<?= number_format($tax_info['tax_amount'] ?? 0, 2) ?></span></div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="pos-total-row"><span>Tax</span><span>$<?= number_format(($total ?? 0) - ($subtotal ?? 0), 2) ?></span></div>
                <?php endif; ?>
                <?php if (!empty($discount) && $discount > 0): ?>
                <div class="pos-total-row"><span>Discount</span><span>-<?= esc($discount) ?>%</span></div>
                <?php endif; ?>
                <div class="pos-total-row grand-total">
                    <span>Total</span>
                    <span>$<?= number_format($total ?? 0, 2) ?></span>
                </div>
                <?php if (!empty($payments)): ?>
                <div class="pos-total-row" style="font-weight: 600; color: var(--pos-text);"><span>Paid</span><span>$<?= number_format($payments_total ?? 0, 2) ?></span></div>
                <?php endif; ?>
                <div class="pos-total-row" style="font-weight: 700; color: var(--pos-text);"><span>Amount Due</span><span>$<?= number_format($amount_due ?? $total ?? 0, 2) ?></span></div>
                
                <!-- Added Payments -->
                <?php if (!empty($payments)): ?>
                    <div style="margin-bottom: 16px;">
                    <?php foreach ($payments as $payment_id => $payment): ?>
                        <div class="pos-total-row" style="color: var(--pos-text);">
                            <div style="display: flex; align-items: center;">
                                <?= esc($payment['payment_type']) ?>
                                <button type="button" class="pos-customer-remove" style="padding: 2px; margin-left: 6px;" onclick="removePayment('<?= base64url_encode($payment_id) ?>')">×</button>
                            </div>
                            <span>$<?= number_format($payment['payment_amount'], 2) ?></span>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?= form_open("sales/addPayment", ['id' => 'add_payment_form']) ?>
                <div class="pos-payment-add">
                    <select id="payment_method" name="payment_type" class="pos-payment-select" onchange="toggleGiftCardInput()">
                        <?php foreach ($payment_options as $key => $value): ?>
                            <option value="<?= esc($key) ?>" <?= ($key == ($selected_payment_type ?? '')) ? 'selected' : '' ?>><?= esc($value) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="amount_tendered" id="payment_amount" class="pos-payment-select" style="width: 110px;" value="<?= number_format($amount_due ?? $total ?? 0, 2, '.', '') ?>" step="0.01" required>
                    <button type="submit" id="add_payment_btn" style="display:none;"></button>
                </div>
                <div class="pos-quick-amounts" id="quick_amounts_row" style="display: flex; gap: 8px; margin-bottom: 12px;">
                    <button type="button" onclick="quickPaymentAmount('remaining')" style="flex:1; padding: 8px; background: var(--pos-surface); border: 1px solid var(--pos-border); border-radius: 10px; font-size: 12px; font-weight: 600; color: var(--pos-text-muted); cursor: pointer;">Full</button>
                    <button type="button" onclick="quickPaymentAmount(50)" style="flex:1; padding: 8px; background: var(--pos-surface); border: 1px solid var(--pos-border); border-radius: 10px; font-size: 12px; font-weight: 600; color: var(--pos-text-muted); cursor: pointer;">$50</button>
                    <button type="button" onclick="quickPaymentAmount(100)" style="flex:1; padding: 8px; background: var(--pos-surface); border: 1px solid var(--pos-border); border-radius: 10px; font-size: 12px; font-weight: 600; color: var(--pos-text-muted); cursor: pointer;">$100</button>
                </div>
                <?= form_close() ?>

                <div style="display: flex; gap: 10px;">
                    <div style="display:none;">
                        <?= form_open("sales/complete", ['id' => 'complete_sale_form']) ?>
                        <button type="submit" id="hidden_complete_btn"></button>
                        <?= form_close() ?>
                    </div>
    
                    <button type="button" id="main_pay_btn" class="pos-btn-pay" <?= empty($cart) ? 'disabled' : '' ?>>
                        <?php if (($amount_due ?? $total ?? 0) > 0): ?>
                            Pay $<?= number_format($amount_due ?? $total ?? 0, 2) ?>
                        <?php else: ?>
                            Complete Sale
                        <?php endif; ?>
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
                <?php if (($amount_change ?? 0) > 0): ?>
                <div class="pos-total-row" style="margin-top: 16px; color: var(--pos-success); font-weight: 700;">
                    <span>Change Due</span>
                    <span>$<?= number_format($amount_change, 2) ?></span>
                </div>
                <?php endif; ?>
            </div>
            
        </div>
    </div>
</div>

<script>
// ============================
// CORE LOGIC
// ============================
function editCartItem(line, qty, price, discount, inStock) {
    document.getElementById('edit_item_backdrop')?.remove(); // Prevent DOM collision

    const backdrop = document.createElement('div');
    backdrop.className = 'pos-modal-backdrop';
    backdrop.id = 'edit_item_backdrop';
    
    let stockInfo = '';
    if (inStock !== null) {
        let stockClass = inStock <= 0 ? 'color: var(--pos-danger);' : 'color: var(--pos-success);';
        stockInfo = `<div style="margin-bottom: 12px; font-size: 0.85em; color: var(--pos-text-muted);">
            Available Stock: <strong style="${stockClass}">${inStock}</strong>
        </div>`;
    }

    backdrop.innerHTML = `
        <div class="pos-modal">
            <div class="pos-modal-header">
                <h3 class="pos-modal-title">Edit Item</h3>
                <button class="pos-modal-close" onclick="document.getElementById('edit_item_backdrop')?.remove()">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="pos-modal-body">
                <form id="edit_item_form">
                    ${stockInfo}
                    <div class="pos-form-group">
                        <label class="pos-form-label">Quantity</label>
                        <input type="number" class="pos-form-input" id="edit_quantity" name="quantity" min="0.01" step="0.01" value="${qty}" required>
                    </div>
                    <div class="pos-form-group">
                        <label class="pos-form-label">Price</label>
                        <input type="number" class="pos-form-input" id="edit_price" name="price" min="0" step="0.01" value="${price}" required>
                    </div>
                    <div class="pos-form-group">
                        <label class="pos-form-label">Discount (%)</label>
                        <input type="number" class="pos-form-input" id="edit_discount" name="discount" min="0" max="100" step="0.01" value="${discount}">
                    </div>
                    <div class="pos-form-actions">
                        <button type="submit" class="pos-btn-primary">Save Changes</button>
                        <button type="button" class="pos-btn-secondary" onclick="document.getElementById('edit_item_backdrop')?.remove()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    `;

    document.body.appendChild(backdrop);
    backdrop.addEventListener('click', e => { if (e.target === backdrop) backdrop.remove(); });

    setTimeout(() => {
        const formEl = document.getElementById('edit_item_form');
        if (formEl) {
            formEl.addEventListener('submit', function(e) {
                e.preventDefault();
                
                window.shopsuiteApp.postAction('<?= base_url("sales/editItem") ?>/' + line, {
                    quantity: document.getElementById('edit_quantity').value,
                    price: document.getElementById('edit_price').value,
                    discount: document.getElementById('edit_discount').value
                }).then(async r => {
                    const text = await r.text();
                    const doc = (new DOMParser()).parseFromString(text, 'text/html');
                    const errBox = doc.getElementById('error_message_box');
                    if (errBox && errBox.textContent.trim().length > 0) {
                        alert("Update failed: " + errBox.textContent.trim());
                    }
                    window.location.reload();
                }).catch(err => {
                    alert("Error updating item: " + err.message);
                    window.location.reload();
                });
            });
        }
    }, 50);
}

function updateQty(line, newQty, price, discount, inStock) {
    if (newQty <= 0) {
        removeCartItem(line);
        return;
    }
    if (inStock !== null && newQty > inStock && inStock > 0) {
        alert("Insufficient stock. Only " + inStock + " available.");
        return;
    }
    window.shopsuiteApp.postAction('<?= base_url("sales/editItem") ?>/' + line, {
        quantity: newQty,
        price: price,
        discount: discount
    }).then(() => window.location.reload())
      .catch(err => alert("Error: " + err.message));
}

function removeCartItem(line) {
    window.shopsuiteApp.postAction('<?= base_url("sales/deleteItem") ?>/' + line)
        .then(() => window.location.reload());
}

function clearCart() {
    if (confirm('Clear entire cart?')) {
        window.shopsuiteApp.postAction('<?= base_url("sales/cancel") ?>').then(() => window.location.reload());
    }
}

function suspendSale() {
    window.shopsuiteApp.postAction('<?= base_url("sales/suspend") ?>').then(() => { window.location.href = '<?= base_url("sales") ?>'; });
}

function removeCustomer() {
    window.shopsuiteApp.postAction('<?= base_url("sales/removeCustomer") ?>')
        .then(r => {
            if (!r.ok) alert("Server rejected the request (Code " + r.status + ").");
            window.location.href = '<?= base_url("sales") ?>';
        })
        .catch(err => {
            alert("Error removing customer: " + err.message);
            window.location.href = '<?= base_url("sales") ?>';
        });
}

function removePayment(paymentId) {
    window.shopsuiteApp.postAction('<?= base_url("sales/deletePayment") ?>/' + paymentId).then(() => window.location.reload());
}

function toggleGiftCardInput() {
    const isGiftCard = document.getElementById('payment_method').value === '<?= lang('Sales.giftcard') ?>';
    const amountInput = document.getElementById('payment_amount');
    const quickRow = document.getElementById('quick_amounts_row');
    if (isGiftCard) {
        amountInput.type = 'text';
        amountInput.placeholder = 'Gift Card Number';
        amountInput.removeAttribute('step');
        amountInput.removeAttribute('min');
        amountInput.value = '';
        if (quickRow) quickRow.style.display = 'none';
    } else {
        amountInput.type = 'number';
        amountInput.placeholder = 'Amount';
        amountInput.step = '0.01';
        amountInput.min = '0.01';
        amountInput.value = (<?= (float)($amount_due ?? $total ?? 0) ?>).toFixed(2);
        if (quickRow) quickRow.style.display = 'flex';
    }
}

// Payment Interceptor
document.getElementById('main_pay_btn')?.addEventListener('click', function(e) {
    e.preventDefault();
    const remaining = <?= (float)($amount_due ?? $total ?? 0) ?>;
    if (remaining > 0) {
        document.getElementById('add_payment_form').dispatchEvent(new Event('submit'));
    } else {
        document.getElementById('hidden_complete_btn').click();
    }
});

document.getElementById('add_payment_form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('main_pay_btn');
    if(btn) { btn.innerHTML = 'Processing...'; btn.disabled = true; }
    
    fetch(this.action, { method: 'POST', body: new FormData(this), credentials: 'same-origin' })
        .then(async r => {
            const text = await r.text();
            const doc = (new DOMParser()).parseFromString(text, "text/html");
            const errBox = doc.getElementById('error_message_box');
            if (errBox && errBox.innerText.trim().length > 0) alert(errBox.innerText.trim());
            window.location.reload();
        }).catch(err => { console.error(err); window.location.reload(); });
});

// Auto focus & init
document.getElementById('item')?.focus();
toggleGiftCardInput();

// ============================
// MODE-SPECIFIC JS HANDLERS
// ============================

// Invoice Mode: Save invoice number on keyup
<?php if (($mode ?? 'sale') === 'sale_invoice' && !empty($config['invoice_enable'])): ?>
(function() {
    let invoiceTimer = null;
    const invoiceInput = document.getElementById('sales_invoice_number');
    if (invoiceInput) {
        invoiceInput.addEventListener('keyup', function() {
            clearTimeout(invoiceTimer);
            invoiceTimer = setTimeout(() => {
                window.shopsuiteApp.postAction('<?= base_url("sales/setInvoiceNumber") ?>', {
                    sales_invoice_number: invoiceInput.value
                });
            }, 400);
        });
    }
})();
<?php endif; ?>

// Work Order Mode: Toggle price inclusion
<?php if (($mode ?? 'sale') === 'sale_work_order'): ?>
(function() {
    const priceCheckbox = document.getElementById('price_work_orders');
    if (priceCheckbox) {
        priceCheckbox.addEventListener('change', function() {
            window.shopsuiteApp.postAction('<?= base_url("sales/setPriceWorkOrders") ?>', {
                price_work_orders: priceCheckbox.checked ? '1' : '0'
            });
        });
    }
})();
<?php endif; ?>

// Return Mode: Sale search autocomplete
<?php if (($mode ?? 'sale') === 'return'): ?>
(function() {
    const searchInput = document.getElementById('return_sale_search');
    const dropdown = document.getElementById('return_sale_autocomplete');
    if (!searchInput || !dropdown) return;

    let debounce = null;
    searchInput.addEventListener('keyup', function() {
        clearTimeout(debounce);
        const q = searchInput.value.trim();
        if (q.length < 2) { dropdown.innerHTML = ''; return; }
        debounce = setTimeout(() => {
            fetch('<?= base_url("sales/searchForReturn") ?>?q=' + encodeURIComponent(q), { credentials: 'same-origin' })
                .then(r => r.json())
                .then(results => {
                    dropdown.innerHTML = '';
                    if (!results || results.length === 0) {
                        dropdown.innerHTML = '<div style="padding:10px;font-size:12px;color:var(--pos-text-muted);">No sales found</div>';
                        return;
                    }
                    results.forEach(item => {
                        const div = document.createElement('div');
                        div.className = 'pos-autocomplete-item';
                        div.innerHTML = `<strong>${item.label || item.value}</strong>`;
                        div.addEventListener('click', () => {
                            window.location.href = '<?= base_url("sales/loadSaleForReturn") ?>/' + item.value;
                        });
                        dropdown.appendChild(div);
                    });
                })
                .catch(() => { dropdown.innerHTML = ''; });
        }, 300);
    });

    document.addEventListener('click', e => { if (e.target !== searchInput) dropdown.innerHTML = ''; });
})();
<?php endif; ?>

// Mode Switching
function changeMode(mode) {
    document.getElementById('mode_input').value = mode;
    document.getElementById('mode_form').submit();
}

// Add Comment
function addComment() {
    const comment = prompt('Add a note to this sale:', '<?= esc($comment ?? '') ?>');
    if (comment !== null) {
        fetch('<?= base_url("sales/setComment") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'comment=' + encodeURIComponent(comment)
        }).catch(err => console.error('Error saving comment:', err));
    }
}

// Keyboard Shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'F1') { e.preventDefault(); window.location.href = '<?= base_url("sales/salesKeyboardHelp") ?>'; }
    else if (e.key === 'F2') { e.preventDefault(); suspendSale(); }
    else if (e.key === 'F3') { e.preventDefault(); quickAddGiftCard(); }
    else if (e.key === 'F4') { e.preventDefault(); document.getElementById('hidden_complete_btn')?.click(); }
    else if (e.key === 'Escape') { e.preventDefault(); clearCart(); }
});

// Payment Helpers
function getRemainingAmount() {
    return <?= (float)($amount_due ?? $total ?? 0) ?>;
}

function quickPaymentAmount(value) {
    let amount = value === 'remaining' ? getRemainingAmount() : parseFloat(value);
    document.getElementById('payment_amount').value = amount.toFixed(2);
    document.getElementById('payment_amount').focus();
}

// Complete Sale Guard
document.getElementById('complete_sale_form')?.addEventListener('submit', function(e) {
    const remaining = getRemainingAmount();
    const cashMode = <?= (int)($cash_mode ?? 0) ?>;

    if (remaining > 0) {
        if (!confirm(`There is still $${remaining.toFixed(2)} remaining. Complete sale anyway?`)) {
            e.preventDefault();
            return false;
        }
    }
});

// Add Item Hook & Autocomplete
const itemInput = document.getElementById('item');
const addItemForm = document.getElementById('add_item_form');
let itemTimeout;
if (itemInput && addItemForm) {
    const itemAC = document.getElementById('item_autocomplete');
    
    itemInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && itemInput.value.trim().length > 0) {
            e.preventDefault();
            addItemForm.submit();
        }
    });

    itemInput.addEventListener('input', function(e) {
        clearTimeout(itemTimeout);
        if (e.target.value.length < 2) { itemAC.style.display = 'none'; return; }
        itemTimeout = setTimeout(() => {
            fetch('<?= base_url("sales/itemSearch") ?>?term=' + encodeURIComponent(e.target.value))
                .then(r => r.text())
                .then(text => {
                    const data = JSON.parse(text);
                    if (data.length > 0) {
                        itemAC.innerHTML = data.map(item => `<div class="pos-autocomplete-item" data-value="${item.value}">${item.label}</div>`).join('');
                        itemAC.style.display = 'block';
                        itemAC.querySelectorAll('.pos-autocomplete-item').forEach(div => {
                            div.addEventListener('click', function() {
                                itemInput.value = this.dataset.value;
                                itemAC.style.display = 'none';
                                addItemForm.submit();
                            });
                        });
                    }
                }).catch(() => { itemAC.style.display = 'none'; });
        }, 300);
    });
    
    document.addEventListener('click', (e) => { 
        if (!itemInput.parentElement.contains(e.target) && !itemAC.contains(e.target)) itemAC.style.display = 'none'; 
    });
}

// Customer Autocomplete (Simple)
let customerTimeout;
const customerInput = document.getElementById('customer_search_input');
if (customerInput) {
    const custAC = document.getElementById('customer_autocomplete');
    customerInput.addEventListener('input', function(e) {
        clearTimeout(customerTimeout);
        if (e.target.value.length < 2) { custAC.style.display = 'none'; return; }
        customerTimeout = setTimeout(() => {
            fetch('<?= base_url("customers/suggest") ?>?term=' + encodeURIComponent(e.target.value))
                .then(r => r.text())
                .then(text => {
                    const data = JSON.parse(text);
                    if (data.length > 0) {
                        custAC.innerHTML = data.map(c => `<div class="pos-autocomplete-item" data-id="${c.value}">${c.label}</div>`).join('');
                        custAC.style.display = 'block';
                        custAC.querySelectorAll('.pos-autocomplete-item').forEach(div => {
                            div.addEventListener('click', function() {
                                window.location.href = '<?= base_url("sales/selectCustomer") ?>?customer=' + this.dataset.id;
                            });
                        });
                    }
                }).catch(() => { custAC.style.display = 'none'; });
        }, 300);
    });
    document.addEventListener('click', (e) => { if (!customerInput.parentElement.contains(e.target)) custAC.style.display = 'none'; });
}

// Custom GiftCard
function quickAddGiftCard() {
    const code = prompt("Enter new Gift Card Serial Number (leave blank to auto-generate):");
    if (code !== null) {
        const val = prompt("Enter Gift Card Balance ($):");
        if (val && parseFloat(val) > 0) {
            const formData = new FormData();
            formData.append('value', val);
            formData.append('giftcard_number', code);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            fetch('<?= base_url("sales/addGiftcard") ?>', { method: 'POST', body: formData, credentials: 'same-origin' })
                .then(() => window.location.reload());
        }
    }
}

// Quick Add Customer Minimal
function quickAddCustomer() {
    const nameStr = prompt("Enter new customer Name (First Last):");
    if (nameStr) {
        const parts = nameStr.split(' ');
        const formData = new FormData();
        formData.append('first_name', parts[0] || '');
        formData.append('last_name', parts.slice(1).join(' ') || '');
        formData.append('email', '');
        formData.append('phone_number', '');
        formData.append('tax_id', '');
        fetch('<?= base_url("customers/save/-1") ?>', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.success) window.location.href = '<?= base_url("sales/selectCustomer") ?>?customer=' + data.id;
                else alert(data.message);
            });
    }
}
</script>

<?php echo view('layouts/modern_footer'); ?>
