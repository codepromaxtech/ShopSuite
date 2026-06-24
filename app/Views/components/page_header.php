<?php
/**
 * Reusable Page Header Component
 * @var string $title - Page title
 * @var string $subtitle - Optional subtitle
 * @var string $icon - Bootstrap icon class
 * @var array $actions - Optional action buttons
 */

$title = $title ?? 'Page Title';
$subtitle = $subtitle ?? '';
$icon = $icon ?? 'bi-file-earmark';
$actions = $actions ?? [];
?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-1 fw-bold">
            <i class="<?= $icon ?>"></i>
            <?= esc($title) ?>
        </h2>
        <?php if ($subtitle): ?>
            <p class="text-secondary mb-0"><?= esc($subtitle) ?></p>
        <?php endif; ?>
    </div>
    <div class="col-md-4 text-md-end">
        <?php foreach ($actions as $action): ?>
            <a href="<?= $action['url'] ?? '#' ?>" 
               class="btn btn-<?= $action['color'] ?? 'primary' ?> <?= $action['size'] ?? '' ?>">
                <?php if (isset($action['icon'])): ?>
                    <i class="<?= $action['icon'] ?> me-2"></i>
                <?php endif; ?>
                <?= esc($action['label']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
