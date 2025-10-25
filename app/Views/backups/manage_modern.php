<?php
/**
 * MODERN BACKUP MANAGEMENT
 * Database Backup & Restore System
 */
$title = 'Database Backups';
echo view('layouts/modern_header', ['title' => $title]);
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-text">
            <h1 class="page-header-title">Database Backups</h1>
        </div>
    </div>
    <div class="page-header-actions">
        <button class="btn btn-primary" onclick="createBackup()">
            <i class="bi bi-plus-circle"></i>
            <span>Create Backup</span>
        </button>
        <a href="<?= base_url('backups/settings') ?>" class="btn btn-secondary">
            <i class="bi bi-gear"></i>
            <span>Settings</span>
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon">
            <i class="bi bi-database-fill-down"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label">Total Backups</div>
            <div class="stat-card-value"><?= count($backups) ?></div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-icon">
            <i class="bi bi-hdd"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label">Total Size</div>
            <div class="stat-card-value"><?= number_format($total_size / 1024 / 1024, 2) ?> MB</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-icon">
            <i class="bi bi-clock-history"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-label">Latest Backup</div>
            <div class="stat-card-value"><?= !empty($backups) ? date('M d', strtotime($backups[0]->created_at)) : 'Never' ?></div>
        </div>
    </div>
</div>

<!-- Backups Table -->
<div class="data-table-container">
    <div class="data-table-header">
        <h2 class="data-table-title">
            <i class="bi bi-list-ul"></i>
            Backup History
        </h2>
        <div class="data-table-actions">
            <button class="btn btn-danger" onclick="deleteSelected()" id="delete-btn" disabled>
                <i class="bi bi-trash"></i>
                <span>Delete Selected</span>
            </button>
            <button class="btn btn-secondary" onclick="cleanOldBackups()">
                <i class="bi bi-broom"></i>
                <span>Clean Old</span>
            </button>
        </div>
    </div>
    <div class="data-table-content">
        <?php if (empty($backups)): ?>
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h3>No backups found</h3>
                <p>Create your first backup to get started</p>
                <button class="btn btn-primary" onclick="createBackup()">
                    <i class="bi bi-plus-circle"></i>
                    <span>Create Backup</span>
                </button>
            </div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 40px">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th>Filename</th>
                        <th>Size</th>
                        <th>Type</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Notes</th>
                        <th style="width: 200px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($backups as $backup): ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="backup-checkbox" value="<?= $backup->backup_id ?>">
                        </td>
                        <td>
                            <i class="bi bi-file-earmark-zip"></i>
                            <strong><?= esc($backup->filename) ?></strong>
                        </td>
                        <td><?= number_format($backup->file_size / 1024 / 1024, 2) ?> MB</td>
                        <td>
                            <?php if ($backup->backup_type === 'auto'): ?>
                                <span class="badge badge-info">Auto</span>
                            <?php else: ?>
                                <span class="badge badge-primary">Manual</span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($backup->first_name . ' ' . $backup->last_name) ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($backup->created_at)) ?></td>
                        <td><?= esc($backup->notes) ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="<?= base_url('backups/download/' . $backup->backup_id) ?>" 
                                   class="btn btn-sm btn-primary" 
                                   title="Download">
                                    <i class="bi bi-download"></i>
                                </a>
                                <button class="btn btn-sm btn-success" 
                                        onclick="restoreBackup(<?= $backup->backup_id ?>, '<?= esc($backup->filename) ?>')" 
                                        title="Restore">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" 
                                        onclick="deleteBackup(<?= $backup->backup_id ?>)" 
                                        title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('💾 Backup Management Page Loaded');
    
    // Select all checkbox
    document.getElementById('select-all')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.backup-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateDeleteButton();
    });
    
    // Individual checkboxes
    document.querySelectorAll('.backup-checkbox').forEach(cb => {
        cb.addEventListener('change', updateDeleteButton);
    });
});

