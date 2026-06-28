<?php
$title = 'Sales Register - ShopSuite';
echo view('layouts/modern_header', ['title' => $title, 'extra_css' => ['css/pos-compact.min.css']]);
?>

<div class="pos-wrapper">
    <!-- Main POS Area -->
    <div class="pos-main">
        <!-- Header -->
        <div class="pos-header">
            <div class="d-flex align-items-center gap-4">
                <div class="pos-logo">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    POS Register
                </div>
                <?= form_open("sales/changeMode", ['id' => 'mode_form']) ?>
                <input type="hidden" name="mode" id="mode_input" value="<?= $mode ?? 'sale' ?>">
                <?= form_close() ?>
                
                <div class="mode-buttons">
                    <button class="mode-btn <?= ($mode ?? 'sale') == 'sale' ? 'active' : '' ?>" onclick="changeMode('sale')">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Sale
                    </button>
                    <button class="mode-btn <?= ($mode ?? '') == 'return' ? 'active' : '' ?>" onclick="changeMode('return')">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                        </svg>
                        Return
                    </button>
                    <button class="mode-btn <?= ($mode ?? '') == 'sale_invoice' ? 'active' : '' ?>" onclick="changeMode('sale_invoice')">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Invoice
                    </button>
                    <button class="mode-btn <?= ($mode ?? '') == 'sale_quote' ? 'active' : '' ?>" onclick="changeMode('sale_quote')">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Quote
                    </button>
                    <button class="mode-btn <?= ($mode ?? '') == 'sale_work_order' ? 'active' : '' ?>" onclick="changeMode('sale_work_order')">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Work Order
                    </button>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <?php if (!empty($active_cashup_id)): ?>
                <a href="<?= base_url('cashups/view/' . (int) $active_cashup_id) ?>" class="pos-cashup-badge" title="<?= esc(lang('Sales.cashup_active_hint')) ?>">
                    <span class="pos-cashup-badge-dot" aria-hidden="true"></span>
                    <?= esc(lang('Sales.cashup_active')) ?> #<?= (int) $active_cashup_id ?>
                </a>
                <?php elseif (!empty($cashups_allowed)): ?>
                <a href="<?= base_url('cashups/view/-1') ?>" class="btn-ghost btn-sm pos-cashup-open">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <?= esc(lang('Sales.open_cashup')) ?>
                </a>
                <?php endif; ?>
                <button class="btn-ghost btn-sm" onclick="window.location.href='<?= base_url('sales/returnExchange') ?>'">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                    Return
                </button>
                <button class="btn-ghost btn-sm" onclick="window.location.href='<?= base_url('sales/suspended') ?>'">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Suspended
                </button>
                <button class="btn-ghost btn-sm" onclick="window.location.href='<?= base_url('sales/manage') ?>'">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    History
                </button>
            </div>
        </div>
        
        <!-- Content Area -->
        <div class="pos-content">
            <!-- Left Panel: Search & Cart -->
            <div class="pos-left">
                <!-- Search Section -->
                <div class="search-section">
                    <?= form_open("sales/add", ['id' => 'add_item_form']) ?>
                    <div class="search-input-wrapper">
                        <svg class="search-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" 
                               class="search-input" 
                               name="item" 
                               id="item" 
                               placeholder="Scan barcode or search products..." 
                               autocomplete="off"
                               autofocus>
                    </div>
                    <?= form_close() ?>
                    
                    <div class="quick-actions">
                        <div class="quick-action" onclick="clearCart()">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <div>Clear</div>
                            <span class="shortcut-badge">ESC</span>
                        </div>
                        <div class="quick-action" onclick="suspendSale()">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>Hold</div>
                            <span class="shortcut-badge">F2</span>
                        </div>
                        <div class="quick-action" onclick="window.location.href='<?= base_url('sales/salesKeyboardHelp') ?>'">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>Help</div>
                            <span class="shortcut-badge">F1</span>
                        </div>
                    </div>
                </div>
                
                <!-- Cart -->
                <div class="cart-container">
                    <div class="cart-header">
                        <h3 class="cart-header-title">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Cart <span class="cart-item-count">(<?= count($cart ?? []) ?> items)</span>
                        </h3>
                    </div>
                    
                    <div class="cart-items">
                        <?php if (empty($cart)): ?>
                            <div class="empty-cart">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <div class="empty-cart-title">Cart is Empty</div>
                                <div class="text-sm text-secondary">Scan or search for products to add</div>
                            </div>
                        <?php else: ?>
                            <?php foreach ($cart as $line => $item): ?>
                                <div class="cart-item" onclick="editCartItem(<?= $line ?>)">
                                    <div class="cart-item-header">
                                        <div class="cart-item-name"><?= esc($item['name']) ?></div>
                                        <div class="cart-item-price">$<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
                                    </div>
                                    <div class="cart-item-details">
                                        <div class="cart-item-qty">
                                            <span>Qty: <?= esc($item['quantity']) ?></span>
                                            <span>×</span>
                                            <span>$<?= number_format($item['price'], 2) ?></span>
                                        </div>
                                        <button type="button" class="btn btn-ghost btn-sm" onclick="event.stopPropagation(); removeCartItem(<?= $line ?>);">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Right Sidebar: Customer, Totals, Payment -->
            <div class="pos-sidebar">
                <!-- Customer Section -->
                <div class="sidebar-section">
                    <div class="section-title">Customer</div>
                    <?php if (isset($customer_id) && $customer_id > 0): ?>
                        <div class="customer-selected-card">
                            <div>
                                <div class="customer-name"><?= esc($customer ?? 'Customer') ?></div>
                                <div class="customer-id">ID: <?= esc($customer_id) ?></div>
                            </div>
                            <button type="button" class="btn btn-ghost btn-sm" onclick="removeCustomer()">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="mb-2">
                            <div class="walk-in-card">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-xs">Walk-in Customer</span>
                            </div>
                        </div>
                        
                        <!-- Customer Search Input -->
                        <div class="pos-search-wrapper">
                            <input type="text" 
                                   id="customer_search_input" 
                                   class="form-control customer-search-input" 
                                   placeholder="Search customer..." 
                                   autocomplete="off">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="search-icon-abs">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <div id="customer_autocomplete" class="customer-autocomplete-dropdown"></div>
                        </div>
                        
                        <!-- New Customer Button -->
                        <button type="button" class="btn btn-outline btn-sm btn-block text-xs" onclick="quickAddCustomer()">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Customer
                        </button>
                    <?php endif; ?>
                </div>
                
                <!-- Totals Section -->
                <div class="totals-section">
                    <div>
                        <div class="total-row">
                            <span class="total-label">Subtotal</span>
                            <span class="total-value">$<?= number_format($subtotal ?? 0, 2) ?></span>
                        </div>
                        
                        <div class="total-row">
                            <span class="total-label">Tax</span>
                            <span class="total-value">$<?= number_format(($total ?? 0) - ($subtotal ?? 0), 2) ?></span>
                        </div>
                        
                        <div class="total-row-main">
                            <span class="total-label">Total</span>
                            <span class="total-value">$<?= number_format($total ?? 0, 2) ?></span>
                        </div>
                        
                        <?php if (!empty($payments)): ?>
                            <div class="total-row">
                                <span class="total-label">Paid</span>
                                <span class="total-value">$<?= number_format($payments_total ?? 0, 2) ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="total-row">
                            <span class="total-label fw-bold">Amount Due</span>
                            <span class="total-value text-primary-600">$<?= number_format($amount_due ?? $total ?? 0, 2) ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Section -->
                <div class="sidebar-section">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="section-title m-0">Payments</div>
                        <div id="remaining_amount" class="remaining-amount-text">Due: $<?= number_format($total ?? 0, 2) ?></div>
                    </div>
                    
                    <!-- Added Payments List -->
                    <div id="payments_list" class="payments-list-container">
                        <?php if (!empty($payments)): ?>
                            <?php foreach ($payments as $payment_id => $payment): ?>
                                <div class="payment-item">
                                    <div class="flex-1">
                                        <span class="payment-item-method"><?= esc($payment['payment_type']) ?></span>
                                        <span class="payment-item-amount">$<?= number_format($payment['payment_amount'], 2) ?></span>
                                    </div>
                                    <button type="button" class="remove-payment-btn text-danger text-decoration-none" title="Remove" onclick="removePayment('<?= base64url_encode($payment_id) ?>')">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Add Payment Form -->
                    <div class="add-payment-card">
                        <?= form_open("sales/addPayment", ['id' => 'add_payment_form']) ?>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-1">
                                <div class="position-relative">
                                    <span class="currency-symbol" id="payment_amount_symbol">$</span>
                                    <input type="number" 
                                           name="amount_tendered"
                                           id="payment_amount" 
                                           class="form-control payment-amount-input" 
                                           placeholder="Amount" 
                                           step="0.01" 
                                           value="<?= number_format($amount_due ?? $total ?? 0, 2, '.', '') ?>"
                                           required>
                                </div>
                            </div>
                            <div class="flex-1">
                                <select id="payment_method" name="payment_type" class="form-control payment-method-select" onchange="toggleGiftCardInput()">
                                    <?php foreach ($payment_options as $key => $value): ?>
                                        <option value="<?= esc($key) ?>" <?= ($key == ($selected_payment_type ?? '')) ? 'selected' : '' ?>><?= esc($value) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" id="add_payment_btn" class="btn btn-primary btn-sm whitespace-nowrap add-payment-btn">
                                + Add
                            </button>
                        </div>
                        <!-- Quick Amounts -->
                        <div class="d-flex gap-1" id="quick_amounts_row">
                            <button type="button" onclick="quickPaymentAmount('remaining')" class="btn btn-outline btn-xxs flex-1">Full</button>
                            <button type="button" onclick="quickPaymentAmount(50)" class="btn btn-outline btn-xxs flex-1">$50</button>
                            <button type="button" onclick="quickPaymentAmount(100)" class="btn btn-outline btn-xxs flex-1">$100</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <?= form_open("sales/complete", ['id' => 'complete_sale_form']) ?>
                    <button type="submit" class="btn btn-success btn-block" <?= empty($cart) ? 'disabled' : '' ?>>
                        <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="align-middle">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Complete Sale <span class="shortcut-badge shortcut-badge-inline">F4</span>
                    </button>
                    <?= form_close() ?>
                    
                    <button class="btn btn-outline btn-sm btn-block" onclick="addComment()">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        Add Note
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Item autocomplete
let itemAutocompleteTimeout;
const itemInput = document.getElementById('item');
const addItemForm = document.getElementById('add_item_form');

