<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;
use App\Models\Cust;
use App\Models\Ptasks;
use Illuminate\Support\Facades\DB;

echo "========================================\n";
echo "🔍 COMPREHENSIVE LOGO TEST\n";
echo "========================================\n\n";

// Test 1: Customer Data
echo "TEST 1: Customer Table Data\n";
echo "----------------------------\n";
$customers = Cust::all();
echo "Total Customers: " . $customers->count() . "\n\n";
foreach ($customers as $cust) {
    echo "Customer ID: {$cust->id}\n";
    echo "  Name: {$cust->name}\n";
    echo "  Logo Field: " . ($cust->logo ?? 'NULL') . "\n";
    if ($cust->logo) {
        $fullPath = public_path($cust->logo);
        echo "  Full Path: {$fullPath}\n";
        echo "  File Exists: " . (file_exists($fullPath) ? 'YES ✅' : 'NO ❌') . "\n";
    }
    echo "\n";
}

// Test 2: Projects and Customer Relationship
echo "TEST 2: Projects Customer Relationship\n";
echo "---------------------------------------\n";
$projectsRaw = DB::table('projects')->get();
echo "Raw Projects Count: {$projectsRaw->count()}\n\n";

foreach ($projectsRaw as $proj) {
    echo "PR: {$proj->pr_number}\n";
    echo "  Name: {$proj->name}\n";
    echo "  cust_id in DB: " . ($proj->cust_id ?? 'NULL') . "\n";
    echo "\n";
}

// Test 3: Projects with Eloquent Relationship
echo "TEST 3: Projects with Eloquent (with cust)\n";
echo "-------------------------------------------\n";
$projects = Project::with('cust')->get();
foreach ($projects as $project) {
    echo "PR: {$project->pr_number} - {$project->name}\n";
    echo "  cust_id: " . ($project->cust_id ?? 'NULL') . "\n";
    echo "  Relationship loaded: " . ($project->relationLoaded('cust') ? 'YES' : 'NO') . "\n";
    echo "  \$project->cust exists: " . ($project->cust ? 'YES ✅' : 'NO ❌') . "\n";

    if ($project->cust) {
        echo "  Customer ID: {$project->cust->id}\n";
        echo "  Customer Name: {$project->cust->name}\n";
        echo "  Customer Logo: " . ($project->cust->logo ?? 'NULL') . "\n";
        echo "  Logo is not empty: " . (!empty($project->cust->logo) ? 'YES ✅' : 'NO ❌') . "\n";
    }
    echo "\n";
}

// Test 4: Specific PR003 Test (Dashboard scenario)
echo "TEST 4: PR003 Specific Test (Dashboard Scenario)\n";
echo "-------------------------------------------------\n";
$pr003 = Project::with('cust')->where('pr_number', 'PR003')->first();
if ($pr003) {
    echo "Project Found: YES ✅\n";
    echo "  Name: {$pr003->name}\n";
    echo "  cust_id: {$pr003->cust_id}\n";
    echo "  \$pr003->cust: " . ($pr003->cust ? 'EXISTS ✅' : 'NULL ❌') . "\n";

    if ($pr003->cust) {
        echo "  \$pr003->cust->logo: " . ($pr003->cust->logo ?? 'NULL') . "\n";
        echo "\n  BLADE CONDITION TESTS:\n";
        echo "  ---------------------\n";
        echo "  if(\$project->cust): " . ($pr003->cust ? 'TRUE ✅' : 'FALSE ❌') . "\n";
        echo "  if(\$project->cust && \$project->cust->logo): " . ($pr003->cust && $pr003->cust->logo ? 'TRUE ✅' : 'FALSE ❌') . "\n";

        if ($pr003->cust->logo) {
            echo "\n  LOGO PATH DETAILS:\n";
            echo "  ------------------\n";
            echo "  Logo value: {$pr003->cust->logo}\n";
            echo "  URL would be: /{$pr003->cust->logo}\n";
            echo "  Asset URL: " . asset($pr003->cust->logo) . "\n";
            echo "  Full system path: " . public_path($pr003->cust->logo) . "\n";
            echo "  File exists: " . (file_exists(public_path($pr003->cust->logo)) ? 'YES ✅' : 'NO ❌') . "\n";
        }
    } else {
        echo "  ❌ Customer relationship is NULL!\n";
        echo "  This is the problem - need to check:\n";
        echo "  1. Is cust_id set in projects table?\n";
        echo "  2. Is the relationship defined correctly in Project model?\n";
    }
} else {
    echo "❌ PR003 NOT FOUND!\n";
}
echo "\n";

// Test 5: Model Relationship Check
echo "TEST 5: Model Relationship Configuration\n";
echo "-----------------------------------------\n";
$project = new Project();
echo "Project Model Methods:\n";
$methods = get_class_methods($project);
$hasCustMethod = in_array('cust', $methods);
echo "  Has 'cust' method: " . ($hasCustMethod ? 'YES ✅' : 'NO ❌') . "\n";

// Test 6: Direct Image Access
echo "\nTEST 6: Direct File Access Check\n";
echo "---------------------------------\n";
$testFiles = [
    'storge/neom_logo.png',
    'storge/1766677157_qrcode_292190732_970acbbc2050a407b1e6ff2e74d5a1a5 (2).png'
];

foreach ($testFiles as $file) {
    $fullPath = public_path($file);
    echo "File: {$file}\n";
    echo "  Exists: " . (file_exists($fullPath) ? 'YES ✅' : 'NO ❌') . "\n";
    if (file_exists($fullPath)) {
        echo "  Size: " . filesize($fullPath) . " bytes\n";
    }
    echo "\n";
}

// Test 7: Check View Cache
echo "TEST 7: View Cache Status\n";
echo "-------------------------\n";
$viewCachePath = storage_path('framework/views');
echo "View cache path: {$viewCachePath}\n";
$viewFiles = glob($viewCachePath . '/*');
echo "Cached view files: " . count($viewFiles) . "\n";
echo "(Run 'php artisan view:clear' to clear)\n\n";

echo "========================================\n";
echo "✅ TEST COMPLETE\n";
echo "========================================\n";
