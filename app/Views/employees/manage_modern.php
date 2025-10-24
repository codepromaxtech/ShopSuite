<?php
/**
 * MODERN EMPLOYEES MANAGEMENT - Pure Native Solution
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.employees'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-person-badge me-2"></i>
                <?= lang('Module.employees') ?>
            </h3>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="openModal('employees/view/-1', 'Add New Employee')">
                <i class="bi bi-plus-circle me-1"></i>Add Employee
            </button>
        </div>
    </div>
    
    <!-- Table Container -->
    <div id="dataTable-container"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Modern Employees Page Loading...');
    
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
                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
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
            field: 'username',
            title: 'Username',
            sortable: true,
            formatter: (value) => {
                return value ? `<span class="badge bg-secondary">${value}</span>` : '-';
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
                        <button class="btn btn-outline-primary" onclick="editEmployee(${row.person_id}); event.stopPropagation();" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteEmployee(${row.person_id}); event.stopPropagation();" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];
    
    // Initialize Modern DataTable
    window.employeesTable = new ModernDataTable({
        tableId: 'dataTable',
        searchUrl: '<?= base_url('employees/search') ?>',
        columns: columns,
        pageSize: <?= $config['lines_per_page'] ?? 20 ?>,
        uniqueId: 'person_id',
        onRowClick: function(row) {
            editEmployee(row.person_id);
        },
        onLoadComplete: function(data) {
            console.log(`✅ Loaded ${data.total} employees`);
        }
    });
    
    console.log('✅ Modern Employees Page Ready');
});

// Employee Actions
function editEmployee(employeeId) {
    openModal(`employees/view/${employeeId}`, 'Edit Employee');
}

async function deleteEmployee(employeeId) {
    const result = await Swal.fire({
        title: 'Delete Employee?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    });
    
    if (result.isConfirmed) {
        try {
            showLoading('Deleting employee...');
            
            const response = await fetch('<?= base_url('employees/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids: [employeeId] })
            });
            
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification('Employee deleted successfully', 'success');
                window.employeesTable.refresh();
            } else {
                showNotification(data.message || 'Failed to delete employee', 'error');
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
