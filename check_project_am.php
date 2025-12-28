<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;

echo "=== Checking Project PR0704 AM Data ===\n\n";

$project = Project::where('pr_number', 'PR0704')->first();

if (!$project) {
    echo "Project not found.\n";
} else {
    echo "Project: {$project->pr_number}\n";
    echo "AM ID: {$project->aams_id}\n\n";

    if ($project->aams) {
        echo "AM Details:\n";
        echo "- Name: {$project->aams->name}\n";
        echo "- Email: " . ($project->aams->email ?: 'NULL') . "\n";
        echo "- Phone: " . ($project->aams->phone ?: 'NULL') . "\n";
    } else {
        echo "No AM assigned.\n";
    }
}
