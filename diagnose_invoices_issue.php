<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║         INVOICES DISPLAY ISSUE DIAGNOSIS                       ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "📋 TEST 1: Check if invoices are loaded in controller\n";
echo "══════════════════════════════════════════════════════════════════\n";

$query = Project::query();
$filteredProjects = $query->with([
    'invoices' => function($q) {
        $q->select('id', 'pr_number', 'invoice_number', 'value', 'status');
    }
])->get();

foreach ($filteredProjects as $project) {
    echo "Project: {$project->pr_number}\n";
    echo "  Invoices loaded: " . ($project->relationLoaded('invoices') ? 'YES' : 'NO') . "\n";
    echo "  Invoices count: {$project->invoices->count()}\n";

    if ($project->invoices->count() > 0) {
        echo "  ✅ Invoices data available:\n";
        foreach ($project->invoices as $inv) {
            echo "    • {$inv->invoice_number} - {$inv->value} SAR\n";
        }
    } else {
        echo "  ❌ No invoices\n";
    }
    echo "\n";
}

echo "\n📋 TEST 2: Check Blade condition\n";
echo "══════════════════════════════════════════════════════════════════\n";

// Simulate request
$hasNoInvoiceFilter = false;
echo "request('filter.pr_number_no_invoice'): " . ($hasNoInvoiceFilter ? 'TRUE' : 'FALSE') . "\n";
echo "@if(!request('filter.pr_number_no_invoice')): " . (!$hasNoInvoiceFilter ? 'TRUE (SHOW)' : 'FALSE (HIDE)') . "\n";
echo "\n";

echo "📋 TEST 3: Check invoice relationship definition\n";
echo "══════════════════════════════════════════════════════════════════\n";

$project = Project::first();
if ($project) {
    echo "Project Model: " . get_class($project) . "\n";
    echo "Has invoices() method: " . (method_exists($project, 'invoices') ? 'YES' : 'NO') . "\n";

    if (method_exists($project, 'invoices')) {
        $relation = $project->invoices();
        echo "Relation type: " . get_class($relation) . "\n";
        echo "Foreign key: {$relation->getForeignKeyName()}\n";
        echo "Owner key: {$relation->getOwnerKeyName()}\n";
    }
}

echo "\n📋 TEST 4: Raw SQL query check\n";
echo "══════════════════════════════════════════════════════════════════\n";

$sql = "SELECT
    p.pr_number,
    p.name,
    COUNT(i.id) as invoice_count
FROM projects p
LEFT JOIN invoices i ON i.pr_number = p.id
GROUP BY p.id, p.pr_number, p.name";

$results = DB::select($sql);
foreach ($results as $row) {
    echo "PR# {$row->pr_number}: {$row->invoice_count} invoices\n";
}

echo "\n📋 TEST 5: Check if view file has correct syntax\n";
echo "══════════════════════════════════════════════════════════════════\n";

$viewFile = resource_path('views/admin/dashboard.blade.php');
echo "View file exists: " . (file_exists($viewFile) ? 'YES' : 'NO') . "\n";
echo "View file size: " . number_format(filesize($viewFile)) . " bytes\n";

// Search for the invoices section
$content = file_get_contents($viewFile);
$hasInvoicesSection = strpos($content, '{{-- Invoices Statistics --}}') !== false;
echo "Has Invoices section: " . ($hasInvoicesSection ? 'YES' : 'NO') . "\n";

// Check for the condition
$hasCondition = strpos($content, "@if(!request('filter.pr_number_no_invoice'))") !== false;
echo "Has filter condition: " . ($hasCondition ? 'YES' : 'NO') . "\n";

// Count @if and @endif to check for balance
$ifCount = substr_count($content, '@if(');
$endifCount = substr_count($content, '@endif');
echo "Total @if: {$ifCount}\n";
echo "Total @endif: {$endifCount}\n";
echo "Balanced: " . ($ifCount === $endifCount ? 'YES ✅' : 'NO ❌') . "\n";

echo "\n✅ Diagnosis complete!\n\n";
