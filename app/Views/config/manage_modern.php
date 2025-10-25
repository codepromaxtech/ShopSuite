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
<div class="config-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: var(--space-6); margin-bottom: var(--space-8);">
    
    <!-- General Settings -->
    <div class="config-category-card">
        <div class="config-category-header">
            <div class="config-category-icon" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
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
            <div class="config-category-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
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
            <div class="config-category-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
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
            <div class="config-category-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
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
            <div class="quick-action-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                <i class="bi bi-cloud-download"></i>
            </div>
            <h4>Backup Database</h4>
            <p>Create a system backup</p>
        </a>
        <button class="quick-action-card" onclick="clearCache()">
            <div class="quick-action-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <i class="bi bi-arrow-clockwise"></i>
            </div>
            <h4>Clear Cache</h4>
            <p>Refresh system cache</p>
        </button>
        <a href="<?= base_url('logs') ?>" class="quick-action-card">
            <div class="quick-action-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <h4>View Logs</h4>
            <p>Check system logs</p>
        </a>
        <a href="<?= base_url('config/system') ?>" class="quick-action-card">
            <div class="quick-action-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                <i class="bi bi-info-circle"></i>
            </div>
            <h4>System Info</h4>
            <p>View system details</p>
        </a>
    </div>
</div>

<style>
/* Config Category Cards */
.config-category-card {
    background: var(--bg-elevated);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: all var(--transition-normal);
}

.config-category-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.config-category-header {
    padding: var(--space-6);
    display: flex;
    align-items: center;
    gap: var(--space-4);
    border-bottom: 1px solid var(--border-color);
}

.config-category-icon {
    width: 64px;
    height: 64px;
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.config-category-icon i {
    font-size: 32px;
    color: white;
}

.config-category-title h3 {
    font-size: var(--text-lg);
    font-weight: var(--font-semibold);
    color: var(--text-primary);
    margin: 0 0 var(--space-1) 0;
}

.config-category-title p {
    font-size: var(--text-sm);
    color: var(--text-tertiary);
    margin: 0;
}

.config-category-links {
    padding: var(--space-2);
}

.config-link {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-4);
    color: var(--text-primary);
    text-decoration: none;
    border-radius: var(--radius-md);
    transition: all var(--transition-fast);
}

.config-link:hover {
    background: var(--bg-secondary);
    color: var(--primary-600);
    transform: translateX(4px);
}

.config-link i:first-child {
    font-size: 20px;
    color: var(--text-tertiary);
    transition: color var(--transition-fast);
}

.config-link:hover i:first-child {
    color: var(--primary-600);
}

.config-link span {
    flex: 1;
    font-weight: var(--font-medium);
}

.config-link i:last-child {
    font-size: 14px;
    color: var(--text-tertiary);
}

/* Quick Actions */
.quick-actions-container {
    background: var(--bg-elevated);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: var(--space-6);
    box-shadow: var(--shadow-sm);
}

.quick-actions-header {
    margin-bottom: var(--space-6);
}

.quick-actions-header h2 {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-size: var(--text-xl);
    font-weight: var(--font-semibold);
    color: var(--text-primary);
    margin: 0 0 var(--space-2) 0;
}

.quick-actions-header h2 i {
    color: var(--warning-600);
}

.quick-actions-header p {
    font-size: var(--text-sm);
    color: var(--text-tertiary);
    margin: 0;
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-4);
}

.quick-action-card {
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    padding: var(--space-5);
    text-align: center;
    text-decoration: none;
    color: var(--text-primary);
    transition: all var(--transition-normal);
    cursor: pointer;
    display: block;
}

.quick-action-card:hover {
    border-color: var(--primary-300);
    box-shadow: var(--shadow-sm);
    transform: translateY(-2px);
}

.quick-action-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto var(--space-4) auto;
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
}

.quick-action-icon i {
    font-size: 32px;
    color: white;
}

.quick-action-card h4 {
    font-size: var(--text-base);
    font-weight: var(--font-semibold);
    color: var(--text-primary);
    margin: 0 0 var(--space-2) 0;
}

.quick-action-card p {
    font-size: var(--text-sm);
    color: var(--text-tertiary);
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .config-grid {
        grid-template-columns: 1fr !important;
    }
    
    .quick-actions-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }
}

/* Dark Mode */
[data-theme="dark"] .config-category-card,
[data-theme="dark"] .quick-actions-container {
    background: var(--bg-elevated);
    border-color: var(--border-color);
}

[data-theme="dark"] .config-link:hover {
    background: var(--bg-secondary);
}

[data-theme="dark"] .quick-action-card {
    background: var(--bg-secondary);
    border-color: var(--border-color);
}

[data-theme="dark"] .quick-action-card:hover {
    border-color: var(--primary-600);
}
</style>

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
