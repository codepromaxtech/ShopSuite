<?php
/**
 * MODERN CASHUPS MANAGEMENT - Pure Native Solution
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.cashups'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-calculator me-2"></i>
                <?= lang('Module.cashups') ?>
            </h3>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="openModal('cashups/view/-1', 'New Cash Up')">
                <i class="bi bi-plus-circle me-1"></i>New Cash Up
            </button>
        </div>
    </div>
    
    <!-- Table Container -->
    <div id="dataTable-container"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Modern Cashups Page Loading...');
    
    // Define table columns
    const columns = [
        {
            field: 'cashup_id',
            title: 'ID',
            sortable: true
        },
        {
            field: 'cashup_time',
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
            field: 'employee_name',
            title: 'Employee',
            sortable: true,
            formatter: (value) => {
                return value || '<span class="text-muted">Unknown</span>';
            }
        },
        {
            field: 'open_amount',
            title: 'Opening',
            sortable: true,
            formatter: (value) => {
                return `<span class="text-info"><?= $config['currency_symbol'] ?>${parseFloat(value || 0).toFixed(2)}</span>`;
            }
        },
        {
            field: 'close_amount',
            title: 'Closing',
            sortable: true,
            formatter: (value) => {
                return `<span class="text-success fw-bold"><?= $config['currency_symbol'] ?>${parseFloat(value || 0).toFixed(2)}</span>`;
            }
        },
        {
            field: 'note',
            title: 'Note',
            sortable: false,
            formatter: (value) => {
                if (!value) return '-';
                const truncated = value.length > 30 ? value.substring(0, 30) + '...' : value;
                return `<small>${truncated}</small>`;
            }
        },
        {
            field: 'actions',
            title: 'Actions',
            sortable: false,
            formatter: (value, row) => {
                return `
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-primary" onclick="viewCashup(${row.cashup_id}); event.stopPropagation();" title="View">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteCashup(${row.cashup_id}); event.stopPropagation();" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];
    
    // Initialize Modern DataTable
    window.cashupsTable = new ModernDataTable({
        tableId: 'dataTable',
        searchUrl: '<?= base_url('cashups/search') ?>',
        columns: columns,
        pageSize: <?= $config['lines_per_page'] ?? 20 ?>,
        uniqueId: 'cashup_id',
        onRowClick: function(row) {
            viewCashup(row.cashup_id);
        },
        onLoadComplete: function(data) {
            console.log(`✅ Loaded ${data.total} cashups`);
        }
    });
    
    console.log('✅ Modern Cashups Page Ready');
});

// Cashup Actions
function viewCashup(cashupId) {
    openModal(`cashups/view/${cashupId}`, 'View Cash Up');
}

async function deleteCashup(cashupId) {
    const result = await Swal.fire({
        title: 'Delete Cash Up?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    });
    
    if (result.isConfirmed) {
        try {
            showLoading('Deleting cash up...');
            
            const response = await fetch('<?= base_url('cashups/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids: [cashupId] })
            });
            
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification('Cash up deleted successfully', 'success');
                window.cashupsTable.refresh();
            } else {
                showNotification(data.message || 'Failed to delete cash up', 'error');
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
