<?php
$title = 'POS Register - ShopSuite';
echo view('layouts/modern_header', ['title' => $title, 'extra_css' => ['css/pos-next.css']]);
?>

<script>document.querySelector('.app-shell')?.classList.add('pos-shell-active');</script>

<div class="pos-shell" id="posShell">
    <!-- ===== TOP BAR ===== -->
    <div class="pos-topbar">
        <!-- Brand -->
        <div class="pos-brand">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            POS
        </div>

        <!-- Mode Switch Form (hidden) -->
        <?= form_open("sales/changeMode", ['id' => 'mode_form', 'style' => 'display:none']) ?>
        <input type="hidden" name="mode" id="mode_input" value="<?= $mode ?? 'sale' ?>">
        <?= form_close() ?>

        <!-- Mode Tabs -->
        <div class="pos-mode-tabs">
            <button class="pos-mode-tab <?= ($mode ?? 'sale') == 'sale' ? 'active' : '' ?>" onclick="changeMode('sale')">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Sale
            </button>
            <button class="pos-mode-tab <?= ($mode ?? '') == 'return' ? 'active' : '' ?>" onclick="changeMode('return')">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                Return
            </button>
            <button class="pos-mode-tab <?= ($mode ?? '') == 'sale_invoice' ? 'active' : '' ?>" onclick="changeMode('sale_invoice')">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Invoice
            </button>
            <button class="pos-mode-tab <?= ($mode ?? '') == 'sale_quote' ? 'active' : '' ?>" onclick="changeMode('sale_quote')">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Quote
            </button>
            <button class="pos-mode-tab <?= ($mode ?? '') == 'sale_work_order' ? 'active' : '' ?>" onclick="changeMode('sale_work_order')">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Work Order
            </button>
        </div>

        <!-- Topbar Actions -->
        <div class="pos-topbar-actions">
            <?php if (!empty($active_cashup_id)): ?>
            <a href="<?= base_url('cashups/view/' . (int) $active_cashup_id) ?>" class="pos-cashup-live" title="<?= esc(lang('Sales.cashup_active_hint')) ?>">
                <span class="pos-cashup-dot"></span>
                <?= esc(lang('Sales.cashup_active')) ?> #<?= (int) $active_cashup_id ?>
            </a>
            <?php elseif (!empty($cashups_allowed)): ?>
            <a href="<?= base_url('cashups/view/-1') ?>" class="pos-topbar-btn">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                <span><?= esc(lang('Sales.open_cashup')) ?></span>
            </a>
            <?php endif; ?>

            <button class="pos-topbar-btn" onclick="window.location.href='<?= base_url('sales/returnExchange') ?>'">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                <span>Return</span>
            </button>
            <button class="pos-topbar-btn" onclick="window.location.href='<?= base_url('sales/suspended') ?>'">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Suspended</span>
            </button>
            <button class="pos-topbar-btn" onclick="window.location.href='<?= base_url('sales/manage') ?>'">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>History</span>
            </button>
            <button class="pos-topbar-btn" onclick="window.location.href='<?= base_url('home') ?>'">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>Dashboard</span>
            </button>
        </div>
    </div>

    <!-- ===== MAIN BODY ===== -->
    <div class="pos-body">
        <!-- ===== LEFT PANE: Search + Cart ===== -->
        <div class="pos-left-pane">
            <!-- Search Area -->
            <div class="pos-search-area">
                <?= form_open("sales/add", ['id' => 'add_item_form']) ?>
                <div class="pos-search-wrap">
                    <svg class="pos-search-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text"
                           class="pos-search-input"
                           name="item"
                           id="item"
                           placeholder="Scan barcode or search products..."
                           autocomplete="off"
                           autofocus>
                </div>
                <?= form_close() ?>

                <div class="pos-quick-actions">
                    <div class="pos-quick-btn" onclick="clearCart()">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        <div>Clear</div>
                        <span class="pos-kbd">ESC</span>
                    </div>
                    <div class="pos-quick-btn" onclick="suspendSale()">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>Hold</div>
                        <span class="pos-kbd">F2</span>
                    </div>
                    <div class="pos-quick-btn" onclick="window.location.href='<?= base_url('sales/salesKeyboardHelp') ?>'">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>Help</div>
                        <span class="pos-kbd">F1</span>
                    </div>
                    <div class="pos-quick-btn" onclick="quickAddGiftCard()">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>Gift Card</div>
                        <span class="pos-kbd">F3</span>
                    </div>
                </div>
            </div>

            <!-- Cart -->
            <div class="pos-cart-wrap">
                <div class="pos-cart-header">
                    <h3 class="pos-cart-title">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Cart
                        <span class="pos-cart-count"><?= $item_count ?? count($cart ?? []) ?> items · <?= $total_units ?? count($cart ?? []) ?> units</span>
                    </h3>
                </div>

                <div class="pos-cart-items" id="cartItemsContainer">
                    <?php if (empty($cart)): ?>
                        <div class="pos-cart-empty">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <div class="pos-cart-empty-title">Cart is Empty</div>
                            <div class="pos-cart-empty-sub">Scan or search products to begin</div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($cart as $line => $item): ?>
                            <div class="pos-cart-item" onclick="editCartItem(<?= $line ?>, <?= (float)$item['quantity'] ?>, <?= (float)$item['price'] ?>, <?= (float)($item['discount'] ?? 0) ?>, <?= isset($item['in_stock']) ? (float)$item['in_stock'] : 'null' ?>)">
                                <div class="pos-cart-item-info">
                                    <div class="pos-cart-item-name"><?= esc($item['name']) ?></div>
                                    <div class="pos-cart-item-meta">
                                        Qty: <?= esc($item['quantity']) ?> × $<?= number_format($item['price'], 2) ?>
                                        <?php if (!empty($item['discount']) && $item['discount'] > 0): ?>
                                            <span class="pos-discount-badge">-<?= esc($item['discount']) ?>%</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="pos-cart-item-total">$<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
                                <button type="button" class="pos-cart-item-remove" onclick="event.stopPropagation(); removeCartItem(<?= $line ?>);" title="Remove">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- ===== RIGHT PANE: Customer + Totals + Payment + Actions ===== -->
        <div class="pos-right-pane">
            <!-- Customer Section -->
            <div>
                <div class="pos-section-label">Customer
                    <?php if (!empty($customer_required)): ?>
                        <span class="pos-customer-warning">⚠ <?= esc($customer_required) ?></span>
                    <?php endif; ?>
                </div>
                <?php if (isset($customer_id) && $customer_id > 0): ?>
                    <div class="pos-customer-card">
                        <div>
                            <div class="pos-customer-name"><?= esc($customer ?? 'Customer') ?></div>
                            <div class="pos-customer-id">ID: <?= esc($customer_id) ?></div>
                        </div>
                        <button type="button" class="pos-cart-item-remove" onclick="removeCustomer()" title="Remove Customer">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                <?php else: ?>
                    <div class="pos-mb-2">
                        <div class="pos-walkin-card">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Walk-in Customer
                        </div>
                    </div>

                    <div class="pos-customer-search-wrap">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="pos-customer-search-icon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text"
                               id="customer_search_input"
                               class="pos-customer-search"
                               placeholder="Search customer..."
                               autocomplete="off">
                        <div id="customer_autocomplete" class="pos-customer-autocomplete"></div>
                    </div>

                    <button type="button" class="pos-new-customer-btn" onclick="quickAddCustomer()">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        New Customer
                    </button>
                <?php endif; ?>
            </div>

            <!-- Invoice / Quote / Work Order Number -->
            <?php if (!empty($invoice_number) && ($mode ?? '') === 'sale_invoice'): ?>
            <div class="pos-doc-number">
                <span class="pos-doc-number-label">Invoice #</span>
                <span class="pos-doc-number-value"><?= esc($invoice_number) ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($quote_number) && ($mode ?? '') === 'sale_quote'): ?>
            <div class="pos-doc-number">
                <span class="pos-doc-number-label">Quote #</span>
                <span class="pos-doc-number-value"><?= esc($quote_number) ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($work_order_number) && ($mode ?? '') === 'sale_work_order'): ?>
            <div class="pos-doc-number">
                <span class="pos-doc-number-label">Work Order #</span>
                <span class="pos-doc-number-value"><?= esc($work_order_number) ?></span>
            </div>
            <?php endif; ?>

            <!-- Totals Card -->
            <div class="pos-totals-card">
                <div class="pos-total-row">
                    <span class="pos-total-label">Subtotal</span>
                    <span class="pos-total-value">$<?= number_format($subtotal ?? 0, 2) ?></span>
                </div>
                <?php if (!empty($taxes) && is_array($taxes)): ?>
                    <?php foreach ($taxes as $tax_name => $tax_info): ?>
                    <div class="pos-total-row">
                        <span class="pos-total-label"><?= esc($tax_name) ?></span>
                        <span class="pos-total-value">$<?= number_format($tax_info['tax_amount'] ?? 0, 2) ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                <div class="pos-total-row">
                    <span class="pos-total-label">Tax</span>
                    <span class="pos-total-value">$<?= number_format(($total ?? 0) - ($subtotal ?? 0), 2) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($discount) && $discount > 0): ?>
                <div class="pos-total-row">
                    <span class="pos-total-label">Discount</span>
                    <span class="pos-total-value">-<?= esc($discount) ?>%</span>
                </div>
                <?php endif; ?>
                <hr class="pos-total-divider">
                <div class="pos-total-grand">
                    <span>Total</span>
                    <span>$<?= number_format($total ?? 0, 2) ?></span>
                </div>
                <?php if (!empty($payments)): ?>
                <div class="pos-total-due">
                    <span class="pos-total-label">Paid</span>
                    <span class="pos-total-due-value">$<?= number_format($payments_total ?? 0, 2) ?></span>
                </div>
                <?php endif; ?>
                <div class="pos-total-due">
                    <span class="pos-total-label-bold">Amount Due</span>
                    <span class="pos-total-due-value">$<?= number_format($amount_due ?? $total ?? 0, 2) ?></span>
                </div>
                <?php if (isset($amount_change) && $amount_change > 0): ?>
                <div class="pos-total-due-spaced">
                    <span class="pos-change-label">Change</span>
                    <span class="pos-change-value">$<?= number_format($amount_change, 2) ?></span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Payment Section -->
            <div>
                <div class="pos-payment-header">
                    <div class="pos-section-label-flush">Payments</div>
                    <div id="remaining_amount" class="pos-payment-due">Due: $<?= number_format($amount_due ?? $total ?? 0, 2) ?></div>
                </div>

                <!-- Existing Payments -->
                <div id="payments_list" class="pos-payment-list">
                    <?php if (!empty($payments)): ?>
                        <?php foreach ($payments as $payment_id => $payment): ?>
                            <div class="pos-payment-item">
                                <div class="pos-payment-item-inner">
                                    <span class="pos-payment-method"><?= esc($payment['payment_type']) ?></span>
                                    <span class="pos-payment-amount">$<?= number_format($payment['payment_amount'], 2) ?></span>
                                </div>
                                <button type="button" class="pos-payment-remove" title="Remove" onclick="removePayment('<?= base64url_encode($payment_id) ?>')">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Add Payment -->
                <div class="pos-add-payment">
                    <?= form_open("sales/addPayment", ['id' => 'add_payment_form']) ?>
                    <div class="pos-payment-row">
                        <div class="pos-payment-field">
                            <span class="pos-currency-sym" id="payment_amount_symbol">$</span>
                            <input type="number"
                                   name="amount_tendered"
                                   id="payment_amount"
                                   class="pos-payment-input"
                                   placeholder="Amount"
                                   step="0.01"
                                   value="<?= number_format($amount_due ?? $total ?? 0, 2, '.', '') ?>"
                                   required>
                        </div>
                        <div class="pos-payment-field">
                            <select id="payment_method" name="payment_type" class="pos-payment-select" onchange="toggleGiftCardInput()">
                                <?php foreach ($payment_options as $key => $value): ?>
                                    <option value="<?= esc($key) ?>" <?= ($key == ($selected_payment_type ?? '')) ? 'selected' : '' ?>><?= esc($value) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" id="add_payment_btn" class="pos-add-payment-btn">+ Add</button>
                    </div>
                    <div class="pos-quick-amounts" id="quick_amounts_row">
                        <button type="button" onclick="quickPaymentAmount('remaining')" class="pos-quick-pill">Full</button>
                        <button type="button" onclick="quickPaymentAmount(50)" class="pos-quick-pill">$50</button>
                        <button type="button" onclick="quickPaymentAmount(100)" class="pos-quick-pill">$100</button>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pos-actions">
                <?= form_open("sales/complete", ['id' => 'complete_sale_form']) ?>
                <button type="submit" class="pos-complete-btn" <?= empty($cart) ? 'disabled' : '' ?>>
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Complete Sale
                    <span class="pos-complete-kbd">F4</span>
                </button>
                <?= form_close() ?>

                <button class="pos-note-btn" onclick="addComment()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    Add Note
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================
     INLINE JAVASCRIPT
     ============================================ -->
