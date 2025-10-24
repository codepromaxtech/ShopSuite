<?php
/**
 * MODERN EXPENSE CATEGORIES MANAGEMENT - Pure Native Solution
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.expenses_categories'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-tags me-2"></i>
                Expense Categories
            </h3>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="openModal('expenses_categories/view/-1', 'Add New Category')">
                <i class="bi bi-plus-circle me-1"></i>Add Category
            </button>
        </div>
    </div>
    
    <!-- Table Container -->
    <div id="dataTable-container"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Modern Expense Categories Page Loading...');
    
    // Define table columns
    const columns = [
        {
            field: 'expense_category_id',
            title: 'ID',
            sortable: true
        },
        {
            field: 'category_name',
            title: 'Category Name',
            sortable: true,
            formatter: (value) => {
                const colors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
                const color = colors[Math.abs(value?.charCodeAt(0) || 0) % colors.length];
                return value ? `<span class="badge bg-${color} fs-6">${value}</span>` : '-';
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
            field: 'actions',
            title: 'Actions',
            sortable: false,
            formatter: (value, row) => {
                return `
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-primary" onclick="editCategory(${row.expense_category_id}); event.stopPropagation();" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteCategory(${row.expense_category_id}); event.stopPropagation();" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];
    
    // Initialize Modern DataTable
    window.categoriesTable = new ModernDataTable({
        tableId: 'dataTable',
        searchUrl: '<?= base_url('expenses_categories/search') ?>',
        columns: columns,
        pageSize: <?= $config['lines_per_page'] ?? 20 ?>,
        uniqueId: 'expense_category_id',
        onRowClick: function(row) {
            editCategory(row.expense_category_id);
        },
        onLoadComplete: function(data) {
            console.log(`✅ Loaded ${data.total} expense categories`);
        }
    });
    
    console.log('✅ Modern Expense Categories Page Ready');
});

// Category Actions
function editCategory(categoryId) {
    openModal(`expenses_categories/view/${categoryId}`, 'Edit Category');
}

async function deleteCategory(categoryId) {
    const result = await Swal.fire({
        title: 'Delete Category?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    });
    
    if (result.isConfirmed) {
        try {
            showLoading('Deleting category...');
            
            const response = await fetch('<?= base_url('expenses_categories/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids: [categoryId] })
            });
            
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification('Category deleted successfully', 'success');
                window.categoriesTable.refresh();
            } else {
                showNotification(data.message || 'Failed to delete category', 'error');
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
