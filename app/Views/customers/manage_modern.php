<?php
/**
 * MODERN CUSTOMERS MANAGEMENT - Pure Native Solution
 * No Bootstrap Table library dependency
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.customers'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Modern DataTable CSS -->
<style>
.sortable:hover {
    background-color: #f8f9fa;
}
.table-row:hover {
    background-color: #f8f9fa;
}
</style>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-people-fill me-2"></i>
                <?= lang('Module.customers') ?>
            </h3>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="openModal('customers/view/-1', 'Add New Customer')">
                <i class="bi bi-plus-circle me-1"></i>Add Customer
            </button>
        </div>
    </div>
    
    <!-- Table Container -->
    <div id="dataTable-container"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Modern Customers Page Loading...');
    
    // Define table columns
    const columns = [
        {
            field: 'person_id',
            title: 'ID',
            sortable: true
        },
        {
            field: 'name',
            title: 'Name',
            sortable: true,
            formatter: (value, row) => {
                return `
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                             style="width: 32px; height: 32px; font-size: 14px;">
                            ${row.first_name?.charAt(0) || '?'}${row.last_name?.charAt(0) || ''}
                        </div>
                        <div>
                            <div class="fw-bold">${row.first_name || ''} ${row.last_name || ''}</div>
                            ${row.email ? `<small class="text-muted">${row.email}</small>` : ''}
                        </div>
                    </div>
                `;
            }
        },
        {
            field: 'phone_number',
            title: 'Phone',
            sortable: true,
            formatter: (value) => {
                return value ? `<i class="bi bi-telephone me-1"></i>${value}` : '-';
            }
        },
        {
            field: 'company_name',
            title: 'Company',
            sortable: true,
            formatter: (value) => {
                return value || '-';
            }
        },
        {
            field: 'total',
            title: 'Total Spent',
            sortable: true,
            formatter: (value) => {
                return value ? `<span class="badge bg-success"><?= $config['currency_symbol'] ?>${parseFloat(value).toFixed(2)}</span>` : '-';
            }
        },
        {
            field: 'date',
            title: 'Registered',
            sortable: true,
            formatter: (value) => {
                if (!value) return '-';
                const date = new Date(value);
                return date.toLocaleDateString();
            }
        },
        {
            field: 'actions',
            title: 'Actions',
            sortable: false,
            formatter: (value, row) => {
                return `
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-primary" onclick="editCustomer(${row.person_id}); event.stopPropagation();" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteCustomer(${row.person_id}); event.stopPropagation();" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];
    
    // Initialize Modern DataTable
    window.customersTable = new ModernDataTable({
        tableId: 'dataTable',
        searchUrl: '<?= base_url('customers/search') ?>',
        columns: columns,
        pageSize: <?= $config['lines_per_page'] ?? 20 ?>,
        uniqueId: 'person_id',
        onRowClick: function(row) {
            editCustomer(row.person_id);
        },
        onLoadComplete: function(data) {
            console.log(`✅ Loaded ${data.total} customers`);
        }
    });
    
    console.log('✅ Modern Customers Page Ready');
});

// Customer Actions
function editCustomer(customerId) {
    openModal(`customers/view/${customerId}`, 'Edit Customer');
}

async function deleteCustomer(customerId) {
    const result = await Swal.fire({
        title: 'Delete Customer?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    });
    
    if (result.isConfirmed) {
        try {
            showLoading('Deleting customer...');
            
            const response = await fetch('<?= base_url('customers/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids: [customerId] })
            });
            
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification('Customer deleted successfully', 'success');
                window.customersTable.refresh();
            } else {
                showNotification(data.message || 'Failed to delete customer', 'error');
            }
        } catch (error) {
            hideLoading();
            console.error('Delete error:', error);
            showNotification('An error occurred', 'error');
        }
    }
}
</script>

<?= view('layouts/bootstrap5_footer') ?>
