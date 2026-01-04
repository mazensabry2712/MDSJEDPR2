<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "═══════════════════════════════════════════════════════\n";
echo "   🧪 COMPREHENSIVE PERMISSION SYSTEM TEST\n";
echo "═══════════════════════════════════════════════════════\n\n";

$allPassed = true;

// Test 1: Check Total Permissions
echo "1️⃣  Testing Total Permissions Count...\n";
$totalPermissions = Permission::count();
if ($totalPermissions === 100) {
    echo "   ✅ PASSED: Total permissions = 100\n\n";
} else {
    echo "   ❌ FAILED: Expected 100, got $totalPermissions\n\n";
    $allPassed = false;
}

// Test 2: Check All 20 Sections
echo "2️⃣  Testing All 20 Sections Have Complete Permissions...\n";
$sections = [
    'dashboard', 'epo', 'project-details', 'customer', 'pm', 'am',
    'vendors', 'supplier', 'invoice', 'dn', 'coc', 'pos', 'status',
    'ptasks', 'risks', 'milestones', 'reports',
    'users', 'roles', 'permissions'
];

$operations = ['show', 'add', 'edit', 'delete', 'view'];
$missingSections = [];

foreach ($sections as $section) {
    $sectionPermissions = Permission::where('name', 'like', "% $section")->count();
    if ($sectionPermissions !== 5) {
        $missingSections[] = "$section (has $sectionPermissions, expected 5)";
    }
}

if (empty($missingSections)) {
    echo "   ✅ PASSED: All 20 sections have complete 5 operations\n\n";
} else {
    echo "   ❌ FAILED: Missing permissions in sections:\n";
    foreach ($missingSections as $missing) {
        echo "      - $missing\n";
    }
    echo "\n";
    $allPassed = false;
}

// Test 3: Check Super Admin Role
echo "3️⃣  Testing Super Admin Role...\n";
$superAdminRole = Role::where('name', 'Super Admin')->first();
if ($superAdminRole) {
    $rolePermissions = $superAdminRole->permissions()->count();
    if ($rolePermissions === 100) {
        echo "   ✅ PASSED: Super Admin has all 100 permissions\n\n";
    } else {
        echo "   ❌ FAILED: Super Admin has $rolePermissions permissions (expected 100)\n\n";
        $allPassed = false;
    }
} else {
    echo "   ❌ FAILED: Super Admin role not found\n\n";
    $allPassed = false;
}

// Test 4: Check Owner Role
echo "4️⃣  Testing Owner Role...\n";
$ownerRole = Role::where('name', 'owner')->first();
if ($ownerRole) {
    $rolePermissions = $ownerRole->permissions()->count();
    if ($rolePermissions === 100) {
        echo "   ✅ PASSED: Owner has all 100 permissions\n\n";
    } else {
        echo "   ❌ FAILED: Owner has $rolePermissions permissions (expected 100)\n\n";
        $allPassed = false;
    }
} else {
    echo "   ❌ FAILED: Owner role not found\n\n";
    $allPassed = false;
}

// Test 5: Check Dashboard Viewer Role
echo "5️⃣  Testing Dashboard Viewer Role...\n";
$dashboardRole = Role::where('name', 'Dashboard Viewer')->first();
if ($dashboardRole) {
    $rolePermissions = $dashboardRole->permissions()->count();
    $hasShowDashboard = $dashboardRole->hasPermissionTo('show dashboard');

    if ($rolePermissions === 2 && $hasShowDashboard) {
        echo "   ✅ PASSED: Dashboard Viewer has only dashboard permissions\n\n";
    } else {
        echo "   ❌ FAILED: Dashboard Viewer has $rolePermissions permissions (expected 2)\n\n";
        $allPassed = false;
    }
} else {
    echo "   ⚠️  WARNING: Dashboard Viewer role not found\n\n";
}

// Test 6: Check Active Users
echo "6️⃣  Testing Active Users...\n";
$activeUsers = User::where('Status', 'active')->count();
$inactiveUsers = User::where('Status', 'inactive')->count();
echo "   📊 Active Users: $activeUsers\n";
echo "   📊 Inactive Users: $inactiveUsers\n";
if ($activeUsers > 0) {
    echo "   ✅ PASSED: At least one active user exists\n\n";
} else {
    echo "   ⚠️  WARNING: No active users found\n\n";
}

