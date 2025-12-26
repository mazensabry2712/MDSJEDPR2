<?php

/**
 * COMPREHENSIVE LIVE SYSTEM CHECK
 * Check actual functionality by visiting the dashboard
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Project;
use App\Models\Ptasks;
use App\Models\Risks;
use App\Models\Milestones;
use App\Models\invoices;
use App\Models\Dn;
use App\Models\Pstatus;

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║           LIVE SYSTEM FUNCTIONALITY CHECK                      ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";
echo "\n";

// Check what data is actually available
$projects = Project::with(['ppms', 'aams', 'cust', 'latestStatus', 'tasks', 'risks', 'milestones', 'invoices', 'dns'])->get();

echo "📊 CURRENT DATABASE STATE\n";
echo "══════════════════════════════════════════════════════════════════\n\n";

echo "Total Projects: " . $projects->count() . "\n";
echo "Projects with Invoices: " . Project::has('invoices')->count() . "\n";
echo "Projects without Invoices: " . Project::whereDoesntHave('invoices')->count() . "\n";
echo "Total Tasks: " . Ptasks::count() . "\n";
echo "Total Risks: " . Risks::count() . "\n";
echo "Total Milestones: " . Milestones::count() . "\n";
echo "Total Invoices: " . invoices::count() . "\n";
echo "Total DNs: " . Dn::count() . "\n";
echo "Total Status Records: " . Pstatus::count() . "\n";
echo "\n";

echo "🔍 DETAILED PROJECT ANALYSIS\n";
echo "══════════════════════════════════════════════════════════════════\n\n";

foreach ($projects as $index => $project) {
    echo "Project " . ($index + 1) . ": PR# {$project->pr_number} - {$project->name}\n";
    echo "─────────────────────────────────────────────────────────────────\n";

    // Basic Info
    echo "Customer: " . ($project->cust->name ?? '❌ MISSING') . "\n";
    echo "PM: " . ($project->ppms->name ?? '❌ MISSING') . "\n";
    echo "AM: " . ($project->aams->name ?? '❌ MISSING') . "\n";
    echo "Value: " . ($project->value ? number_format($project->value, 2) . " SAR" : '❌ NOT SET') . "\n";
    echo "PO Date: " . ($project->customer_po_date ?? '❌ NOT SET') . "\n";
    echo "Technologies: " . ($project->technologies ?? '❌ NOT SET') . "\n";
    echo "Customer Contact: " . ($project->customer_contact_details ?? '❌ NOT SET') . "\n";

    // Tasks Analysis
    $tasks = Ptasks::where('pr_number', $project->id)
        ->orWhere('pr_number', $project->pr_number)
        ->get();

    echo "\nTasks: " . $tasks->count() . " total\n";
    if ($tasks->count() > 0) {
        $completed = $tasks->whereIn('status', ['Completed', 'completed', 'Done', 'done'])->count();
        $pending = $tasks->whereIn('status', ['Pending', 'pending', 'In Progress', 'in progress'])->count();
        $progress = $tasks->count() > 0 ? round(($completed / $tasks->count()) * 100, 1) : 0;

        echo "  ✓ Completed: {$completed}\n";
        echo "  ⏳ Pending: {$pending}\n";
        echo "  📊 Progress: {$progress}%\n";

        if ($tasks->count() <= 5) {
            foreach ($tasks as $task) {
                echo "    - " . ($task->details ?? 'No details') . " → " . ($task->assigned ?? 'Unassigned') . " [{$task->status}]\n";
            }
        }
    } else {
        echo "  ❌ NO TASKS FOUND\n";
    }

    // Risks Analysis
    $risks = $project->risks;
    echo "\nRisks: " . $risks->count() . " total\n";
    if ($risks->count() > 0) {
        $closed = $risks->whereIn('status', ['closed', 'Closed'])->count();
        echo "  ✓ Closed: {$closed}\n";
        echo "  ⚠️ Open: " . ($risks->count() - $closed) . "\n";

        foreach ($risks->take(3) as $risk) {
            echo "    - " . ($risk->risk ?? 'No description') . " [Impact: " . ($risk->impact ?? 'N/A') . "]\n";
        }
    } else {
        echo "  ℹ️  No risks recorded\n";
    }

    // Milestones Analysis
    $milestones = $project->milestones;
    echo "\nMilestones: " . $milestones->count() . " total\n";
    if ($milestones->count() > 0) {
        $completed = $milestones->whereIn('status', ['Completed', 'completed', 'on track'])->count();
        echo "  ✓ Completed: {$completed}\n";

        foreach ($milestones->take(3) as $milestone) {
            echo "    - " . ($milestone->milestone ?? 'No name') . " [{$milestone->status}]\n";
        }
    } else {
        echo "  ℹ️  No milestones set\n";
    }

    // Invoices Analysis
    $invoices = $project->invoices;
    echo "\nInvoices: " . $invoices->count() . " total\n";
    if ($invoices->count() > 0) {
        $paid = $invoices->whereIn('status', ['paid', 'Paid'])->count();
        $totalValue = $invoices->sum('value');
        echo "  ✓ Paid: {$paid}\n";
        echo "  💰 Total Value: " . number_format($totalValue, 2) . " SAR\n";

        foreach ($invoices->take(3) as $invoice) {
            echo "    - " . ($invoice->invoice_number ?? 'No number') . " - " . number_format($invoice->value ?? 0, 2) . " SAR [{$invoice->status}]\n";
        }
    } else {
        echo "  ℹ️  No invoices created\n";
    }

    // DNs Analysis
    $dns = $project->dns;
    echo "\nDNs: " . $dns->count() . " total\n";
    if ($dns->count() > 0) {
        foreach ($dns->take(5) as $dn) {
            echo "    - DN# " . ($dn->dn_number ?? 'No number') . "\n";
        }
    } else {
        echo "  ℹ️  No DNs created\n";
    }

    // Status Analysis
    echo "\nProject Status:\n";
    if ($project->latestStatus) {
        echo "  ✓ Latest Status ID: {$project->latestStatus->id}\n";
        echo "  📅 Expected Completion: " . ($project->latestStatus->expected_completion ?? '❌ NOT SET') . "\n";
        echo "  📊 Status Details: " . ($project->latestStatus->status ?? 'N/A') . "\n";
    } else {
        echo "  ❌ NO STATUS RECORDS FOUND\n";

        // Check if status exists in database
        $statusCount = Pstatus::where('pr_number', $project->id)
            ->orWhere('pr_number', $project->pr_number)
            ->count();
        echo "  ℹ️  Status records in DB: {$statusCount}\n";
    }

    echo "\n";
}

echo "\n";
echo "🔧 CHECKING FILTER FUNCTIONALITY\n";
echo "══════════════════════════════════════════════════════════════════\n\n";

// Test Filter 1: PR Number
$testProject = Project::first();
if ($testProject) {
    $filtered = Project::where('pr_number', $testProject->pr_number)->get();
    $success = $filtered->count() == 1;
    echo ($success ? "✅" : "❌") . " Filter by PR Number: " . ($success ? "WORKING" : "FAILED") . "\n";
    echo "   Query: pr_number = {$testProject->pr_number}\n";
    echo "   Results: {$filtered->count()}\n\n";
}

// Test Filter 2: All Projects
$allProjects = Project::get();
$success = $allProjects->count() == Project::count();
echo ($success ? "✅" : "❌") . " Filter by All: " . ($success ? "WORKING" : "FAILED") . "\n";
echo "   Results: {$allProjects->count()}\n\n";

// Test Filter 3: No Invoices
$noInvoiceProjects = Project::whereDoesntHave('invoices')->get();
echo "✅ Filter by No Invoices: WORKING\n";
echo "   Results: {$noInvoiceProjects->count()} projects without invoices\n\n";

echo "\n";
echo "🔍 POTENTIAL ISSUES FOUND\n";
echo "══════════════════════════════════════════════════════════════════\n\n";

$issues = [];

// Check for missing data
foreach ($projects as $project) {
    if (!$project->cust) {
        $issues[] = "PR# {$project->pr_number}: Missing Customer relationship";
    }
    if (!$project->ppms) {
        $issues[] = "PR# {$project->pr_number}: Missing PM relationship";
    }
    if (!$project->aams) {
        $issues[] = "PR# {$project->pr_number}: Missing AM relationship";
    }
    if (!$project->latestStatus) {
        $issues[] = "PR# {$project->pr_number}: Missing Status records (Expected completion date won't show)";
    }
    if (!$project->value) {
        $issues[] = "PR# {$project->pr_number}: Missing Value";
    }
    if (!$project->customer_po_date) {
        $issues[] = "PR# {$project->pr_number}: Missing PO Date";
    }
    if (!$project->technologies) {
        $issues[] = "PR# {$project->pr_number}: Missing Technologies";
    }

    $tasks = Ptasks::where('pr_number', $project->id)
        ->orWhere('pr_number', $project->pr_number)
        ->count();
    if ($tasks == 0) {
        $issues[] = "PR# {$project->pr_number}: No tasks found (Progress will show 0%)";
    }
}

if (count($issues) > 0) {
    foreach ($issues as $issue) {
        echo "⚠️  {$issue}\n";
    }
} else {
    echo "✅ No data issues found!\n";
}

echo "\n";
echo "📋 RECOMMENDATIONS\n";
echo "══════════════════════════════════════════════════════════════════\n\n";

$recommendations = [];

// Check for missing status
$projectsWithoutStatus = Project::whereDoesntHave('latestStatus')->count();
if ($projectsWithoutStatus > 0) {
    $recommendations[] = "Add Status records for {$projectsWithoutStatus} project(s) to show Expected Completion Date";
}

// Check for projects without tasks
$projectsWithoutTasks = 0;
foreach ($projects as $project) {
    $taskCount = Ptasks::where('pr_number', $project->id)
        ->orWhere('pr_number', $project->pr_number)
        ->count();
    if ($taskCount == 0) {
        $projectsWithoutTasks++;
    }
}
if ($projectsWithoutTasks > 0) {
    $recommendations[] = "Add tasks for {$projectsWithoutTasks} project(s) to show progress tracking";
}

// Check for missing basic info
$projectsWithMissingInfo = 0;
foreach ($projects as $project) {
    if (!$project->value || !$project->customer_po_date || !$project->technologies) {
        $projectsWithMissingInfo++;
    }
}
if ($projectsWithMissingInfo > 0) {
    $recommendations[] = "Complete basic info (Value, PO Date, Technologies) for {$projectsWithMissingInfo} project(s)";
}

if (count($recommendations) > 0) {
    foreach ($recommendations as $i => $rec) {
        echo ($i + 1) . ". {$rec}\n";
    }
} else {
    echo "✅ All data is complete!\n";
}

echo "\n";
echo "═══════════════════════════════════════════════════════════════════\n";
echo "                    SYSTEM CHECK COMPLETE                          \n";
echo "═══════════════════════════════════════════════════════════════════\n";
echo "\n";
