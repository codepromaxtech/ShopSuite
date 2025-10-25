<?php
$title = 'Product Bundles - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            <div>
                <h1>Product Bundles</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <button class="btn btn-primary" onclick="addItemKit()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Product Bundle
            </button>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active">Product Bundles</div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-title">Total Bundles</div>
            <div class="stat-card-icon" style="background: var(--primary-100);">
                <svg width="24" height="24" fill="none" stroke="var(--primary-600)" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        <div class="stat-card-value" id="totalKits">-</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-title">Active Bundles</div>
            <div class="stat-card-icon" style="background: var(--success-100);">
                <svg width="24" height="24" fill="none" stroke="var(--success-600)" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-card-value" id="activeKits">-</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-title">Total Value</div>
            <div class="stat-card-icon" style="background: var(--warning-100);">
                <svg width="24" height="24" fill="none" stroke="var(--warning-600)" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-card-value" id="totalValue">-</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-header-title">All Item Kits</h3>
    </div>
    <div class="card-body" style="padding: 0;">
        <div id="itemKitsTable"></div>
    </div>
</div>

<script>
let itemKitsTable;

document.addEventListener('DOMContentLoaded', function() {
    initializeDataTable();
    loadStats();
});

function initializeDataTable() {
    itemKitsTable = new ModernDataTable('#itemKitsTable', {
        ajax: {
            url: '<?= base_url("item_kits/search") ?>',
            dataSrc: 'rows'
        },
        columns: [
            { field: 'item_kit_id', title: 'ID', sortable: true },
            { 
                field: 'name', 
                title: 'Kit Name',
                sortable: true,
                render: (data, row) => {
                    return `<div>
                        <div style="font-weight: var(--font-semibold);">${data || ''}</div>
                        <div style="font-size: var(--text-sm); color: var(--text-secondary);">${row.item_kit_number || ''}</div>
                    </div>`;
                }
            },
            { 
                field: 'description', 
                title: 'Description',
                sortable: true
            },
            { 
                field: 'cost_price', 
                title: 'Cost Price',
                sortable: true,
                render: (data) => '$' + parseFloat(data || 0).toFixed(2)
            },
            { 
                field: 'unit_price', 
                title: 'Unit Price',
                sortable: true,
                render: (data) => '$' + parseFloat(data || 0).toFixed(2)
            }
        ],
        searchable: true,
        exportable: true,
        pageSize: 25,
        onRowClick: (row, tr) => {
            viewItemKit(row);
        }
    });
}

function loadStats() {
    // Load stats when table is ready
    setTimeout(() => {
        const totalEl = document.getElementById('totalKits');
        const activeEl = document.getElementById('activeKits');
        const totalValueEl = document.getElementById('totalValue');
        
        if (itemKitsTable && itemKitsTable.totalRecords) {
            totalEl.textContent = new Intl.NumberFormat().format(itemKitsTable.totalRecords);
            activeEl.textContent = new Intl.NumberFormat().format(itemKitsTable.totalRecords);
        }
        
        totalValueEl.textContent = '-';
    }, 1000);
}

function addItemKit() {
    window.location.href = '<?= base_url("item_kits/view/-1") ?>';
}

function viewItemKit(itemKit) {
    window.location.href = `<?= base_url("item_kits/view") ?>/${itemKit.item_kit_id}`;
}

function deleteItemKit(itemKitId) {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.showConfirm(
            'Delete Item Kit',
            'Are you sure you want to delete this item kit? This action cannot be undone.',
            () => {
                window.shopsuiteApp.showLoading('Deleting item kit...');
                
                fetch('<?= base_url("item_kits/delete") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ ids: [itemKitId] })
                })
                .then(response => response.json())
                .then(data => {
                    window.shopsuiteApp.hideLoading();
                    
                    if (data.success) {
                        window.shopsuiteApp.showToast('Success', data.message || 'Item kit deleted successfully', 'success');
                        if (itemKitsTable) {
                            itemKitsTable.reload();
                        }
                        loadStats();
                    } else {
                        window.shopsuiteApp.showToast('Error', data.message || 'Failed to delete item kit', 'error');
                    }
                })
                .catch(error => {
                    window.shopsuiteApp.hideLoading();
                    window.shopsuiteApp.showToast('Error', 'An error occurred', 'error');
                    console.error('Error:', error);
                });
            }
        );
    }
}
</script>

<?php echo view('layouts/modern_footer'); ?>
