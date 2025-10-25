<?php
$title = 'Receivings - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            <div>
                <h1>Receivings</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <a href="<?= base_url('receivings') ?>" class="btn btn-primary">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Receiving
            </a>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active">Receivings</div>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <div id="receivingsTable"></div>
    </div>
</div>

<script>
let receivingsTable;

document.addEventListener('DOMContentLoaded', function() {
    initializeDataTable();
});

function initializeDataTable() {
    receivingsTable = new ModernDataTable('#receivingsTable', {
        ajax: {
            url: '<?= base_url("receivings/search") ?>',
            dataSrc: 'rows'
        },
        columns: [
            { field: 'receiving_id', title: 'ID', sortable: true },
            { 
                field: 'receiving_time', 
                title: 'Date',
                sortable: true,
                render: (value) => {
                    const date = new Date(value);
                    return date.toLocaleString();
                }
            },
            { field: 'supplier_name', title: 'Supplier', sortable: true },
            { 
                field: 'items_purchased', 
                title: 'Items',
                sortable: true,
                render: (value) => `<span style="font-weight: var(--font-medium);">${value}</span>`
            },
            { field: 'payment_type', title: 'Payment', sortable: true },
            { 
                field: 'receiving_amount', 
                title: 'Amount',
                sortable: true,
                render: (value) => {
                    const formatted = parseFloat(value).toFixed(2);
                    return `<span style="color: var(--success-600); font-weight: var(--font-semibold);">$${formatted}</span>`;
                }
            }
        ],
        actions: [
            {
                title: 'View Receipt',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>',
                className: 'btn-ghost',
                onClick: 'viewReceipt'
            },
            {
                title: 'Edit',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>',
                className: 'btn-ghost',
                onClick: 'editReceiving'
            },
            {
                title: 'Delete',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>',
                className: 'btn-ghost',
                onClick: 'deleteReceiving'
            }
        ],
        searchable: true,
        exportable: true,
        pageSize: 25,
        onRowClick: (row, tr) => {
            viewReceipt(row);
        }
    });
}

function viewReceipt(receiving) {
    window.location.href = `<?= base_url("receivings/receipt") ?>/${receiving.receiving_id}`;
}

function editReceiving(receiving) {
    window.location.href = `<?= base_url("receivings/edit") ?>/${receiving.receiving_id}`;
}

function deleteReceiving(receiving) {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Receiving',
            `Are you sure you want to delete receiving #${receiving.receiving_id}? This action cannot be undone.`,
            function() {
                fetch(`<?= base_url("receivings/delete") ?>/${receiving.receiving_id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.shopsuiteApp.showToast('Success', 'Receiving deleted successfully', 'success');
                        receivingsTable.refresh();
                    } else {
                        window.shopsuiteApp.showToast('Error', data.message || 'Failed to delete receiving', 'error');
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