if (itemInput) {
    // Create autocomplete dropdown container
    const autocompleteContainer = document.createElement('div');
    autocompleteContainer.style.cssText = 'position: absolute; top: 100%; left: 0; right: 0; background: var(--bg-elevated); border: 1px solid var(--border-color); border-radius: var(--radius-lg); max-height: 300px; overflow-y: auto; z-index: 1000; display: none; box-shadow: var(--shadow-xl); margin-top: 4px;';
    itemInput.parentElement.style.position = 'relative';
    itemInput.parentElement.appendChild(autocompleteContainer);
    
    // Handle item input for autocomplete
    itemInput.addEventListener('input', function(e) {
        const query = e.target.value.trim();
        
        clearTimeout(itemAutocompleteTimeout);
        
        if (query.length < 2) {
            autocompleteContainer.style.display = 'none';
            return;
        }
        
        itemAutocompleteTimeout = setTimeout(() => {
            fetch('<?= base_url("sales/itemSearch") ?>?term=' + encodeURIComponent(query))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('HTTP error ' + response.status);
                    }
                    return response.text();
                })
                .then(text => {
                    try {
                        const data = JSON.parse(text);
                        if (data && data.length > 0) {
                            autocompleteContainer.innerHTML = data.map(item => `
                                <div class="autocomplete-item" data-value="${item.value}">
                                    ${item.label}
                                </div>
                            `).join('');
                            autocompleteContainer.style.display = 'block';
                            
                            // Add click handlers to autocomplete items
                            autocompleteContainer.querySelectorAll('.autocomplete-item').forEach(div => {
                                div.addEventListener('click', function() {
                                    itemInput.value = this.dataset.value;
                                    autocompleteContainer.style.display = 'none';
                                    addItemForm.submit();
                                });
                            });
                        } else {
                            autocompleteContainer.style.display = 'none';
                        }
                    } catch (e) {
                        console.error('JSON parse error:', e, 'Response:', text.substring(0, 200));
                        autocompleteContainer.style.display = 'none';
                    }
                })
                .catch(err => {
                    console.error('Item search error:', err);
                    autocompleteContainer.style.display = 'none';
                });
        }, 300);
    });
    
    // Close autocomplete when clicking outside
    document.addEventListener('click', function(e) {
        if (!itemInput.parentElement.contains(e.target)) {
            autocompleteContainer.style.display = 'none';
        }
    });
}

