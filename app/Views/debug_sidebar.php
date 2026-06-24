<?php
/**
 * DEBUG PAGE - Check sidebar data
 */
?>

$title = 'DEBUG: Sidebar Data';
echo view('layouts/modern_header', ['title' => $title]);
?>

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header bg-danger text-inverse">
            <h4 class="mb-0">🐛 DEBUG: Sidebar Data Check</h4>
        </div>
        <div class="card-body">
            <h5>Allowed Modules Count: <?= isset($allowed_modules) ? count($allowed_modules) : 0 ?></h5>
            
            <?php if (isset($allowed_modules) && !empty($allowed_modules)): ?>
                <h6 class="mt-4">Modules List:</h6>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Module ID</th>
                            <th>Name</th>
                            <th>Sort</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($allowed_modules as $module): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><code><?= esc($module->module_id) ?></code></td>
                                <td><?= lang('Module.' . $module->module_id) ?></td>
                                <td><?= $module->sort ?? 'N/A' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-danger">
                    <strong>ERROR:</strong> No modules found! The $allowed_modules variable is empty or not set.
                </div>
            <?php endif; ?>
            
            <hr>
            
            <h6>Expected Modules in Sidebar:</h6>
            <div class="row">
                <div class="col-md-3">
                    <h6>MAIN MENU:</h6>
                    <ul>
                        <li>home</li>
                        <li>sales</li>
                        <li>items</li>
                        <li>customers</li>
                        <li>suppliers</li>
                        <li>receivings</li>
                        <li>reports</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>SYSTEM SETTINGS:</h6>
                    <ul>
                        <li>config</li>
                        <li>roles</li>
                        <li>employees</li>
                        <li>backups</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>BUSINESS SETTINGS:</h6>
                    <ul>
                        <li>taxes</li>
                        <li>attributes</li>
                        <li>giftcards</li>
                        <li>item_kits</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>FINANCIAL SETTINGS:</h6>
                    <ul>
                        <li>expenses</li>
                        <li>expenses_categories</li>
                        <li>cashups</li>
                    </ul>
                    <h6>TOOLS:</h6>
                    <ul>
                        <li>messages</li>
                        <li>migrate</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('layouts/modern_footer') ?>
