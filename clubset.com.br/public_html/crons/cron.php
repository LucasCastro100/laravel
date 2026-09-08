<?php

/**
 * Cron entry point for hosting panels.
 * URL: https://clubset.com.br/crons/cron.php
 */

define('LARAVEL_START', microtime(true));

$laravelPath = __DIR__ . '/../laravel';

require $laravelPath . '/vendor/autoload.php';

$app = require_once $laravelPath . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->call('schedule:run');

exit($status);
