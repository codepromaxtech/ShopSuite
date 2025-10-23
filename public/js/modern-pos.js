/**
 * Modern POS Register - JavaScript
 * Handles cart management, product search, and payment processing
 */

// Global state
let cart = [];
let customer = null;
let taxRate = 0.10; // Default 10%, will be overridden from server
let searchTimeout = null;

// Initialize POS on document ready
$(document).ready(function() {
    console.log('🚀 Modern POS JavaScript Initialized');
    
    // Load initial cart state
    loadCart();
    
    // Set up barcode scanner
    initializeBarcodeScanner();
    
    // Set up keyboard shortcuts
    initializeKeyboardShortcuts();
    
    // Load tax rate from config
    const taxRateText = $('#tax_rate').text();
    const match = taxRateText.match(/[\d.]+/);
    if (match) {
        taxRate = parseFloat(match[0]) / 100;
    }
    
    console.log('✅ POS ready. Tax rate:', (taxRate * 100).toFixed(1) + '%');
});

/**
 * Initialize barcode scanner with autocomplete
 */
function initializeBarcodeScanner() {
    const $scanner = $('#barcode_scanner');
    
    // Real-time search as user types
    $scanner.on('input', function() {
        const query = $(this).val().trim();
        
        // Clear previous timeout
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }
        
        if (query.length >= 2) {
            // Debounce search
            searchTimeout = setTimeout(() => {
                searchProducts(query);
            }, 300);
        } else {
            $('#search_results').hide();
        }
    });
    
    // Enter key to add product
    $scanner.on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            const query = $(this).val().trim();
            if (query) {
                addProductByCode(query);
            }
        }
    });
    
    // Keep focus on scanner
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#search_results, #barcode_scanner').length) {
            $scanner.focus();
        }
    });
}

/**
 * Initialize keyboard shortcuts
 */
function initializeKeyboardShortcuts() {
    $(document).on('keydown', function(e) {
        // Ignore if typing in textarea or input (except barcode scanner)
        if ($(e.target).is('textarea') || ($(e.target).is('input') && e.target.id !== 'barcode_scanner')) {
            return;
        }
        
        switch(e.key) {
            case 'F1':
                e.preventDefault();
                processCash();
                break;
            case 'F2':
                e.preventDefault();
                processCard();
                break;
            case 'F3':
                e.preventDefault();
                processCheck();
                break;
            case 'F4':
                e.preventDefault();
                processCredit();
                break;
            case 'F9':
                e.preventDefault();
                suspendSale();
                break;
            case 'Escape':
                e.preventDefault();
                clearCart();
                break;
        }
    });
}

/**
 * Search products via AJAX
 */
async function searchProducts(query) {
    try {
        const response = await $.get(BASE_URL + 'sales/item_search', { term: query });
        displaySearchResults(response);
    } catch (error) {
        console.error('Search error:', error);
    }
}

/**
 * Display search results
 */
function displaySearchResults(products) {
    const $results = $('#search_results');
    
    if (!products || products.length === 0) {
        $results.hide();
        return;
    }
    
    let html = '<div class="list-group">';
    products.forEach(product => {
        html += `
            <button type="button" class="list-group-item list-group-item-action" onclick="addProduct('${product.item_id}')">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <strong>${escapeHtml(product.name)}</strong>
                        ${product.item_number ? `<small class="text-muted d-block">${escapeHtml(product.item_number)}</small>` : ''}
                    </div>
                    <span class="badge bg-success ms-2">$${parseFloat(product.unit_price).toFixed(2)}</span>
                </div>
            </button>
        `;
    });
    html += '</div>';
    
    $results.html(html).show();
}

/**
 * Add product by barcode or item code
 */
async function addProductByCode(code) {
    try {
        showLoading('Adding product...');
        
        const response = await $.post(BASE_URL + 'sales/add', { item: code });
        
        hideLoading();
        
        // Clear scanner and hide results
        $('#barcode_scanner').val('');
        $('#search_results').hide();
        
        // Reload page to refresh cart (controller returns full page)
        window.location.reload();
    } catch (error) {
        hideLoading();
        console.error('Add product error:', error);
        showNotification('Failed to add product', 'error');
    }
}

/**
 * Add product by ID
 */
async function addProduct(itemId) {
    await addProductByCode(itemId);
}

/**
 * Load cart from server
 * Note: Cart is managed server-side in session
 */
async function loadCart() {
    // Cart data is embedded in the page on load
    // This function will be called after AJAX operations
    // For now, just refresh the page to get updated cart
    console.log('Cart managed server-side');
}

