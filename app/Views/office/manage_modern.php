<?php
/**
 * MODERN OFFICE MANAGEMENT - Pure Native Solution
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.office'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-briefcase me-2"></i>
                <?= lang('Module.office') ?>
            </h3>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="openModal('office/view/-1', 'Add New Entry')">
                <i class="bi bi-plus-circle me-1"></i>Add Entry
            </button>
        </div>
    </div>
    
    <!-- Table Container -->
    <div id="dataTable-container"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Modern Office Page Loading...');
    
    // Define table columns
    const columns = [
        {
            field: 'id',
            title: 'ID',
            sortable: true
        },
        {
            field: 'date',
            title: 'Date',
            sortable: true,
            formatter: (value) => {
                if (!value) return '-';
                const date = new Date(value);
                return date.toLocaleDateString();
            }
        },
        {
            field: 'description',
            title: 'Description',
            sortable: true,
            formatter: (value) => {
                return value || '-';
            }
        },
        {
            field: 'employee_name',
            title: 'Employee',
            sortable: true,
            formatter: (value) => {
                return value ? `<small>${value}</small>` : '-';
            }
        },
        {
            field: 'actions',
            title: 'Actions',
            sortable: false,
            formatter: (value, row) => {
                return `
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-primary" onclick="editOffice(${row.id}); event.stopPropagation();" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteOffice(${row.id}); event.stopPropagation();" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];
    
    // Initialize Modern DataTable
    window.officeTable = new ModernDataTable({
        tableId: 'dataTable',
        searchUrl: '<?= base_url('office/search') ?>',
        columns: columns,
        pageSize: <?= $config['lines_per_page'] ?? 20 ?>,
        uniqueId: 'id',
        onRowClick: function(row) {
            editOffice(row.id);
        },
        onLoadComplete: function(data) {
            console.log(`✅ Loaded ${data.total} office entries`);
        }
    });
    
    console.log('✅ Modern Office Page Ready');
});

// Office Actions
function editOffice(id) {
    openModal(`office/view/${id}`, 'Edit Office Entry');
}

async function deleteOffice(id) {
    const result = await Swal.fire({
        title: 'Delete Office Entry?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    });
    
    if (result.isConfirmed) {
        try {
            showLoading('Deleting office entry...');
            
            const response = await fetch('<?= base_url('office/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids: [id] })
            });
            
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification('Office entry deleted successfully', 'success');
                window.officeTable.refresh();
            } else {
                showNotification(data.message || 'Failed to delete office entry', 'error');
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