<script>
// ============================
// ITEM AUTOCOMPLETE
// ============================
let itemAutocompleteTimeout;
const itemInput = document.getElementById('item');
const addItemForm = document.getElementById('add_item_form');

if (itemInput) {
    const acContainer = document.createElement('div');
    acContainer.className = 'pos-autocomplete';
    itemInput.parentElement.appendChild(acContainer);

    itemInput.addEventListener('input', function(e) {
        const query = e.target.value.trim();
        clearTimeout(itemAutocompleteTimeout);

        if (query.length < 2) {
            acContainer.style.display = 'none';
            return;
        }

        itemAutocompleteTimeout = setTimeout(() => {
            fetch('<?= base_url("sales/itemSearch") ?>?term=' + encodeURIComponent(query))
                .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.text(); })
                .then(text => {
                    try {
                        const data = JSON.parse(text);
                        if (data && data.length > 0) {
                            acContainer.innerHTML = data.map(item => `
                                <div class="pos-autocomplete-item" data-value="${item.value}">${item.label}</div>
                            `).join('');
                            acContainer.style.display = 'block';

                            acContainer.querySelectorAll('.pos-autocomplete-item').forEach(div => {
                                div.addEventListener('click', function() {
                                    itemInput.value = this.dataset.value;
                                    acContainer.style.display = 'none';
                                    addItemForm.submit();
                                });
                            });
                        } else {
                            acContainer.style.display = 'none';
                        }
                    } catch (e) {
                        console.error('Parse error:', e);
                        acContainer.style.display = 'none';
                    }
                })
                .catch(err => {
                    console.error('Search error:', err);
                    acContainer.style.display = 'none';
                });
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (!itemInput.parentElement.contains(e.target)) {
            acContainer.style.display = 'none';
        }
    });
}

