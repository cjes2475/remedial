<?php

$_ENV['LARAVEL_STORAGE_PATH'] = '/tmp/remedial-storage';
$_SERVER['LARAVEL_STORAGE_PATH'] = '/tmp/remedial-storage';

$directories = [
    '/tmp/remedial-storage/framework/cache/data',
    '/tmp/remedial-storage/framework/sessions',
    '/tmp/remedial-storage/framework/testing',
    '/tmp/remedial-storage/framework/views',
    '/tmp/remedial-storage/logs',
];

foreach ($directories as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

require __DIR__.'/../public/index.php';
