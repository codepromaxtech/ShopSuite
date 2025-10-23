<?php

use Config\ShopSuite;

?>

        </div>
    </div>

    <div id="footer">
        <div class="jumbotron push-spaces">
            <strong>
                <?= lang('Common.copyrights', [date('Y')]) ?> ·
                <a href="https://shopsuite.org" target="_blank"><?= lang('Common.website') ?></a> ·
                <?= esc(config('App')->application_version) ?> -
                <a target="_blank" href="https://github.com/shopsuite/shopsuite/commit/<?= esc(config(ShopSuite::class)->commit_sha1) ?>">
                    <?= esc(substr(config(ShopSuite::class)->commit_sha1, 0, 6)); ?>
                </a>
            </strong>.
        </div>
    </div>
</body>

</html>
