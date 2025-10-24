<?php
/**
 * MODERN GIFTCARDS MANAGEMENT - Pure Native Solution
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.giftcards'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-gift me-2"></i>
                <?= lang('Module.giftcards') ?>
            </h3>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="openModal('giftcards/view/-1', 'Add New Giftcard')">
                <i class="bi bi-plus-circle me-1"></i>Add Giftcard
            </button>
        </div>
    </div>
    
    <!-- Table Container -->
    <div id="dataTable-container"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Modern Giftcards Page Loading...');
    
    // Define table columns
    const columns = [
        {
            field: 'giftcard_id',
            title: 'ID',
            sortable: true
        },
        {
            field: 'giftcard_number',
            title: 'Card Number',
            sortable: true,
            formatter: (value) => {
                return `<span class="badge bg-primary font-monospace">${value || '-'}</span>`;
            }
        },
        {
            field: 'value',
            title: 'Value',
            sortable: true,
            formatter: (value) => {
                return `<span class="badge bg-success fs-6"><?= $config['currency_symbol'] ?>${parseFloat(value || 0).toFixed(2)}</span>`;
            }
        },
        {
            field: 'customer_name',
            title: 'Customer',
            sortable: false,
            formatter: (value, row) => {
                if (row.first_name || row.last_name) {
                    return `${row.first_name || ''} ${row.last_name || ''}`.trim();
                }
                return '<span class="text-muted">Unassigned</span>';
            }
        },
        {
            field: 'actions',
            title: 'Actions',
            sortable: false,
            formatter: (value, row) => {
                return `
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-primary" onclick="editGiftcard(${row.giftcard_id}); event.stopPropagation();" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteGiftcard(${row.giftcard_id}); event.stopPropagation();" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];
    
    // Initialize Modern DataTable
    window.giftcardsTable = new ModernDataTable({
        tableId: 'dataTable',
        searchUrl: '<?= base_url('giftcards/search') ?>',
        columns: columns,
        pageSize: <?= $config['lines_per_page'] ?? 20 ?>,
        uniqueId: 'giftcard_id',
        onRowClick: function(row) {
            editGiftcard(row.giftcard_id);
        },
        onLoadComplete: function(data) {
            console.log(`✅ Loaded ${data.total} giftcards`);
        }
    });
    
    console.log('✅ Modern Giftcards Page Ready');
});

// Giftcard Actions
function editGiftcard(giftcardId) {
    openModal(`giftcards/view/${giftcardId}`, 'Edit Giftcard');
}

async function deleteGiftcard(giftcardId) {
    const result = await Swal.fire({
        title: 'Delete Giftcard?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    });
    
    if (result.isConfirmed) {
        try {
            showLoading('Deleting giftcard...');
            
            const response = await fetch('<?= base_url('giftcards/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids: [giftcardId] })
            });
            
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification('Giftcard deleted successfully', 'success');
                window.giftcardsTable.refresh();
            } else {
                showNotification(data.message || 'Failed to delete giftcard', 'error');
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
