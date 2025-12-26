<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n📋 USERS TABLE STRUCTURE:\n";
echo "══════════════════════════════════════════════════════════════════\n";

$columns = DB::select("DESCRIBE users");

foreach ($columns as $column) {
    echo "• {$column->Field} ({$column->Type})\n";
}

echo "\n📊 Sample User:\n";
echo "══════════════════════════════════════════════════════════════════\n";
$user = DB::table('users')->first();
if ($user) {
    foreach ((array)$user as $key => $value) {
        echo "{$key}: " . ($value ?? 'NULL') . "\n";
    }
}

echo "\n";