/**
 * Update cart display
 */
function updateCartDisplay() {
    const $container = $('#cart_items');
    
    if (cart.length === 0) {
        $container.html(`
            <div class="empty-cart-state">
                <i class="bi bi-cart-x"></i>
                <p class="mt-3 fw-semibold">Cart is empty</p>
                <p class="small">Scan or search for products to add</p>
            </div>
        `);
        $('#cart_count').text('0');
        $('#total_items').text('0');
        return;
    }
    
    let html = '';
    let totalItems = 0;
    
    cart.forEach((item, index) => {
        const qty = parseFloat(item.quantity);
        const price = parseFloat(item.price);
        const lineTotal = qty * price;
        totalItems += qty;
        
        html += `
            <div class="cart-item" data-index="${index}">
                <img src="${item.image || BASE_URL + 'images/no-image.png'}" 
                     class="cart-item-image" 
                     alt="${escapeHtml(item.name)}">
                
                <div>
                    <div class="cart-item-name">${escapeHtml(item.name)}</div>
                    <div class="cart-item-price">$${price.toFixed(2)} each</div>
                </div>
                
                <div class="cart-item-qty-controls">
                    <button class="btn btn-sm btn-outline-secondary" onclick="decrementQuantity(${index})">
                        <i class="bi bi-dash"></i>
                    </button>
                </div>
                
                <input type="number" 
                       class="form-control cart-item-qty" 
                       value="${qty}"
                       onchange="updateQuantity(${index}, this.value)"
                       min="0.01"
                       step="0.01">
                
                <div class="cart-item-qty-controls">
                    <button class="btn btn-sm btn-outline-secondary" onclick="incrementQuantity(${index})">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
                
                <div class="text-end">
                    <div class="cart-item-total">$${lineTotal.toFixed(2)}</div>
                    <button class="cart-item-remove" onclick="removeItem(${index})" title="Remove">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
    });
    
    $container.html(html);
    $('#cart_count').text(cart.length);
    $('#total_items').text(totalItems.toFixed(2));
}

/**
 * Update totals display
 */
function updateTotals(totals = null) {
    if (!totals) {
        // Calculate from cart
        let subtotal = 0;
        cart.forEach(item => {
            subtotal += parseFloat(item.price) * parseFloat(item.quantity);
        });
        
        const taxAmount = subtotal * taxRate;
        const discountAmount = 0; // TODO: Apply customer discount
        const total = subtotal + taxAmount - discountAmount;
        
        totals = {
            subtotal: subtotal,
            tax: taxAmount,
            discount: discountAmount,
            total: total
        };
    }
    
    $('#subtotal').text('$' + totals.subtotal.toFixed(2));
    $('#tax_amount').text('$' + totals.tax.toFixed(2));
    $('#grand_total').text('$' + totals.total.toFixed(2));
    
    if (totals.discount > 0) {
        $('#discount_line').show();
        $('#discount_amount').text('-$' + totals.discount.toFixed(2));
    } else {
        $('#discount_line').hide();
    }
}

/**
 * Increment item quantity
 */
async function incrementQuantity(index) {
    cart[index].quantity = parseFloat(cart[index].quantity) + 1;
    await saveCart();
}

/**
 * Decrement item quantity
 */
async function decrementQuantity(index) {
    const newQty = parseFloat(cart[index].quantity) - 1;
    if (newQty > 0) {
        cart[index].quantity = newQty;
        await saveCart();
    } else {
        await removeItem(index);
    }
}

/**
 * Update item quantity
 */
async function updateQuantity(index, value) {
    const qty = parseFloat(value);
    if (qty > 0) {
        cart[index].quantity = qty;
        await saveCart();
    } else {
        showNotification('Quantity must be greater than 0', 'warning');
        updateCartDisplay(); // Reset display
    }
}

/**
 * Remove item from cart
 */
async function removeItem(itemId) {
    const confirmed = await Swal.fire({
        title: 'Remove Item?',
        text: 'Remove this item from cart?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, remove',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#ef4444'
    });
    
    if (confirmed.isConfirmed) {
        try {
            showLoading('Removing item...');
            await $.get(BASE_URL + 'sales/delete_item/' + itemId);
            window.location.reload();
        } catch (error) {
            hideLoading();
            console.error('Remove error:', error);
            showNotification('Failed to remove item', 'error');
        }
    }
}

/**
 * Clear entire cart
 */
async function clearCart() {
    const confirmed = await Swal.fire({
        title: 'Clear Cart?',
        text: 'Remove all items from cart?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, clear all',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#ef4444'
    });
    
    if (confirmed.isConfirmed) {
        try {
            showLoading('Clearing cart...');
            await $.post(BASE_URL + 'sales/cancel');
            window.location.reload();
        } catch (error) {
            hideLoading();
            console.error('Clear cart error:', error);
            showNotification('Failed to clear cart', 'error');
        }
    }
}

/**
 * Save cart to server
 */
async function saveCart() {
    try {
        await $.post(BASE_URL + 'sales/update', { cart: cart });
        updateCartDisplay();
        await loadCart(); // Refresh totals from server
    } catch (error) {
        console.error('Save cart error:', error);
        showNotification('Failed to update cart', 'error');
    }
}

/**
 * Process cash payment
 */
async function processCash() {
    if (cart.length === 0) {
        showNotification('Cart is empty', 'warning');
        return;
    }
    
    const total = parseFloat($('#grand_total').text().replace('$', ''));
    
    const { value: cashAmount } = await Swal.fire({
        title: 'Cash Payment',
        html: `
            <div class="text-start">
                <div class="alert alert-success mb-3">
                    <h4 class="mb-0">Total: $${total.toFixed(2)}</h4>
                </div>
                <label class="form-label fw-bold">Cash Received</label>
                <input type="number" id="cash_received" class="form-control form-control-lg text-center" 
                       value="${total.toFixed(2)}" step="0.01" min="${total}" autofocus>
                <div id="change_display" class="alert alert-info mt-3" style="display: none;">
                    <strong>Change: $<span id="change_amount">0.00</span></strong>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-check-circle me-2"></i>Complete Sale',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#10b981',
        width: '500px',
        didOpen: () => {
            const input = document.getElementById('cash_received');
            input.focus();
            input.select();
            
            input.addEventListener('input', function() {
                const received = parseFloat(this.value) || 0;
                const change = received - total;
                if (change >= 0) {
                    document.getElementById('change_display').style.display = 'block';
                    document.getElementById('change_amount').textContent = change.toFixed(2);
                } else {
                    document.getElementById('change_display').style.display = 'none';
                }
            });
            
            // Trigger initial calculation
            input.dispatchEvent(new Event('input'));
        },
        preConfirm: () => {
            const received = parseFloat(document.getElementById('cash_received').value);
            if (received < total) {
                Swal.showValidationMessage('Cash received must be at least the total amount');
                return false;
            }
            return received;
        }
    });
    
    if (cashAmount) {
        await completeSale('cash', cashAmount);
    }
}

