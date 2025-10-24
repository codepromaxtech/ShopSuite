<?php
/**
 * MODERN EXPENSES MANAGEMENT - Pure Native Solution
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.expenses'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-cash-stack me-2"></i>
                <?= lang('Module.expenses') ?>
            </h3>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="openModal('expenses/view/-1', 'Add New Expense')">
                <i class="bi bi-plus-circle me-1"></i>Add Expense
            </button>
        </div>
    </div>
    
    <!-- Table Container -->
    <div id="dataTable-container"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Modern Expenses Page Loading...');
    
    // Define table columns
    const columns = [
        {
            field: 'expense_id',
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
            field: 'category',
            title: 'Category',
            sortable: true,
            formatter: (value) => {
                const colors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
                const color = colors[Math.abs(value?.charCodeAt(0) || 0) % colors.length];
                return value ? `<span class="badge bg-${color}">${value}</span>` : '-';
            }
        },
        {
            field: 'description',
            title: 'Description',
            sortable: true,
            formatter: (value) => {
                if (!value) return '-';
                const truncated = value.length > 40 ? value.substring(0, 40) + '...' : value;
                return truncated;
            }
        },
        {
            field: 'amount',
            title: 'Amount',
            sortable: true,
            formatter: (value) => {
                return `<span class="text-danger fw-bold"><?= $config['currency_symbol'] ?>${parseFloat(value || 0).toFixed(2)}</span>`;
            }
        },
        {
            field: 'employee_name',
            title: 'Added By',
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
                        <button class="btn btn-outline-primary" onclick="editExpense(${row.expense_id}); event.stopPropagation();" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteExpense(${row.expense_id}); event.stopPropagation();" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];
    
    // Initialize Modern DataTable
    window.expensesTable = new ModernDataTable({
        tableId: 'dataTable',
        searchUrl: '<?= base_url('expenses/search') ?>',
        columns: columns,
        pageSize: <?= $config['lines_per_page'] ?? 20 ?>,
        uniqueId: 'expense_id',
        onRowClick: function(row) {
            editExpense(row.expense_id);
        },
        onLoadComplete: function(data) {
            console.log(`✅ Loaded ${data.total} expenses`);
        }
    });
    
    console.log('✅ Modern Expenses Page Ready');
});

// Expense Actions
function editExpense(expenseId) {
    openModal(`expenses/view/${expenseId}`, 'Edit Expense');
}

async function deleteExpense(expenseId) {
    const result = await Swal.fire({
        title: 'Delete Expense?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    });
    
    if (result.isConfirmed) {
        try {
            showLoading('Deleting expense...');
            
            const response = await fetch('<?= base_url('expenses/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids: [expenseId] })
            });
            
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification('Expense deleted successfully', 'success');
                window.expensesTable.refresh();
            } else {
                showNotification(data.message || 'Failed to delete expense', 'error');
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
