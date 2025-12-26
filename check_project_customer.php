<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;
use App\Models\Cust;

echo "=== Project PR003 Details ===\n";
$project = Project::where('pr_number', 'PR003')->with('cust')->first();

if ($project) {
    echo "Project ID: " . $project->id . "\n";
    echo "Project Name: " . $project->name . "\n";
    echo "Project PR Number: " . $project->pr_number . "\n";
    echo "Customer ID in Project: " . $project->customer_id . "\n\n";

    echo "=== Customer Relationship ===\n";
    if ($project->cust) {
        echo "Customer exists: YES\n";
        echo "Customer ID: " . $project->cust->id . "\n";
        echo "Customer Name: " . $project->cust->name . "\n";
        echo "Customer Logo: " . ($project->cust->logo ?? 'NULL') . "\n";
        echo "Logo Path: " . asset($project->cust->logo ?? '') . "\n";
    } else {
        echo "Customer exists: NO\n";
        echo "ERROR: No customer found!\n";
    }
} else {
    echo "Project PR003 not found!\n";
}

echo "\n=== All Customers ===\n";
$customers = Cust::all();
foreach ($customers as $cust) {
    echo "ID: {$cust->id}, Name: {$cust->name}, Logo: " . ($cust->logo ?? 'NULL') . "\n";
}

echo "\n=== All Projects ===\n";
$projects = Project::all();
foreach ($projects as $proj) {
    echo "PR: {$proj->pr_number}, Name: {$proj->name}, Customer ID: " . ($proj->customer_id ?? 'NULL') . "\n";
}
