<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

echo "===============================================\n";
echo "   CREATING TEST USERS WITH PERMISSIONS\n";
echo "===============================================\n\n";

// 1. Create Super Admin user (all permissions)
echo "1️⃣  Creating Super Admin user...\n";
$superAdmin = User::firstOrCreate(
    ['email' => 'superadmin@test.com'],
    [
        'name' => 'Super Admin',
        'password' => Hash::make('123456'),
        'Status' => 'active'
    ]
);

$superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
$superAdminRole->syncPermissions(Permission::all());
$superAdmin->syncRoles(['Super Admin']);

echo "   ✅ Email: superadmin@test.com | Password: 123456\n";
echo "   📋 Permissions: ALL (80 permissions)\n\n";

// 2. Create Dashboard Only user (can only see dashboard)
echo "2️⃣  Creating Dashboard Viewer user...\n";
$dashboardUser = User::firstOrCreate(
    ['email' => 'dashboard@test.com'],
    [
        'name' => 'Dashboard Viewer',
        'password' => Hash::make('123456'),
        'Status' => 'active'
    ]
);

$dashboardRole = Role::firstOrCreate(['name' => 'Dashboard Viewer']);
$dashboardRole->syncPermissions(['show dashboard', 'view dashboard']);
$dashboardUser->syncRoles(['Dashboard Viewer']);

echo "   ✅ Email: dashboard@test.com | Password: 123456\n";
echo "   📋 Permissions: show dashboard, view dashboard\n\n";

// 3. Create Project Manager user (dashboard + projects + customers + pm/am)
echo "3️⃣  Creating Project Manager user...\n";
$projectManager = User::firstOrCreate(
    ['email' => 'pm@test.com'],
    [
        'name' => 'Project Manager',
        'password' => Hash::make('123456'),
        'Status' => 'active'
    ]
);

$pmRole = Role::firstOrCreate(['name' => 'Project Manager']);
$pmPermissions = Permission::where('name', 'like', '% dashboard')
    ->orWhere('name', 'like', '% project-details')
    ->orWhere('name', 'like', '% customer')
    ->orWhere('name', 'like', '% pm')
    ->orWhere('name', 'like', '% am')
    ->get();
$pmRole->syncPermissions($pmPermissions);
$projectManager->syncRoles(['Project Manager']);

echo "   ✅ Email: pm@test.com | Password: 123456\n";
echo "   📋 Permissions: Dashboard, Project Details, Customer, PM, AM\n\n";

// 4. Create Accountant user (invoices, POs, DN only)
echo "4️⃣  Creating Accountant user...\n";
$accountant = User::firstOrCreate(
    ['email' => 'accountant@test.com'],
    [
        'name' => 'Accountant',
        'password' => Hash::make('123456'),
        'Status' => 'active'
    ]
);

$accountantRole = Role::firstOrCreate(['name' => 'Accountant']);
$accountantPermissions = Permission::where('name', 'like', '% dashboard')
    ->orWhere('name', 'like', '% invoice')
    ->orWhere('name', 'like', '% pos')
    ->orWhere('name', 'like', '% dn')
    ->get();
$accountantRole->syncPermissions($accountantPermissions);
$accountant->syncRoles(['Accountant']);

echo "   ✅ Email: accountant@test.com | Password: 123456\n";
echo "   📋 Permissions: Dashboard, Invoice, Project POs, DN\n\n";

// 5. Activate existing admin user
echo "5️⃣  Activating existing admin user...\n";
$admin = User::where('email', 'admin@admin.com')->first();
if ($admin) {
    $admin->update(['Status' => 'active']);
    $ownerRole = Role::where('name', 'owner')->first();
    if ($ownerRole) {
        $ownerRole->syncPermissions(Permission::all());
        $admin->syncRoles(['owner']);
    }
    echo "   ✅ Email: admin@admin.com | Status: Active\n";
    echo "   📋 Role: owner (ALL permissions)\n\n";
} else {
    echo "   ⚠️  Admin user not found\n\n";
}

echo "===============================================\n";
echo "   ✅ TEST USERS CREATED SUCCESSFULLY!\n";
echo "===============================================\n\n";

echo "🧪 TEST SCENARIOS:\n";
echo "-------------------------------------------\n";
echo "1. Login as 'dashboard@test.com' → Should only see Dashboard\n";
echo "2. Login as 'pm@test.com' → Should see Dashboard, Projects, Customer, PM, AM\n";
echo "3. Login as 'accountant@test.com' → Should see Dashboard, Invoice, POs, DN\n";
echo "4. Login as 'superadmin@test.com' → Should see EVERYTHING\n";
echo "5. Login as 'admin@admin.com' → Should see EVERYTHING (owner)\n\n";

echo "🔐 All passwords: 123456\n";