// Auto-submit on item search
if (addItemForm) {
    addItemForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const itemValue = itemInput?.value;
        if (itemValue && itemValue.trim()) {
            this.submit();
        }
    });
}

// Auto-submit on enter key
if (itemInput) {
    itemInput.addEventListener('keypress', function(e) {
        if (e.which === 13 || e.keyCode === 13) {
            addItemForm?.submit();
        }
    });
}

// Clear cart
function clearCart() {
    if (confirm('Clear all items from cart?')) {
        window.shopsuiteApp.postAction('<?= base_url("sales/cancel") ?>')
            .then(() => window.location.reload())
            .catch(err => console.error('Error clearing cart:', err));
    }
}

function removeCartItem(line) {
    if (!confirm('Remove this item?')) {
        return;
    }

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

// Suspend sale
function suspendSale() {
    const cartItems = document.querySelectorAll('.cart-item');
    if (cartItems.length === 0) {
        alert('Cannot suspend an empty sale. Please add items first.');
        return;
    }
    
    if (!confirm('Suspend this sale?')) {
        return;
    }
    
    window.shopsuiteApp.postAction('<?= base_url("sales/suspend") ?>')
    .then(() => {
        window.location.href = '<?= base_url("sales") ?>';
    })
    .catch(err => {
        console.error('Error suspending sale:', err);
        alert('Error suspending sale. Please try again.');
    });
}

// Change mode
function changeMode(mode) {
    document.getElementById('mode_input').value = mode;
    document.getElementById('mode_form').submit();
}

// Add comment
function addComment() {
    const comment = prompt('Add a note to this sale:', '<?= esc($comment ?? '') ?>');
    if (comment !== null) {
        fetch('<?= base_url("sales/setComment") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'comment=' + encodeURIComponent(comment)
        }).then(() => {
            console.log('Comment saved');
        }).catch(err => {
            console.error('Error saving comment:', err);
        });
    }
}

