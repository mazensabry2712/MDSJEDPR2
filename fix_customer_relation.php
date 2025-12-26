<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;
use Illuminate\Support\Facades\DB;

echo "=== Updating Projects with Customer ID ===\n\n";

// Update all projects to link to customer ID 1 (NEOM Company)
$updated = DB::table('projects')->update(['cust_id' => 1]);

echo "Updated {$updated} projects with cust_id = 1 (NEOM Company)\n\n";

echo "=== Verifying Projects ===\n";
$projects = Project::with('cust')->get();
foreach ($projects as $project) {
    echo "PR: {$project->pr_number}\n";
    echo "  Name: {$project->name}\n";
    echo "  cust_id: {$project->cust_id}\n";
    if ($project->cust) {
        echo "  Customer: {$project->cust->name}\n";
        echo "  Logo: {$project->cust->logo}\n";
    } else {
        echo "  Customer: NOT FOUND\n";
    }
    echo "\n";
}
