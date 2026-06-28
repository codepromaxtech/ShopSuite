<?php
/**
 * Return & Exchange - Search Invoice
 */

$title = 'Return & Exchange - ShopSuite';
echo view('layouts/modern_header', ['title' => $title, 'extra_css' => ['css/pos-compact.min.css']]);
?>

<div class="return-page">
    <div class="return-container">
        <!-- Header -->
        <div class="return-header">
            <div class="d-flex align-items-center return-header-flex">
                <svg width="44" height="44" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                </svg>
                <h1>Return & Exchange</h1>
            </div>
            <p>Search for a sale to process return or exchange</p>
        </div>
        
        <!-- Content -->
        <div class="return-content">
            <!-- Search Section -->
            <div class="card return-search-card">
                <h3 class="return-section-title">Search Sale</h3>
                
                <form id="search_form" onsubmit="searchSale(event)">
                    <div class="search-input-group">
                        <svg class="search-icon" width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" 
                               id="search_input" 
                               class="search-input-large" 
                               placeholder="Enter Sale ID, Invoice Number, or Customer Name..."
                               autocomplete="off"
                               autofocus>
                    </div>
                    
                    <button type="submit" class="btn-search">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search Sales
                    </button>
                </form>
            </div>
            
            <!-- Results Section -->
            <div id="results_section" class="return-results-section">
                <h3 class="return-section-title">Search Results</h3>
                <div id="sales_results"></div>
            </div>
            
            <!-- Empty State -->
            <div id="empty_state" class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3>No Sales Found</h3>
                <p>Enter a sale ID, invoice number, or customer name to search</p>
            </div>
            
            <!-- Back Button -->
            <div class="return-back-container">
                <a href="<?= base_url('sales') ?>" class="back-link">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to POS Register
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function searchSale(event) {
    event.preventDefault();
    
    const searchTerm = document.getElementById('search_input').value.trim();
    if (!searchTerm) {
        window.shopsuiteApp.showToast('Search Required', <?= json_encode(lang('Sales.return_exchange_search_required')) ?>, 'warning');
        return;
    }
    
    const btn = event.target.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<div class="spinner spinner-sm search-spinner-inline"></div> Searching...';
    
    fetch('<?= base_url("sales/searchForReturn") ?>?term=' + encodeURIComponent(searchTerm))
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = originalText;
            
            if (data.success && data.sales && data.sales.length > 0) {
                displayResults(data.sales);
            } else {
                document.getElementById('results_section').style.display = 'none';
                document.getElementById('empty_state').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.disabled = false;
            btn.innerHTML = originalText;
            window.shopsuiteApp.showToast('Search Failed', <?= json_encode(lang('Sales.return_exchange_search_error')) ?>, 'error');
        });
}

function displayResults(sales) {
    const resultsDiv = document.getElementById('sales_results');
    document.getElementById('results_section').style.display = 'block';
    document.getElementById('empty_state').style.display = 'none';
    
    resultsDiv.innerHTML = sales.map((sale, index) => `
        <div class="sale-card u-animation-delay-index008">
            <div class="sale-header">
                <div>
                    <div class="sale-header-id">Sale #${sale.sale_id}</div>
                    ${sale.invoice_number ? `<div class="sale-header-invoice">Invoice: ${sale.invoice_number}</div>` : ''}
                </div>
                <div class="sale-header-right">
                    <div class="sale-header-amount">$${parseFloat(sale.total).toFixed(2)}</div>
                    <div class="sale-header-date">${new Date(sale.sale_time).toLocaleDateString()}</div>
                </div>
            </div>
            
            <div class="sale-info-grid">
                <div class="info-item">
                    <div class="info-label">Customer</div>
                    <div class="info-value">${sale.customer_name || 'Walk-in'}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Employee</div>
                    <div class="info-value">${sale.employee_name || 'N/A'}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Payment</div>
                    <div class="info-value">${sale.payment_type || 'Multiple'}</div>
                </div>
            </div>
            
            ${sale.items && sale.items.length > 0 ? `
                <div class="items-list">
                    <div class="items-list-title">Items (${sale.items.length})</div>
                    ${sale.items.slice(0, 3).map(item => `
                        <div class="item-row">
                            <span>${item.name}</span>
                            <span>Qty: ${item.quantity} × $${parseFloat(item.price).toFixed(2)}</span>
                        </div>
                    `).join('')}
                    ${sale.items.length > 3 ? `<div class="text-xs text-tertiary sale-items-more">+${sale.items.length - 3} more items</div>` : ''}
                </div>
            ` : ''}
            
            <button onclick="processReturn(${sale.sale_id})" class="btn-process-return">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                </svg>
                Process Return/Exchange
            </button>
        </div>
    `).join('');
}

function processReturn(saleId) {
    window.shopsuiteApp.confirm(
        <?= json_encode(lang('Sales.return_exchange_confirm_title')) ?>,
        <?= json_encode(lang('Sales.return_exchange_confirm_load')) ?>,
        () => {
            window.location.href = '<?= base_url("sales/loadSaleForReturn") ?>/' + saleId;
        }
    );
}
</script>

<?php echo view('layouts/modern_footer'); ?>
