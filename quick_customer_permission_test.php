<?php

/**
 * Quick Permission Test for Customer Page
 * اختبار سريع لصلاحيات صفحة العملاء
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "\n========================================\n";
echo "  QUICK CUSTOMER PERMISSION TEST\n";
echo "  اختبار سريع لصلاحيات العملاء\n";
echo "========================================\n\n";

// Get admin user
$adminUser = User::where('email', 'admin@admin.com')->first();

if (!$adminUser) {
    echo "❌ Admin user not found!\n";
    exit(1);
}

echo "Testing for user: {$adminUser->name} ({$adminUser->email})\n";
echo "Roles: " . implode(', ', $adminUser->getRoleNames()->toArray()) . "\n\n";

// Test all customer permissions
$customerPermissions = [
    'show customer' => 'View customer list page',
    'add customer' => 'Add new customer (BUTTON VISIBILITY)',
    'edit customer' => 'Edit customer button',
    'delete customer' => 'Delete customer button',
    'view customer' => 'View customer details button',
];

echo "CUSTOMER PERMISSIONS TEST:\n";
echo "===========================\n";

$allPass = true;
foreach ($customerPermissions as $permission => $description) {
    $canAccess = $adminUser->can($permission);
    $status = $canAccess ? "✅ PASS" : "❌ FAIL";

    if (!$canAccess) {
        $allPass = false;
    }

    echo "{$status} | {$permission}\n";
    echo "        └─ {$description}\n";
}

echo "\n";

if ($allPass) {
    echo "🎉 SUCCESS! All customer permissions are working!\n";
    echo "   زر إضافة عميل سيظهر الآن للـ owner\n\n";

    echo "Expected behavior on /customer page:\n";
    echo "  ✓ Add Customer button should be visible\n";
    echo "  ✓ View button visible in operations column\n";
    echo "  ✓ Edit button visible in operations column\n";
    echo "  ✓ Delete button visible in operations column\n";
} else {
    echo "❌ FAILURE! Some permissions are not working!\n";
    echo "   Please check the role assignments.\n";
}

echo "\n========================================\n";
echo "  TEST COMPLETE\n";
echo "========================================\n\n";
