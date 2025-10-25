<?php
$title = 'Sales Register - ShopSuite';
echo view('layouts/modern_header', ['title' => $title, 'extra_css' => ['css/pos-compact.css']]);
?>

<div class="pos-wrapper">
    <!-- Main POS Area -->
    <div class="pos-main">
        <!-- Header -->
        <div class="pos-header">
            <div style="display: flex; align-items: center; gap: var(--space-4);">
                <div class="pos-logo">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    POS Register
                </div>
                <?= form_open("sales/changeMode", ['id' => 'mode_form']) ?>
                <input type="hidden" name="mode" id="mode_input" value="<?= $mode ?? 'sale' ?>">
                <?= form_close() ?>
                
                <div class="mode-buttons">
                    <button class="mode-btn <?= ($mode ?? 'sale') == 'sale' ? 'active' : '' ?>" onclick="changeMode('sale')">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Sale
                    </button>
                    <button class="mode-btn <?= ($mode ?? '') == 'return' ? 'active' : '' ?>" onclick="changeMode('return')">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                        </svg>
                        Return
                    </button>
                    <button class="mode-btn <?= ($mode ?? '') == 'sale_invoice' ? 'active' : '' ?>" onclick="changeMode('sale_invoice')">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Invoice
                    </button>
                    <button class="mode-btn <?= ($mode ?? '') == 'sale_quote' ? 'active' : '' ?>" onclick="changeMode('sale_quote')">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Quote
                    </button>
                    <button class="mode-btn <?= ($mode ?? '') == 'sale_work_order' ? 'active' : '' ?>" onclick="changeMode('sale_work_order')">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Work Order
                    </button>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; gap: var(--space-2);">
                <button class="btn btn-ghost btn-sm" onclick="window.location.href='<?= base_url('sales/returnExchange') ?>'">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                    Return
                </button>
                <button class="btn btn-ghost btn-sm" onclick="window.location.href='<?= base_url('sales/suspended') ?>'">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Suspended
                </button>
                <button class="btn btn-ghost btn-sm" onclick="window.location.href='<?= base_url('sales/manage') ?>'">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <div>Clear</div>
                            <span class="shortcut-badge">ESC</span>
                        </div>
                        <div class="quick-action" onclick="suspendSale()">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>Hold</div>
                            <span class="shortcut-badge">F2</span>
                        </div>
                        <div class="quick-action" onclick="window.location.href='<?= base_url('sales/salesKeyboardHelp') ?>'">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <h3 style="margin: 0; font-size: var(--text-base); font-weight: var(--font-semibold); display: flex; align-items: center; gap: var(--space-2);">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Cart <span style="color: var(--text-tertiary); font-weight: normal; font-size: var(--text-sm);">(<?= count($cart ?? []) ?> items)</span>
                        </h3>
                    </div>
                    
                    <div class="cart-items">
                        <?php if (empty($cart)): ?>
                            <div class="empty-cart">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <div style="font-size: var(--text-lg); font-weight: var(--font-semibold); margin-bottom: var(--space-2);">Cart is Empty</div>
                                <div style="font-size: var(--text-sm);">Scan or search for products to add</div>
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
                                            <span>@</span>
                                            <span>$<?= number_format($item['price'], 2) ?></span>
                                        </div>
                                        <a href="<?= base_url("sales/deleteItem/$line") ?>" class="btn btn-ghost btn-sm" onclick="event.stopPropagation(); return confirm('Remove this item?');">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </a>
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
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 10px; background: #f0f9ff; border-radius: 6px; border: 1px solid #bae6fd; margin-bottom: 8px;">
                            <div>
                                <div style="font-weight: 600; color: #0369a1; font-size: 13px;"><?= esc($customer ?? 'Customer') ?></div>
                                <div style="font-size: 11px; color: #0891b2;">ID: <?= esc($customer_id) ?></div>
                            </div>
                            <a href="<?= base_url('sales/removeCustomer') ?>" class="btn btn-ghost btn-sm">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        </div>
                    <?php else: ?>
                        <div style="margin-bottom: 8px;">
                            <div style="display: flex; align-items: center; padding: 6px 8px; background: #f9fafb; border-radius: 6px; border: 1px dashed #d1d5db;">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 6px; color: #9ca3af;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span style="color: #9ca3af; font-size: 12px;">Walk-in</span>
                            </div>
                        </div>
                        
                        <!-- Customer Search Input -->
                        <div style="position: relative; margin-bottom: 6px;">
                            <input type="text" 
                                   id="customer_search_input" 
                                   class="form-control" 
                                   placeholder="Search customer..." 
                                   autocomplete="off"
                                   style="font-size: 12px; padding: 6px 8px 6px 32px;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                                 style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #9ca3af;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <div id="customer_autocomplete" style="display: none;"></div>
                        </div>
                        
                        <!-- New Customer Button -->
                        <button type="button" class="btn btn-outline btn-sm btn-block" onclick="quickAddCustomer()" style="font-size: 12px; padding: 6px 10px;">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 4px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New
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
                                <span class="total-value">$<?= number_format($amount_tendered ?? 0, 2) ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="total-row">
                            <span class="total-label" style="font-weight: var(--font-bold);">Amount Due</span>
                            <span class="total-value" style="color: var(--primary-600);">$<?= number_format($amount_due ?? $total ?? 0, 2) ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Section -->
                <div class="sidebar-section" style="margin-top: var(--space-3);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-2);">
                        <div class="section-title" style="margin: 0; font-size: var(--text-base);">Payments</div>
                        <div id="remaining_amount" style="font-size: var(--text-xs); font-weight: var(--font-bold); color: var(--danger);">Due: $<?= number_format($total ?? 0, 2) ?></div>
                    </div>
                    
                    <!-- Added Payments List -->
                    <div id="payments_list" style="margin-bottom: var(--space-2); max-height: 80px; overflow-y: auto;"></div>
                    
                    <!-- Add Payment Form -->
                    <div style="padding: var(--space-2); background: var(--bg-secondary); border-radius: var(--radius-md); margin-bottom: var(--space-2);">
                        <div style="display: flex; gap: var(--space-2); margin-bottom: var(--space-2);">
                            <div style="flex: 1;">
                                <div style="position: relative;">
                                    <span style="position: absolute; left: var(--space-2); top: 50%; transform: translateY(-50%); color: var(--text-tertiary); font-weight: var(--font-semibold); font-size: var(--text-xs);">$</span>
                                    <input type="number" 
                                           id="payment_amount" 
                                           class="form-control" 
                                           placeholder="Amount" 
                                           step="0.01" 
                                           min="0.01"
                                           style="padding-left: var(--space-5); font-size: var(--text-xs); padding-top: var(--space-1); padding-bottom: var(--space-1);">
                                </div>
                            </div>
                            <div style="flex: 1;">
                                <select id="payment_method" class="form-control" style="font-size: var(--text-xs); padding-top: var(--space-1); padding-bottom: var(--space-1);">
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="Mobile">Mobile</option>
                                </select>
                            </div>
                            <button type="button" onclick="addPayment()" class="btn btn-primary btn-sm" style="font-size: var(--text-xs); padding: var(--space-1) var(--space-2); white-space: nowrap;">
                                + Add
                            </button>
                        </div>
                        <!-- Quick Amounts -->
                        <div style="display: flex; gap: var(--space-1);">
                            <button type="button" onclick="quickPaymentAmount('remaining')" class="btn btn-outline" style="flex: 1; font-size: 10px; padding: 4px;">Full</button>
                            <button type="button" onclick="quickPaymentAmount(50)" class="btn btn-outline" style="flex: 1; font-size: 10px; padding: 4px;">$50</button>
                            <button type="button" onclick="quickPaymentAmount(100)" class="btn btn-outline" style="flex: 1; font-size: 10px; padding: 4px;">$100</button>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <?= form_open("sales/complete", ['id' => 'complete_sale_form']) ?>
                    <input type="hidden" name="payment_type" id="payment_type" value="cash">
                    <input type="hidden" name="amount_tendered" id="amount_tendered" value="<?= $total ?? 0 ?>">
                    <button type="submit" class="btn btn-success btn-xl btn-block" <?= empty($cart) ? 'disabled' : '' ?>>
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: var(--space-2);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Complete Sale <span class="shortcut-badge">F4</span>
                    </button>
                    <?= form_close() ?>
                    
                    <button class="btn btn-outline btn-sm btn-block" onclick="addComment()" style="font-size: 12px;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 4px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        Note
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
    autocompleteContainer.style.cssText = 'position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid var(--border-primary); border-radius: var(--radius-md); max-height: 300px; overflow-y: auto; z-index: 1000; display: none; box-shadow: var(--shadow-lg);';
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
                                <div class="autocomplete-item" 
                                     data-value="${item.value}" 
                                     style="padding: var(--space-3); border-bottom: 1px solid var(--border-primary); cursor: pointer; transition: background var(--transition-fast);">
                                    ${item.label}
                                </div>
                            `).join('');
                            autocompleteContainer.style.display = 'block';
                            
                            // Add click handlers to autocomplete items
                            autocompleteContainer.querySelectorAll('.autocomplete-item').forEach(div => {
                                div.addEventListener('mouseenter', function() {
                                    this.style.background = 'var(--bg-secondary)';
                                });
                                div.addEventListener('mouseleave', function() {
                                    this.style.background = 'white';
                                });
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
        window.location.href = '<?= base_url("sales/cancel") ?>';
    }
}

// Suspend sale
function suspendSale() {
    // Check if cart has items
    const cartItems = document.querySelectorAll('.cart-item');
    if (cartItems.length === 0) {
        alert('Cannot suspend an empty sale. Please add items first.');
        return;
    }
    
    // Confirm suspension
    if (!confirm('Suspend this sale?')) {
        return;
    }
    
    // Suspend the sale
    fetch('<?= base_url("sales/suspend") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    })
    .then(response => response.text())
    .then(() => {
        // Reload to get fresh POS
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

// Select customer modal
function selectCustomer() {
    if (window.shopsuiteApp) {
        const modalHtml = `
            <div style="padding: var(--space-4);">
                <div class="form-group">
                    <label class="form-label">Search Customer</label>
                    <input type="text" 
                           class="form-control" 
                           id="customer_search" 
                           placeholder="Search by name, phone, or email..."
                           autocomplete="off">
                </div>
                <div id="customer_results" style="max-height: 300px; overflow-y: auto; margin-top: var(--space-3);"></div>
                <div style="margin-top: var(--space-4);">
                    <a href="<?= base_url('customers/view/-1') ?>" class="btn btn-outline btn-sm" target="_blank">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Customer
                    </a>
                </div>
            </div>
        `;
        
        window.shopsuiteApp.showModal('Select Customer', modalHtml);
        
        // Add search functionality
        setTimeout(() => {
            const searchInput = document.getElementById('customer_search');
            if (searchInput) {
                searchInput.focus();
                let searchTimeout;
                
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value;
                    
                    if (query.length < 2) {
                        document.getElementById('customer_results').innerHTML = '';
                        return;
                    }
                    
                    searchTimeout = setTimeout(() => {
                        // Make AJAX call to search customers
                        fetch('<?= base_url("customers/suggest") ?>?term=' + encodeURIComponent(query))
                            .then(response => response.json())
                            .then(data => {
                                const resultsDiv = document.getElementById('customer_results');
                                if (data.length === 0) {
                                    resultsDiv.innerHTML = '<div style="padding: var(--space-4); text-align: center; color: var(--text-tertiary);">No customers found</div>';
                                } else {
                                    resultsDiv.innerHTML = data.map(customer => `
                                        <div class="customer-result-item" 
                                             onclick="window.location.href='<?= base_url('sales/selectCustomer') ?>?customer=' + ${customer.person_id}"
                                             style="padding: var(--space-3); border-bottom: 1px solid var(--border-primary); cursor: pointer; transition: background var(--transition-fast);">
                                            <div style="font-weight: var(--font-semibold);">${customer.name}</div>
                                            <div style="font-size: var(--text-sm); color: var(--text-secondary);">
                                                ${customer.email || ''} ${customer.phone_number || ''}
                                            </div>
                                        </div>
                                    `).join('');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }, 300);
                });
            }
        }, 100);
    } else {
        // Fallback without modal
        const customerName = prompt('Enter customer name to search:');
        if (customerName) {
            window.location.href = '<?= base_url("customers") ?>';
        }
    }
}

// Edit cart item
function editCartItem(line) {
    if (window.shopsuiteApp) {
        const modalHtml = `
            <form id="edit_item_form" style="padding: var(--space-4);">
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
                <div style="display: flex; gap: var(--space-2); margin-top: var(--space-4);">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-outline" onclick="window.shopsuiteApp.hideModal()">Cancel</button>
                </div>
            </form>
        `;
        
        window.shopsuiteApp.showModal('Edit Item', modalHtml);
        
        // Handle form submission
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
    // F1 - Help
    if (e.key === 'F1') {
        e.preventDefault();
        window.location.href = '<?= base_url("sales/salesKeyboardHelp") ?>';
    }
    // F2 - Suspend
    else if (e.key === 'F2') {
        e.preventDefault();
        suspendSale();
    }
    // F4 - Payment
    else if (e.key === 'F4') {
        e.preventDefault();
        document.getElementById('complete_sale_form')?.submit();
    }
    // ESC - Clear
    else if (e.key === 'Escape') {
        e.preventDefault();
        clearCart();
    }
});

// Customer autocomplete
let customerAutocompleteTimeout;
const customerInput = document.getElementById('customer_search_input');

if (customerInput) {
    // Create autocomplete dropdown container
    const customerAutocompleteContainer = document.createElement('div');
    customerAutocompleteContainer.style.cssText = 'position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid var(--border-primary); border-radius: var(--radius-md); max-height: 300px; overflow-y: auto; z-index: 1000; display: none; box-shadow: var(--shadow-lg); margin-top: 4px;';
    customerInput.parentElement.appendChild(customerAutocompleteContainer);
    
    // Handle customer input for autocomplete
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
                                <div class="autocomplete-item" 
                                     data-customer-id="${customer.value}" 
                                     style="padding: var(--space-3); border-bottom: 1px solid var(--border-primary); cursor: pointer; transition: background var(--transition-fast);">
                                    <div style="font-weight: var(--font-semibold);">${customer.label}</div>
                                </div>
                            `).join('');
                            customerAutocompleteContainer.style.display = 'block';
                            
                            // Add click handlers to autocomplete items
                            customerAutocompleteContainer.querySelectorAll('.autocomplete-item').forEach(div => {
                                div.addEventListener('mouseenter', function() {
                                    this.style.background = 'var(--bg-secondary)';
                                });
                                div.addEventListener('mouseleave', function() {
                                    this.style.background = 'white';
                                });
                                div.addEventListener('click', function() {
                                    const customerId = this.dataset.customerId;
                                    window.location.href = '<?= base_url("sales/selectCustomer") ?>?customer=' + customerId;
                                });
                            });
                        } else {
                            customerAutocompleteContainer.innerHTML = '<div style="padding: var(--space-4); text-align: center; color: var(--text-tertiary);">No customers found</div>';
                            customerAutocompleteContainer.style.display = 'block';
                        }
                    } catch (e) {
                        console.error('Customer search JSON parse error:', e, 'Response:', text.substring(0, 200));
                        customerAutocompleteContainer.style.display = 'none';
                    }
                })
                .catch(err => {
                    console.error('Customer search error:', err);
                    customerAutocompleteContainer.style.display = 'none';
                });
        }, 300);
    });
    
    // Close autocomplete when clicking outside
    document.addEventListener('click', function(e) {
        if (!customerInput.parentElement.contains(e.target)) {
            customerAutocompleteContainer.style.display = 'none';
        }
    });
}

