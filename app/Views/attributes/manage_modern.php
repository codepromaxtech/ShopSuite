<?php
/**
 * MODERN ATTRIBUTES MANAGEMENT - Pure Native Solution
 */
?>

$title = 'Attributes';
echo view('layouts/modern_header', ['title' => $title]);
?>

<!-- Page Header -->
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-header-title mb-0">
                <i class="bi bi-list-check me-2"></i>
                <?= lang('Module.attributes') ?>
            </h3>
            <button class="btn btn-primary" onclick="openModal('attributes/view/-1', 'Add New Attribute')">
                <i class="bi bi-plus-circle me-1"></i>Add Attribute
            </button>
        </div>
        <div class="card-body">
            <!-- Table Container -->
            <div id="dataTable-container"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Modern Attributes Page Loading...');
    
    // Define table columns
    const columns = [
        {
            field: 'attribute_id',
            title: 'ID',
            sortable: true
        },
        {
            field: 'attribute_name',
            title: 'Attribute Name',
            sortable: true,
            formatter: (value) => {
                return `<span class="fw-bold">${value || '-'}</span>`;
            }
        },
        {
            field: 'attribute_type',
            title: 'Type',
            sortable: true,
            formatter: (value) => {
                const types = {
                    'TEXT': 'primary',
                    'DROPDOWN': 'success',
                    'CHECKBOX': 'info',
                    'DATE': 'warning'
                };
                const color = types[value] || 'secondary';
                return value ? `<span class="badge bg-${color}">${value}</span>` : '-';
            }
        },
        {
            field: 'attribute_values',
            title: 'Values',
            sortable: false,
            formatter: (value) => {
                if (!value) return '-';
                const truncated = value.length > 40 ? value.substring(0, 40) + '...' : value;
                return `<small class="text-secondary">${truncated}</small>`;
            }
        },
        {
            field: 'actions',
            title: 'Actions',
            sortable: false,
            formatter: (value, row) => {
                return `
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-primary" onclick="editAttribute(${row.attribute_id}); event.stopPropagation();" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteAttribute(${row.attribute_id}); event.stopPropagation();" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];
    
    // Initialize Modern DataTable
    window.attributesTable = new ModernDataTable({
        tableId: 'dataTable',
        searchUrl: '<?= base_url('attributes/search') ?>',
        columns: columns,
        pageSize: <?= $config['lines_per_page'] ?? 20 ?>,
        uniqueId: 'attribute_id',
        onRowClick: function(row) {
            editAttribute(row.attribute_id);
        },
        onLoadComplete: function(data) {
            console.log(`✅ Loaded ${data.total} attributes`);
        }
    });
    
    console.log('✅ Modern Attributes Page Ready');
});

// Attribute Actions
function editAttribute(attributeId) {
    openModal(`attributes/view/${attributeId}`, 'Edit Attribute');
}

async function deleteAttribute(attributeId) {
    const result = await Swal.fire({
        title: 'Delete Attribute?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    });
    
    if (result.isConfirmed) {
        try {
            showLoading('Deleting attribute...');
            
            const response = await fetch('<?= base_url('attributes/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids: [attributeId] })
            });
            
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification('Attribute deleted successfully', 'success');
                window.attributesTable.refresh();
            } else {
                showNotification(data.message || 'Failed to delete attribute', 'error');
            }
        } catch (error) {
            hideLoading();
            console.error('Delete error:', error);
            showNotification('An error occurred', 'error');
        }
    }
}
</script>

<?= view('layouts/modern_footer') ?>
