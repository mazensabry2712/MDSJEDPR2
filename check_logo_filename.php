<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Cust;

$cust = Cust::first();

echo "Logo path in DB: [{$cust->logo}]\n";
echo "Length: " . strlen($cust->logo) . "\n";

$dbPath = public_path($cust->logo);
echo "Full path from DB: {$dbPath}\n";
echo "File exists (DB path): " . (file_exists($dbPath) ? 'YES' : 'NO') . "\n\n";

// Try with space before (2)
$tryPath1 = "public/storge/1766677157_qrcode_292190732_970acbbc2050a407b1e6ff2e74d5a1a5 (2).png";
echo "Try path with space: {$tryPath1}\n";
echo "Exists: " . (file_exists($tryPath1) ? 'YES' : 'NO') . "\n\n";

// List actual files
echo "Actual files in storge folder containing 'qrcode':\n";
$files = glob("public/storge/*qrcode*");
foreach ($files as $file) {
    $basename = basename($file);
    echo "  - [{$basename}]\n";
    echo "    Length: " . strlen($basename) . "\n";
}
