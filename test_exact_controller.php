<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;
use App\Models\Ptasks;

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║         EXACT CONTROLLER SIMULATION TEST                      ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Simulate EXACT controller code
$query = Project::query();

$filteredProjects = $query->with([
    'ppms:id,name',
    'aams:id,name',
    'cust:id,name',
    'latestStatus',
    'tasks' => function($q) {
        $q->select('id', 'pr_number', 'details', 'assigned', 'status');
    },
    'risks' => function($q) {
        $q->select('id', 'pr_number', 'risk', 'impact', 'status');
    },
    'milestones' => function($q) {
        $q->select('id', 'pr_number', 'milestone', 'status');
    },
    'invoices' => function($q) {
        $q->select('id', 'pr_number', 'invoice_number', 'value', 'status');
    },
    'dns' => function($q) {
        $q->select('id', 'pr_number', 'dn_number');
    }
])->get()->map(function($project) {
    // Get tasks using multiple methods for compatibility
    $tasks = Ptasks::where('pr_number', $project->id)
        ->orWhere('pr_number', $project->pr_number)
        ->get();

    // Calculate progress
    $totalTasks = $tasks->count();
    $completedTasks = $tasks->whereIn('status', ['Completed', 'completed', 'Done', 'done'])->count();
    $pendingTasks = $tasks->whereIn('status', ['Pending', 'pending', 'In Progress', 'in progress'])->count();

    // Add calculated properties to project
    $project->totalTasks = $totalTasks;
    $project->completedTasks = $completedTasks;
    $project->pendingTasks = $pendingTasks;
    $project->progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;
    $project->calculatedTasks = $tasks;

    return $project;
});

echo "Total Projects: {$filteredProjects->count()}\n\n";

foreach ($filteredProjects as $project) {
    echo "═══════════════════════════════════════════════════════════════════\n";
    echo "PROJECT: {$project->pr_number}\n";
    echo "═══════════════════════════════════════════════════════════════════\n\n";

    // Check what's available for the view
    echo "📊 AVAILABLE DATA FOR VIEW:\n";
    echo "─────────────────────────────────────────────────────────────────\n";
    echo "  \$project->totalTasks = " . ($project->totalTasks ?? 'NOT SET') . "\n";
    echo "  \$project->completedTasks = " . ($project->completedTasks ?? 'NOT SET') . "\n";
    echo "  \$project->pendingTasks = " . ($project->pendingTasks ?? 'NOT SET') . "\n";
    echo "  \$project->progress = " . ($project->progress ?? 'NOT SET') . "\n";
    echo "  \$project->calculatedTasks = " . (isset($project->calculatedTasks) ? $project->calculatedTasks->count() . ' tasks' : 'NOT SET') . "\n";
    echo "\n";

    echo "📋 TASKS RELATION:\n";
    echo "─────────────────────────────────────────────────────────────────\n";
    echo "  \$project->tasks->count() = {$project->tasks->count()}\n";
    if ($project->tasks->count() > 0) {
        $pending = $project->tasks->whereIn('status', ['Pending', 'pending', 'In Progress', 'in progress']);
        echo "  Pending tasks: {$pending->count()}\n";
        foreach ($project->tasks->take(2) as $task) {
            echo "    • {$task->details} [{$task->status}]\n";
        }
    }
    echo "\n";

    echo "💰 INVOICES RELATION:\n";
    echo "─────────────────────────────────────────────────────────────────\n";
    echo "  \$project->invoices->count() = {$project->invoices->count()}\n";
    if ($project->invoices->count() > 0) {
        $paid = $project->invoices->whereIn('status', ['paid', 'Paid']);
        echo "  Paid invoices: {$paid->count()}\n";
        foreach ($project->invoices as $invoice) {
            echo "    • {$invoice->invoice_number} - " . number_format($invoice->value, 0) . " SAR [{$invoice->status}]\n";
        }
        echo "\n";
        echo "  VIEW SHOULD SHOW:\n";
        echo "    - Invoice list: {$project->invoices->count()} invoices\n";
        echo "    - Paid status: {$paid->count()}/{$project->invoices->count()} Paid\n";
    } else {
        echo "  ❌ No invoices\n";
        echo "\n";
        echo "  VIEW SHOULD SHOW:\n";
        echo "    - Message: \"No invoices\"\n";
        echo "    - Paid status: \"0/0 Paid\"\n";
    }
    echo "\n";

    echo "🎨 BLADE VARIABLES:\n";
    echo "─────────────────────────────────────────────────────────────────\n";

    // Simulate the @php block in view
    $projectTasks = $project->calculatedTasks ?? collect();
    echo "  \$projectTasks (from \$project->calculatedTasks):\n";
    echo "    Count: {$projectTasks->count()}\n";
    $pendingTasksView = $projectTasks->whereIn('status', ['Pending', 'pending', 'In Progress', 'in progress']);
    echo "    Pending: {$pendingTasksView->count()}\n";
    echo "    Should display: \"{$pendingTasksView->count()}/{$projectTasks->count()} Pending\"\n";

    echo "\n\n";
}

echo "✅ Simulation Complete!\n\n";
