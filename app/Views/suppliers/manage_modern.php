<?php
/**
 * MODERN SUPPLIERS MANAGEMENT - Pure Native Solution
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.suppliers'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-building me-2"></i>
                <?= lang('Module.suppliers') ?>
            </h3>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="openModal('suppliers/view/-1', 'Add New Supplier')">
                <i class="bi bi-plus-circle me-1"></i>Add Supplier
            </button>
        </div>
    </div>
    
    <!-- Table Container -->
    <div id="dataTable-container"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Modern Suppliers Page Loading...');
    
    // Define table columns
    const columns = [
        {
            field: 'person_id',
            title: 'ID',
            sortable: true
        },
        {
            field: 'company_name',
            title: 'Company',
            sortable: true,
            formatter: (value, row) => {
                return `
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                             style="width: 32px; height: 32px; font-size: 14px;">
                            ${value?.charAt(0) || '?'}
                        </div>
                        <div>
                            <div class="fw-bold">${value || '-'}</div>
                            ${row.agency_name ? `<small class="text-muted">${row.agency_name}</small>` : ''}
                        </div>
                    </div>
                `;
            }
        },
        {
            field: 'category',
            title: 'Category',
            sortable: true,
            formatter: (value) => {
                return value ? `<span class="badge bg-info">${value}</span>` : '-';
            }
        },
        {
            field: 'contact',
            title: 'Contact Person',
            sortable: false,
            formatter: (value, row) => {
                return `${row.first_name || ''} ${row.last_name || ''}`.trim() || '-';
            }
        },
        {
            field: 'email',
            title: 'Email',
            sortable: true,
            formatter: (value) => {
                return value ? `<i class="bi bi-envelope me-1"></i>${value}` : '-';
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
            field: 'actions',
            title: 'Actions',
            sortable: false,
            formatter: (value, row) => {
                return `
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-primary" onclick="editSupplier(${row.person_id}); event.stopPropagation();" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteSupplier(${row.person_id}); event.stopPropagation();" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];
    
    // Initialize Modern DataTable
    window.suppliersTable = new ModernDataTable({
        tableId: 'dataTable',
        searchUrl: '<?= base_url('suppliers/search') ?>',
        columns: columns,
        pageSize: <?= $config['lines_per_page'] ?? 20 ?>,
        uniqueId: 'person_id',
        onRowClick: function(row) {
            editSupplier(row.person_id);
        },
        onLoadComplete: function(data) {
            console.log(`✅ Loaded ${data.total} suppliers`);
        }
    });
    
    console.log('✅ Modern Suppliers Page Ready');
});

// Supplier Actions
function editSupplier(supplierId) {
    openModal(`suppliers/view/${supplierId}`, 'Edit Supplier');
}

async function deleteSupplier(supplierId) {
    const result = await Swal.fire({
        title: 'Delete Supplier?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    });
    
    if (result.isConfirmed) {
        try {
            showLoading('Deleting supplier...');
            
            const response = await fetch('<?= base_url('suppliers/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids: [supplierId] })
            });
            
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification('Supplier deleted successfully', 'success');
                window.suppliersTable.refresh();
            } else {
                showNotification(data.message || 'Failed to delete supplier', 'error');
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
