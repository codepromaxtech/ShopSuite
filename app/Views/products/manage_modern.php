<?php
$title = 'Products - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            <div>
                <h1>Products</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <button class="btn btn-outline" onclick="importItems()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Import
            </button>
            <button class="btn btn-primary" onclick="addItem()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Product
            </button>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item">
            <a href="<?= base_url('home') ?>">Dashboard</a>
        </div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active">Products</div>
    </div>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: var(--space-6);">
    <div class="stat-card">
        <div class="stat-card-header">
            <h3 class="stat-card-title">Total Products</h3>
            <div class="stat-card-icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        <div class="stat-card-value" id="totalItems">-</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-header">
            <h3 class="stat-card-title">Low Stock</h3>
            <div class="stat-card-icon" style="background-color: var(--warning-50); color: var(--warning-700);">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-card-value" id="lowStockItems">-</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-header">
            <h3 class="stat-card-title">Total Value</h3>
            <div class="stat-card-icon" style="background-color: var(--success-50); color: var(--success-700);">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-card-value" id="totalValue">-</div>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <div id="itemsTable"></div>
    </div>
</div>

<script>
let itemsTable;

document.addEventListener('DOMContentLoaded', function() {
    initializeDataTable();
    loadStats();
});

function loadStats() {
    // Fetch stats from API
    fetch('<?= base_url("items/stats") ?>')
        .then(response => response.json())
        .then(data => {
            const totalEl = document.getElementById('totalItems');
            const lowStockEl = document.getElementById('lowStockItems');
            const totalValueEl = document.getElementById('totalValue');
            
            if (totalEl && data.total !== undefined) {
                totalEl.textContent = new Intl.NumberFormat().format(data.total);
            }
            
            if (lowStockEl && data.low_stock !== undefined) {
                lowStockEl.textContent = new Intl.NumberFormat().format(data.low_stock);
            }
            
            if (totalValueEl && data.total_value !== undefined) {
                totalValueEl.textContent = '$' + new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(data.total_value);
            }
        })
        .catch(error => {
            console.error('Error loading stats:', error);
            document.getElementById('totalItems').textContent = '-';
            document.getElementById('lowStockItems').textContent = '-';
            document.getElementById('totalValue').textContent = '-';
        });
}

function initializeDataTable() {
    itemsTable = new ModernDataTable('#itemsTable', {
        ajax: {
            url: '<?= base_url("items/search") ?>',
            dataSrc: 'rows'
        },
        columns: [
            { field: 'item_id', title: 'ID', sortable: true },
            { 
                field: 'name', 
                title: 'Name',
                sortable: true,
                render: (value, row) => {
                    return `<span style="font-weight: var(--font-medium);">${value || '-'}</span>`;
                }
            },
            { field: 'item_number', title: 'SKU/Barcode', sortable: true },
            { field: 'category', title: 'Category', sortable: true },
            { 
                field: 'unit_price', 
                title: 'Price',
                type: 'currency',
                sortable: true
            },
            { 
                field: 'quantity', 
                title: 'Stock',
                sortable: true,
                render: (value, row) => {
                    const qty = parseFloat(value || 0);
                    const badgeClass = qty <= 5 ? 'badge-danger' : qty <= 20 ? 'badge-warning' : 'badge-success';
                    return `<span class="badge ${badgeClass}">${qty}</span>`;
                }
            }
        ],
        actions: [
            {
                title: 'Edit',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>',
                className: 'btn-ghost',
                onClick: 'editItem'
            },
            {
                title: 'Delete',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>',
                className: 'btn-ghost',
                onClick: 'deleteItem'
            }
        ],
        searchable: true,
        exportable: true,
        pageSize: 25,
        onRowClick: (row, tr) => {
            editItem(row);
        }
    });
    
    setTimeout(() => {
        if (itemsTable && itemsTable.totalRecords) {
            document.getElementById('totalItems').textContent = new Intl.NumberFormat().format(itemsTable.totalRecords);
        }
    }, 1000);
}

function addItem() {
    window.location.href = '<?= base_url("items/view/-1") ?>';
}

function editItem(item) {
    window.location.href = `<?= base_url("items/view") ?>/${item.item_id}`;
}

function deleteItem(item) {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Item',
            `Are you sure you want to delete ${item.name}? This action cannot be undone.`,
            function() {
                fetch(`<?= base_url("items/delete") ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ ids: [item.item_id] })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.shopsuiteApp.showToast('Success', 'Item deleted successfully', 'success');
                        itemsTable.refresh();
                    } else {
                        window.shopsuiteApp.showToast('Error', data.message || 'Failed to delete item', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.shopsuiteApp.showToast('Error', 'An error occurred', 'error');
                });
            }
        );
    }
}

function importItems() {
    if (window.shopsuiteApp) {
        const modalHtml = `
            <form id="import_form" enctype="multipart/form-data" style="padding: var(--space-4);">
                <div class="form-group">
                    <label class="form-label">Select CSV File</label>
                    <input type="file" 
                           class="form-control" 
                           name="file_path" 
                           id="import_file" 
                           accept=".csv,.xlsx,.xls"
                           required>
                    <small class="form-text">Supported formats: CSV, Excel (.xlsx, .xls)</small>
                </div>
                
                <div class="alert alert-info" style="margin-top: var(--space-3);">
                    <strong>CSV Format:</strong>
                    <div style="font-size: var(--text-sm); margin-top: var(--space-2);">
                        Item Number, Name, Category, Cost Price, Unit Price, Quantity, Description, Reorder Level
                    </div>
                </div>
                
                <div style="display: flex; gap: var(--space-2); margin-top: var(--space-4);">
                    <button type="submit" class="btn btn-primary">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Import Items
                    </button>
                    <button type="button" class="btn btn-outline" onclick="window.shopsuiteApp.hideModal()">Cancel</button>
                    <a href="<?= base_url('products/excel_export') ?>" class="btn btn-outline" download>
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download Template
                    </a>
                </div>
            </form>
        `;
        
        window.shopsuiteApp.showModal('Import Items', modalHtml);
        
        // Handle form submission
        setTimeout(() => {
            document.getElementById('import_form')?.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const fileInput = document.getElementById('import_file');
                
                if (!fileInput.files.length) {
                    alert('Please select a file to import');
                    return;
                }
                
                if (window.shopsuiteApp) {
                    window.shopsuiteApp.showLoading('Importing items...');
                }
                
                fetch('<?= base_url("items/excel_import") ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (window.shopsuiteApp) {
                        window.shopsuiteApp.hideLoading();
                        window.shopsuiteApp.hideModal();
                    }
                    
                    if (data.success) {
                        if (window.shopsuiteApp) {
                            window.shopsuiteApp.showToast('Success', data.message || 'Items imported successfully', 'success');
                        }
                        setTimeout(() => {
                            itemsTable.refresh();
                        }, 1000);
                    } else {
                        if (window.shopsuiteApp) {
                            window.shopsuiteApp.showToast('Error', data.message || 'Failed to import items', 'error');
                        }
                    }
                })
                .catch(error => {
                    if (window.shopsuiteApp) {
                        window.shopsuiteApp.hideLoading();
                        window.shopsuiteApp.showToast('Error', 'An error occurred during import', 'error');
                    }
                    console.error('Error:', error);
                });
            });
        }, 100);
    }
}
</script>

<?php echo view('layouts/modern_footer'); ?>