/**
 * Process card payment
 */
async function processCard() {
    if (cart.length === 0) {
        showNotification('Cart is empty', 'warning');
        return;
    }
    
    const total = parseFloat($('#grand_total').text().replace('$', ''));
    
    const confirmed = await Swal.fire({
        title: 'Card Payment',
        html: `
            <div class="text-start">
                <div class="alert alert-primary mb-3">
                    <h4 class="mb-0">Total: $${total.toFixed(2)}</h4>
                </div>
                <p>Process card payment for the full amount?</p>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-credit-card me-2"></i>Process Payment',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#3b82f6'
    });
    
    if (confirmed.isConfirmed) {
        await completeSale('card', total);
    }
}

/**
 * Process check payment
 */
async function processCheck() {
    if (cart.length === 0) {
        showNotification('Cart is empty', 'warning');
        return;
    }
    
    const total = parseFloat($('#grand_total').text().replace('$', ''));
    
    const { value: checkNumber } = await Swal.fire({
        title: 'Check Payment',
        html: `
            <div class="text-start">
                <div class="alert alert-info mb-3">
                    <h4 class="mb-0">Total: $${total.toFixed(2)}</h4>
                </div>
                <label class="form-label fw-bold">Check Number</label>
                <input type="text" id="check_number" class="form-control" placeholder="Enter check number" autofocus>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-bank me-2"></i>Process Payment',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#0ea5e9',
        preConfirm: () => {
            const checkNum = document.getElementById('check_number').value;
            if (!checkNum) {
                Swal.showValidationMessage('Please enter check number');
                return false;
            }
            return checkNum;
        }
    });
    
    if (checkNumber) {
        await completeSale('check', total, checkNumber);
    }
}

/**
 * Process credit/invoice payment
 */
