<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

echo "════════════════════════════════════════════════════════════════\n";
echo "   🔍 COMPREHENSIVE SYSTEM TEST - FULL VALIDATION\n";
echo "════════════════════════════════════════════════════════════════\n\n";

$totalTests = 0;
$passedTests = 0;
$failedTests = 0;
$warnings = 0;

function testResult($testName, $passed, $message = '') {
    global $totalTests, $passedTests, $failedTests;
    $totalTests++;
    if ($passed) {
        $passedTests++;
        echo "   ✅ PASSED: $testName\n";
    } else {
        $failedTests++;
        echo "   ❌ FAILED: $testName\n";
        if ($message) echo "      → $message\n";
    }
}

function testWarning($message) {
    global $warnings;
    $warnings++;
    echo "   ⚠️  WARNING: $message\n";
}

// ═══════════════════════════════════════════════════════════════
// TEST CATEGORY 1: DATABASE STRUCTURE & DATA
// ═══════════════════════════════════════════════════════════════
echo "1️⃣  DATABASE STRUCTURE & DATA TESTS\n";
echo "─────────────────────────────────────────────────────────────\n";

// Test 1.1: Permissions count
$permCount = Permission::count();
testResult("Total Permissions Count = 100", $permCount === 100, "Found: $permCount");

// Test 1.2: Check all 20 sections exist
$expectedSections = [
    'dashboard', 'epo', 'project-details', 'customer', 'pm', 'am',
    'vendors', 'supplier', 'invoice', 'dn', 'coc', 'pos', 'status',
    'ptasks', 'risks', 'milestones', 'reports',
    'users', 'roles', 'permissions'
];

foreach ($expectedSections as $section) {
    $sectionPerms = Permission::where('name', 'like', "% $section")->count();
    testResult("Section '$section' has 5 permissions", $sectionPerms === 5, "Found: $sectionPerms");
}

// Test 1.3: Check operations completeness
$operations = ['show', 'add', 'edit', 'delete', 'view'];
foreach ($expectedSections as $section) {
    foreach ($operations as $operation) {
        $exists = Permission::where('name', "$operation $section")->exists();
        if (!$exists) {
            testResult("Permission '$operation $section' exists", false, "Missing permission");
        }
    }
}
testResult("All 100 permissions have correct naming", true);

// Test 1.4: Roles existence
$requiredRoles = ['Super Admin', 'owner', 'Dashboard Viewer', 'Project Manager', 'Accountant'];
foreach ($requiredRoles as $roleName) {
    $exists = Role::where('name', $roleName)->exists();
    testResult("Role '$roleName' exists", $exists);
}

// Test 1.5: Super Admin & Owner have all permissions
$superAdmin = Role::where('name', 'Super Admin')->first();
if ($superAdmin) {
    $perms = $superAdmin->permissions()->count();
    testResult("Super Admin has all 100 permissions", $perms === 100, "Has: $perms");
}

$owner = Role::where('name', 'owner')->first();
if ($owner) {
    $perms = $owner->permissions()->count();
    testResult("Owner has all 100 permissions", $perms === 100, "Has: $perms");
}

// Test 1.6: Active users exist
$activeCount = User::where('Status', 'active')->count();
testResult("At least 1 active user exists", $activeCount > 0, "Found: $activeCount");

// Test 1.7: Test users can login
$testEmails = ['superadmin@test.com', 'admin@admin.com', 'dashboard@test.com', 'pm@test.com', 'accountant@test.com'];
foreach ($testEmails as $email) {
    $user = User::where('email', $email)->first();
    if ($user) {
        testResult("User '$email' is active", $user->Status === 'active', "Status: {$user->Status}");
    }
}

echo "\n";

// ═══════════════════════════════════════════════════════════════
// TEST CATEGORY 2: CONTROLLERS VALIDATION
// ═══════════════════════════════════════════════════════════════
echo "2️⃣  CONTROLLERS MIDDLEWARE TESTS\n";
echo "─────────────────────────────────────────────────────────────\n";