// Test 7: Test User Permissions (Sample)
echo "7️⃣  Testing User Permission Inheritance...\n";
$superAdminUser = User::where('email', 'superadmin@test.com')->first();
if ($superAdminUser) {
    $userPermissions = $superAdminUser->getAllPermissions()->count();
    $canShowPtasks = $superAdminUser->can('show ptasks');
    $canShowRisks = $superAdminUser->can('show risks');
    $canShowMilestones = $superAdminUser->can('show milestones');
    $canShowReports = $superAdminUser->can('show reports');

    if ($userPermissions === 100 && $canShowPtasks && $canShowRisks && $canShowMilestones && $canShowReports) {
        echo "   ✅ PASSED: Super Admin user has all permissions including new sections\n\n";
    } else {
        echo "   ❌ FAILED: Super Admin user permissions incomplete\n";
        echo "      - Total permissions: $userPermissions/100\n";
        echo "      - Can show ptasks: " . ($canShowPtasks ? 'Yes' : 'No') . "\n";
        echo "      - Can show risks: " . ($canShowRisks ? 'Yes' : 'No') . "\n";
        echo "      - Can show milestones: " . ($canShowMilestones ? 'Yes' : 'No') . "\n";
        echo "      - Can show reports: " . ($canShowReports ? 'Yes' : 'No') . "\n\n";
        $allPassed = false;
    }
} else {
    echo "   ⚠️  WARNING: Super Admin user not found\n\n";
}

// Test 8: Test New Sections Permissions
echo "8️⃣  Testing New Sections (ptasks, risks, milestones, reports)...\n";
$newSections = ['ptasks', 'risks', 'milestones', 'reports'];
$newSectionsPassed = true;

foreach ($newSections as $section) {
    $sectionPerms = Permission::where('name', 'like', "% $section")->pluck('name')->toArray();
    if (count($sectionPerms) === 5) {
        echo "   ✅ $section: " . implode(', ', $sectionPerms) . "\n";
    } else {
        echo "   ❌ $section: Only " . count($sectionPerms) . " permissions found\n";
        $newSectionsPassed = false;
        $allPassed = false;
    }
}

if ($newSectionsPassed) {
    echo "   ✅ PASSED: All new sections have complete permissions\n\n";
} else {
    echo "   ❌ FAILED: Some new sections are incomplete\n\n";
}

// Final Summary
echo "═══════════════════════════════════════════════════════\n";
if ($allPassed) {
    echo "   ✅✅✅ ALL TESTS PASSED! SYSTEM IS READY! ✅✅✅\n";
} else {
    echo "   ⚠️⚠️⚠️ SOME TESTS FAILED - CHECK ABOVE ⚠️⚠️⚠️\n";
}
echo "═══════════════════════════════════════════════════════\n\n";

echo "📋 SYSTEM STATISTICS:\n";
echo "─────────────────────────────────────────────────────\n";
echo "Total Permissions: " . Permission::count() . "\n";
echo "Total Roles: " . Role::count() . "\n";
echo "Total Users: " . User::count() . "\n";
echo "Active Users: " . User::where('Status', 'active')->count() . "\n";
echo "Sections Covered: " . count($sections) . "\n";
echo "═══════════════════════════════════════════════════════\n\n";

echo "🔐 TEST USER ACCOUNTS:\n";
echo "─────────────────────────────────────────────────────\n";
$testUsers = [
    'superadmin@test.com' => 'Super Admin (ALL permissions)',
    'admin@admin.com' => 'Owner (ALL permissions)',
    'dashboard@test.com' => 'Dashboard Viewer (Dashboard only)',
    'pm@test.com' => 'Project Manager (Projects, Customer, PM, AM)',
    'accountant@test.com' => 'Accountant (Invoice, POs, DN)'
];

foreach ($testUsers as $email => $description) {
    $user = User::where('email', $email)->first();
    if ($user) {
        $status = $user->Status === 'active' ? '🟢 Active' : '🔴 Inactive';
        $roleNames = $user->roles->pluck('name')->implode(', ');
        echo "✓ $email\n";
        echo "  Status: $status | Role: $roleNames\n";
        echo "  Description: $description\n\n";
    }
}

echo "═══════════════════════════════════════════════════════\n";
echo "🚀 READY FOR MANUAL TESTING!\n";
echo "═══════════════════════════════════════════════════════\n";
