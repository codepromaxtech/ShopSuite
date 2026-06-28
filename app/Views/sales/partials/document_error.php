<?php
/**
 * Standalone error page for sale document views.
 *
 * @var string $error_message
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Failed</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="stylesheet" href="<?= base_url('css/modern-pages.css') ?>">
</head>
<body class="u-margin-0_padding-0_font-family--apple-1">
<div class="u-display-flex_align-items-center_justif">
    <div class="u-max-width-500px_padding-40px_border-ra">
        <svg class="u-margin-0auto20px" width="80" height="80" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        <h1 class="u-margin-bottom-16px">Transaction Failed</h1>
        <p class="u-margin-bottom-24px"><?= esc($error_message) ?></p>
        <a class="sale-doc-error-link" href="<?= base_url('sales') ?>">Back to Sales</a>
    </div>
</div>
</body>
</html>
