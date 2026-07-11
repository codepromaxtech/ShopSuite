<?php
$env = file_get_contents('.env');
preg_match('/database\.default\.hostname = \'(.*?)\'/', $env, $host);
preg_match('/database\.default\.database = \'(.*?)\'/', $env, $db);
preg_match('/database\.default\.username = \'(.*?)\'/', $env, $user);
preg_match('/database\.default\.password = \'(.*?)\'/', $env, $pass);

$pdo = new PDO("mysql:host={$host[1]};dbname={$db[1]}", $user[1], $pass[1]);

// emulate the Model call in CI4 logic
// actually we need CI4... let's just make a file that uses the CI4 route to test mark_all_read!