// Enter key submit
if (addItemForm && itemInput) {
    addItemForm.addEventListener('submit', function(e) {
        e.preventDefault();
        if (itemInput.value.trim()) this.submit();
    });

    itemInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') addItemForm.submit();
    });
}

// ============================
// CART ACTIONS
// ============================
function clearCart() {
    if (confirm('Clear all items from cart?')) {
        window.shopsuiteApp.postAction('<?= base_url("sales/cancel") ?>')
            .then(() => window.location.reload())
            .catch(err => console.error('Error clearing cart:', err));
    }
}

function removeCartItem(line) {
    if (!confirm('Remove this item?')) return;
    window.shopsuiteApp.postAction('<?= base_url("sales/deleteItem") ?>/' + line)
        .then(() => window.location.reload())
        .catch(err => console.error('Error removing item:', err));
}

function removeCustomer() {
    window.shopsuiteApp.postAction('<?= base_url("sales/removeCustomer") ?>')
        .then(() => window.location.reload())
        .catch(err => console.error('Error removing customer:', err));
}

function removePayment(paymentId) {
    window.shopsuiteApp.postAction('<?= base_url("sales/deletePayment") ?>/' + paymentId)
        .then(() => window.location.reload())
        .catch(err => console.error('Error removing payment:', err));
}

