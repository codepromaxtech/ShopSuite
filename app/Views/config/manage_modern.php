<?php
/**
 * MODERN CONFIG MANAGEMENT
 * System Configuration Hub
 */
$title = 'System Configuration';
echo view('layouts/modern_header', ['title' => $title]);
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-text">
            <h1 class="page-header-title">System Configuration</h1>
        </div>
    </div>
    <div class="page-header-actions">
        <a href="<?= base_url('backups') ?>" class="btn btn-secondary">
            <i class="bi bi-cloud-download"></i>
            <span>Backup</span>
        </a>
    </div>
</div>

<!-- Configuration Categories Grid -->
<div class="config-grid u-display-grid_grid-template-columns-rep">
    
    <!-- General Settings -->
    <div class="config-category-card">
        <div class="config-category-header">
            <div class="config-category-icon" >
                <i class="bi bi-gear-fill"></i>
            </div>
            <div class="config-category-title">
                <h3>General Settings</h3>
                <p>Basic system configuration</p>
            </div>
        </div>
        <div class="config-category-links">
            <a href="<?= base_url('config/company') ?>" class="config-link">
                <i class="bi bi-building"></i>
                <span>Company Information</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('config/locale') ?>" class="config-link">
                <i class="bi bi-globe"></i>
                <span>Locale & Language</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('config/tax') ?>" class="config-link">
                <i class="bi bi-percent"></i>
                <span>Tax Settings</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('config/receipt') ?>" class="config-link">
                <i class="bi bi-receipt"></i>
                <span>Receipt Configuration</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Sales Settings -->
    <div class="config-category-card">
        <div class="config-category-header">
            <div class="config-category-icon" >
                <i class="bi bi-cart-check-fill"></i>
            </div>
            <div class="config-category-title">
                <h3>Sales Settings</h3>
                <p>Configure sales options</p>
            </div>
        </div>
        <div class="config-category-links">
            <a href="<?= base_url('config/sales') ?>" class="config-link">
                <i class="bi bi-cart"></i>
                <span>Sales Options</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('config/payment') ?>" class="config-link">
                <i class="bi bi-credit-card"></i>
                <span>Payment Methods</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('config/invoice') ?>" class="config-link">
                <i class="bi bi-file-earmark-text"></i>
                <span>Invoice Settings</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('config/rewards') ?>" class="config-link">
                <i class="bi bi-gift"></i>
                <span>Rewards Program</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Inventory Settings -->
    <div class="config-category-card">
        <div class="config-category-header">
            <div class="config-category-icon" >
                <i class="bi bi-box-seam-fill"></i>
            </div>
            <div class="config-category-title">
                <h3>Inventory Settings</h3>
                <p>Stock management options</p>
            </div>
        </div>
        <div class="config-category-links">
            <a href="<?= base_url('config/stock') ?>" class="config-link">
                <i class="bi bi-box"></i>
                <span>Stock Settings</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('config/locations') ?>" class="config-link">
                <i class="bi bi-geo-alt"></i>
                <span>Stock Locations</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('config/categories') ?>" class="config-link">
                <i class="bi bi-tags"></i>
                <span>Categories</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('config/barcode') ?>" class="config-link">
                <i class="bi bi-upc-scan"></i>
                <span>Barcode Settings</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
    
    <!-- System & Security -->
    <div class="config-category-card">
        <div class="config-category-header">
            <div class="config-category-icon" >
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <div class="config-category-title">
                <h3>System & Security</h3>
                <p>Advanced system settings</p>
            </div>
        </div>
        <div class="config-category-links">
            <a href="<?= base_url('backups') ?>" class="config-link">
                <i class="bi bi-cloud-download"></i>
                <span>Backup & Restore</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('config/email') ?>" class="config-link">
                <i class="bi bi-envelope"></i>
                <span>Email Settings</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('config/security') ?>" class="config-link">
                <i class="bi bi-lock"></i>
                <span>Security Settings</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="<?= base_url('config/system') ?>" class="config-link">
                <i class="bi bi-cpu"></i>
                <span>System Info</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions-container">
    <div class="quick-actions-header">
        <h2>
            <i class="bi bi-lightning-fill"></i>
            Quick Actions
        </h2>
        <p>Common administrative tasks</p>
    </div>
    <div class="quick-actions-grid">
        <a href="<?= base_url('backups/create') ?>" class="quick-action-card">
            <div class="quick-action-icon" >
                <i class="bi bi-cloud-download"></i>
            </div>
            <h4>Backup Database</h4>
            <p>Create a system backup</p>
        </a>
        <button class="quick-action-card" onclick="clearCache()">
            <div class="quick-action-icon" >
                <i class="bi bi-arrow-clockwise"></i>
            </div>
            <h4>Clear Cache</h4>
            <p>Refresh system cache</p>
        </button>
        <a href="<?= base_url('logs') ?>" class="quick-action-card">
            <div class="quick-action-icon" >
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <h4>View Logs</h4>
            <p>Check system logs</p>
        </a>
        <a href="<?= base_url('config/system') ?>" class="quick-action-card">
            <div class="quick-action-icon" >
                <i class="bi bi-info-circle"></i>
            </div>
            <h4>System Info</h4>
            <p>View system details</p>
        </a>
    </div>
</div>



<script>
async function clearCache() {
    if (!confirm('Are you sure you want to clear the cache?')) {
        return;
    }
    
    try {
        const response = await fetch('<?= base_url("config/clearCache") ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            window.shopsuiteApp?.showToast?.('Success', 'Cache cleared successfully', 'success') || alert('Cache cleared successfully');
        } else {
            window.shopsuiteApp?.showToast?.('Error', result.message || 'Failed to clear cache', 'error') || alert('Failed to clear cache');
        }
    } catch (error) {
        window.shopsuiteApp?.showToast?.('Error', 'Failed to clear cache', 'error') || alert('Error clearing cache');
    }
}
</script>

<?= view('layouts/modern_footer') ?>
