<?php
/**
 * @var object $person_info
 * @var bool $force_password_change
 */
$title = lang('Employees.change_password');
$force = !empty($force_password_change);
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-text">
            <h1 class="page-header-title"><?= esc(lang('Employees.change_password')) ?></h1>
            <?php if ($force): ?>
                <p class="page-header-subtitle">Your password was migrated from a legacy format. Please set a new password to continue.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if ($force): ?>
<div class="alert alert-warning u-margin-bottom-space-6" role="alert">
    <i class="bi bi-shield-exclamation"></i>
    You must change your password before accessing other areas of the system.
</div>
<?php endif; ?>

<div class="card u-max-width-640px">
    <div class="card-body">
        <?= form_open('home/save/' . (int) $person_info->person_id, ['id' => 'change_password_form']) ?>
            <div class="form-group">
                <label for="username" class="form-label"><?= lang('Employees.username') ?></label>
                <input type="text" class="form-control" id="username" name="username" value="<?= esc($person_info->username ?? '') ?>" readonly>
            </div>

            <div class="form-group">
                <label for="current_password" class="form-label form-label-required"><?= lang('Employees.current_password') ?></label>
                <input type="password" class="form-control" id="current_password" name="current_password" required minlength="8" autocomplete="current-password">
            </div>

            <div class="form-group">
                <label for="password" class="form-label form-label-required"><?= lang('Employees.password') ?></label>
                <input type="password" class="form-control" id="password" name="password" required minlength="8" autocomplete="new-password">
            </div>

            <div class="form-group">
                <label for="repeat_password" class="form-label form-label-required"><?= lang('Employees.repeat_password') ?></label>
                <input type="password" class="form-control" id="repeat_password" name="repeat_password" required minlength="8" autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i>
                <?= lang('Common.submit') ?>
            </button>
            <?php if (!$force): ?>
                <a href="<?= base_url('home') ?>" class="btn btn-outline"><?= lang('Common.cancel') ?></a>
            <?php endif; ?>
        <?= form_close() ?>
    </div>
</div>

<script>
document.getElementById('change_password_form').addEventListener('submit', function(e) {
    e.preventDefault();

    const password = document.getElementById('password').value;
    const repeat = document.getElementById('repeat_password').value;
    const current = document.getElementById('current_password').value;

    if (password !== repeat) {
        window.shopsuiteApp?.showToast?.('Error', '<?= esc(lang('Employees.password_must_match'), 'js') ?>', 'error');
        return;
    }

    if (password === current) {
        window.shopsuiteApp?.showToast?.('Error', '<?= esc(lang('Employees.password_not_must_match'), 'js') ?>', 'error');
        return;
    }

    window.shopsuiteApp?.showLoading?.('Saving...');

    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        window.shopsuiteApp?.hideLoading?.();
        if (data.success) {
            window.shopsuiteApp?.showToast?.('Success', data.message, 'success');
            setTimeout(() => { window.location.href = '<?= base_url('home') ?>'; }, 800);
        } else {
            window.shopsuiteApp?.showToast?.('Error', data.message || 'Failed to change password', 'error');
        }
    })
    .catch(() => {
        window.shopsuiteApp?.hideLoading?.();
        window.shopsuiteApp?.showToast?.('Error', 'An error occurred', 'error');
    });
});
</script>

<?= view('layouts/modern_footer') ?>
