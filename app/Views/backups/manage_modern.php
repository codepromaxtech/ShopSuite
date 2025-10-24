<?php
/**
 * MODERN BACKUP MANAGEMENT
 * Database Backup & Restore System
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => 'Database Backups',
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<div class="container-fluid py-3">
    <div class="row align-items-center mb-3">
        <div class="col">
            <h3 class="mb-0">
                <i class="bi bi-database-fill-down me-2"></i>
                Database Backups
            </h3>
            <small class="text-muted">Create, download, and restore database backups</small>
        </div>
        <div class="col-auto">
            <button class="btn btn-success" onclick="createBackup()">
                <i class="bi bi-plus-circle me-1"></i>Create Backup
            </button>
            <a href="<?= base_url('backups/settings') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-gear me-1"></i>Auto Backup Settings
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="bi bi-database-fill-down text-primary" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Backups</h6>
                            <h2 class="mb-0"><?= count($backups) ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="bi bi-hdd text-success" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Size</h6>
                            <h2 class="mb-0"><?= number_format($total_size / 1024 / 1024, 2) ?> MB</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="bi bi-clock-history text-info" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Latest Backup</h6>
                            <h2 class="mb-0"><?= !empty($backups) ? date('M d', strtotime($backups[0]->created_at)) : 'Never' ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Backups Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Backup History</h5>
            <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-danger" onclick="deleteSelected()" id="delete-btn" disabled>
                    <i class="bi bi-trash"></i> Delete Selected
                </button>
                <button class="btn btn-outline-warning" onclick="cleanOldBackups()">
                    <i class="bi bi-broom"></i> Clean Old
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <?php if (empty($backups)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 4rem; opacity: 0.3;"></i>
                    <h5 class="mt-3 text-muted">No backups found</h5>
                    <p class="text-muted">Create your first backup to get started</p>
                    <button class="btn btn-primary" onclick="createBackup()">
                        <i class="bi bi-plus-circle me-1"></i>Create Backup
                    </button>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="40">
                                    <input type="checkbox" class="form-check-input" id="select-all">
                                </th>
                                <th>Filename</th>
                                <th>Size</th>
                                <th>Type</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Notes</th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($backups as $backup): ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input backup-checkbox" value="<?= $backup->backup_id ?>">
                                    </td>
                                    <td>
                                        <i class="bi bi-file-earmark-zip text-primary me-2"></i>
                                        <strong><?= esc($backup->filename) ?></strong>
                                    </td>
                                    <td><?= number_format($backup->file_size / 1024 / 1024, 2) ?> MB</td>
                                    <td>
                                        <?php if ($backup->backup_type === 'auto'): ?>
                                            <span class="badge bg-info">Auto</span>
                                        <?php else: ?>
                                            <span class="badge bg-primary">Manual</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($backup->first_name . ' ' . $backup->last_name) ?></td>
                                    <td><?= date('Y-m-d H:i', strtotime($backup->created_at)) ?></td>
                                    <td><small class="text-muted"><?= esc($backup->notes) ?></small></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('backups/download/' . $backup->backup_id) ?>" 
                                               class="btn btn-outline-primary" 
                                               title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            <button class="btn btn-outline-success" 
                                                    onclick="restoreBackup(<?= $backup->backup_id ?>, '<?= esc($backup->filename) ?>')" 
                                                    title="Restore">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" 
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
                </div>
            <?php endif; ?>
        </div>
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

function createBackup() {
    Swal.fire({
        title: 'Create Database Backup',
        input: 'textarea',
        inputLabel: 'Notes (optional)',
        inputPlaceholder: 'Enter backup notes...',
        showCancelButton: true,
        confirmButtonText: 'Create Backup',
        showLoaderOnConfirm: true,
        preConfirm: (notes) => {
            return $.ajax({
                url: BASE_URL + 'backups/create',
                method: 'POST',
                data: { notes: notes },
                dataType: 'json'
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value.success) {
                Swal.fire('Success!', result.value.message, 'success').then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', result.value.message, 'error');
            }
        }
    });
}

function restoreBackup(backupId, filename) {
    Swal.fire({
        title: 'Restore Database?',
        html: `<strong>WARNING:</strong> This will replace all current data with the backup:<br><br><code>${filename}</code><br><br>This action cannot be undone!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, restore it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + 'backups/restore',
                method: 'POST',
                data: { backup_id: backupId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Restored!', response.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'An error occurred during restore', 'error');
                }
            });
        }
    });
}

function deleteBackup(backupId) {
    Swal.fire({
        title: 'Delete Backup?',
        text: 'This will permanently delete the backup file.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + 'backups/delete',
                method: 'POST',
                data: { ids: [backupId] },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showNotification(response.message, 'success');
                        location.reload();
                    } else {
                        showNotification(response.message, 'error');
                    }
                }
            });
        }
    });
}

function deleteSelected() {
    const selected = Array.from(document.querySelectorAll('.backup-checkbox:checked')).map(cb => cb.value);
    
    if (selected.length === 0) {
        return;
    }
    
    Swal.fire({
        title: 'Delete Selected Backups?',
        text: `This will delete ${selected.length} backup(s).`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete them!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + 'backups/delete',
                method: 'POST',
                data: { ids: selected },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showNotification(response.message, 'success');
                        location.reload();
                    } else {
                        showNotification(response.message, 'error');
                    }
                }
            });
        }
    });
}

function cleanOldBackups() {
    Swal.fire({
        title: 'Clean Old Backups',
        input: 'number',
        inputLabel: 'Keep how many recent backups?',
        inputValue: 10,
        inputAttributes: {
            min: 1,
            max: 100,
            step: 1
        },
        showCancelButton: true,
        confirmButtonText: 'Clean',
        preConfirm: (keepCount) => {
            return $.ajax({
                url: BASE_URL + 'backups/clean',
                method: 'POST',
                data: { keep_count: keepCount },
                dataType: 'json'
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value.success) {
                Swal.fire('Success!', result.value.message, 'success').then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', result.value.message, 'error');
            }
        }
    });
}
</script>

<?= view('layouts/bootstrap5_footer') ?>
