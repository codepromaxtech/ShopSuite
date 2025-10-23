<?php
/**
 * MODERN POS REGISTER - Bootstrap 5
 * Complete redesign with modern features
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Sales.register'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Load Modern POS Styles -->
<link rel="stylesheet" href="<?= base_url('css/modern-pos.css') ?>">

<!-- MODERN POS REGISTER - Version 2025 -->
<script>console.log('✅ MODERN POS REGISTER LOADED - v2025');</script>

<div class="pos-container">
    <!-- LEFT SECTION: Scanner, Actions & Cart -->
    <div class="pos-left">
        <!-- Scanner Section -->
        <div class="scanner-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 fw-bold">
                    <i class="bi bi-upc-scan me-2"></i>Scan or Search Product
                </h4>
                <div class="text-end">
                    <span class="mode-badge"><?= esc($mode_label ?? 'Sale') ?></span>
                </div>
            </div>
            
            <div class="position-relative">
                <input type="text" 
                       id="barcode_scanner" 
                       class="form-control scanner-input" 
                       placeholder="🔍 Scan barcode or type product name..." 
                       autocomplete="off"
                       autofocus>
            </div>
            
            <div id="search_results" class="mt-3" style="display: none;">
                <!-- Search results populate here -->
            </div>
        </div>
        
        <!-- Quick Actions Bar -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="quick-actions">
                    <button class="btn btn-outline-primary quick-action-btn" onclick="openChangeMode()">
                        <i class="bi bi-arrow-repeat me-1"></i>Mode
                    </button>
                    <button class="btn btn-outline-info quick-action-btn" onclick="openSuspended()">
                        <i class="bi bi-pause-circle me-1"></i>Suspended
                    </button>
                    <button class="btn btn-outline-secondary quick-action-btn" onclick="openHistory()">
                        <i class="bi bi-clock-history me-1"></i>History
                    </button>
                    <button class="btn btn-outline-danger quick-action-btn" onclick="clearCart()">
                        <i class="bi bi-trash me-1"></i>Clear <span class="shortcut-badge">ESC</span>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Cart Items -->
        <div class="card border-0 shadow-sm flex-fill">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-cart3 me-2 text-primary"></i>Shopping Cart
                        <span class="badge bg-primary ms-2" id="cart_count">0</span>
                    </h5>
                    <div>
                        <span class="text-muted small">Items: </span>
                        <span class="fw-bold text-primary" id="total_items">0</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="cart-items" id="cart_items">
                    <!-- Empty state -->
                    <div class="empty-cart-state" id="empty_cart">
                        <i class="bi bi-cart-x"></i>
                        <p class="mt-3 fw-semibold">Cart is empty</p>
                        <p class="small">Scan or search for products to add</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- RIGHT SECTION: Customer, Totals, Payment -->
    <div class="pos-right">
        <!-- Customer Section -->
        <div class="customer-section">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-person-circle me-2 text-primary"></i>Customer
            </h6>
            <div class="input-group mb-2">
                <input type="text" 
                       id="customer_search" 
                       class="form-control" 
                       placeholder="Search customer..."
                       value="<?= esc($customer_name ?? 'Walk-in Customer') ?>"
                       readonly>
                <button class="btn btn-outline-primary" type="button" onclick="selectCustomer()" title="Search Customer">
                    <i class="bi bi-search"></i>
                </button>
                <button class="btn btn-outline-success" type="button" onclick="addNewCustomer()" title="Add New Customer">
                    <i class="bi bi-person-plus"></i>
                </button>
            </div>
            <input type="hidden" id="customer_id" value="<?= esc($customer_id ?? -1) ?>">
            
            <!-- Customer info display -->
            <div id="customer_info" class="customer-info-display" style="display: none;">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Account Balance:</span>
                    <span class="fw-bold" id="customer_balance">$0.00</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted small">Discount:</span>
                    <span class="text-success fw-bold" id="customer_discount">0%</span>
                </div>
            </div>
        </div>
        
        <!-- Totals Section -->
        <div class="totals-section">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-calculator me-2 text-primary"></i>Order Summary
            </h6>
            
            <div class="total-line">
                <span class="label">Subtotal</span>
                <span class="value" id="subtotal">$0.00</span>
            </div>
            
            <div class="total-line">
                <span class="label">
                    Tax <small class="text-muted" id="tax_rate">(<?= number_format(($config['tax_rate'] ?? 0) * 100, 1) ?>%)</small>
                </span>
                <span class="value" id="tax_amount">$0.00</span>
            </div>
            
            <div class="total-line" id="discount_line" style="display: none;">
                <span class="label text-success">
                    Discount <small class="text-muted" id="discount_percent"></small>
                </span>
                <span class="value text-success" id="discount_amount">-$0.00</span>
            </div>
            
            <div class="total-line grand-total">
                <span>TOTAL</span>
                <span id="grand_total">$0.00</span>
            </div>
            
            <!-- Additional Options -->
            <div class="mt-3 pt-3 border-top">
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="print_receipt" checked>
                            <label class="form-check-label small" for="print_receipt">
                                <i class="bi bi-printer me-1"></i>Print Receipt
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="email_receipt">
                            <label class="form-check-label small" for="email_receipt">
                                <i class="bi bi-envelope me-1"></i>Email Receipt
                            </label>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="form-label small fw-semibold">Comment/Notes (Optional)</label>
                    <textarea class="form-control" id="sale_comment" rows="2" placeholder="Add note to sale..."></textarea>
                </div>
            </div>
        </div>
        
        <!-- Payment Buttons -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-credit-card me-2 text-primary"></i>Complete Payment
                </h6>
                
                <div class="payment-grid">
                    <button class="payment-btn btn btn-success" onclick="processCash()" id="btn_cash">
                        <i class="bi bi-cash-coin me-2"></i>Cash
                        <span class="shortcut-badge">F1</span>
                    </button>
                    
                    <button class="payment-btn btn btn-primary" onclick="processCard()" id="btn_card">
                        <i class="bi bi-credit-card me-2"></i>Card
                        <span class="shortcut-badge">F2</span>
                    </button>
                    
                    <button class="payment-btn btn btn-info" onclick="processCheck()" id="btn_check">
                        <i class="bi bi-bank me-2"></i>Check
                        <span class="shortcut-badge">F3</span>
                    </button>
                    
                    <button class="payment-btn btn btn-warning" onclick="processCredit()" id="btn_credit">
                        <i class="bi bi-receipt me-2"></i>Credit
                        <span class="shortcut-badge">F4</span>
                    </button>
                </div>
                
                <div class="d-grid gap-2 mt-3">
                    <button class="btn btn-secondary btn-lg" onclick="suspendSale()">
                        <i class="bi bi-pause-circle me-2"></i>Suspend Sale
                        <span class="shortcut-badge">F9</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Modern POS JavaScript -->
<script src="<?= base_url('js/modern-pos.js') ?>"></script>

<?= view('layouts/bootstrap5_footer') ?>
