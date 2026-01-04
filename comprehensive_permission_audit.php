<?php

/**
 * Comprehensive Permission System Audit Script
 * الفحص الشامل لنظام الصلاحيات
 *
 * This script checks:
 * 1. All permissions in database
 * 2. All roles and their permissions
 * 3. User permissions
 * 4. Blade view permission checks vs actual permissions
 * 5. Controller middleware vs actual permissions
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

echo "\n========================================\n";
echo "  COMPREHENSIVE PERMISSION AUDIT\n";
echo "  فحص شامل لنظام الصلاحيات\n";
echo "========================================\n\n";

// =========================================
// 1. Check All Permissions in Database
// =========================================
echo "1. ALL PERMISSIONS IN DATABASE:\n";
echo "================================\n";
$allPermissions = Permission::orderBy('name')->get();
echo "Total Permissions: " . $allPermissions->count() . "\n\n";

$permissionsBySection = [];
foreach ($allPermissions as $permission) {
    $parts = explode(' ', $permission->name);
    $operation = $parts[0];
    $section = implode(' ', array_slice($parts, 1));

    if (!isset($permissionsBySection[$section])) {
        $permissionsBySection[$section] = [];
    }
    $permissionsBySection[$section][] = $operation;
}

foreach ($permissionsBySection as $section => $operations) {
    echo "  📁 {$section}:\n";
    foreach ($operations as $operation) {
        echo "     ✓ {$operation} {$section}\n";
    }
    echo "\n";
}

// =========================================
// 2. Check All Roles and Their Permissions
// =========================================
echo "\n2. ALL ROLES AND THEIR PERMISSIONS:\n";
echo "====================================\n";
$allRoles = Role::with('permissions')->get();
echo "Total Roles: " . $allRoles->count() . "\n\n";

foreach ($allRoles as $role) {
    echo "  👤 Role: {$role->name}\n";
    echo "     Permissions: " . $role->permissions->count() . "\n";

    $rolePermissionsBySection = [];
    foreach ($role->permissions as $permission) {
        $parts = explode(' ', $permission->name);
        $operation = $parts[0];
        $section = implode(' ', array_slice($parts, 1));

        if (!isset($rolePermissionsBySection[$section])) {
            $rolePermissionsBySection[$section] = [];
        }
        $rolePermissionsBySection[$section][] = $operation;
    }

    foreach ($rolePermissionsBySection as $section => $operations) {
        echo "       📁 {$section}: " . implode(', ', $operations) . "\n";
    }
    echo "\n";
}

// =========================================
// 3. Check Owner Role Specifically
// =========================================
echo "\n3. OWNER ROLE DETAILED CHECK:\n";
echo "==============================\n";
$ownerRole = Role::where('name', 'owner')->first();

if ($ownerRole) {
    echo "  ✓ Owner role exists\n";
    echo "  Total Permissions: " . $ownerRole->permissions->count() . "\n\n";

    // Check specific customer permissions
    echo "  Customer Permissions:\n";
    $customerPermissions = ['show customer', 'add customer', 'edit customer', 'delete customer', 'view customer'];
    foreach ($customerPermissions as $permName) {
        $hasPermission = $ownerRole->hasPermissionTo($permName);
        $status = $hasPermission ? "✓ HAS" : "✗ MISSING";
        echo "     {$status}: {$permName}\n";
    }

    // Check all sections
    echo "\n  All Sections Coverage:\n";
    $sections = [
        'dashboard', 'epo', 'project-details', 'customer', 'pm', 'am',
        'vendors', 'supplier', 'invoice', 'dn', 'coc', 'pos', 'status',
        'ptasks', 'risks', 'milestones', 'reports', 'users', 'roles', 'permissions'
    ];

    foreach ($sections as $section) {
        $operations = ['show', 'add', 'edit', 'delete', 'view'];
        $sectionPerms = [];
        foreach ($operations as $op) {
            try {
                if ($ownerRole->hasPermissionTo("{$op} {$section}")) {
                    $sectionPerms[] = $op;
                }
            } catch (\Exception $e) {
                // Permission doesn't exist
            }
        }

        $coverage = empty($sectionPerms) ? "✗ NO PERMISSIONS" : "✓ " . implode(', ', $sectionPerms);
        echo "     {$section}: {$coverage}\n";
    }
} else {
    echo "  ✗ Owner role NOT FOUND!\n";
}

// =========================================
// 4. Check Admin User
// =========================================
echo "\n\n4. ADMIN USER CHECK:\n";
echo "=====================\n";
$adminUser = User::where('email', 'admin@admin.com')->first();

if ($adminUser) {
    echo "  ✓ Admin user exists\n";
    echo "  Name: {$adminUser->name}\n";
    echo "  Email: {$adminUser->email}\n";
    echo "  Status: {$adminUser->Status}\n";
    echo "  Roles: " . implode(', ', $adminUser->getRoleNames()->toArray()) . "\n";

    // Check direct permissions
    echo "  Direct Permissions: " . $adminUser->permissions->count() . "\n";

    // Check via role
    echo "  Permissions via Roles: " . $adminUser->getAllPermissions()->count() . "\n";

    // Check specific customer permissions
    echo "\n  Customer Permissions Check:\n";
    $customerPermissions = ['show customer', 'add customer', 'edit customer', 'delete customer', 'view customer'];
    foreach ($customerPermissions as $permName) {
        $hasPermission = $adminUser->can($permName);
        $status = $hasPermission ? "✓ CAN" : "✗ CANNOT";
        echo "     {$status}: {$permName}\n";
    }

    // Check generic permissions (that might be used in blade files)
    echo "\n  Generic Permissions Check (Used in Blade Files):\n";
    $genericPermissions = ['Add', 'Edit', 'Delete', 'View', 'Show'];
    foreach ($genericPermissions as $permName) {
        $hasPermission = $adminUser->can($permName);
        $status = $hasPermission ? "✓ CAN" : "✗ CANNOT";
        echo "     {$status}: {$permName}\n";
    }
} else {
    echo "  ✗ Admin user NOT FOUND!\n";
}

// =========================================
// 5. Check Blade Views Permission Usage
// =========================================
echo "\n\n5. BLADE VIEWS PERMISSION USAGE ANALYSIS:\n";
echo "==========================================\n";
echo "Analyzing customer/index.blade.php...\n\n";

$customerIndexPath = resource_path('views/dashboard/customer/index.blade.php');
if (file_exists($customerIndexPath)) {
    $content = file_get_contents($customerIndexPath);

    // Extract @can directives
    preg_match_all('/@can\([\'"]([^\'"]+)[\'"]\)/', $content, $matches);

    if (!empty($matches[1])) {
        echo "  Found @can directives:\n";
        $canDirectives = array_unique($matches[1]);
        foreach ($canDirectives as $directive) {
            echo "     @can('{$directive}')\n";

            // Check if this permission exists
            $permissionExists = Permission::where('name', $directive)->exists();
            if (!$permissionExists) {
                echo "        ⚠️  WARNING: Permission '{$directive}' does NOT exist in database!\n";
            }
        }
    } else {
        echo "  ⚠️  No @can directives found in customer index view!\n";
    }
} else {
    echo "  ✗ customer/index.blade.php not found!\n";
}

// =========================================
// 6. Check Controller Middleware
// =========================================
echo "\n\n6. CONTROLLER MIDDLEWARE CHECK:\n";
echo "================================\n";
echo "Checking CustController.php...\n\n";

$controllerPath = app_path('Http/Controllers/CustController.php');
if (file_exists($controllerPath)) {
    $content = file_get_contents($controllerPath);

    // Extract permission middleware
    preg_match_all('/permission:([^\'"\]]+)/', $content, $matches);

    if (!empty($matches[1])) {
        echo "  Found permission middleware:\n";
        $middlewarePerms = array_unique($matches[1]);
        foreach ($middlewarePerms as $perm) {
            $perm = trim($perm);
            echo "     permission:{$perm}\n";

            // Check if this permission exists
            $permissionExists = Permission::where('name', $perm)->exists();
            if (!$permissionExists) {
                echo "        ⚠️  WARNING: Permission '{$perm}' does NOT exist in database!\n";
            } else {
                // Check if owner has this permission
                if ($ownerRole && $ownerRole->hasPermissionTo($perm)) {
                    echo "        ✓ Owner role HAS this permission\n";
                } else {
                    echo "        ✗ Owner role MISSING this permission\n";
                }
            }
        }
    }
} else {
    echo "  ✗ CustController.php not found!\n";
}

// =========================================
// 7. PROBLEM IDENTIFICATION
// =========================================
echo "\n\n7. PROBLEM IDENTIFICATION:\n";
echo "===========================\n";

$problems = [];

// Check if generic permissions exist
$genericPerms = ['Add', 'Edit', 'Delete', 'View', 'Show'];
foreach ($genericPerms as $perm) {
    if (!Permission::where('name', $perm)->exists()) {
        $problems[] = "Generic permission '{$perm}' does NOT exist in database but is used in blade views (@can('{$perm}'))";
    }
}

// Check if owner has customer permissions
if ($ownerRole) {
    $customerPerms = ['show customer', 'add customer', 'edit customer', 'delete customer', 'view customer'];
    foreach ($customerPerms as $perm) {
        if (!$ownerRole->hasPermissionTo($perm)) {
            $problems[] = "Owner role is MISSING permission: {$perm}";
        }
    }
}

if (empty($problems)) {
    echo "  ✓ No problems detected!\n";
} else {
    echo "  ⚠️  PROBLEMS FOUND:\n\n";
    foreach ($problems as $i => $problem) {
        echo "  " . ($i + 1) . ". {$problem}\n";
    }
}

// =========================================
// 8. RECOMMENDATIONS
// =========================================
echo "\n\n8. RECOMMENDATIONS:\n";
echo "====================\n";

$recommendations = [];

// Check blade usage
if (file_exists($customerIndexPath)) {
    $content = file_get_contents($customerIndexPath);
    if (strpos($content, "@can('Add')") !== false) {
        $recommendations[] = "Change @can('Add') to @can('add customer') in customer/index.blade.php";
    }
    if (strpos($content, "@can('Edit')") !== false) {
        $recommendations[] = "Change @can('Edit') to @can('edit customer') in customer/index.blade.php";
    }
    if (strpos($content, "@can('Delete')") !== false) {
        $recommendations[] = "Change @can('Delete') to @can('delete customer') in customer/index.blade.php";
    }
    if (strpos($content, "@can('View')") !== false) {
        $recommendations[] = "Change @can('View') to @can('view customer') in customer/index.blade.php";
    }
}

if (empty($recommendations)) {
    echo "  ✓ No recommendations at this time.\n";
} else {
    echo "  📝 RECOMMENDED FIXES:\n\n";
    foreach ($recommendations as $i => $recommendation) {
        echo "  " . ($i + 1) . ". {$recommendation}\n";
    }
}

// =========================================
// 9. SUMMARY
// =========================================
echo "\n\n9. SUMMARY:\n";
echo "============\n";
echo "Total Permissions: " . $allPermissions->count() . "\n";
echo "Total Roles: " . $allRoles->count() . "\n";
echo "Owner Role: " . ($ownerRole ? "✓ EXISTS" : "✗ NOT FOUND") . "\n";
if ($ownerRole) {
    echo "Owner Permissions Count: " . $ownerRole->permissions->count() . "\n";
}
echo "Admin User: " . ($adminUser ? "✓ EXISTS" : "✗ NOT FOUND") . "\n";
echo "Problems Found: " . count($problems) . "\n";
echo "Recommendations: " . count($recommendations) . "\n";

echo "\n========================================\n";
echo "  AUDIT COMPLETE!\n";
echo "========================================\n\n";