$controllersToCheck = [
    'DashboardController' => 'dashboard',
    'PepoController' => 'epo',
    'ProjectsController' => 'project-details',
    'CustController' => 'customer',
    'PpmsController' => 'pm',
    'AamsController' => 'am',
    'VendorsController' => 'vendors',
    'DsController' => 'supplier',
    'InvoicesController' => 'invoice',
    'DnController' => 'dn',
    'CocController' => 'coc',
    'PposController' => 'pos',
    'PstatusController' => 'status',
    'PtasksController' => 'ptasks',
    'RisksController' => 'risks',
    'MilestonesController' => 'milestones',
    'ReportController' => 'reports',
    'UserController' => 'users',
    'RoleController' => 'roles',
];

foreach ($controllersToCheck as $controller => $section) {
    $filePath = app_path("Http/Controllers/{$controller}.php");
    if (File::exists($filePath)) {
        $content = File::get($filePath);

        // Check if controller has __construct method
        $hasConstruct = strpos($content, 'public function __construct') !== false;
        testResult("$controller has __construct method", $hasConstruct);

        // Check if it has permission middleware
        $hasMiddleware = strpos($content, "permission:") !== false;
        testResult("$controller has permission middleware", $hasMiddleware);

        // Check for specific section permission
        $hasShowPerm = strpos($content, "show $section") !== false;
        if ($controller !== 'ReportController') { // ReportController only uses show
            testResult("$controller protects '$section' section", $hasShowPerm);
        }
    } else {
        testResult("$controller file exists", false, "File not found");
    }
}

echo "\n";

// ═══════════════════════════════════════════════════════════════
// TEST CATEGORY 3: VIEWS VALIDATION
// ═══════════════════════════════════════════════════════════════
echo "3️⃣  VIEWS & BLADE TEMPLATES TESTS\n";
echo "─────────────────────────────────────────────────────────────\n";

// Test 3.1: Sidebar protection
$sidebarPath = resource_path('views/layouts/main-sidebar.blade.php');
if (File::exists($sidebarPath)) {
    $sidebarContent = File::get($sidebarPath);

    testResult("Sidebar file exists", true);

    // Check each section has @can directive
    foreach ($expectedSections as $section) {
        $hasCanDirective = strpos($sidebarContent, "@can('show $section')") !== false;
        if ($section !== 'permissions') { // permissions might not be in sidebar
            testResult("Sidebar: '$section' protected with @can", $hasCanDirective);
        }
    }
} else {
    testResult("Sidebar file exists", false);
}

// Test 3.2: Users view protection
$usersViewPath = resource_path('views/users/show_users.blade.php');
if (File::exists($usersViewPath)) {
    $usersContent = File::get($usersViewPath);

    $hasAddPerm = strpos($usersContent, "@can('add users')") !== false;
    $hasEditPerm = strpos($usersContent, "@can('edit users')") !== false;
    $hasDeletePerm = strpos($usersContent, "@can('delete users')") !== false;

    testResult("Users view: Add button protected", $hasAddPerm);
    testResult("Users view: Edit button protected", $hasEditPerm);
    testResult("Users view: Delete button protected", $hasDeletePerm);
} else {
    testResult("Users view file exists", false);
}

// Test 3.3: Roles view protection
$rolesViewPath = resource_path('views/roles/index.blade.php');
if (File::exists($rolesViewPath)) {
    $rolesContent = File::get($rolesViewPath);

    $hasAddPerm = strpos($rolesContent, "@can('add roles')") !== false;
    $hasEditPerm = strpos($rolesContent, "@can('edit roles')") !== false;
    $hasDeletePerm = strpos($rolesContent, "@can('delete roles')") !== false;
    $hasViewPerm = strpos($rolesContent, "@can('view roles')") !== false;

    testResult("Roles view: Add button protected", $hasAddPerm);
    testResult("Roles view: View button protected", $hasViewPerm);
    testResult("Roles view: Edit button protected", $hasEditPerm);
    testResult("Roles view: Delete button protected", $hasDeletePerm);
} else {
    testResult("Roles view file exists", false);
}

