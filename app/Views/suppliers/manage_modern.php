<?php
$title = 'Suppliers - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            <div>
                <h1>Suppliers</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <button class="btn btn-primary" onclick="addSupplier()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Supplier
            </button>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active">Suppliers</div>
    </div>
</div>

<div class="card">
    <div class="card-body u-padding-0">
        <div id="suppliersTable"></div>
    </div>
</div>

<script>
let suppliersTable;

document.addEventListener('DOMContentLoaded', function() {
    initializeDataTable();
});

function initializeDataTable() {
    suppliersTable = new ModernDataTable('#suppliersTable', {
        ajax: {
            url: '<?= base_url("suppliers/search") ?>',
            dataSrc: 'rows'
        },
        columns: [
            { field: 'person_id', title: 'ID', sortable: true },
            { 
                field: 'company_name', 
                title: 'Company',
                sortable: true,
                render: (value) => `<span class="u-font-weight-font-medium">${value || '-'}</span>`
            },
            { field: 'agency_name', title: 'Agency', sortable: true },
            { field: 'category', title: 'Category', sortable: true },
            { field: 'first_name', title: 'Contact Name', sortable: true },
            { field: 'email', title: 'Email', sortable: true },
            { field: 'phone_number', title: 'Phone', sortable: true }
        ],
        actions: [
            {
                title: 'Edit',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>',
                className: 'btn-ghost',
                onClick: 'editSupplier'
            },
            {
                title: 'Delete',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>',
                className: 'btn-ghost',
                onClick: 'deleteSupplier'
            }
        ],
        searchable: true,
        exportable: true,
        pageSize: 25,
        onRowClick: (row, tr) => {
            editSupplier(row);
        }
    });
}

function addSupplier() {
    window.location.href = '<?= base_url("suppliers/view/-1") ?>';
}

function editSupplier(supplier) {
    window.location.href = `<?= base_url("suppliers/view") ?>/${supplier.person_id}`;
}

function deleteSupplier(supplier) {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Supplier',
            `Are you sure you want to delete ${supplier.company_name}? This action cannot be undone.`,
            function() {
                fetch(`<?= base_url("suppliers/delete") ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ ids: [supplier.person_id] })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.shopsuiteApp.showToast('Success', 'Supplier deleted successfully', 'success');
                        suppliersTable.refresh();
                    } else {
                        window.shopsuiteApp.showToast('Error', data.message || 'Failed to delete supplier', 'error');
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
