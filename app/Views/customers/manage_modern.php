<?php
$title = 'Customers - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            <div>
                <h1>Customers</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <button class="btn btn-outline" onclick="importCustomers()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Import
            </button>
            <button class="btn btn-primary" onclick="addCustomer()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Customer
            </button>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item">
            <a href="<?= base_url('home') ?>">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>
        </div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active">Customers</div>
    </div>
</div>

<!-- Customer Stats -->
<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: var(--space-6);">
    <div class="stat-card">
        <div class="stat-card-header">
            <h3 class="stat-card-title">Total Customers</h3>
            <div class="stat-card-icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-card-value" id="totalCustomers">-</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-header">
            <h3 class="stat-card-title">Active This Month</h3>
            <div class="stat-card-icon" style="background-color: var(--success-50); color: var(--success-700);">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-card-value" id="activeCustomers">-</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-header">
            <h3 class="stat-card-title">New This Month</h3>
            <div class="stat-card-icon" style="background-color: var(--accent-50); color: var(--accent-700);">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-card-value" id="newCustomers">-</div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        <div id="customersTable"></div>
    </div>
</div>

<!-- Modals will be added dynamically -->
<div id="modalContainer"></div>

<script>
let customersTable;

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Page loaded, initializing...');
    console.log('ModernDataTable available?', typeof ModernDataTable);
    initializeDataTable();
    loadStats();
});

function initializeDataTable() {
    console.log('📋 Initializing customer table...');
    const container = document.querySelector('#customersTable');
    console.log('Container found?', container);
    
    // Using real search endpoint
    const searchUrl = '<?= base_url("customers/search") ?>';
    console.log('🔍 Using search URL:', searchUrl);
    
    customersTable = new ModernDataTable('#customersTable', {
        ajax: {
            url: searchUrl,
            dataSrc: 'rows'
        },
        uniqueId: 'person_id',
        columns: [
            { 
                field: 'person_id', 
                title: 'ID',
                sortable: true
            },
            { 
                field: 'first_name', 
                title: 'First Name',
                sortable: true,
                render: (value, row) => {
                    return `
                        <div class="flex items-center gap-3">
                            <div class="avatar avatar-sm" style="background-color: var(--primary-100); color: var(--primary-700);">
                                ${(row.first_name?.charAt(0) || 'C').toUpperCase()}
                            </div>
                            <span style="font-weight: var(--font-medium);">${value || '-'}</span>
                        </div>
                    `;
                }
            },
            { 
                field: 'last_name', 
                title: 'Last Name',
                sortable: true
            },
            { 
                field: 'email', 
                title: 'Email',
                sortable: true
            },
            { 
                field: 'phone_number', 
                title: 'Phone',
                sortable: true
            },
            { 
                field: 'account_number', 
                title: 'Account #',
                sortable: true
            },
            { 
                field: 'total', 
                title: 'Total Sales',
                type: 'currency',
                sortable: true
            }
        ],
        actions: [
            {
                title: 'View',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>',
                className: 'btn-outline',
                onClick: 'viewCustomer'
            },
            {
                title: 'Edit',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>',
                className: 'btn-ghost',
                onClick: 'editCustomer'
            },
            {
                title: 'Delete',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>',
                className: 'btn-ghost',
                onClick: 'deleteCustomer'
            }
        ],
        searchable: true,
        exportable: true,
        pageSize: 25,
        onRowClick: (row, tr) => {
            viewCustomer(row);
        }
    });
    
    console.log('✅ Customer table initialized:', customersTable);
    console.log('🔍 Table ID:', customersTable ? customersTable.tableId : 'N/A');
    console.log('🔍 Container:', customersTable ? customersTable.container : 'N/A');
}