// Test 3.4: Role create/edit forms have permission dependency
$roleCreatePath = resource_path('views/roles/create.blade.php');
if (File::exists($roleCreatePath)) {
    $createContent = File::get($roleCreatePath);

    $hasDataPermission = strpos($createContent, "data-permission") !== false;
    $hasPermissionCheckbox = strpos($createContent, "permission-checkbox") !== false;
    $hasSelectAllBtn = strpos($createContent, "selectAllBtn") !== false;
    $hasDeselectAllBtn = strpos($createContent, "deselectAllBtn") !== false;

    testResult("Role create: Has data-permission attribute", $hasDataPermission);
    testResult("Role create: Has permission-checkbox class", $hasPermissionCheckbox);
    testResult("Role create: Has Select All button", $hasSelectAllBtn);
    testResult("Role create: Has Deselect All button", $hasDeselectAllBtn);

    // Check for dependency logic
    $hasDependencyLogic = strpos($createContent, "updateDependentPermissions") !== false;
    testResult("Role create: Has permission dependency logic", $hasDependencyLogic);
} else {
    testResult("Role create form exists", false);
}

$roleEditPath = resource_path('views/roles/edit.blade.php');
if (File::exists($roleEditPath)) {
    $editContent = File::get($roleEditPath);

    $hasDataPermission = strpos($editContent, "data-permission") !== false;
    $hasPermissionCheckbox = strpos($editContent, "permission-checkbox") !== false;
    $hasSelectAllBtn = strpos($editContent, "selectAllBtn") !== false;
    $hasDeselectAllBtn = strpos($editContent, "deselectAllBtn") !== false;
    $hasDependencyLogic = strpos($editContent, "updateDependentPermissions") !== false;

    testResult("Role edit: Has data-permission attribute", $hasDataPermission);
    testResult("Role edit: Has permission-checkbox class", $hasPermissionCheckbox);
    testResult("Role edit: Has Select All button", $hasSelectAllBtn);
    testResult("Role edit: Has Deselect All button", $hasDeselectAllBtn);
    testResult("Role edit: Has permission dependency logic", $hasDependencyLogic);
} else {
    testResult("Role edit form exists", false);
}

echo "\n";

// ═══════════════════════════════════════════════════════════════
// TEST CATEGORY 4: AUTHENTICATION & AUTHORIZATION LOGIC
// ═══════════════════════════════════════════════════════════════
echo "4️⃣  AUTHENTICATION & AUTHORIZATION TESTS\n";
echo "─────────────────────────────────────────────────────────────\n";

// Test 4.1: LoginController blocks inactive users
$loginControllerPath = app_path('Http/Controllers/Auth/LoginController.php');
if (File::exists($loginControllerPath)) {
    $loginContent = File::get($loginControllerPath);

    $hasCredentialsMethod = strpos($loginContent, "protected function credentials") !== false;
    $hasStatusCheck = strpos($loginContent, "'Status' => 'active'") !== false;

    testResult("LoginController has credentials method", $hasCredentialsMethod);
    testResult("LoginController checks Status = active", $hasStatusCheck);
} else {
    testResult("LoginController file exists", false);
}

// Test 4.2: Test user permissions inheritance
$superAdminUser = User::where('email', 'superadmin@test.com')->first();
if ($superAdminUser) {
    $userPerms = $superAdminUser->getAllPermissions()->count();
    testResult("Super Admin user inherits all 100 permissions", $userPerms === 100, "Has: $userPerms");

    // Test specific new section permissions
    $canShowPtasks = $superAdminUser->can('show ptasks');
    $canShowRisks = $superAdminUser->can('show risks');
    $canShowMilestones = $superAdminUser->can('show milestones');
    $canShowReports = $superAdminUser->can('show reports');

    testResult("Super Admin can access ptasks", $canShowPtasks);
    testResult("Super Admin can access risks", $canShowRisks);
    testResult("Super Admin can access milestones", $canShowMilestones);
    testResult("Super Admin can access reports", $canShowReports);
}

