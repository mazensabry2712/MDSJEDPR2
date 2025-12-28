<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\aams;

echo "=== Checking AM Data ===\n\n";

$ams = aams::all();

if ($ams->isEmpty()) {
    echo "No AMs found in database.\n";
} else {
    foreach ($ams as $am) {
        echo "ID: {$am->id}\n";
        echo "Name: {$am->name}\n";
        echo "Email: " . ($am->email ?: 'NOT SET') . "\n";
        echo "Phone: " . ($am->phone ?: 'NOT SET') . "\n";
        echo "---\n";
    }
}