// Quick Add Customer Modal
function quickAddCustomer() {
    // Create modal backdrop
    const backdrop = document.createElement('div');
    backdrop.id = 'customer_modal_backdrop';
    backdrop.style.cssText = 'position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;';
    
    // Create modal
    const modal = document.createElement('div');
    modal.style.cssText = 'background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-xl); max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto;';
    
    modal.innerHTML = `
        <div style="padding: var(--space-4); border-bottom: 1px solid var(--border-primary);">
            <h3 style="margin: 0; font-size: var(--text-xl); font-weight: var(--font-semibold);">New Customer</h3>
        </div>
        <div style="padding: var(--space-4);">
            <form id="quick_customer_form">
                <div class="form-group" style="margin-bottom: var(--space-3);">
                    <label class="form-label" style="display: block; margin-bottom: var(--space-2); font-weight: var(--font-medium);">First Name *</label>
                    <input type="text" class="form-control" id="quick_first_name" required style="width: 100%;">
                </div>
                
                <div class="form-group" style="margin-bottom: var(--space-3);">
                    <label class="form-label" style="display: block; margin-bottom: var(--space-2); font-weight: var(--font-medium);">Last Name *</label>
                    <input type="text" class="form-control" id="quick_last_name" required style="width: 100%;">
                </div>
                
                <div class="form-group" style="margin-bottom: var(--space-3);">
                    <label class="form-label" style="display: block; margin-bottom: var(--space-2); font-weight: var(--font-medium);">Phone</label>
                    <input type="text" class="form-control" id="quick_phone" style="width: 100%;">
                </div>
                
                <div style="display: flex; gap: var(--space-2); margin-top: var(--space-4);">
                    <button type="button" class="btn btn-outline" onclick="closeCustomerModal()" style="flex: 1;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Add Customer</button>
                </div>
            </form>
        </div>
    `;
    
    backdrop.appendChild(modal);
    document.body.appendChild(backdrop);
    
    // Close on backdrop click
    backdrop.addEventListener('click', function(e) {
        if (e.target === backdrop) {
            closeCustomerModal();
        }
    });
    
    // Focus first field
    setTimeout(() => {
        document.getElementById('quick_first_name')?.focus();
    }, 100);
    
    // Handle form submission
    const form = document.getElementById('quick_customer_form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData();
        formData.append('first_name', document.getElementById('quick_first_name').value);
        formData.append('last_name', document.getElementById('quick_last_name').value);
        formData.append('email', '');
        formData.append('phone_number', document.getElementById('quick_phone').value);
        formData.append('tax_id', '');
        
        // Disable submit button
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
                // Close modal and select the new customer
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

// Multi-payment system
let payments = [];
let saleTotal = 0;

// Add payment
function addPayment() {
    const amount = parseFloat(document.getElementById('payment_amount').value);
    const method = document.getElementById('payment_method').value;
    
    if (!amount || amount <= 0) {
        alert('Please enter a valid payment amount');
        return;
    }
    
    const remaining = getRemainingAmount();
    if (amount > remaining) {
        if (!confirm(`Payment amount ($${amount.toFixed(2)}) exceeds remaining balance ($${remaining.toFixed(2)}). Continue?`)) {
            return;
        }
    }
    
    payments.push({ method, amount });
    
    // Clear inputs
    document.getElementById('payment_amount').value = '';
    document.getElementById('payment_method').selectedIndex = 0;
    
    updatePaymentsList();
    updateRemainingAmount();
}

// Remove payment
function removePayment(index) {
    payments.splice(index, 1);
    updatePaymentsList();
    updateRemainingAmount();
}

// Update payments list display
function updatePaymentsList() {
    const listEl = document.getElementById('payments_list');
    
    if (payments.length === 0) {
        listEl.innerHTML = '';
        return;
    }
    
    listEl.innerHTML = payments.map((payment, index) => `
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 6px 8px; background: white; border: 1px solid var(--border-primary); border-radius: 4px; margin-bottom: 4px;">
            <div style="flex: 1;">
                <span style="font-size: 11px; color: var(--text-secondary);">${payment.method}</span>
                <span style="font-size: 13px; font-weight: var(--font-bold); color: var(--success); margin-left: 8px;">$${payment.amount.toFixed(2)}</span>
            </div>
            <button type="button" onclick="removePayment(${index})" style="background: none; border: none; color: var(--danger); cursor: pointer; padding: 2px;" title="Remove">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `).join('');
}

// Get total of all payments
function getTotalPayments() {
    return payments.reduce((sum, p) => sum + p.amount, 0);
}

// Get remaining amount to pay
function getRemainingAmount() {
    const totalEl = document.querySelector('.total-value[style*="color"]');
    if (!totalEl) return 0;
    
    saleTotal = parseFloat(totalEl.textContent.replace('$', '').replace(',', '')) || 0;
    const paid = getTotalPayments();
    return Math.max(0, saleTotal - paid);
}

// Update remaining amount display
function updateRemainingAmount() {
    const remaining = getRemainingAmount();
    const el = document.getElementById('remaining_amount');
    
    if (remaining > 0) {
        el.textContent = `Due: $${remaining.toFixed(2)}`;
        el.style.color = 'var(--danger)';
    } else if (remaining === 0) {
        el.textContent = 'Paid in Full';
        el.style.color = 'var(--success)';
    } else {
        el.textContent = `Change: $${Math.abs(remaining).toFixed(2)}`;
        el.style.color = 'var(--success)';
    }
}

// Quick payment amount
function quickPaymentAmount(value) {
    const remaining = getRemainingAmount();
    let amount;
    
    if (value === 'remaining') {
        amount = remaining;
    } else {
        amount = value;
    }
    
    document.getElementById('payment_amount').value = amount.toFixed(2);
    document.getElementById('payment_amount').focus();
}

// Before form submit, add payments to form
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('complete_sale_form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (payments.length === 0) {
                e.preventDefault();
                alert('Please add at least one payment method');
                return false;
            }
            
            const remaining = getRemainingAmount();
            if (remaining > 0) {
                e.preventDefault();
                if (!confirm(`There is still $${remaining.toFixed(2)} remaining. Complete sale anyway?`)) {
                    return false;
                }
            }
            
            // Remove existing payment inputs
            form.querySelectorAll('input[name^="payment"]').forEach(el => el.remove());
            
            // Add payment data to form
            payments.forEach((payment, index) => {
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = `payment_${index}_type`;
                methodInput.value = payment.method;
                form.appendChild(methodInput);
                
                const amountInput = document.createElement('input');
                amountInput.type = 'hidden';
                amountInput.name = `payment_${index}_amount`;
                amountInput.value = payment.amount.toFixed(2);
                form.appendChild(amountInput);
            });
        });
    }
});

// Focus search on load and initialize payments
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('item')?.focus();
    updatePaymentsList();
    updateRemainingAmount();
});
</script>

<?php echo view('layouts/modern_footer'); ?>
