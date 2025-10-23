<?php
/**
 * Modern Bootstrap 5 Dashboard for ShopSuite
 */

// Get data
$allowed_modules = $allowed_modules ?? [];
$user_info = $user_info ?? null;
$config = $config ?? [];
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => 'Dashboard',
    'allowed_modules' => $allowed_modules,
    'user_info' => $user_info,
    'config' => $config
]) ?>

<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body p-4 text-white">
                <h2 class="mb-2">
                    <i class="bi bi-hand-wave"></i>
                    Welcome back, <?= esc($user_info->first_name ?? 'User') ?>!
                </h2>
                <p class="mb-0 opacity-75">Here's what's happening with your store today.</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Today's Sales</p>
                        <h3 class="mb-0 fw-bold">$0.00</h3>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i> 0%
                        </small>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded">
                        <i class="bi bi-currency-dollar text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Total Orders</p>
                        <h3 class="mb-0 fw-bold">0</h3>
                        <small class="text-info">
                            <i class="bi bi-dash"></i> 0%
                        </small>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded">
                        <i class="bi bi-cart text-info fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Customers</p>
                        <h3 class="mb-0 fw-bold">0</h3>
                        <small class="text-primary">
                            <i class="bi bi-arrow-up"></i> 0%
                        </small>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded">
                        <i class="bi bi-people text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Products</p>
                        <h3 class="mb-0 fw-bold">0</h3>
                        <small class="text-warning">
                            <i class="bi bi-dash"></i> 0%
                        </small>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded">
                        <i class="bi bi-box-seam text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modules Grid -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-grid-3x3-gap"></i>
                    Quick Access
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <?php foreach ($allowed_modules as $module): ?>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                            <a href="<?= base_url($module->module_id) ?>" 
                               class="text-decoration-none">
                                <div class="card border-0 h-100 module-card" 
                                     style="background: linear-gradient(135deg, <?= getModuleGradient($module->module_id) ?>);">
                                    <div class="card-body text-center text-white p-3">
                                        <i class="<?= getModuleIcon($module->module_id) ?> fs-1 mb-2"></i>
                                        <h6 class="mb-0 fw-semibold">
                                            <?= lang('Module.' . $module->module_id) ?>
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-md-8">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-clock-history"></i>
                    Recent Activity
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center text-muted py-5">
                    <i class="bi bi-inbox fs-1 mb-3 d-block"></i>
                    <p>No recent activity</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-info-circle"></i>
                    System Info
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Company</small>
                    <strong><?= esc($config['company'] ?? 'ShopSuite') ?></strong>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Version</small>
                    <strong><?= esc(config('App')->application_version) ?></strong>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Environment</small>
                    <span class="badge bg-<?= ENVIRONMENT === 'production' ? 'success' : 'warning' ?>">
                        <?= strtoupper(ENVIRONMENT) ?>
                    </span>
                </div>
                <div>
                    <small class="text-muted d-block">PHP Version</small>
                    <strong><?= PHP_VERSION ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.module-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.module-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>

<?= view('layouts/bootstrap5_footer') ?>
