<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
require FCPATH . '../vendor/codeigniter4/framework/system/Boot.php';

$app = \CodeIgniter\Boot::bootWeb(new \Config\Paths());
// Just load the Model
$model = model(\App\Models\Notification::class);
$res = $model->mark_all_as_read(1);
echo "Result: " . ($res ? 'TRUE' : 'FALSE') . "\n";
echo "DB Error: " . $model->db->error()['message'] . "\n";
