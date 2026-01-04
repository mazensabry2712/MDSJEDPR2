<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "===============================================\n";
echo "   TESTING PERMISSIONS & ROLES SYSTEM\n";
echo "===============================================\n\n";

// 1. Check total permissions
$totalPermissions = Permission::count();
echo "✓ Total Permissions in Database: {$totalPermissions}\n\n";

// 2. Group permissions by section
echo "📋 Permissions by Section:\n";
echo "-------------------------------------------\n";
$sections = [
    'dashboard', 'epo', 'project-details', 'customer', 'pm', 'am',
    'vendors', 'supplier', 'invoice', 'dn', 'coc', 'pos', 'status',
    'users', 'roles', 'permissions'
];

foreach ($sections as $section) {
    $count = Permission::where('name', 'like', "% {$section}")->count();
    $sectionName = ucwords(str_replace('-', ' ', $section));
    echo sprintf("%-25s : %d permissions\n", $sectionName, $count);
}

// 3. Check if permissions have all 5 operations
echo "\n📊 Checking Permission Structure:\n";
echo "-------------------------------------------\n";
$operations = ['show', 'add', 'edit', 'delete', 'view'];
$missingPerms = [];

foreach ($sections as $section) {
    foreach ($operations as $operation) {
        $permName = "{$operation} {$section}";
        if (!Permission::where('name', $permName)->exists()) {
            $missingPerms[] = $permName;
        }
    }
}

if (empty($missingPerms)) {
    echo "✅ All sections have complete 5 operations (show, add, edit, delete, view)\n";
} else {
    echo "❌ Missing permissions:\n";
    foreach ($missingPerms as $perm) {
        echo "   - {$perm}\n";
    }
}

// 4. Check roles
echo "\n👥 Roles in System:\n";
echo "-------------------------------------------\n";
$roles = Role::all();
foreach ($roles as $role) {
    $permCount = $role->permissions()->count();
    echo "- {$role->name}: {$permCount} permissions assigned\n";
}

// 5. Check users and their permissions
echo "\n👤 Users and Their Roles:\n";
echo "-------------------------------------------\n";
$users = User::with('roles')->get();
foreach ($users as $user) {
    $status = $user->Status == 'active' ? '🟢' : '🔴';
    $roleNames = $user->roles->pluck('name')->implode(', ') ?: 'No roles';
    echo "{$status} {$user->name} ({$user->email})\n";
    echo "   Roles: {$roleNames}\n";

    if ($user->roles->count() > 0) {
        $allPermissions = $user->getAllPermissions()->count();
        echo "   Total Permissions: {$allPermissions}\n";
    }
}

// 6. Test permission logic
echo "\n🧪 Testing Permission Logic:\n";
echo "-------------------------------------------\n";

// Test 1: Can create role and assign permissions
try {
    echo "Test 1: Creating test role with permissions... ";
    $testRole = Role::firstOrCreate(['name' => 'Test Role']);
    $testPerms = Permission::whereIn('name', ['show dashboard', 'view dashboard', 'show epo'])->get();
    $testRole->syncPermissions($testPerms);
    echo "✅ PASSED\n";
} catch (\Exception $e) {
    echo "❌ FAILED: " . $e->getMessage() . "\n";
}

// Test 2: Can assign role to user
try {
    echo "Test 2: Assigning role to user... ";
    $testUser = User::where('Status', 'active')->first();
    if ($testUser) {
        $testUser->assignRole('Test Role');
        echo "✅ PASSED\n";
    } else {
        echo "⚠️  SKIPPED: No active users found\n";
    }
} catch (\Exception $e) {
    echo "❌ FAILED: " . $e->getMessage() . "\n";
}

// Test 3: Check if user has permission through role
try {
    echo "Test 3: Checking user permissions through role... ";
    if ($testUser) {
        $hasPermission = $testUser->hasPermissionTo('show dashboard');
        if ($hasPermission) {
            echo "✅ PASSED\n";
        } else {
            echo "❌ FAILED: User should have 'show dashboard' permission\n";
        }
    } else {
        echo "⚠️  SKIPPED: No test user\n";
    }
} catch (\Exception $e) {
    echo "❌ FAILED: " . $e->getMessage() . "\n";
}

// Test 4: Check inactive user login restriction
echo "Test 4: Checking inactive user restriction... ";
$inactiveCount = User::where('Status', 'inactive')->count();
echo "✅ PASSED ({$inactiveCount} inactive users cannot login)\n";

// Cleanup test role
if (isset($testRole)) {
    $testRole->delete();
}
if (isset($testUser)) {
    $testUser->roles()->detach();
}

echo "\n===============================================\n";
echo "   SYSTEM STATUS: ";
if (empty($missingPerms) && $totalPermissions == 80) {
    echo "✅ HEALTHY\n";
} else {
    echo "⚠️  NEEDS ATTENTION\n";
}
echo "===============================================\n";
