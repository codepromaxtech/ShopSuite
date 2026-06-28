<?php
/**
 * Modern Config Form Wrapper
 */
$title = 'System Configuration - ' . ucfirst($active_tab);
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-text">
            <h1 class="page-header-title">System Configuration: <?= ucfirst($active_tab) ?></h1>
        </div>
    </div>
    <div class="page-header-actions">
        <a href="<?= base_url('config') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Settings Hub</span>
        </a>
    </div>
</div>

<div class="card config-page-card">
    <div class="card-body">
        <div class="config-form-card config-legacy-form">
            <?= view('configs/' . $active_tab . '_config') ?>
        </div>
    </div>
</div>

<script>
    // Include dialog support if needed
    if (typeof dialog_support !== 'undefined') {
        dialog_support.init("a.modal-dlg");
    }
</script>

<?= view('layouts/modern_footer') ?>
