<?php
$title = 'Employees - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            <div>
                <h1>Employees</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <button class="btn btn-primary" onclick="addEmployee()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Employee
            </button>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active">Employees</div>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <div id="employeesTable"></div>
    </div>
</div>

<script>
let employeesTable;

document.addEventListener('DOMContentLoaded', function() {
    initializeDataTable();
});

function initializeDataTable() {
    employeesTable = new ModernDataTable('#employeesTable', {
        ajax: {
            url: '<?= base_url("employees/search") ?>',
            dataSrc: 'rows'
        },
        columns: [
            { field: 'person_id', title: 'ID', sortable: true },
            { 
                field: 'first_name', 
                title: 'First Name',
                sortable: true,
                render: (value, row) => {
                    return `
                        <div class="flex items-center gap-3">
                            <div class="avatar avatar-sm" style="background-color: var(--primary-100); color: var(--primary-700);">
                                ${(row.first_name?.charAt(0) || 'E').toUpperCase()}
                            </div>
                            <span style="font-weight: var(--font-medium);">${value || '-'}</span>
                        </div>
                    `;
                }
            },
            { field: 'last_name', title: 'Last Name', sortable: true },
            { field: 'username', title: 'Username', sortable: true },
            { field: 'email', title: 'Email', sortable: true },
            { field: 'phone_number', title: 'Phone', sortable: true }
        ],
        actions: [
            {
                title: 'Edit',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>',
                className: 'btn-ghost',
                onClick: 'editEmployee'
            },
            {
                title: 'Delete',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>',
                className: 'btn-ghost',
                onClick: 'deleteEmployee'
            }
        ],
        searchable: true,
        exportable: true,
        pageSize: 25,
        onRowClick: (row, tr) => {
            editEmployee(row);
        }
    });
}

function addEmployee() {
    window.location.href = '<?= base_url("employees/view/-1") ?>';
}

function editEmployee(employee) {
    window.location.href = `<?= base_url("employees/view") ?>/${employee.person_id}`;
}

function deleteEmployee(employee) {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Employee',
            `Are you sure you want to delete ${employee.first_name} ${employee.last_name}? This action cannot be undone.`,
            function() {
                fetch(`<?= base_url("employees/delete") ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ ids: [employee.person_id] })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.shopsuiteApp.showToast('Success', 'Employee deleted successfully', 'success');
                        employeesTable.refresh();
                    } else {
                        window.shopsuiteApp.showToast('Error', data.message || 'Failed to delete employee', 'error');
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