// ============================
// SUSPEND SALE
// ============================
function suspendSale() {
    const cartItems = document.querySelectorAll('.pos-cart-item');
    if (cartItems.length === 0) {
        alert('Cannot suspend an empty sale. Please add items first.');
        return;
    }
    if (!confirm('Suspend this sale?')) return;

    window.shopsuiteApp.postAction('<?= base_url("sales/suspend") ?>')
        .then(() => { window.location.href = '<?= base_url("sales") ?>'; })
        .catch(err => {
            console.error('Error suspending sale:', err);
            alert('Error suspending sale. Please try again.');
        });
}

// ============================
// MODE SWITCHING
// ============================
function changeMode(mode) {
    document.getElementById('mode_input').value = mode;
    document.getElementById('mode_form').submit();
}

// ============================
// ADD COMMENT
// ============================
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

// ============================
// EDIT CART ITEM
// ============================
function editCartItem(line, qty, price, discount, inStock) {
    const backdrop = document.createElement('div');
    backdrop.className = 'pos-modal-backdrop';
    backdrop.id = 'edit_item_backdrop';
    
    let stockInfo = '';
    if (inStock !== null) {
        let stockClass = inStock <= 0 ? 'color: var(--pos-danger);' : 'color: var(--pos-success);';
        stockInfo = \`<div style="margin-bottom: 12px; font-size: 0.85em; color: var(--pos-text-muted);">
            Available Stock: <strong style="\${stockClass}">\${inStock}</strong>
        </div>\`;
    }

    backdrop.innerHTML = \`
        <div class="pos-modal">
            <div class="pos-modal-header">
                <h3 class="pos-modal-title">Edit Item</h3>
                <button class="pos-modal-close" onclick="document.getElementById('edit_item_backdrop')?.remove()">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="pos-modal-body">
                <form id="edit_item_form">
                    \${stockInfo}
                    <div class="pos-form-group">
                        <label class="pos-form-label">Quantity</label>
                        <input type="number" class="pos-form-input" id="edit_quantity" name="quantity" min="0.01" step="0.01" value="\${qty}" required>
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
        document.getElementById('edit_item_form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            window.shopsuiteApp.postAction('<?= base_url("sales/editItem") ?>/' + line, {
                quantity: document.getElementById('edit_quantity').value,
                price: document.getElementById('edit_price').value,
                discount: document.getElementById('edit_discount').value
            }).then(() => window.location.reload())
              .catch(err => console.error('Error updating item:', err));
        });
    }, 50);
}

// ============================
// KEYBOARD SHORTCUTS
// ============================
document.addEventListener('keydown', function(e) {
    if (e.key === 'F1') { e.preventDefault(); window.location.href = '<?= base_url("sales/salesKeyboardHelp") ?>'; }
    else if (e.key === 'F2') { e.preventDefault(); suspendSale(); }
    else if (e.key === 'F3') { e.preventDefault(); quickAddGiftCard(); }
    else if (e.key === 'F4') { e.preventDefault(); document.getElementById('complete_sale_form')?.submit(); }
    else if (e.key === 'Escape') { e.preventDefault(); clearCart(); }
});

// ============================
// CUSTOMER AUTOCOMPLETE
// ============================
let customerTimeout;
const customerInput = document.getElementById('customer_search_input');

if (customerInput) {
    const custAC = document.getElementById('customer_autocomplete');

    customerInput.addEventListener('input', function(e) {
        const query = e.target.value.trim();
        clearTimeout(customerTimeout);

        if (query.length < 2) { custAC.style.display = 'none'; return; }

        customerTimeout = setTimeout(() => {
            fetch('<?= base_url("customers/suggest") ?>?term=' + encodeURIComponent(query))
                .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.text(); })
                .then(text => {
                    try {
                        const data = JSON.parse(text);
                        if (data && data.length > 0) {
                            custAC.innerHTML = data.map(c => `
                                <div class="pos-autocomplete-item" data-id="${c.value}">
                                    <div class="pos-autocomplete-name">${c.label}</div>
                                </div>
                            `).join('');
                            custAC.style.display = 'block';

                            custAC.querySelectorAll('.pos-autocomplete-item').forEach(div => {
                                div.addEventListener('click', function() {
                                    window.location.href = '<?= base_url("sales/selectCustomer") ?>?customer=' + this.dataset.id;
                                });
                            });
                        } else {
                            custAC.innerHTML = '<div class="pos-autocomplete-empty">No customers found</div>';
                            custAC.style.display = 'block';
                        }
                    } catch (e) {
                        custAC.style.display = 'none';
                    }
                })
                .catch(() => { custAC.style.display = 'none'; });
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (!customerInput.parentElement.contains(e.target)) {
            custAC.style.display = 'none';
        }
    });
}

// ============================
// QUICK ADD CUSTOMER MODAL
// ============================
function quickAddCustomer() {
    const backdrop = document.createElement('div');
    backdrop.className = 'pos-modal-backdrop';
    backdrop.id = 'customer_modal_backdrop';

    backdrop.innerHTML = `
        <div class="pos-modal">
            <div class="pos-modal-header">
                <h3 class="pos-modal-title">New Customer</h3>
                <button class="pos-modal-close" onclick="closeCustomerModal()">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="pos-modal-body">
                <form id="quick_customer_form">
                    <div class="pos-form-group">
                        <label class="pos-form-label">First Name *</label>
                        <input type="text" class="pos-form-input" id="quick_first_name" required>
                    </div>
                    <div class="pos-form-group">
                        <label class="pos-form-label">Last Name *</label>
                        <input type="text" class="pos-form-input" id="quick_last_name" required>
                    </div>
                    <div class="pos-form-group">
                        <label class="pos-form-label">Phone</label>
                        <input type="text" class="pos-form-input" id="quick_phone">
                    </div>
                    <div class="pos-form-actions">
                        <button type="submit" class="pos-btn-primary">Add Customer</button>
                        <button type="button" class="pos-btn-secondary" onclick="closeCustomerModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    `;

    document.body.appendChild(backdrop);
    backdrop.addEventListener('click', e => { if (e.target === backdrop) closeCustomerModal(); });
    setTimeout(() => document.getElementById('quick_first_name')?.focus(), 100);

    document.getElementById('quick_customer_form').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.textContent = 'Adding...';

        const formData = new FormData();
        formData.append('first_name', document.getElementById('quick_first_name').value);
        formData.append('last_name', document.getElementById('quick_last_name').value);
        formData.append('email', '');
        formData.append('phone_number', document.getElementById('quick_phone').value);
        formData.append('tax_id', '');

        fetch('<?= base_url("customers/save/-1") ?>', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    closeCustomerModal();
                    window.location.href = '<?= base_url("sales/selectCustomer") ?>?customer=' + data.id;
                } else {
                    alert('Error: ' + data.message);
                    btn.disabled = false;
                    btn.textContent = 'Add Customer';
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Failed to add customer.');
                btn.disabled = false;
                btn.textContent = 'Add Customer';
            });
    });
}

