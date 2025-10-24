<?php
/**
 * MODERN RECEIVINGS MANAGEMENT - Pure Native Solution
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.receivings'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-box-arrow-in-down me-2"></i>
                <?= lang('Module.receivings') ?>
            </h3>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="window.location.href='<?= base_url('receivings') ?>'">
                <i class="bi bi-plus-circle me-1"></i>New Receiving
            </button>
        </div>
    </div>
    
    <!-- Table Container -->
    <div id="dataTable-container"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Modern Receivings Page Loading...');
    
    // Define table columns
    const columns = [
        {
            field: 'receiving_id',
            title: 'Receiving ID',
            sortable: true,
            formatter: (value) => {
                return `<span class="badge bg-primary">#${value}</span>`;
            }
        },
        {
            field: 'receiving_time',
            title: 'Date & Time',
            sortable: true,
            formatter: (value) => {
                if (!value) return '-';
                const date = new Date(value);
                return `
                    <div>
                        <div>${date.toLocaleDateString()}</div>
                        <small class="text-muted">${date.toLocaleTimeString()}</small>
                    </div>
                `;
            }
        },
        {
            field: 'supplier_name',
            title: 'Supplier',
            sortable: true,
            formatter: (value) => {
                return value || '<span class="text-muted">N/A</span>';
            }
        },
        {
            field: 'items_purchased',
            title: 'Items',
            sortable: true,
            formatter: (value) => {
                return `<span class="badge bg-info">${value || 0}</span>`;
            }
        },
        {
            field: 'payment_type',
            title: 'Payment',
            sortable: true,
            formatter: (value) => {
                const badges = {
                    'cash': 'bg-success',
                    'credit': 'bg-primary',
                    'check': 'bg-warning',
                    'due': 'bg-danger'
                };
                const badgeClass = badges[value?.toLowerCase()] || 'bg-secondary';
                return `<span class="badge ${badgeClass}">${value || '-'}</span>`;
            }
        },
        {
            field: 'receiving_amount',
            title: 'Amount',
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
                        <button class="btn btn-outline-primary" onclick="viewReceiving(${row.receiving_id}); event.stopPropagation();" title="View">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteReceiving(${row.receiving_id}); event.stopPropagation();" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];
    
    // Initialize Modern DataTable
    window.receivingsTable = new ModernDataTable({
        tableId: 'dataTable',
        searchUrl: '<?= base_url('receivings/search') ?>',
        columns: columns,
        pageSize: <?= $config['lines_per_page'] ?? 20 ?>,
        uniqueId: 'receiving_id',
        onRowClick: function(row) {
            viewReceiving(row.receiving_id);
        },
        onLoadComplete: function(data) {
            console.log(`✅ Loaded ${data.total} receivings`);
        }
    });
    
    console.log('✅ Modern Receivings Page Ready');
});

// Receiving Actions
function viewReceiving(receivingId) {
    openModal(`receivings/receipt/${receivingId}`, 'View Receiving');
}

async function deleteReceiving(receivingId) {
    const result = await Swal.fire({
        title: 'Delete Receiving?',
        text: 'This action cannot be undone and will affect inventory',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    });
    
    if (result.isConfirmed) {
        try {
            showLoading('Deleting receiving...');
            
            const response = await fetch(`<?= base_url('receivings/delete/') ?>${receivingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            });
            
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification('Receiving deleted successfully', 'success');
                window.receivingsTable.refresh();
            } else {
                showNotification(data.message || 'Failed to delete receiving', 'error');
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
