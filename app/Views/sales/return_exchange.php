<?php
/**
 * Return & Exchange - Search Invoice
 */

$title = 'Return & Exchange - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<style>
/* Return Exchange Styles */
.return-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.return-container {
    max-width: 900px;
    width: 100%;
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    overflow: hidden;
}

.return-header {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    padding: 30px;
    text-align: center;
}

.return-content {
    padding: 40px;
}

.search-section {
    background: #f9fafb;
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 30px;
}

.search-input-group {
    position: relative;
    margin-bottom: 20px;
}

.search-input-large {
    width: 100%;
    padding: 16px 20px 16px 50px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 16px;
    transition: all 0.2s;
}

.search-input-large:focus {
    outline: none;
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.search-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
}

.btn-search {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    padding: 16px 32px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    width: 100%;
    transition: all 0.3s;
}

.btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.4);
}

.sale-card {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 16px;
    transition: all 0.2s;
}

.sale-card:hover {
    border-color: #f59e0b;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.sale-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 1px solid #e5e7eb;
}

.sale-info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 16px;
}

.info-item {
    display: flex;
    flex-direction: column;
}

.info-label {
    font-size: 11px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.info-value {
    font-size: 14px;
    color: #111827;
    font-weight: 600;
}

.items-list {
    background: #f9fafb;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 16px;
}

.item-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #e5e7eb;
}

.item-row:last-child {
    border-bottom: none;
}

.btn-process-return {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-process-return:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #9ca3af;
}

.empty-state svg {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    opacity: 0.5;
}
</style>

<div class="return-page">
    <div class="return-container">
        <!-- Header -->
        <div class="return-header">
            <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 12px;">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                </svg>
                <h1 style="margin: 0; font-size: 36px; font-weight: 700;">Return & Exchange</h1>
            </div>
            <p style="margin: 0; font-size: 16px; opacity: 0.9;">Search for a sale to process return or exchange</p>
        </div>
        
        <!-- Content -->
        <div class="return-content">
            <!-- Search Section -->
            <div class="search-section">
                <h3 style="margin: 0 0 20px; font-size: 18px; font-weight: 600; color: #111827;">Search Sale</h3>
                
                <form id="search_form" onsubmit="searchSale(event)">
                    <div class="search-input-group">
                        <svg class="search-icon" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search Sales
                    </button>
                </form>
            </div>
            
            <!-- Results Section -->
            <div id="results_section" style="display: none;">
                <h3 style="margin: 0 0 20px; font-size: 18px; font-weight: 600; color: #111827;">Search Results</h3>
                <div id="sales_results"></div>
            </div>
            
            <!-- Empty State -->
            <div id="empty_state" class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 style="font-size: 20px; font-weight: 600; color: #6b7280; margin-bottom: 8px;">No Sales Found</h3>
                <p style="font-size: 14px; color: #9ca3af;">Enter a sale ID, invoice number, or customer name to search</p>
            </div>
            
            <!-- Back Button -->
            <div style="margin-top: 30px; text-align: center;">
                <a href="<?= base_url('sales') ?>" style="color: #f59e0b; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        alert('Please enter a search term');
        return;
    }
    
    // Show loading
    const btn = event.target.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle; margin-right: 8px; animation: spin 1s linear infinite;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Searching...';
    
    // Search for sales
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
            alert('Error searching for sales. Please try again.');
        });
}

function displayResults(sales) {
    const resultsDiv = document.getElementById('sales_results');
    document.getElementById('results_section').style.display = 'block';
    document.getElementById('empty_state').style.display = 'none';
    
    resultsDiv.innerHTML = sales.map(sale => `
        <div class="sale-card">
            <div class="sale-header">
                <div>
                    <div style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 4px;">
                        Sale #${sale.sale_id}
                    </div>
                    ${sale.invoice_number ? `<div style="font-size: 14px; color: #6b7280;">Invoice: ${sale.invoice_number}</div>` : ''}
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 24px; font-weight: 700; color: #f59e0b;">
                        $${parseFloat(sale.total).toFixed(2)}
                    </div>
                    <div style="font-size: 12px; color: #6b7280;">
                        ${new Date(sale.sale_time).toLocaleDateString()}
                    </div>
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
                    <div style="font-weight: 600; margin-bottom: 12px; color: #374151;">Items (${sale.items.length})</div>
                    ${sale.items.slice(0, 3).map(item => `
                        <div class="item-row">
                            <span style="color: #111827;">${item.name}</span>
                            <span style="color: #6b7280;">Qty: ${item.quantity} × $${parseFloat(item.price).toFixed(2)}</span>
                        </div>
                    `).join('')}
                    ${sale.items.length > 3 ? `<div style="color: #9ca3af; font-size: 12px; margin-top: 8px;">+${sale.items.length - 3} more items</div>` : ''}
                </div>
            ` : ''}
            
            <button onclick="processReturn(${sale.sale_id})" class="btn-process-return">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                </svg>
                Process Return/Exchange
            </button>
        </div>
    `).join('');
}

function processReturn(saleId) {
    if (confirm('Load this sale into POS for return/exchange?')) {
        window.location.href = '<?= base_url("sales/loadSaleForReturn") ?>/' + saleId;
    }
}

// Add spinning animation for loading
const style = document.createElement('style');
style.textContent = '@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }';
document.head.appendChild(style);
</script>

<?php echo view('layouts/modern_footer'); ?>