function closeCustomerModal() {
    document.getElementById('customer_modal_backdrop')?.remove();
}

// ============================
// QUICK SELL GIFTCARD MODAL
// ============================
function quickAddGiftCard() {
    const backdrop = document.createElement('div');
    backdrop.className = 'pos-modal-backdrop';
    backdrop.id = 'giftcard_modal_backdrop';

    backdrop.innerHTML = `
        <div class="pos-modal">
            <div class="pos-modal-header">
                <h3 class="pos-modal-title">Sell Gift Card</h3>
                <button type="button" class="pos-modal-close" onclick="closeGiftCardModal()">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="pos-modal-body">
                <form id="quick_giftcard_form">
                    <div class="pos-form-group">
                        <label class="pos-form-label">Gift Card Value ($) *</label>
                        <input type="number" class="pos-form-input" id="quick_giftcard_value" step="0.01" min="0.01" required>
                    </div>
                    <div class="pos-form-group">
                        <label class="pos-form-label">Gift Card Number (Optional)</label>
                        <input type="text" class="pos-form-input" id="quick_giftcard_number" placeholder="Leave blank to auto-generate">
                    </div>
                    <div class="pos-form-actions">
                        <button type="submit" class="pos-btn-primary">Add to Sale</button>
                        <button type="button" class="pos-btn-secondary" onclick="closeGiftCardModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    `;

    document.body.appendChild(backdrop);
    backdrop.addEventListener('click', e => { if (e.target === backdrop) closeGiftCardModal(); });
    setTimeout(() => document.getElementById('quick_giftcard_value')?.focus(), 100);

    document.getElementById('quick_giftcard_form').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.textContent = 'Adding...';

        const formData = new FormData();
        formData.append('value', document.getElementById('quick_giftcard_value').value);
        formData.append('giftcard_number', document.getElementById('quick_giftcard_number').value);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        fetch('<?= base_url("sales/addGiftcard") ?>', { method: 'POST', body: formData })
            .then(() => {
                closeGiftCardModal();
                window.location.reload();
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Failed to add gift card.');
                btn.disabled = false;
                btn.textContent = 'Add to Sale';
            });
    });
}

