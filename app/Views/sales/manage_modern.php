<?php
$title = 'Sales - ShopSuite';
echo view('layouts/modern_header', ['title' => $title, 'extra_css' => ['css/pos-compact.min.css']]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <div>
                <h1>Sales History</h1>
                <p class="page-header-desc">View and manage all completed sales</p>
            </div>
        </div>
        
        <div class="page-header-actions">
            <a href="<?= base_url('sales') ?>" class="btn btn-primary">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Sale
            </a>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item">
            <a href="<?= base_url('home') ?>">Dashboard</a>
        </div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active">Sales</div>
    </div>
</div>

<div class="stats-grid manage-stats-grid">
    <div class="stat-card card-hover">
        <div class="stat-card-header">
            <h3 class="stat-card-title">Total Sales</h3>
            <div class="stat-card-icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
        <div class="stat-card-value" id="totalSales">—</div>
    </div>
    
    <div class="stat-card card-hover">
        <div class="stat-card-header">
            <h3 class="stat-card-title">Today's Sales</h3>
            <div class="stat-card-icon stat-icon-success">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-card-value" id="todaysSales">—</div>
    </div>
    
    <div class="stat-card card-hover">
        <div class="stat-card-header">
            <h3 class="stat-card-title">Total Revenue</h3>
            <div class="stat-card-icon stat-icon-primary">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
        <div class="stat-card-value" id="totalRevenue">—</div>
    </div>
</div>

<div class="card">
    <div class="card-body card-body-nopad">
        <div id="salesTable"></div>
    </div>
</div>

<script>
let salesTable;

document.addEventListener('DOMContentLoaded', function() {
    initializeDataTable();
});

function initializeDataTable() {
    salesTable = new ModernDataTable('#salesTable', {
        ajax: {
            url: '<?= base_url("sales/search") ?>',
            dataSrc: 'rows'
        },
        columns: [
            { field: 'sale_id', title: 'ID', sortable: true },
            { 
                field: 'sale_time', 
                title: 'Date',
                sortable: true,
                type: 'datetime'
            },
            { 
                field: 'customer_name', 
                title: 'Customer',
                sortable: true,
                render: (value) => value || '<span class="text-tertiary">Walk-in</span>'
            },
            { 
                field: 'items_purchased', 
                title: 'Items',
                sortable: true
            },
            { 
                field: 'payment_type', 
                title: 'Payment',
                sortable: true,
                render: (value) => {
                    const method = value || 'Cash';
                    const colors = { 'Cash': 'success', 'Card': 'primary', 'Mobile': 'warning' };
                    const color = colors[method] || 'secondary';
                    return `<span class="badge badge-${color}">${method}</span>`;
                }
            },
            { 
                field: 'sale_amount', 
                title: 'Amount',
                type: 'currency',
                sortable: true
            }
        ],
        actions: [
            {
                title: 'View Receipt',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>',
                className: 'btn-outline',
                onClick: 'viewReceipt'
            },
            {
                title: 'Edit',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>',
                className: 'btn-ghost',
                onClick: 'editSale'
            },
            {
                title: 'Delete',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>',
                className: 'btn-ghost',
                onClick: 'deleteSale'
            }
        ],
        searchable: true,
        exportable: true,
        pageSize: 25,
        onRowClick: (row, tr) => {
            viewReceipt(row);
        }
    });
    
    setTimeout(() => {
        if (salesTable && salesTable.totalRecords) {
            document.getElementById('totalSales').textContent = new Intl.NumberFormat().format(salesTable.totalRecords);
        }
    }, 1000);
}

function viewReceipt(sale) {
    window.open(`<?= base_url("sales/receipt") ?>/${sale.sale_id}`, '_blank');
}

function editSale(sale) {
    window.location.href = `<?= base_url("sales/edit") ?>/${sale.sale_id}`;
}

function deleteSale(sale) {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Sale',
            `Are you sure you want to delete Sale #${sale.sale_id}? This action cannot be undone.`,
            function() {
                fetch(`<?= base_url("sales/delete") ?>/${sale.sale_id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.shopsuiteApp.showToast('Success', 'Sale deleted successfully', 'success');
                        salesTable.refresh();
                    } else {
                        window.shopsuiteApp.showToast('Error', data.message || 'Failed to delete sale', 'error');
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
</script>

<?php echo view('layouts/modern_footer'); ?>
