<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
require FCPATH . '../vendor/codeigniter4/framework/system/Boot.php';
$paths = new \Config\Paths();
\CodeIgniter\Boot::bootWeb($paths);

$ctrl = new \App\Controllers\Notifications();
$result = $ctrl->mark_all_read();
print_r($result);
