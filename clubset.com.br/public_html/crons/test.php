<?php

/**
 * Simple test cron to verify cron execution is working.
 * URL: https://clubset.com.br/crons/test.php
 */

define('LARAVEL_START', microtime(true));

$laravelPath = __DIR__ . '/../laravel';

require $laravelPath . '/vendor/autoload.php';

$app = require_once $laravelPath . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "Cron test executed at: " . date('Y-m-d H:i:s') . "\n";
echo "PHP version: " . PHP_VERSION . "\n";
echo "Status: OK\n";