// Debug function to test search endpoint
function debugSearch() {
    const url = '<?= base_url("customers/search") ?>?search=&limit=5&offset=0&sort=&order=asc';
    console.log('🔍 DEBUG: Testing URL:', url);
    
    fetch(url)
        .then(response => {
            console.log('🔍 DEBUG Response status:', response.status);
            console.log('🔍 DEBUG Response headers:', response.headers);
            return response.text();
        })
        .then(text => {
            console.log('🔍 DEBUG Raw response:', text);
            try {
                const data = JSON.parse(text);
                console.log('🔍 DEBUG Parsed data:', data);
                console.log('🔍 DEBUG Total:', data.total);
                console.log('🔍 DEBUG Rows length:', data.rows ? data.rows.length : 0);
                console.log('🔍 DEBUG First row:', data.rows ? data.rows[0] : null);
            } catch (e) {
                console.error('🔍 DEBUG Parse error:', e);
            }
        })
        .catch(error => {
            console.error('🔍 DEBUG Fetch error:', error);
        });
}

// Add debug button
window.debugSearch = debugSearch;

function loadStats() {
    console.log('📊 Loading stats...');
    // Fetch stats from API
    fetch('<?= base_url("customers/stats") ?>')
        .then(response => {
            console.log('📊 Stats response:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('📊 Stats data:', data);
            const totalEl = document.getElementById('totalCustomers');
            const activeEl = document.getElementById('activeCustomers');
            const newEl = document.getElementById('newCustomers');
            
            if (totalEl && data.total !== undefined) {
                totalEl.textContent = new Intl.NumberFormat().format(data.total);
            }
            
            if (activeEl && data.active_this_month !== undefined) {
                activeEl.textContent = new Intl.NumberFormat().format(data.active_this_month);
            }
            
            if (newEl && data.new_this_month !== undefined) {
                newEl.textContent = new Intl.NumberFormat().format(data.new_this_month);
            }
        })
        .catch(error => {
            console.error('Error loading stats:', error);
            // Show fallback values
            document.getElementById('totalCustomers').textContent = '-';
            document.getElementById('activeCustomers').textContent = '-';
            document.getElementById('newCustomers').textContent = '-';
        });
}

function addCustomer() {
    window.location.href = '<?= base_url("customers/view/-1") ?>';
}

function viewCustomer(customer) {
    window.location.href = `<?= base_url("customers/view") ?>/${customer.person_id}`;
}

function editCustomer(customer) {
    window.location.href = `<?= base_url("customers/view") ?>/${customer.person_id}`;
}

function deleteCustomer(customer) {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Customer',
            `Are you sure you want to delete ${customer.first_name} ${customer.last_name}? This action cannot be undone.`,
            function() {
                // Perform delete
                fetch(`<?= base_url("customers/delete") ?>/${customer.person_id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.shopsuiteApp.showToast('Success', 'Customer deleted successfully', 'success');
                        customersTable.refresh();
                        loadStats();
                    } else {
                        window.shopsuiteApp.showToast('Error', data.message || 'Failed to delete customer', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.shopsuiteApp.showToast('Error', 'An error occurred while deleting the customer', 'error');
                });
            }
        );
    }
}

function importCustomers() {
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
                        First Name, Last Name, Email, Phone Number, Company, Address, City, State, Zip, Country
                    </div>
                </div>
                
                <div style="display: flex; gap: var(--space-2); margin-top: var(--space-4);">
                    <button type="submit" class="btn btn-primary">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Import Customers
                    </button>
                    <button type="button" class="btn btn-outline" onclick="window.shopsuiteApp.hideModal()">Cancel</button>
                    <a href="<?= base_url('customers/excel_export') ?>" class="btn btn-outline" download>
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download Template
                    </a>
                </div>
            </form>
        `;
        
        window.shopsuiteApp.showModal('Import Customers', modalHtml);
        
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
                    window.shopsuiteApp.showLoading('Importing customers...');
                }
                
                fetch('<?= base_url("customers/excel_import") ?>', {
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
                            window.shopsuiteApp.showToast('Success', data.message || 'Customers imported successfully', 'success');
                        }
                        setTimeout(() => {
                            customersTable.refresh();
                        }, 1000);
                    } else {
                        if (window.shopsuiteApp) {
                            window.shopsuiteApp.showToast('Error', data.message || 'Failed to import customers', 'error');
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
