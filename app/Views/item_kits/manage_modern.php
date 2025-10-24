<?php
/**
 * MODERN ITEM KITS MANAGEMENT - Pure Native Solution
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.item_kits'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-box2 me-2"></i>
                <?= lang('Module.item_kits') ?>
            </h3>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="openModal('item_kits/view/-1', 'Add New Item Kit')">
                <i class="bi bi-plus-circle me-1"></i>Add Item Kit
            </button>
        </div>
    </div>
    
    <!-- Table Container -->
    <div id="dataTable-container"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Modern Item Kits Page Loading...');
    
    // Define table columns
    const columns = [
        {
            field: 'item_kit_id',
            title: 'ID',
            sortable: true
        },
        {
            field: 'name',
            title: 'Kit Name',
            sortable: true,
            formatter: (value, row) => {
                return `
                    <div>
                        <div class="fw-bold">${value || '-'}</div>
                        <small class="text-muted">${row.item_kit_number || '-'}</small>
                    </div>
                `;
            }
        },
        {
            field: 'description',
            title: 'Description',
            sortable: true,
            formatter: (value) => {
                return value ? `<small>${value}</small>` : '-';
            }
        },
        {
            field: 'cost_price',
            title: 'Cost',
            sortable: true,
            formatter: (value) => {
                return `<span class="text-muted"><?= $config['currency_symbol'] ?>${parseFloat(value || 0).toFixed(2)}</span>`;
            }
        },
        {
            field: 'unit_price',
            title: 'Price',
            sortable: true,
            formatter: (value) => {
                return `<span class="text-success fw-bold"><?= $config['currency_symbol'] ?>${parseFloat(value || 0).toFixed(2)}</span>`;
            }
        },
        {
            field: 'actions',
            title: 'Actions',
            sortable: false,
            formatter: (value, row) => {
                return `
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-primary" onclick="editItemKit(${row.item_kit_id}); event.stopPropagation();" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteItemKit(${row.item_kit_id}); event.stopPropagation();" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];
    
    // Initialize Modern DataTable
    window.itemKitsTable = new ModernDataTable({
        tableId: 'dataTable',
        searchUrl: '<?= base_url('item_kits/search') ?>',
        columns: columns,
        pageSize: <?= $config['lines_per_page'] ?? 20 ?>,
        uniqueId: 'item_kit_id',
        onRowClick: function(row) {
            editItemKit(row.item_kit_id);
        },
        onLoadComplete: function(data) {
            console.log(`✅ Loaded ${data.total} item kits`);
        }
    });
    
    console.log('✅ Modern Item Kits Page Ready');
});

// Item Kit Actions
function editItemKit(itemKitId) {
    openModal(`item_kits/view/${itemKitId}`, 'Edit Item Kit');
}

async function deleteItemKit(itemKitId) {
    const result = await Swal.fire({
        title: 'Delete Item Kit?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    });
    
    if (result.isConfirmed) {
        try {
            showLoading('Deleting item kit...');
            
            const response = await fetch('<?= base_url('item_kits/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids: [itemKitId] })
            });
            
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification('Item kit deleted successfully', 'success');
                window.itemKitsTable.refresh();
            } else {
                showNotification(data.message || 'Failed to delete item kit', 'error');
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