function closeGiftCardModal() {
    document.getElementById('giftcard_modal_backdrop')?.remove();
}

// ============================
// PAYMENT HELPERS
// ============================
function getRemainingAmount() {
    return <?= (float)($amount_due ?? $total ?? 0) ?>;
}

function quickPaymentAmount(value) {
    let amount = value === 'remaining' ? getRemainingAmount() : parseFloat(value);
    document.getElementById('payment_amount').value = amount.toFixed(2);
    document.getElementById('payment_amount').focus();
}

function toggleGiftCardInput() {
    const isGiftCard = document.getElementById('payment_method').value === '<?= lang('Sales.giftcard') ?>';
    const amountInput = document.getElementById('payment_amount');
    const sym = document.getElementById('payment_amount_symbol');
    const quickRow = document.getElementById('quick_amounts_row');

    if (isGiftCard) {
        amountInput.type = 'text';
        amountInput.placeholder = 'Gift Card Number';
        amountInput.removeAttribute('step');
        amountInput.removeAttribute('min');
        amountInput.value = '';
        if (sym) sym.style.display = 'none';
        if (quickRow) quickRow.style.display = 'none';
    } else {
        amountInput.type = 'number';
        amountInput.placeholder = 'Amount';
        amountInput.step = '0.01';
        amountInput.min = '0.01';
        amountInput.value = getRemainingAmount().toFixed(2);
        if (sym) sym.style.display = 'inline-block';
        if (quickRow) quickRow.style.display = 'flex';
    }
}

