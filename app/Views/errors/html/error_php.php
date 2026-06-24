<?php
/**
 * @var string $severity
 * @var string $message
 * @var string $filepath
 * @var int $line
 */
?>

<div class="ci-error-box">

    <h4>A PHP Error was encountered</h4>

    <p>Severity: <?= esc($severity) ?></p>
    <p>Message: <?= esc($message) ?></p>
    <p>Filename: <?= esc($filepath) ?></p>
    <p>Line Number: <?= $line ?></p>

    <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE): ?>

        <p>Backtrace:</p>
        <?php foreach (debug_backtrace() as $error): ?>

            <?php if (isset($error['file']) && strpos($error['file'], realpath(ROOTPATH)) !== 0): ?>

                <p class="u-margin-left-10px">
                    File: <?= $error['file'] ?><br>
                    Line: <?= $error['line'] ?><br>
                    Function: <?= $error['function'] ?>
                </p>

            <?php endif ?>

        <?php endforeach ?>

    <?php endif ?>

</div>