// Edit cart item
function editCartItem(line) {
    if (window.shopsuiteApp) {
        const modalHtml = `
            <form id="edit_item_form" class="edit-item-form">
                <div class="form-group">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="edit_quantity" name="quantity" min="0.01" step="0.01" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Price</label>
                    <input type="number" class="form-control" id="edit_price" name="price" min="0" step="0.01" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Discount (%)</label>
                    <input type="number" class="form-control" id="edit_discount" name="discount" min="0" max="100" step="0.01" value="0">
                </div>
                <div class="d-flex gap-2 edit-item-buttons">
                    <button type="submit" class="btn btn-primary flex-1">Save Changes</button>
                    <button type="button" class="btn btn-outline flex-1" onclick="window.shopsuiteApp.hideModal()">Cancel</button>
                </div>
            </form>
        `;
        
        window.shopsuiteApp.showModal('Edit Item', modalHtml);
        
        setTimeout(() => {
            document.getElementById('edit_item_form')?.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                
                fetch('<?= base_url("sales/editItem") ?>/' + line, {
                    method: 'POST',
                    body: formData
                }).then(() => {
                    window.location.reload();
                });
            });
        }, 100);
    } else {
        window.location.href = '<?= base_url("sales") ?>';
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'F1') {
        e.preventDefault();
        window.location.href = '<?= base_url("sales/salesKeyboardHelp") ?>';
    }
    else if (e.key === 'F2') {
        e.preventDefault();
        suspendSale();
    }
    else if (e.key === 'F4') {
        e.preventDefault();
        document.getElementById('complete_sale_form')?.submit();
    }
    else if (e.key === 'Escape') {
        e.preventDefault();
        clearCart();
    }
});

