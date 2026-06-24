<?php
/**
 * PREMIUM BACKUP MANAGEMENT
 * Modern Database Backup & Restore System
 */
$title = 'Database Backups';
echo view('layouts/modern_header', ['title' => $title]);
?>



<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-text">
            <h1 class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                </svg>
                Database Backups
            </h1>
        </div>
    </div>
    <div class="page-header-actions">
        <button class="btn btn-primary" onclick="openCreateModal()">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Create Backup</span>
        </button>
        <a href="<?= base_url('backups/settings') ?>" class="btn btn-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span>Settings</span>
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="backup-hero">
    <div class="backup-stat-card">
        <div class="backup-stat-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
            </svg>
        </div>
        <div>
            <div class="backup-stat-label">Total Backups</div>
            <div class="backup-stat-value"><?= count($backups) ?></div>
        </div>
    </div>

    <div class="backup-stat-card">
        <div class="backup-stat-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
            </svg>
        </div>
        <div>
            <div class="backup-stat-label">Total Size</div>
            <div class="backup-stat-value"><?= number_format($total_size / 1024 / 1024, 2) ?> MB</div>
        </div>
    </div>

    <div class="backup-stat-card">
        <div class="backup-stat-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="backup-stat-label">Latest Backup</div>
            <div class="backup-stat-value"><?= !empty($backups) ? date('M d, H:i', strtotime($backups[0]->created_at)) : 'Never' ?></div>
        </div>
    </div>

    <div class="backup-stat-card">
        <div class="backup-stat-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
        </div>
        <div>
            <div class="backup-stat-label">Status</div>
            <div class="backup-stat-value u-color-success-600_font-size-text-base">● Healthy</div>
        </div>
    </div>
</div>

<!-- Backup History Panel -->
<div class="backup-panel">
    <div class="backup-panel-header">
        <div class="backup-panel-title">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            Backup History
        </div>
        <div class="backup-panel-actions">
            <button class="btn btn-danger btn-sm" onclick="deleteSelected()" id="delete-selected-btn" disabled>
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span>Delete Selected</span>
            </button>
            <button class="btn btn-secondary btn-sm" onclick="openCleanModal()">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span>Clean Old</span>
            </button>
        </div>
    </div>

    <div class="backup-panel-body">
        <?php if (empty($backups)): ?>
            <div class="backup-empty">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <h3>No backups yet</h3>
                <p>Create your first database backup to safeguard your data. Backups can be restored at any time.</p>
                <button class="btn btn-primary" onclick="openCreateModal()">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create First Backup
                </button>
            </div>
        <?php else: ?>
            <table class="backup-table">
                <thead>
                    <tr>
                        <th class="u-width-40px"><input type="checkbox" id="select-all"></th>
                        <th>Filename</th>
                        <th>Size</th>
                        <th>Type</th>
                        <th>Created By</th>
                        <th>Date</th>
                        <th>Notes</th>
                        <th class="u-width-140px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($backups as $backup): ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="backup-checkbox" value="<?= $backup->backup_id ?>">
                        </td>
                        <td>
                            <div class="backup-filename">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7"></path>
                                </svg>
                                <?= esc($backup->filename) ?>
                            </div>
                        </td>
                        <td><?= number_format($backup->file_size / 1024 / 1024, 2) ?> MB</td>
                        <td>
                            <span class="backup-type-badge <?= $backup->backup_type === 'auto' ? 'badge-auto' : 'badge-manual' ?>">
                                <?= ucfirst($backup->backup_type) ?>
                            </span>
                        </td>
                        <td><?= esc(($backup->first_name ?? '') . ' ' . ($backup->last_name ?? '')) ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($backup->created_at)) ?></td>
                        <td><?= esc($backup->notes ?? '') ?></td>
                        <td>
                            <div class="backup-actions-cell">
                                <a href="<?= base_url('backups/download/' . $backup->backup_id) ?>" 
                                   class="backup-action-btn" title="Download">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </a>
                                <button class="backup-action-btn success" 
                                        onclick="openRestoreModal(<?= $backup->backup_id ?>, '<?= esc($backup->filename) ?>')" 
                                        title="Restore">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </button>
                                <button class="backup-action-btn danger" 
                                        onclick="deleteSingleBackup(<?= $backup->backup_id ?>)" 
                                        title="Delete">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
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