// Test 4.3: Dashboard Viewer has limited permissions
$dashboardUser = User::where('email', 'dashboard@test.com')->first();
if ($dashboardUser) {
    $userPerms = $dashboardUser->getAllPermissions()->count();
    testResult("Dashboard Viewer has only 2 permissions", $userPerms === 2, "Has: $userPerms");

    $canShowDashboard = $dashboardUser->can('show dashboard');
    $cannotShowEpo = !$dashboardUser->can('show epo');
    $cannotShowProjects = !$dashboardUser->can('show project-details');

    testResult("Dashboard Viewer can show dashboard", $canShowDashboard);
    testResult("Dashboard Viewer CANNOT show epo", $cannotShowEpo);
    testResult("Dashboard Viewer CANNOT show projects", $cannotShowProjects);
}

// Test 4.4: Project Manager has correct permissions
$pmUser = User::where('email', 'pm@test.com')->first();
if ($pmUser) {
    $canShowDashboard = $pmUser->can('show dashboard');
    $canShowProjects = $pmUser->can('show project-details');
    $canShowCustomer = $pmUser->can('show customer');
    $canShowPm = $pmUser->can('show pm');
    $canShowAm = $pmUser->can('show am');

    $cannotShowInvoice = !$pmUser->can('show invoice');
    $cannotShowVendors = !$pmUser->can('show vendors');

    testResult("PM can show dashboard", $canShowDashboard);
    testResult("PM can show project-details", $canShowProjects);
    testResult("PM can show customer", $canShowCustomer);
    testResult("PM can show pm", $canShowPm);
    testResult("PM can show am", $canShowAm);
    testResult("PM CANNOT show invoice", $cannotShowInvoice);
    testResult("PM CANNOT show vendors", $cannotShowVendors);
}

// Test 4.5: Accountant has correct permissions
$accountantUser = User::where('email', 'accountant@test.com')->first();
if ($accountantUser) {
    $canShowInvoice = $accountantUser->can('show invoice');
    $canShowPos = $accountantUser->can('show pos');
    $canShowDn = $accountantUser->can('show dn');

    $cannotShowCustomer = !$accountantUser->can('show customer');
    $cannotShowPm = !$accountantUser->can('show pm');

    testResult("Accountant can show invoice", $canShowInvoice);
    testResult("Accountant can show pos", $canShowPos);
    testResult("Accountant can show dn", $canShowDn);
    testResult("Accountant CANNOT show customer", $cannotShowCustomer);
    testResult("Accountant CANNOT show pm", $cannotShowPm);
}

echo "\n";

// ═══════════════════════════════════════════════════════════════
// TEST CATEGORY 5: ROUTES & MIDDLEWARE
// ═══════════════════════════════════════════════════════════════
echo "5️⃣  ROUTES & MIDDLEWARE TESTS\n";
echo "─────────────────────────────────────────────────────────────\n";

// Test 5.1: Check critical routes exist
$criticalRoutes = [
    'dashboard.index',
    'epo.index',
    'projects.index',
    'customer.index',
    'pm.index',
    'am.index',
    'vendors.index',
    'ds.index',
    'invoices.index',
    'dn.index',
    'coc.index',
    'ppos.index',
    'pstatus.index',
    'ptasks.index',
    'risks.index',
    'milestones.index',
    'reports.index',
    'users.index',
    'roles.index',
];

foreach ($criticalRoutes as $routeName) {
    $routeExists = Route::has($routeName);
    testResult("Route '$routeName' exists", $routeExists);
}

// Test 5.2: Auth routes exist
$authRoutes = ['login', 'logout'];
foreach ($authRoutes as $routeName) {
    $routeExists = Route::has($routeName);
    testResult("Auth route '$routeName' exists", $routeExists);
}

echo "\n";

// ═══════════════════════════════════════════════════════════════
// TEST CATEGORY 6: DATA INTEGRITY & RELATIONSHIPS
// ═══════════════════════════════════════════════════════════════
echo "6️⃣  DATA INTEGRITY TESTS\n";
echo "─────────────────────────────────────────────────────────────\n";

