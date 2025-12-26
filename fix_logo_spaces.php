<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Cust;
use Illuminate\Support\Facades\DB;

echo "=== Fixing Customer Logos with Spaces ===\n\n";

$customers = Cust::all();

foreach ($customers as $cust) {
    if ($cust->logo && strpos($cust->logo, ' ') !== false) {
        echo "Customer: {$cust->name}\n";
        echo "  Old logo: {$cust->logo}\n";

        // Remove spaces from filename
        $oldPath = $cust->logo;
        $newPath = str_replace(' ', '_', $oldPath);

        $oldFullPath = public_path($oldPath);
        $newFullPath = public_path($newPath);

        // Copy file
        if (file_exists($oldFullPath)) {
            copy($oldFullPath, $newFullPath);
            echo "  Copied to: {$newPath}\n";

            // Update database
            $cust->logo = $newPath;
            $cust->save();
            echo "  ✅ Database updated\n";
        } else {
            echo "  ❌ File not found\n";
        }
        echo "\n";
    }
}

echo "=== Verification ===\n";
$customers = Cust::all();
foreach ($customers as $cust) {
    echo "{$cust->name}: {$cust->logo}\n";
    echo "  Has spaces: " . (strpos($cust->logo, ' ') !== false ? 'YES ❌' : 'NO ✅') . "\n";
    echo "  File exists: " . (file_exists(public_path($cust->logo)) ? 'YES ✅' : 'NO ❌') . "\n\n";
}

echo "✅ Complete!\n";
