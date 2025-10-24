<?php
/**
 * MODERN MESSAGES MANAGEMENT - Pure Native Solution
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.messages'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-chat-dots me-2"></i>
                <?= lang('Module.messages') ?>
            </h3>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="openModal('messages/view/-1', 'Send New Message')">
                <i class="bi bi-plus-circle me-1"></i>Send Message
            </button>
        </div>
    </div>
    
    <!-- Table Container -->
    <div id="dataTable-container"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Modern Messages Page Loading...');
    
    // Define table columns
    const columns = [
        {
            field: 'message_id',
            title: 'ID',
            sortable: true
        },
        {
            field: 'recipient',
            title: 'Recipient',
            sortable: true,
            formatter: (value, row) => {
                return `
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                             style="width: 32px; height: 32px; font-size: 14px;">
                            ${value?.charAt(0)?.toUpperCase() || '?'}
                        </div>
                        <div>
                            <div class="fw-bold">${value || '-'}</div>
                            ${row.phone_number ? `<small class="text-muted">${row.phone_number}</small>` : ''}
                        </div>
                    </div>
                `;
            }
        },
        {
            field: 'message',
            title: 'Message',
            sortable: false,
            formatter: (value) => {
                if (!value) return '-';
                const truncated = value.length > 50 ? value.substring(0, 50) + '...' : value;
                return `<small>${truncated}</small>`;
            }
        },
        {
            field: 'sent_time',
            title: 'Sent',
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
            field: 'actions',
            title: 'Actions',
            sortable: false,
            formatter: (value, row) => {
                return `
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-primary" onclick="viewMessage(${row.message_id}); event.stopPropagation();" title="View">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteMessage(${row.message_id}); event.stopPropagation();" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];
    
    // Initialize Modern DataTable
    window.messagesTable = new ModernDataTable({
        tableId: 'dataTable',
        searchUrl: '<?= base_url('messages/search') ?>',
        columns: columns,
        pageSize: <?= $config['lines_per_page'] ?? 20 ?>,
        uniqueId: 'message_id',
        onRowClick: function(row) {
            viewMessage(row.message_id);
        },
        onLoadComplete: function(data) {
            console.log(`✅ Loaded ${data.total} messages`);
        }
    });
    
    console.log('✅ Modern Messages Page Ready');
});

// Message Actions
function viewMessage(messageId) {
    openModal(`messages/view/${messageId}`, 'View Message');
}

async function deleteMessage(messageId) {
    const result = await Swal.fire({
        title: 'Delete Message?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    });
    
    if (result.isConfirmed) {
        try {
            showLoading('Deleting message...');
            
            const response = await fetch('<?= base_url('messages/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids: [messageId] })
            });
            
            const data = await response.json();
            hideLoading();
            
            if (data.success) {
                showNotification('Message deleted successfully', 'success');
                window.messagesTable.refresh();
            } else {
                showNotification(data.message || 'Failed to delete message', 'error');
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