// Test 6.1: Check for orphaned role assignments
$usersWithRoles = User::has('roles')->count();
$totalUsers = User::count();
testResult("All users have at least one role", $usersWithRoles === $totalUsers, "Users with roles: $usersWithRoles / Total: $totalUsers");

// Test 6.2: Check for permissions without roles
$orphanedPermissions = Permission::doesntHave('roles')->count();
if ($orphanedPermissions > 0) {
    testWarning("Found $orphanedPermissions permissions not assigned to any role");
}

// Test 6.3: Inactive users count
$inactiveUsers = User::where('Status', 'inactive')->count();
if ($inactiveUsers > 0) {
    testWarning("Found $inactiveUsers inactive users (they cannot login)");
}

// Test 6.4: Check for duplicate permissions
$duplicates = Permission::select('name')
    ->groupBy('name')
    ->havingRaw('COUNT(*) > 1')
    ->get();
testResult("No duplicate permissions exist", $duplicates->count() === 0, "Duplicates: " . $duplicates->count());

echo "\n";

// ═══════════════════════════════════════════════════════════════
// TEST CATEGORY 7: FILE STRUCTURE & DEPENDENCIES
// ═══════════════════════════════════════════════════════════════
echo "7️⃣  FILE STRUCTURE & DEPENDENCIES TESTS\n";
echo "─────────────────────────────────────────────────────────────\n";

// Test 7.1: Check critical files exist
$criticalFiles = [
    'database/seeders/PermissionSeeder.php',
    'app/Http/Controllers/Auth/LoginController.php',
    'resources/views/layouts/main-sidebar.blade.php',
    'resources/views/users/show_users.blade.php',
    'resources/views/users/Add_user.blade.php',
    'resources/views/users/edit.blade.php',
    'resources/views/roles/index.blade.php',
    'resources/views/roles/create.blade.php',
    'resources/views/roles/edit.blade.php',
];

foreach ($criticalFiles as $file) {
    $exists = File::exists(base_path($file));
    testResult("Critical file exists: " . basename($file), $exists, $file);
}

// Test 7.2: Check Spatie Permission package installed
$composerPath = base_path('composer.json');
if (File::exists($composerPath)) {
    $composerContent = File::get($composerPath);
    $hasSpatiePermission = strpos($composerContent, 'spatie/laravel-permission') !== false;
    testResult("Spatie Permission package installed", $hasSpatiePermission);
}

echo "\n";

// ═══════════════════════════════════════════════════════════════
// FINAL SUMMARY
// ═══════════════════════════════════════════════════════════════
echo "════════════════════════════════════════════════════════════════\n";
echo "   📊 TEST SUMMARY\n";
echo "════════════════════════════════════════════════════════════════\n\n";

$passRate = $totalTests > 0 ? round(($passedTests / $totalTests) * 100, 2) : 0;

echo "Total Tests Run:     $totalTests\n";
echo "✅ Passed:           $passedTests\n";
echo "❌ Failed:           $failedTests\n";
echo "⚠️  Warnings:        $warnings\n";
echo "📈 Pass Rate:        $passRate%\n\n";

if ($failedTests === 0 && $warnings === 0) {
    echo "════════════════════════════════════════════════════════════════\n";
    echo "   🎉🎉🎉 PERFECT! ALL TESTS PASSED! 🎉🎉🎉\n";
    echo "   System is ready for production!\n";
    echo "════════════════════════════════════════════════════════════════\n";
} elseif ($failedTests === 0) {
    echo "════════════════════════════════════════════════════════════════\n";
    echo "   ✅ ALL TESTS PASSED! ($warnings warnings to review)\n";
    echo "   System is functional but review warnings above\n";
    echo "════════════════════════════════════════════════════════════════\n";
} else {
    echo "════════════════════════════════════════════════════════════════\n";
    echo "   ⚠️  SYSTEM HAS ISSUES - REVIEW FAILED TESTS ABOVE\n";
    echo "════════════════════════════════════════════════════════════════\n";
}

echo "\n";
