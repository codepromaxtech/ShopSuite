<?php
/**
 * Modern Bootstrap 5 Config Management View
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => 'Configuration',
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<!-- Page Header -->
<?= view('components/page_header', [
    'title' => 'System Configuration',
    'subtitle' => 'Manage system settings and preferences',
    'icon' => 'bi-gear',
    'actions' => []
]) ?>

<!-- Configuration Categories -->
<div class="row g-4">
    <!-- General Settings -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-gear-fill fs-3 text-primary"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">General Settings</h5>
                        <small class="text-muted">Basic system configuration</small>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= base_url('config/company') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-building me-2"></i>Company Information</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="<?= base_url('config/locale') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-globe me-2"></i>Locale & Language</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="<?= base_url('config/tax') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-percent me-2"></i>Tax Settings</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="<?= base_url('config/receipt') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-receipt me-2"></i>Receipt Configuration</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sales Settings -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-cart-check fs-3 text-success"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Sales Settings</h5>
                        <small class="text-muted">Configure sales options</small>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= base_url('config/sales') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-cart me-2"></i>Sales Options</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="<?= base_url('config/payment') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-credit-card me-2"></i>Payment Methods</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="<?= base_url('config/invoice') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-file-earmark-text me-2"></i>Invoice Settings</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="<?= base_url('config/rewards') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-gift me-2"></i>Rewards Program</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Inventory Settings -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-box-seam fs-3 text-warning"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Inventory Settings</h5>
                        <small class="text-muted">Stock management options</small>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= base_url('config/stock') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-box me-2"></i>Stock Settings</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="<?= base_url('config/locations') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-geo-alt me-2"></i>Stock Locations</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="<?= base_url('config/categories') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-tags me-2"></i>Categories</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="<?= base_url('config/barcode') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-upc-scan me-2"></i>Barcode Settings</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- System Settings -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-danger bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-shield-lock fs-3 text-danger"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">System & Security</h5>
                        <small class="text-muted">Advanced system settings</small>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= base_url('config/backup') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-cloud-download me-2"></i>Backup & Restore</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="<?= base_url('config/email') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-envelope me-2"></i>Email Settings</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="<?= base_url('config/security') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-lock me-2"></i>Security Settings</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="<?= base_url('config/system') ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-cpu me-2"></i>System Info</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-lightning"></i>
            Quick Actions
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <button class="btn btn-outline-primary w-100">
                    <i class="bi bi-cloud-download d-block fs-3 mb-2"></i>
                    Backup Database
                </button>
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-success w-100">
                    <i class="bi bi-arrow-clockwise d-block fs-3 mb-2"></i>
                    Clear Cache
                </button>
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-warning w-100">
                    <i class="bi bi-file-earmark-text d-block fs-3 mb-2"></i>
                    View Logs
                </button>
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-info w-100">
                    <i class="bi bi-info-circle d-block fs-3 mb-2"></i>
                    System Info
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.list-group-item-action:hover {
    background-color: rgba(79, 70, 229, 0.05);
    transform: translateX(5px);
    transition: all 0.3s ease;
}
</style>

<?= view('layouts/bootstrap5_footer') ?>
