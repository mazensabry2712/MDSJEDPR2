<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;
use App\Models\Pstatus;

echo "=== Testing Latest Status Relationship ===\n\n";

// Get first project by PR number
$project = Project::with('latestStatus', 'statuses')->where('pr_number', 'PR0704')->first();

// If not found, try to get any project
if (!$project) {
    echo "PR0704 not found, trying to get first project...\n";
    $project = Project::with('latestStatus', 'statuses')->first();
}

if ($project) {
    echo "Project ID: {$project->id}\n";
    echo "Project PR Number: {$project->pr_number}\n";
    echo "Project Name: {$project->name}\n\n";

    // Get all statuses
    echo "--- All Statuses for this project ---\n";
    $allStatuses = Pstatus::where('pr_number', $project->id)
        ->orderBy('expected_completion', 'desc')
        ->orderBy('id', 'desc')
        ->get();

    foreach ($allStatuses as $status) {
        echo "  Status ID: {$status->id}\n";
        echo "  Expected Completion: {$status->expected_completion}\n";
        echo "  Actual Completion: " . ($status->actual_completion ?? 'NULL') . "%\n";
        echo "  Created: {$status->created_at}\n";
        echo "  ---\n";
    }

    echo "\n--- Latest Status (via relationship) ---\n";
    if ($project->latestStatus) {
        echo "  Status ID: {$project->latestStatus->id}\n";
        echo "  Expected Completion: {$project->latestStatus->expected_completion}\n";
        echo "  Actual Completion: " . ($project->latestStatus->actual_completion ?? 'NULL') . "%\n";
    } else {
        echo "  No latest status found!\n";
    }
} else {
    echo "Project not found!\n";
}