<!-- Create Backup Modal -->
<div class="backup-modal-overlay" id="create-modal">
    <div class="backup-modal">
        <div class="backup-modal-header">
            <h3>Create New Backup</h3>
        </div>
        <div class="backup-modal-body">
            <p class="u-color-text-secondary_margin-bottom-spa">
                This will create a full database backup using <code>mysqldump</code>. The process may take a few moments depending on database size.
            </p>
            <div class="form-group">
                <label class="form-label" for="backup-notes">Notes (optional)</label>
                <textarea class="form-control" id="backup-notes" rows="3" placeholder="e.g., Before system update..."></textarea>
            </div>
        </div>
        <div class="backup-modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('create-modal')">Cancel</button>
            <button class="btn btn-primary" onclick="createBackup()">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                Start Backup
            </button>
        </div>
    </div>
</div>

<!-- Restore Modal -->
<div class="backup-modal-overlay" id="restore-modal">
    <div class="backup-modal">
        <div class="backup-modal-header">
            <h3>⚠️ Restore Database</h3>
        </div>
        <div class="backup-modal-body">
            <div class="u-background-danger-50_border-left-4pxso">
                <strong class="u-color-danger-700">Warning: Destructive Action</strong>
                <p class="u-color-danger-600_margin-space-1000_fon">
                    This will replace <strong>ALL current data</strong> with the selected backup. This action cannot be undone.
                </p>
            </div>
            <p class="u-color-text-secondary">
                Restoring: <strong id="restore-filename"></strong>
            </p>
        </div>
        <div class="backup-modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('restore-modal')">Cancel</button>
            <button class="btn btn-danger" id="confirm-restore-btn" onclick="confirmRestore()">
                Confirm Restore
            </button>
        </div>
    </div>
</div>

<!-- Clean Old Backups Modal -->
<div class="backup-modal-overlay" id="clean-modal">
    <div class="backup-modal">
        <div class="backup-modal-header">
            <h3>Clean Old Backups</h3>
        </div>
        <div class="backup-modal-body">
            <p class="u-color-text-secondary_margin-bottom-spa">
                Remove older backups to free up disk space. Specify how many recent backups to keep.
            </p>
            <div class="form-group">
                <label class="form-label" for="keep-count">Keep Recent Backups</label>
                <input type="number" class="form-control" id="keep-count" value="10" min="1" max="100">
            </div>
        </div>
        <div class="backup-modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('clean-modal')">Cancel</button>
            <button class="btn btn-warning" onclick="confirmClean()">Clean Old Backups</button>
        </div>
    </div>
</div>

<!-- Progress Overlay -->
<div class="backup-progress" id="progress-overlay">
    <div class="backup-spinner"></div>
    <div class="backup-progress-text" id="progress-text">Creating backup...</div>
</div>

<script>
let restoreBackupId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox
    document.getElementById('select-all')?.addEventListener('change', function() {
        document.querySelectorAll('.backup-checkbox').forEach(cb => cb.checked = this.checked);
        updateDeleteBtn();
    });
    
    document.querySelectorAll('.backup-checkbox').forEach(cb => {
        cb.addEventListener('change', updateDeleteBtn);
    });
});

function updateDeleteBtn() {
    const count = document.querySelectorAll('.backup-checkbox:checked').length;
    const btn = document.getElementById('delete-selected-btn');
    btn.disabled = count === 0;
    btn.querySelector('span').textContent = count > 0 ? `Delete Selected (${count})` : 'Delete Selected';
}

function openCreateModal() { document.getElementById('create-modal').classList.add('active'); }
function openCleanModal() { document.getElementById('clean-modal').classList.add('active'); }

