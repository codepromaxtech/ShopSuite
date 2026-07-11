<?php
$title = 'Gift Cards - ShopSuite';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-top">
        <div class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            <div>
                <h1>Gift Cards</h1>
            </div>
        </div>
        
        <div class="page-header-actions">
            <button class="btn btn-primary" onclick="addGiftcard()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Gift Card
            </button>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <div class="breadcrumb-item"><a href="<?= base_url('home') ?>">Dashboard</a></div>
        <span class="breadcrumb-separator">/</span>
        <div class="breadcrumb-item active">Gift Cards</div>
    </div>
</div>

<div class="card">
    <div class="card-body u-padding-0">
        <div id="giftcardsTable"></div>
    </div>
</div>

<script>
let giftcardsTable;

document.addEventListener('DOMContentLoaded', function() {
    initializeDataTable();
});

function initializeDataTable() {
    giftcardsTable = new ModernDataTable('#giftcardsTable', {
        ajax: {
            url: '<?= base_url("giftcards/search") ?>',
            dataSrc: 'rows'
        },
        columns: [
            { field: 'giftcard_id', title: 'ID', sortable: true },
            { 
                field: 'giftcard_number', 
                title: 'Card Number',
                sortable: true,
                render: (value) => `<span style="font-family: var(--font-mono); font-weight: 500;">${value}</span>`
            },
            { 
                field: 'value', 
                title: 'Value',
                sortable: true,
                render: (value) => {
                    const formatted = parseFloat(value).toFixed(2);
                    return `<span style="color: var(--color-success-600); font-weight: 600;">$${formatted}</span>`;
                }
            },
            { 
                field: 'first_name', 
                title: 'Owner',
                sortable: true,
                render: (value, row) => {
                    if (value || row.last_name) {
                        return `${value || ''} ${row.last_name || ''}`.trim();
                    }
                    return '<span class="u-color-text-tertiary">Unassigned</span>';
                }
            }
        ],
        actions: [
            {
                title: 'Edit',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>',
                className: 'btn-ghost',
                onClick: 'editGiftcard'
            },
            {
                title: 'Delete',
                icon: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>',
                className: 'btn-ghost',
                onClick: 'deleteGiftcard'
            }
        ],
        searchable: true,
        exportable: true,
        pageSize: 25,
        onRowClick: (row, tr) => {
            editGiftcard(row);
        }
    });
}

function addGiftcard() {
    window.location.href = '<?= base_url("giftcards/view/-1") ?>';
}

function editGiftcard(giftcard) {
    window.location.href = `<?= base_url("giftcards/view") ?>/${giftcard.giftcard_id}`;
}

function deleteGiftcard(giftcard) {
    if (window.shopsuiteApp) {
        window.shopsuiteApp.confirm(
            'Delete Gift Card',
            `Are you sure you want to delete gift card ${giftcard.giftcard_number}? This action cannot be undone.`,
            function() {
                const formData = new FormData();
                formData.append('ids[]', giftcard.giftcard_id);
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                fetch(`<?= base_url("giftcards/delete") ?>`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.shopsuiteApp.showToast('Success', 'Gift card deleted successfully', 'success');
                        giftcardsTable.refresh();
                    } else {
                        window.shopsuiteApp.showToast('Error', data.message || 'Failed to delete gift card', 'error');
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