// ============================
// PAYMENT FORM HANDLING
// ============================
document.addEventListener('DOMContentLoaded', function() {
    const payForm = document.getElementById('add_payment_form');
    if (payForm) {
        payForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('add_payment_btn');
            const og = btn.innerHTML;
            btn.innerHTML = '...';
            btn.disabled = true;

            fetch(this.action, { method: 'POST', body: new FormData(this) })
                .then(() => window.location.reload())
                .catch(err => {
                    console.error('Error adding payment:', err);
                    btn.innerHTML = og;
                    btn.disabled = false;
                });
        });
    }

    // Complete sale form guard
    const completeForm = document.getElementById('complete_sale_form');
    if (completeForm) {
        completeForm.addEventListener('submit', function(e) {
            const hasPayments = document.querySelectorAll('.pos-payment-item').length > 0;
            const remaining = getRemainingAmount();
            const cashMode = <?= (int)($cash_mode ?? 0) ?>;

            if (remaining > 0 && !hasPayments && cashMode !== 1) {
                if (!confirm(`There is still $${remaining.toFixed(2)} remaining. Complete sale anyway?`)) {
                    e.preventDefault();
                    return false;
                }
            } else if (remaining > 0) {
                if (!confirm(`There is still $${remaining.toFixed(2)} remaining. Complete sale anyway?`)) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    }

    // Focus and init
    document.getElementById('item')?.focus();
    toggleGiftCardInput();
});
</script>

<?php echo view('layouts/modern_footer'); ?>