async function processCredit() {
    if (cart.length === 0) {
        showNotification('Cart is empty', 'warning');
        return;
    }
    
    const total = parseFloat($('#grand_total').text().replace('$', ''));
    
    const confirmed = await Swal.fire({
        title: 'Credit Sale',
        html: `
            <div class="text-start">
                <div class="alert alert-warning mb-3">
                    <h4 class="mb-0">Total: $${total.toFixed(2)}</h4>
                </div>
                <p>Process as credit/invoice?</p>
                <p class="small text-muted">Customer will be billed for this amount.</p>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-receipt me-2"></i>Process Credit Sale',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#f59e0b'
    });
    
    if (confirmed.isConfirmed) {
        await completeSale('credit', total);
    }
}

/**
 * Complete sale with payment
 */
async function completeSale(paymentType, amount, reference = null) {
    showLoading('Processing sale...');
    
    try {
        // Add payment first
        const paymentData = {
            payment_type: paymentType,
            payment_amount: amount
        };
        
        if (reference) {
            paymentData.payment_reference = reference;
        }
        
        await $.post(BASE_URL + 'sales/add_payment', paymentData);
        
        // Then complete the sale
        const response = await $.post(BASE_URL + 'sales/complete', {
            comment: $('#sale_comment').val()
        });
        
        hideLoading();
        
        if (response.success) {
            // Show success with animation
            await Swal.fire({
                title: 'Sale Complete!',
                html: `
                    <div class="success-checkmark">
                        <div class="check-icon">
                            <span class="icon-line line-tip"></span>
                            <span class="icon-line line-long"></span>
                        </div>
                    </div>
                    <p class="mt-3">Sale #${response.sale_id} completed successfully</p>
                    ${response.change > 0 ? `<p class="text-success">Change: $${response.change.toFixed(2)}</p>` : ''}
                `,
                icon: 'success',
                confirmButtonText: 'New Sale',
                confirmButtonColor: '#10b981'
            });
            
            // Clear cart and reload
            await loadCart();
            $('#sale_comment').val('');
            $('#barcode_scanner').focus();
            
            // Print receipt if enabled
            if (response.print_receipt && response.receipt_url) {
                window.open(response.receipt_url, '_blank');
            }
        } else {
            showNotification(response.message || 'Sale failed', 'error');
        }
    } catch (error) {
        hideLoading();
        console.error('Complete sale error:', error);
        showNotification('Failed to complete sale', 'error');
    }
}

/**
 * Suspend current sale
 */
async function suspendSale() {
    const { value: comment } = await Swal.fire({
        title: 'Suspend Sale',
        input: 'textarea',
        inputLabel: 'Add a note (optional)',
        inputPlaceholder: 'Reason for suspending...',
        showCancelButton: true,
        confirmButtonText: 'Suspend',
        confirmButtonColor: '#6b7280'
    });
    
    if (comment !== undefined) {
        try {
            showLoading('Suspending sale...');
            
            if (comment) {
                await $.post(BASE_URL + 'sales/set_comment', { comment: comment });
            }
            
            await $.post(BASE_URL + 'sales/suspend_sale');
            
            hideLoading();
            showNotification('Sale suspended', 'success');
            window.location.reload();
        } catch (error) {
            hideLoading();
            console.error('Suspend error:', error);
            showNotification('Failed to suspend sale', 'error');
        }
    }
}

/**
 * Open suspended sales
 */
function openSuspended() {
    openModal(BASE_URL + 'sales/suspended', 'Suspended Sales', { size: 'xl' });
}

/**
 * Open change mode dialog
 */
function openChangeMode() {
    openModal(BASE_URL + 'sales/changeMode', 'Change Mode');
}

/**
 * Open sales history
 */
function openHistory() {
    window.location.href = BASE_URL + 'sales/manage';
}

/**
 * Select customer
 */
function selectCustomer() {
    openModal(BASE_URL + 'customers/select', 'Select Customer', { 
        size: 'lg',
        onHide: () => loadCart() // Refresh cart to apply customer discount
    });
}

/**
 * Add new customer
 */
function addNewCustomer() {
    openModal(BASE_URL + 'customers/view', 'New Customer', {
        size: 'xl',
        onHide: () => loadCart()
    });
}

/**
 * Escape HTML
 */
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}

// Make functions globally available
window.addProduct = addProduct;
window.incrementQuantity = incrementQuantity;
window.decrementQuantity = decrementQuantity;
window.updateQuantity = updateQuantity;
window.removeItem = removeItem;
window.clearCart = clearCart;
window.processCash = processCash;
window.processCard = processCard;
window.processCheck = processCheck;
window.processCredit = processCredit;
window.suspendSale = suspendSale;
window.openSuspended = openSuspended;
window.openChangeMode = openChangeMode;
window.openHistory = openHistory;
window.selectCustomer = selectCustomer;
window.addNewCustomer = addNewCustomer;

console.log('✅ Modern POS JavaScript loaded successfully');
