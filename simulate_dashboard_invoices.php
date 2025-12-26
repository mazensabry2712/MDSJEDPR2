<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;
use Illuminate\Http\Request;

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║         SIMULATE DASHBOARD INVOICES DISPLAY                    ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Simulate the controller logic for filtered projects
$request = new Request();
$request->merge([
    'filter' => [
        'pr_number' => 'all'
    ]
]);

echo "🔍 SIMULATING FILTER: pr_number = all\n";
echo "══════════════════════════════════════════════════════════════════\n\n";

// Base query
$query = Project::query();

// Apply filter
$filters = $request->filter;
if (!empty($filters['pr_number']) && $filters['pr_number'] !== 'all') {
    $query->where('pr_number', $filters['pr_number']);
}

// Load relationships
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

echo "📊 FILTERED PROJECTS RESULT:\n";
echo "══════════════════════════════════════════════════════════════════\n";
echo "Total Projects: {$filteredProjects->count()}\n\n";

foreach ($filteredProjects as $project) {
    echo "Project: {$project->pr_number} - {$project->name}\n";
    echo "─────────────────────────────────────────────────────────────────\n";

    echo "  Invoices Count: {$project->invoices->count()}\n";

    if ($project->invoices->count() > 0) {
        echo "  Invoices Details:\n";
        foreach ($project->invoices as $invoice) {
            echo "    • {$invoice->invoice_number} - " . number_format($invoice->value, 0) . " SAR [{$invoice->status}]\n";
        }

        $paidCount = $project->invoices->whereIn('status', ['paid', 'Paid'])->count();
        $totalCount = $project->invoices->count();
        echo "  Paid: {$paidCount}/{$totalCount}\n";
    } else {
        echo "  ❌ No invoices\n";
    }

    echo "\n";
}

echo "\n🔍 CHECKING VIEW CONDITION:\n";
echo "══════════════════════════════════════════════════════════════════\n";

// Check the condition from the view
$prNumberNoInvoice = $request->input('filter.pr_number_no_invoice');
echo "filter.pr_number_no_invoice = " . ($prNumberNoInvoice ?? 'null') . "\n";
echo "Condition @if(!request('filter.pr_number_no_invoice')): " . (!$prNumberNoInvoice ? 'TRUE (show invoices)' : 'FALSE (hide invoices)') . "\n";

echo "\n✅ Simulation complete!\n\n";
