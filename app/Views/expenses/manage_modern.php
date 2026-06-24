<?php
$title = 'Expenses - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            <div>
                <h1>Expenses</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <button class="btn btn-primary" onclick="addExpense()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Expense
            </button>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active">Expenses</div>
    </div>
</div>

<div class="card">
    <div class="card-body u-padding-0">
        <div id="expensesTable"></div>
    </div>
</div>

<script>
let expensesTable;

document.addEventListener('DOMContentLoaded', function() {
    initializeDataTable();
});

function initializeDataTable() {
    expensesTable = new ModernDataTable('#expensesTable', {
        ajax: {
            url: '<?= base_url("expenses/search") ?>',
            dataSrc: 'rows'
        },
        columns: [
            { field: 'expense_id', title: 'ID', sortable: true },
            { 
                field: 'date', 
                title: 'Date',
                sortable: true,
                render: (value) => {
                    const date = new Date(value);
                    return date.toLocaleDateString();
                }
            },
            { 
                field: 'category', 
                title: 'Category',
                sortable: true,
                render: (value) => `<span class="badge badge-primary">${value || 'Uncategorized'}</span>`
            },
            { 
                field: 'description', 
                title: 'Description',
                sortable: true
            },
            { 
                field: 'amount', 
                title: 'Amount',
                sortable: true,
                render: (value) => {
                    const formatted = parseFloat(value).toFixed(2);
                    return `<span class="u-color-danger-600_font-weight-font-semi">$${formatted}</span>`;
                }
            },
            { field: 'employee_name', title: 'Employee', sortable: true }
        ],
        actions: [
            {
                title: 'Edit',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>',
                className: 'btn-ghost',
                onClick: 'editExpense'
            },
            {
                title: 'Delete',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>',
                className: 'btn-ghost',
                onClick: 'deleteExpense'
            }
        ],
        searchable: true,
        exportable: true,
        pageSize: 25,
        onRowClick: (row, tr) => {
            editExpense(row);
        }
    });
}

function addExpense() {
    window.location.href = '<?= base_url("expenses/view/-1") ?>';
}

function editExpense(expense) {
    window.location.href = `<?= base_url("expenses/view") ?>/${expense.expense_id}`;
}

function deleteExpense(expense) {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Expense',
            `Are you sure you want to delete this expense? This action cannot be undone.`,
            function() {
                fetch(`<?= base_url("expenses/delete") ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ ids: [expense.expense_id] })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.shopsuiteApp.showToast('Success', 'Expense deleted successfully', 'success');
                        expensesTable.refresh();
                    } else {
                        window.shopsuiteApp.showToast('Error', data.message || 'Failed to delete expense', 'error');
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
