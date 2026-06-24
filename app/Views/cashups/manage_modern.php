<?php
$title = 'Cash Ups - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
            <div>
                <h1>Cash Ups</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <button class="btn btn-primary" onclick="addCashup()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Cash Up
            </button>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active">Cash Ups</div>
    </div>
</div>

<div class="card">
    <div class="card-body u-padding-0">
        <div id="cashupsTable"></div>
    </div>
</div>

<script>
let cashupsTable;

document.addEventListener('DOMContentLoaded', function() {
    initializeDataTable();
});

function initializeDataTable() {
    cashupsTable = new ModernDataTable('#cashupsTable', {
        ajax: {
            url: '<?= base_url("cashups/search") ?>',
            dataSrc: 'rows'
        },
        columns: [
            { field: 'cashup_id', title: 'ID', sortable: true },
            { 
                field: 'cashup_time', 
                title: 'Time',
                sortable: true,
                render: (value) => {
                    const date = new Date(value);
                    return date.toLocaleString();
                }
            },
            { field: 'employee_name', title: 'Employee', sortable: true },
            { 
                field: 'open_amount', 
                title: 'Opening',
                sortable: true,
                render: (value) => `<span class="u-color-text-secondary">$${parseFloat(value).toFixed(2)}</span>`
            },
            { 
                field: 'close_amount', 
                title: 'Closing',
                sortable: true,
                render: (value) => `<span class="u-color-success-600_font-weight-font-sem">$${parseFloat(value).toFixed(2)}</span>`
            },
            { 
                field: 'note', 
                title: 'Note',
                sortable: true,
                render: (value) => value ? value.substring(0, 50) + (value.length > 50 ? '...' : '') : '-'
            }
        ],
        actions: [
            {
                title: 'Edit',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>',
                className: 'btn-ghost',
                onClick: 'editCashup'
            },
            {
                title: 'Delete',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>',
                className: 'btn-ghost',
                onClick: 'deleteCashup'
            }
        ],
        searchable: true,
        exportable: true,
        pageSize: 25,
        onRowClick: (row, tr) => {
            editCashup(row);
        }
    });
}

function addCashup() {
    window.location.href = '<?= base_url("cashups/view/-1") ?>';
}

function editCashup(cashup) {
    window.location.href = `<?= base_url("cashups/view") ?>/${cashup.cashup_id}`;
}

function deleteCashup(cashup) {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Cash Up',
            `Are you sure you want to delete this cash up record? This action cannot be undone.`,
            function() {
                fetch(`<?= base_url("cashups/delete") ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ ids: [cashup.cashup_id] })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.shopsuiteApp.showToast('Success', 'Cash up deleted successfully', 'success');
                        cashupsTable.refresh();
                    } else {
                        window.shopsuiteApp.showToast('Error', data.message || 'Failed to delete cash up', 'error');
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
