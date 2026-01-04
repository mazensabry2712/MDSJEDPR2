<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\Permission\Models\Permission;

echo "Cleaning up old/unused permissions...\n\n";

// Old permissions to delete (the ones without proper naming convention)
$oldPermissions = [
    'Add',
    'Delete',
    'Edit',
];

$deletedCount = 0;

foreach ($oldPermissions as $permName) {
    $permission = Permission::where('name', $permName)->first();
    if ($permission) {
        echo "Deleting: {$permName}\n";
        $permission->delete();
        $deletedCount++;
    }
}

echo "\n✅ Cleanup complete! Deleted {$deletedCount} old permissions.\n";
echo "✅ New permission system is now clean and ready to use!\n";
