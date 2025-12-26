<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Project;
use App\Models\Ptasks;

echo "=== Testing Project Progress Issue ===\n\n";

// Show all projects first
echo "=== All Projects ===\n";
$allProjects = Project::select('id', 'pr_number', 'name')->get();
foreach ($allProjects as $p) {
    echo "Project ID: {$p->id}, PR: {$p->pr_number}, Name: {$p->name}\n";
}
echo "\nTotal Projects: " . $allProjects->count() . "\n\n";

// Get first project
$project = Project::first();

if (!$project) {
    echo "❌ Project PR0704 not found!\n";
    exit;
}

echo "✅ Project Found:\n";
echo "   ID: {$project->id}\n";
echo "   PR Number: {$project->pr_number}\n";
echo "   Name: {$project->name}\n\n";

// Check tasks relationship
echo "=== Tasks Relationship Test ===\n";
$tasksCount = $project->tasks->count();
echo "Tasks Count (via relationship): {$tasksCount}\n\n";

// Check tasks directly from database
echo "=== Direct Database Check ===\n";
$directTasksById = Ptasks::where('pr_number', $project->id)->get();
echo "Tasks where pr_number = {$project->id} (project id): " . $directTasksById->count() . "\n";

$directTasksByPrNumber = Ptasks::where('pr_number', $project->pr_number)->get();
echo "Tasks where pr_number = '{$project->pr_number}' (project pr_number): " . $directTasksByPrNumber->count() . "\n\n";

// Show sample tasks
echo "=== Sample Tasks (Direct Query by ID) ===\n";
foreach ($directTasksById->take(3) as $task) {
    echo "Task ID: {$task->id}\n";
    echo "   pr_number field: {$task->pr_number}\n";
    echo "   status: {$task->status}\n";
    echo "   details: " . ($task->details ?? 'N/A') . "\n\n";
}

// Check ptasks table structure
echo "=== All Tasks pr_number values (sample) ===\n";
$allTasks = Ptasks::select('id', 'pr_number', 'status')->take(10)->get();
foreach ($allTasks as $task) {
    echo "Task #{$task->id}: pr_number = '{$task->pr_number}', status = {$task->status}\n";
}

echo "\n=== All Projects (sample) ===\n";
$allProjects = Project::select('id', 'pr_number', 'name')->take(5)->get();
foreach ($allProjects as $p) {
    echo "Project ID: {$p->id}, PR: {$p->pr_number}, Name: {$p->name}\n";
}
