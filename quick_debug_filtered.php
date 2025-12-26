<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;
use Illuminate\Http\Request;

echo "\n🔍 Simulating Dashboard with Filter\n";
echo "══════════════════════════════════════════════════════════════════\n\n";

// Simulate the exact controller code
$request = new Request();
$request->merge([
    'filter' => [
        'pr_number' => 'all'
    ]
]);

$filters = $request->filter;
$query = Project::query();

// Apply filter
if (!empty($filters['pr_number']) && $filters['pr_number'] !== 'all') {
    $query->where('pr_number', $filters['pr_number']);
}

// Load relationships EXACTLY as in controller
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
])->get();

echo "Total Filtered Projects: {$filteredProjects->count()}\n\n";

foreach ($filteredProjects as $project) {
    echo "═══════════════════════════════════════════════════════════════════\n";
    echo "PROJECT: {$project->pr_number} - {$project->name}\n";
    echo "═══════════════════════════════════════════════════════════════════\n\n";

    // Tasks
    echo "📋 TASKS:\n";
    echo "  Relation loaded: " . ($project->relationLoaded('tasks') ? 'YES' : 'NO') . "\n";
    echo "  Count: {$project->tasks->count()}\n";

    if ($project->tasks->count() > 0) {
        $pending = $project->tasks->whereIn('status', ['Pending', 'pending', 'In Progress', 'in progress']);
        echo "  Pending: {$pending->count()}\n";
        foreach ($project->tasks->take(3) as $task) {
            echo "    • {$task->details} → {$task->assigned} [{$task->status}]\n";
        }
    } else {
        echo "  ❌ NO TASKS FOUND\n";
    }
    echo "\n";

    // Invoices
    echo "💰 INVOICES:\n";
    echo "  Relation loaded: " . ($project->relationLoaded('invoices') ? 'YES' : 'NO') . "\n";
    echo "  Count: {$project->invoices->count()}\n";

    if ($project->invoices->count() > 0) {
        $paid = $project->invoices->whereIn('status', ['paid', 'Paid']);
        echo "  Paid: {$paid->count()}/{$project->invoices->count()}\n";
        foreach ($project->invoices as $invoice) {
            echo "    • {$invoice->invoice_number} → " . number_format($invoice->value, 0) . " SAR [{$invoice->status}]\n";
        }
    } else {
        echo "  ❌ NO INVOICES FOUND\n";
    }
    echo "\n\n";
}

echo "✅ Simulation Complete!\n\n";
