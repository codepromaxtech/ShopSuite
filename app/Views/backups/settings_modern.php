<?php
/**
 * PREMIUM BACKUP SETTINGS
 */
$title = 'Backup Settings';
echo view('layouts/modern_header', ['title' => $title]);
?>



<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-text">
            <h1 class="page-header-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Backup Settings
            </h1>
        </div>
    </div>
    <div class="page-header-actions">
        <a href="<?= base_url('backups') ?>" class="btn btn-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Backups
        </a>
    </div>
</div>

<div class="settings-container">
    <form id="backup-settings-form" onsubmit="saveSettings(event)">
        <div class="settings-card">
            <div class="settings-header">
                <div class="settings-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <div class="settings-title">
                    <h2>Automated Backups</h2>
                    <p>Configure how often the system should automatically backup your database.</p>
                </div>
            </div>
            
            <div class="settings-body">
                <?php 
                $auto_enabled = isset($config['auto_backup_enabled']) && $config['auto_backup_enabled'];
                $frequency = $config['backup_frequency'] ?? 'daily';
                $keep_count = $config['keep_backups'] ?? 10;
                ?>
                
                <div class="form-group-modern">
                    <label class="form-label-modern">Enable Auto Backups</label>
                    <div class="toggle-wrapper">
                        <label class="toggle-switch">
                            <input type="checkbox" id="auto_backup_enabled" name="auto_backup_enabled" <?= $auto_enabled ? 'checked' : '' ?>>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="text-sm font-semibold" id="toggle-status"><?= $auto_enabled ? 'Enabled' : 'Disabled' ?></span>
                    </div>
                    <span class="form-text-modern">When enabled, the system will automatically create database backups in the background.</span>
                </div>
                
                <div class="form-group-modern">
                    <label class="form-label-modern">Backup Frequency</label>
                    <select class="form-control" name="backup_frequency" id="backup_frequency" <?= !$auto_enabled ? 'disabled' : '' ?>>
                        <option value="daily" <?= $frequency === 'daily' ? 'selected' : '' ?>>Daily</option>
                        <option value="weekly" <?= $frequency === 'weekly' ? 'selected' : '' ?>>Weekly</option>
                        <option value="monthly" <?= $frequency === 'monthly' ? 'selected' : '' ?>>Monthly</option>
                    </select>
                </div>
                
                <div class="form-group-modern">
                    <label class="form-label-modern">Retention Policy</label>
                    <div class="u-display-flex_align-items-center_gap-sp-3">
                        <input type="number" class="form-control" name="keep_backups" id="keep_backups" value="<?= esc($keep_count) ?>" min="1" max="100" style="width: 120px;" <?= !$auto_enabled ? 'disabled' : '' ?>>
                        <span class="form-text-modern u-margin-top-0">backups to keep</span>
                    </div>
                    <span class="form-text-modern">Older backups will be automatically deleted when this limit is reached.</span>
                </div>
            </div>
            
            <div class="settings-footer">
                <button type="submit" class="btn btn-primary" id="save-btn">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('auto_backup_enabled').addEventListener('change', function(e) {
    const isChecked = e.target.checked;
    document.getElementById('toggle-status').textContent = isChecked ? 'Enabled' : 'Disabled';
    document.getElementById('backup_frequency').disabled = !isChecked;
    document.getElementById('keep_backups').disabled = !isChecked;
});

async function saveSettings(e) {
    e.preventDefault();
    const btn = document.getElementById('save-btn');
    const originalText = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = `<svg class="u-animation-spin1slinearinfinite" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="3" stroke-dasharray="31.4 31.4" stroke-linecap="round"/></svg> Saving...`;
    
    try {
        const formData = new FormData(e.target);
        const response = await fetch('<?= base_url("backups/saveSettings") ?>', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            window.shopsuiteApp?.showToast?.('Success', result.message, 'success') || alert(result.message);
        } else {
            window.shopsuiteApp?.showToast?.('Error', result.message, 'error') || alert(result.message);
        }
    } catch (error) {
        window.shopsuiteApp?.showToast?.('Error', 'Failed to save settings', 'error') || alert('Error saving config');
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
}

const style = document.createElement('style');
style.textContent = `@keyframes spin { 100% { transform: rotate(360deg); } }`;
document.head.appendChild(style);
</script>

<?= view('layouts/modern_footer') ?>
