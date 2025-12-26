<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;

echo "=== Testing Logo Display for All Projects ===\n\n";

$projects = Project::with('cust')->get();

foreach ($projects as $project) {
    echo "Project: {$project->pr_number} - {$project->name}\n";
    echo "  cust_id: " . ($project->cust_id ?? 'NULL') . "\n";

    if ($project->cust) {
        echo "  Customer Found: YES\n";
        echo "  Customer ID: {$project->cust->id}\n";
        echo "  Customer Name: {$project->cust->name}\n";
        echo "  Logo Field: " . ($project->cust->logo ?? 'NULL') . "\n";

        if ($project->cust->logo) {
            $logoPath = public_path($project->cust->logo);
            echo "  Logo Path: {$logoPath}\n";
            echo "  Logo Exists: " . (file_exists($logoPath) ? 'YES' : 'NO') . "\n";
            echo "  Asset URL: " . asset($project->cust->logo) . "\n";
        }
    } else {
        echo "  Customer Found: NO\n";
    }

    echo "  Condition \$project->cust: " . ($project->cust ? 'TRUE' : 'FALSE') . "\n";
    echo "  Condition \$project->cust->logo: " . ($project->cust && $project->cust->logo ? 'TRUE' : 'FALSE') . "\n";
    echo "\n";
}
