<?php
/**
 * Error View
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= lang('Errors.badRequest') ?></title>
    <link rel="stylesheet" href="/css/error-pages.min.css">
</head>
<body>
    <div class="error-container">
        <div class="error-code">400</div>
        <h1 class="error-title"><?= lang('Errors.badRequest') ?></h1>
        <div class="error-message">
            <?php if (ENVIRONMENT !== 'production') : ?>
                <?= nl2br(esc($message)) ?>
            <?php else : ?>
                <?= lang('Errors.sorryBadRequest') ?>
            <?php endif; ?>
        </div>
        <a href="/" class="btn-home">
            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Return Home
        </a>
    </div>
</body>
</html>
