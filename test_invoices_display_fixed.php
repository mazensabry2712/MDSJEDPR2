<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;

echo "\n🔍 Testing Invoices Display After Fix\n";
echo "══════════════════════════════════════════════════════════════════\n\n";

// Simulate controller logic with filter
$query = Project::query();

// Apply filter (simulate user selecting "all")
$query->where(function($q) {
    // This mimics the "all" filter - show all projects
});

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

echo "Total Projects: {$filteredProjects->count()}\n\n";

foreach ($filteredProjects as $project) {
    echo "┌─────────────────────────────────────────────────────────────────┐\n";
    echo "│ PROJECT: {$project->pr_number} - {$project->name}\n";
    echo "├─────────────────────────────────────────────────────────────────┤\n";

    echo "│\n";
    echo "│ 📋 INVOICES SECTION:\n";
    echo "│ ───────────────────────────────────────────────────────────────\n";

    if ($project->invoices->count() > 0) {
        echo "│ ✅ Invoices Found: {$project->invoices->count()}\n";
        echo "│\n";

        foreach ($project->invoices as $invoice) {
            $formattedValue = number_format($invoice->value, 0);
            echo "│   • {$invoice->invoice_number} → {$formattedValue} SAR [{$invoice->status}]\n";
        }

        $paidCount = $project->invoices->whereIn('status', ['paid', 'Paid'])->count();
        $totalCount = $project->invoices->count();

        echo "│\n";
        echo "│   Paid Status: {$paidCount}/{$totalCount} Paid\n";
        echo "│\n";

        // Calculate what should display in view
        echo "│ 🎨 VIEW DISPLAY:\n";
        echo "│   @if(\$project->invoices->count() > 0): TRUE ✅\n";
        echo "│   Loop through invoices: {$project->invoices->count()} items\n";
        echo "│   Display: \"{$paidCount}/{$totalCount} Paid\"\n";
    } else {
        echo "│ ❌ No Invoices\n";
        echo "│\n";
        echo "│ 🎨 VIEW DISPLAY:\n";
        echo "│   @if(\$project->invoices->count() > 0): FALSE\n";
        echo "│   Display: \"No invoices\"\n";
        echo "│   Display: \"0/0 Paid\"\n";
    }

    echo "│\n";
    echo "└─────────────────────────────────────────────────────────────────┘\n\n";
}

echo "✅ Test Complete!\n\n";
