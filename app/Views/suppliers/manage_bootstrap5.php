<?php
/**
 * Modern Bootstrap 5 Suppliers Management View with Full Functionality
 * @var string $controller_name
 * @var string $table_headers
 * @var array $config
 */
?>

<?= view('layouts/bootstrap5_header', [
    'page_title' => lang('Module.suppliers'),
    'allowed_modules' => $allowed_modules ?? [],
    'user_info' => $user_info ?? null,
    'config' => $config ?? []
]) ?>

<script type="text/javascript">
    $(document).ready(function() {
        <?= view('partial/bootstrap_tables_locale') ?>

        table_support.init({
            resource: '<?= esc($controller_name) ?>',
            headers: <?= $table_headers ?>,
            pageSize: <?= $config['lines_per_page'] ?>,
            uniqueId: 'person_id'
        });
    });
</script>

<!-- Title Bar -->
<div id="title_bar" class="mb-3 d-flex justify-content-end gap-2 print_hide">
    <button class="btn btn-primary modal-dlg" data-btn-new="<?= lang('Common.new') ?>" data-btn-submit="<?= lang('Common.submit') ?>" data-href="<?= "$controller_name/view" ?>" title="<?= lang(ucfirst($controller_name) . '.new') ?>">
        <i class="bi bi-plus-circle me-2"></i><?= lang(ucfirst($controller_name) . '.new') ?>
    </button>
</div>

<!-- Toolbar -->
<div id="toolbar" class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <button id="delete" class="btn btn-danger print_hide">
                <i class="bi bi-trash me-2"></i><?= lang('Common.delete') ?>
            </button>
        </div>
    </div>
</div>


<!-- Suppliers Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div id="table_holder" class="table-responsive">
            <table id="table"></table>
        </div>
    </div>
</div>

<?= view('layouts/bootstrap5_footer') ?>

