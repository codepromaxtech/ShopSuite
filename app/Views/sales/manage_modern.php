<?php
/**
 * MODERN SALES MANAGEMENT - Pure Native Solution
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.sales'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-receipt me-2"></i>
                <?= lang('Module.sales') ?>
            </h3>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="window.location.href='<?= base_url('sales') ?>'">
                <i class="bi bi-plus-circle me-1"></i>New Sale
            </button>
        </div>
    </div>
    
    <!-- Table Container -->
    <div id="dataTable-container"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Modern Sales Page Loading...');
    
    // Define table columns
    const columns = [
        {
            field: 'sale_id',
            title: 'Sale ID',
            sortable: true,
            formatter: (value) => {
                return `<span class="badge bg-primary">#${value}</span>`;
            }
        },
        {
            field: 'sale_time',
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
            field: 'customer_name',
            title: 'Customer',
            sortable: true,
            formatter: (value, row) => {
                return value || '<span class="text-muted">Walk-in</span>';
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
            field: 'sale_amount',
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
                        <button class="btn btn-outline-primary" onclick="viewSale(${row.sale_id}); event.stopPropagation();" title="View">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-outline-info" onclick="printReceipt(${row.sale_id}); event.stopPropagation();" title="Print">
                            <i class="bi bi-printer"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteSale(${row.sale_id}); event.stopPropagation();" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];
    
    // Initialize Modern DataTable
    window.salesTable = new ModernDataTable({
        tableId: 'dataTable',
        searchUrl: '<?= base_url('sales/search') ?>',
        columns: columns,
        pageSize: <?= $config['lines_per_page'] ?? 20 ?>,
        uniqueId: 'sale_id',
        onRowClick: function(row) {
            viewSale(row.sale_id);
        },
        onLoadComplete: function(data) {
            console.log(`✅ Loaded ${data.total} sales`);
        }
    });
    
    console.log('✅ Modern Sales Page Ready');
});

// Sale Actions
function viewSale(saleId) {
    openModal(`sales/receipt/${saleId}`, 'View Sale');
}

function printReceipt(saleId) {
    window.open(`<?= base_url('sales/receipt/') ?>${saleId}?print=true`, '_blank');
}

async function deleteSale(saleId) {
    const result = await Swal.fire({
        title: 'Delete Sale?',
        text: 'This action cannot be undone and will affect inventory',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    });
    
    if (result.isConfirmed) {
        try {
            showLoading('Deleting sale...');
            
            const response = await fetch(`<?= base_url('sales/delete/') ?>${saleId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            });
            
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification('Sale deleted successfully', 'success');
                window.salesTable.refresh();
            } else {
                showNotification(data.message || 'Failed to delete sale', 'error');
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
