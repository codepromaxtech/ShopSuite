<?php
/**
 * MODERN ITEMS MANAGEMENT - Pure Native Solution
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.items'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-box-seam me-2"></i>
                <?= lang('Module.items') ?>
            </h3>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="openModal('items/view/-1', 'Add New Item')">
                <i class="bi bi-plus-circle me-1"></i>Add Item
            </button>
        </div>
    </div>
    
    <!-- Table Container -->
    <div id="dataTable-container"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Modern Items Page Loading...');
    
    // Define table columns
    const columns = [
        {
            field: 'item_id',
            title: 'ID',
            sortable: true
        },
        {
            field: 'name',
            title: 'Item',
            sortable: true,
            formatter: (value, row) => {
                return `
                    <div>
                        <div class="fw-bold">${row.name || '-'}</div>
                        <small class="text-muted">${row.item_number || '-'}</small>
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
            field: 'unit_price',
            title: 'Price',
            sortable: true,
            formatter: (value) => {
                return value ? `<span class="text-success fw-bold"><?= $config['currency_symbol'] ?>${parseFloat(value).toFixed(2)}</span>` : '-';
            }
        },
        {
            field: 'quantity',
            title: 'Stock',
            sortable: true,
            formatter: (value) => {
                const qty = parseFloat(value || 0);
                let badgeClass = 'bg-success';
                if (qty <= 0) badgeClass = 'bg-danger';
                else if (qty < 10) badgeClass = 'bg-warning';
                return `<span class="badge ${badgeClass}">${qty}</span>`;
            }
        },
        {
            field: 'actions',
            title: 'Actions',
            sortable: false,
            formatter: (value, row) => {
                return `
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-primary" onclick="editItem(${row.item_id}); event.stopPropagation();" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteItem(${row.item_id}); event.stopPropagation();" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];
    
    // Initialize Modern DataTable
    window.itemsTable = new ModernDataTable({
        tableId: 'dataTable',
        searchUrl: '<?= base_url('items/search') ?>',
        columns: columns,
        pageSize: <?= $config['lines_per_page'] ?? 20 ?>,
        uniqueId: 'item_id',
        onRowClick: function(row) {
            editItem(row.item_id);
        },
        onLoadComplete: function(data) {
            console.log(`✅ Loaded ${data.total} items`);
        }
    });
    
    console.log('✅ Modern Items Page Ready');
});

// Item Actions
function editItem(itemId) {
    openModal(`items/view/${itemId}`, 'Edit Item');
}

async function deleteItem(itemId) {
    const result = await Swal.fire({
        title: 'Delete Item?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    });
    
    if (result.isConfirmed) {
        try {
            showLoading('Deleting item...');
            
            const response = await fetch('<?= base_url('items/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids: [itemId] })
            });
            
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification('Item deleted successfully', 'success');
                window.itemsTable.refresh();
            } else {
                showNotification(data.message || 'Failed to delete item', 'error');
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
