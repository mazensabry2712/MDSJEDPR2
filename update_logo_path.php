<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Cust;
use Illuminate\Support\Facades\DB;

echo "=== Updating Customer Logo Path ===\n\n";

$customer = Cust::first();
echo "Old logo path: {$customer->logo}\n";

// Update to new path without spaces
$customer->logo = 'storge/neom_logo.png';
$customer->save();

echo "New logo path: {$customer->logo}\n";
echo "File exists: " . (file_exists(public_path($customer->logo)) ? 'YES' : 'NO') . "\n";
echo "\nUpdate complete!\n";