function updateDeleteButton() {
    const selected = document.querySelectorAll('.backup-checkbox:checked');
    const deleteBtn = document.getElementById('delete-btn');
    deleteBtn.disabled = selected.length === 0;
}

async function createBackup() {
    const notes = prompt('Enter backup notes (optional):');
    if (notes === null) return; // User cancelled
    
    try {
        const formData = new FormData();
        formData.append('notes', notes);
        
        const response = await fetch('<?= base_url('backups/create') ?>', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            window.shopsuiteApp?.showToast?.('Success', result.message, 'success') || alert(result.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            window.shopsuiteApp?.showToast?.('Error', result.message, 'error') || alert(result.message);
        }
    } catch (error) {
        window.shopsuiteApp?.showToast?.('Error', 'Failed to create backup', 'error') || alert('Error creating backup');
    }
}

async function restoreBackup(backupId, filename) {
    const confirmed = confirm(`WARNING: This will replace all current data with the backup:\n\n${filename}\n\nThis action cannot be undone! Continue?`);
    if (!confirmed) return;
    
    try {
        const formData = new FormData();
        formData.append('backup_id', backupId);
        
        const response = await fetch('<?= base_url('backups/restore') ?>', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            window.shopsuiteApp?.showToast?.('Restored!', result.message, 'success') || alert(result.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            window.shopsuiteApp?.showToast?.('Error', result.message, 'error') || alert(result.message);
        }
    } catch (error) {
        window.shopsuiteApp?.showToast?.('Error', 'An error occurred during restore', 'error') || alert('Error during restore');
    }
}

async function deleteBackup(backupId) {
    const confirmed = confirm('Delete this backup? This will permanently delete the backup file.');
    if (!confirmed) return;
    
    try {
        const formData = new FormData();
        formData.append('ids[]', backupId);
        
        const response = await fetch('<?= base_url('backups/delete') ?>', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            window.shopsuiteApp?.showToast?.('Success', result.message, 'success') || alert(result.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            window.shopsuiteApp?.showToast?.('Error', result.message, 'error') || alert(result.message);
        }
    } catch (error) {
        window.shopsuiteApp?.showToast?.('Error', 'Failed to delete backup', 'error') || alert('Error deleting backup');
    }
}

async function deleteSelected() {
    const selected = Array.from(document.querySelectorAll('.backup-checkbox:checked')).map(cb => cb.value);
    
    if (selected.length === 0) return;
    
    const confirmed = confirm(`Delete ${selected.length} selected backup(s)?`);
    if (!confirmed) return;
    
    try {
        const formData = new FormData();
        selected.forEach(id => formData.append('ids[]', id));
        
        const response = await fetch('<?= base_url('backups/delete') ?>', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            window.shopsuiteApp?.showToast?.('Success', result.message, 'success') || alert(result.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            window.shopsuiteApp?.showToast?.('Error', result.message, 'error') || alert(result.message);
        }
    } catch (error) {
        window.shopsuiteApp?.showToast?.('Error', 'Failed to delete backups', 'error') || alert('Error deleting backups');
    }
}

async function cleanOldBackups() {
    const keepCount = prompt('Keep how many recent backups?', '10');
    if (keepCount === null) return; // User cancelled
    
    if (isNaN(keepCount) || keepCount < 1) {
        alert('Please enter a valid number (minimum 1)');
        return;
    }
    
    try {
        const formData = new FormData();
        formData.append('keep_count', keepCount);
        
        const response = await fetch('<?= base_url('backups/clean') ?>', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            window.shopsuiteApp?.showToast?.('Success', result.message, 'success') || alert(result.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            window.shopsuiteApp?.showToast?.('Error', result.message, 'error') || alert(result.message);
        }
    } catch (error) {
        window.shopsuiteApp?.showToast?.('Error', 'Failed to clean backups', 'error') || alert('Error cleaning backups');
    }
}
</script>

<?= view('layouts/modern_footer') ?>