// Customer autocomplete
let customerAutocompleteTimeout;
const customerInput = document.getElementById('customer_search_input');

if (customerInput) {
    const customerAutocompleteContainer = document.createElement('div');
    customerAutocompleteContainer.style.cssText = 'position: absolute; top: 100%; left: 0; right: 0; background: var(--bg-elevated); border: 1px solid var(--border-color); border-radius: var(--radius-lg); max-height: 240px; overflow-y: auto; z-index: 1000; display: none; box-shadow: var(--shadow-xl); margin-top: 4px;';
    customerInput.parentElement.appendChild(customerAutocompleteContainer);
    
    customerInput.addEventListener('input', function(e) {
        const query = e.target.value.trim();
        
        clearTimeout(customerAutocompleteTimeout);
        
        if (query.length < 2) {
            customerAutocompleteContainer.style.display = 'none';
            return;
        }
        
        customerAutocompleteTimeout = setTimeout(() => {
            fetch('<?= base_url("customers/suggest") ?>?term=' + encodeURIComponent(query))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('HTTP error ' + response.status);
                    }
                    return response.text();
                })
                .then(text => {
                    try {
                        const data = JSON.parse(text);
                        if (data && data.length > 0) {
                            customerAutocompleteContainer.innerHTML = data.map(customer => `
                                <div class="autocomplete-item" data-customer-id="${customer.value}">
                                    <div class="fw-semibold">${customer.label}</div>
                                </div>
                            `).join('');
                            customerAutocompleteContainer.style.display = 'block';
                            
                            customerAutocompleteContainer.querySelectorAll('.autocomplete-item').forEach(div => {
                                div.addEventListener('click', function() {
                                    const customerId = this.dataset.customerId;
                                    window.location.href = '<?= base_url("sales/selectCustomer") ?>?customer=' + customerId;
                                });
                            });
                        } else {
                            customerAutocompleteContainer.innerHTML = '<div class="p-4 text-center text-tertiary">No customers found</div>';
                            customerAutocompleteContainer.style.display = 'block';
                        }
                    } catch (e) {
                        console.error('Customer search JSON parse error:', e);
                        customerAutocompleteContainer.style.display = 'none';
                    }
                })
                .catch(err => {
                    console.error('Customer search error:', err);
                    customerAutocompleteContainer.style.display = 'none';
                });
        }, 300);
    });
    
    document.addEventListener('click', function(e) {
        if (!customerInput.parentElement.contains(e.target)) {
            customerAutocompleteContainer.style.display = 'none';
        }
    });
}

