<?php
/** @var array $rows */
/** @var string $title */
/** @var string $add_url */
/** @var string $edit_url_prefix */
/** @var string $name_field */
/** @var string $id_field */
$title = $title ?? 'Tax';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-text">
            <h1 class="page-header-title"><?= esc($title) ?></h1>
        </div>
    </div>
    <div class="page-header-actions">
        <a href="<?= base_url('taxes') ?>" class="btn btn-outline">Tax Hub</a>
        <a href="<?= esc($add_url) ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add
        </a>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="u-width-15pct">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rows)): ?>
                    <?php foreach ($rows as $row): ?>
                        <?php if (empty($row[$name_field])) continue; ?>
                        <tr>
                            <td><?= esc($row[$name_field]) ?></td>
                            <td>
                                <a href="<?= esc($edit_url_prefix . (int) $row[$id_field]) ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="2"><div class="empty-state"><p>No records found.</p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('layouts/modern_footer') ?>