function openRestoreModal(id, filename) {
    restoreBackupId = id;
    document.getElementById('restore-filename').textContent = filename;
    document.getElementById('restore-modal').classList.add('active');
}

function closeModal(id) { document.getElementById(id).classList.remove('active'); }

function showProgress(text) {
    document.getElementById('progress-text').textContent = text;
    document.getElementById('progress-overlay').classList.add('active');
}

function hideProgress() {
    document.getElementById('progress-overlay').classList.remove('active');
}

function showToast(title, msg, type) {
    if (window.shopsuiteApp?.showToast) {
        window.shopsuiteApp.showToast(title, msg, type);
    } else {
        alert(title + ': ' + msg);
    }
}

async function createBackup() {
    const notes = document.getElementById('backup-notes').value;
    closeModal('create-modal');
    showProgress('Creating database backup...');
    
    try {
        const fd = new FormData();
        fd.append('notes', notes);
        const res = await fetch('<?= base_url("backups/create") ?>', { method: 'POST', body: fd });
        const result = await res.json();
        hideProgress();
        showToast(result.success ? 'Success' : 'Error', result.message, result.success ? 'success' : 'error');
        if (result.success) setTimeout(() => location.reload(), 1200);
    } catch (e) {
        hideProgress();
        showToast('Error', 'Backup creation failed', 'error');
    }
}

async function confirmRestore() {
    closeModal('restore-modal');
    showProgress('Restoring database...');
    
    try {
        const fd = new FormData();
        fd.append('backup_id', restoreBackupId);
        const res = await fetch('<?= base_url("backups/restore") ?>', { method: 'POST', body: fd });
        const result = await res.json();
        hideProgress();
        showToast(result.success ? 'Restored' : 'Error', result.message, result.success ? 'success' : 'error');
        if (result.success) setTimeout(() => location.reload(), 1500);
    } catch (e) {
        hideProgress();
        showToast('Error', 'Restore failed', 'error');
    }
}

async function deleteSingleBackup(id) {
    if (!confirm('Delete this backup permanently?')) return;
    
    try {
        const fd = new FormData();
        fd.append('ids[]', id);
        const res = await fetch('<?= base_url("backups/delete") ?>', { method: 'POST', body: fd });
        const result = await res.json();
        showToast(result.success ? 'Deleted' : 'Error', result.message, result.success ? 'success' : 'error');
        if (result.success) setTimeout(() => location.reload(), 1000);
    } catch (e) {
        showToast('Error', 'Delete failed', 'error');
    }
}

async function deleteSelected() {
    const ids = Array.from(document.querySelectorAll('.backup-checkbox:checked')).map(cb => cb.value);
    if (!ids.length || !confirm(`Delete ${ids.length} selected backup(s)?`)) return;
    
    try {
        const fd = new FormData();
        ids.forEach(id => fd.append('ids[]', id));
        const res = await fetch('<?= base_url("backups/delete") ?>', { method: 'POST', body: fd });
        const result = await res.json();
        showToast(result.success ? 'Deleted' : 'Error', result.message, result.success ? 'success' : 'error');
        if (result.success) setTimeout(() => location.reload(), 1000);
    } catch (e) {
        showToast('Error', 'Delete failed', 'error');
    }
}

async function confirmClean() {
    const keepCount = document.getElementById('keep-count').value;
    if (isNaN(keepCount) || keepCount < 1) { alert('Enter a valid number (min 1)'); return; }
    closeModal('clean-modal');
    
    try {
        const fd = new FormData();
        fd.append('keep_count', keepCount);
        const res = await fetch('<?= base_url("backups/clean") ?>', { method: 'POST', body: fd });
        const result = await res.json();
        showToast(result.success ? 'Cleaned' : 'Error', result.message, result.success ? 'success' : 'error');
        if (result.success) setTimeout(() => location.reload(), 1000);
    } catch (e) {
        showToast('Error', 'Clean failed', 'error');
    }
}

// Close modals on overlay click
document.querySelectorAll('.backup-modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });
});
</script>

<?= view('layouts/modern_footer') ?>