// Quick Add Customer Modal
function quickAddCustomer() {
    const backdrop = document.createElement('div');
    backdrop.id = 'customer_modal_backdrop';
    backdrop.className = 'modal-backdrop';
    
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.style.maxWidth = '480px';
    
    modal.innerHTML = `
        <div class="modal-header">
            <h3 class="modal-title">New Customer</h3>
            <button class="modal-close" onclick="closeCustomerModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <form id="quick_customer_form">
                <div class="form-group">
                    <label class="form-label">First Name *</label>
                    <input type="text" class="form-control" id="quick_first_name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name *</label>
                    <input type="text" class="form-control" id="quick_last_name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" id="quick_phone">
                </div>
                <div class="d-flex gap-2 quick-customer-buttons">
                    <button type="button" class="btn btn-outline flex-1" onclick="closeCustomerModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary flex-1">Add Customer</button>
                </div>
            </form>
        </div>
    `;
    
    backdrop.appendChild(modal);
    document.body.appendChild(backdrop);
    
    backdrop.addEventListener('click', function(e) {
        if (e.target === backdrop) {
            closeCustomerModal();
        }
    });
    
    setTimeout(() => {
        document.getElementById('quick_first_name')?.focus();
    }, 100);
    
    const form = document.getElementById('quick_customer_form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData();
        formData.append('first_name', document.getElementById('quick_first_name').value);
        formData.append('last_name', document.getElementById('quick_last_name').value);
        formData.append('email', '');
        formData.append('phone_number', document.getElementById('quick_phone').value);
        formData.append('tax_id', '');
        
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Adding...';
        
        fetch('<?= base_url("customers/save/-1") ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeCustomerModal();
                window.location.href = '<?= base_url("sales/selectCustomer") ?>?customer=' + data.id;
            } else {
                alert('Error: ' + data.message);
                submitBtn.disabled = false;
                submitBtn.textContent = 'Add Customer';
            }
        })
        .catch(error => {
            console.error('Error adding customer:', error);
            alert('Failed to add customer. Please try again.');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Add Customer';
        });
    });
}

function closeCustomerModal() {
    const backdrop = document.getElementById('customer_modal_backdrop');
    if (backdrop) {
        backdrop.remove();
    }
}

// Handled via PHP now

function getRemainingAmount() {
    return <?= (float)($amount_due ?? $total ?? 0) ?>;
}

function quickPaymentAmount(value) {
    let amount;
    if (value === 'remaining') {
        amount = getRemainingAmount();
    } else {
        amount = parseFloat(value);
    }
    document.getElementById('payment_amount').value = amount.toFixed(2);
    document.getElementById('payment_amount').focus();
}

function toggleGiftCardInput() {
    const isGiftCard = document.getElementById('payment_method').value === '<?= lang('Sales.giftcard') ?>';
    const amountInput = document.getElementById('payment_amount');
    const symbol = document.getElementById('payment_amount_symbol');
    const quickAmounts = document.getElementById('quick_amounts_row');
    
    if (isGiftCard) {
        amountInput.type = 'text';
        amountInput.placeholder = 'Gift Card Number';
        amountInput.removeAttribute('step');
        amountInput.removeAttribute('min');
        amountInput.value = '';
        if (symbol) symbol.style.display = 'none';
        if (quickAmounts) quickAmounts.style.display = 'none';
    } else {
        amountInput.type = 'number';
        amountInput.placeholder = 'Amount';
        amountInput.step = '0.01';
        amountInput.min = '0.01';
        amountInput.value = getRemainingAmount().toFixed(2);
        if (symbol) symbol.style.display = 'inline-block';
        if (quickAmounts) quickAmounts.style.display = 'flex';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('add_payment_form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('add_payment_btn');
            const ogText = btn.innerHTML;
            btn.innerHTML = '...';
            btn.disabled = true;
            
            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(() => {
                window.location.reload();
            })
            .catch(err => {
                console.error('Error adding payment:', err);
                btn.innerHTML = ogText;
                btn.disabled = false;
            });
        });
    }
});

// Before form submit logic check
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('complete_sale_form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const hasPayments = document.querySelectorAll('.payment-item').length > 0;
            const remaining = getRemainingAmount();
            
            if (remaining > 0 && !hasPayments && <?= (int)$cash_mode ?> !== 1) {
                // Cash_mode = 0 means they haven't explicitly set full amount as cash fallback
                // For modern we allow it if they proceed, but maybe warn them
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
});

// Focus search on load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('item')?.focus();
    toggleGiftCardInput();
});
</script>

<?php echo view('layouts/modern_footer'); ?>
