<?php
// Hosting Debug Script - Run this on your hosting server
// URL: yourdomain.com/hosting_debug.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Server Environment Check</h2>";
echo "<pre>";

// PHP Version
echo "PHP Version: " . phpversion() . "\n\n";

// Check if Laravel is accessible
echo "--- Laravel Bootstrap Check ---\n";
if (file_exists(__DIR__.'/vendor/autoload.php')) {
    echo "✓ Composer autoload exists\n";
    require __DIR__.'/vendor/autoload.php';

    if (file_exists(__DIR__.'/bootstrap/app.php')) {
        echo "✓ Bootstrap app exists\n";
        try {
            $app = require_once __DIR__.'/bootstrap/app.php';
            echo "✓ Laravel app loaded successfully\n";

            $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
            $kernel->bootstrap();
            echo "✓ Laravel kernel bootstrapped\n";

        } catch (Exception $e) {
            echo "✗ Error loading Laravel: " . $e->getMessage() . "\n";
            echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
        }
    } else {
        echo "✗ bootstrap/app.php not found\n";
    }
} else {
    echo "✗ vendor/autoload.php not found - Run: composer install\n";
}

echo "\n--- Directory Permissions ---\n";
$dirs = ['storage', 'storage/logs', 'storage/framework', 'bootstrap/cache'];
foreach ($dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (file_exists($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        $writable = is_writable($path) ? '✓' : '✗';
        echo "$writable $dir: $perms\n";
    } else {
        echo "✗ $dir: NOT FOUND\n";
    }
}

echo "\n--- Environment File ---\n";
if (file_exists(__DIR__.'/.env')) {
    echo "✓ .env file exists\n";
    $env = file_get_contents(__DIR__.'/.env');
    echo "APP_ENV: " . (preg_match('/APP_ENV=(\w+)/', $env, $m) ? $m[1] : 'NOT SET') . "\n";
    echo "APP_DEBUG: " . (preg_match('/APP_DEBUG=(\w+)/', $env, $m) ? $m[1] : 'NOT SET') . "\n";
    echo "DB_CONNECTION: " . (preg_match('/DB_CONNECTION=(\w+)/', $env, $m) ? $m[1] : 'NOT SET') . "\n";
} else {
    echo "✗ .env file NOT FOUND - Copy from .env.example\n";
}

echo "\n--- Recent Laravel Logs ---\n";
$logFile = __DIR__.'/storage/logs/laravel.log';
if (file_exists($logFile)) {
    echo "✓ Log file exists\n";
    $logs = file_get_contents($logFile);
    $lines = explode("\n", $logs);
    $recent = array_slice($lines, -30);
    echo "Last 30 lines:\n";
    echo implode("\n", $recent) . "\n";
} else {
    echo "✗ No log file found (storage/logs/laravel.log)\n";
}

echo "\n--- PHP Extensions ---\n";
$required = ['pdo', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath'];
foreach ($required as $ext) {
    $loaded = extension_loaded($ext) ? '✓' : '✗';
    echo "$loaded $ext\n";
}

echo "</pre>";

echo "<p style='color: red; font-weight: bold;'>⚠️ DELETE THIS FILE AFTER DEBUGGING!</p>";
?>
