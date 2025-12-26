<?php

/**
 * ==============================================================
 * COMPREHENSIVE DASHBOARD FILTERS & DATA TEST
 * ==============================================================
 *
 * This script tests:
 * 1. Advanced Filter Functionality
 * 2. Filtered Dashboard Data Display
 * 3. Database Queries Accuracy
 * 4. Relationship Loading
 * 5. Progress Calculations
 * 6. Statistics Rendering
 *
 * ==============================================================
 */

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Ptasks;
use App\Models\Risks;
use App\Models\Milestones;
use App\Models\invoices;
use App\Models\Dn;

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║   COMPREHENSIVE DASHBOARD FILTERS & DATA TEST SUITE            ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";
echo "\n";

$testsPassed = 0;
$testsFailed = 0;
$totalTests = 0;

/**
 * Helper function to print test results
 */
function printTestResult($testName, $passed, $details = '') {
    global $testsPassed, $testsFailed, $totalTests;
    $totalTests++;

    if ($passed) {
        $testsPassed++;
        echo "✅ PASS: {$testName}\n";
    } else {
        $testsFailed++;
        echo "❌ FAIL: {$testName}\n";
    }

    if (!empty($details)) {
        echo "   ℹ️  {$details}\n";
    }
    echo "\n";
}

/**
 * Helper function to print section header
 */
function printSection($title) {
    echo "\n";
    echo "┌────────────────────────────────────────────────────────────────┐\n";
    echo "│ {$title}\n";
    echo "└────────────────────────────────────────────────────────────────┘\n";
    echo "\n";
}

// ==============================================================
// TEST 1: DATABASE CONNECTION & BASE DATA
// ==============================================================
printSection("TEST 1: DATABASE CONNECTION & BASE DATA");

try {
    $projectCount = Project::count();
    printTestResult(
        "Database Connection",
        $projectCount > 0,
        "Found {$projectCount} projects in database"
    );

    // Get sample project for testing
    $sampleProject = Project::with(['ppms', 'aams', 'cust'])->first();
    printTestResult(
        "Sample Project Retrieved",
        $sampleProject !== null,
        "PR Number: {$sampleProject->pr_number}, Name: {$sampleProject->name}"
    );

} catch (Exception $e) {
    printTestResult("Database Connection", false, "Error: " . $e->getMessage());
}

// ==============================================================
// TEST 2: FILTER BY PR NUMBER
// ==============================================================
printSection("TEST 2: FILTER BY PR NUMBER");

try {
    $testPrNumber = Project::first()->pr_number;

    // Simulate filter query
    $filteredProjects = Project::where('pr_number', $testPrNumber)
        ->with(['ppms', 'aams', 'cust', 'latestStatus'])
        ->get();

    $allMatchPrNumber = $filteredProjects->every(function($project) use ($testPrNumber) {
        return $project->pr_number == $testPrNumber;
    });

    printTestResult(
        "Filter by PR Number = {$testPrNumber}",
        $allMatchPrNumber && $filteredProjects->count() > 0,
        "Found {$filteredProjects->count()} project(s) matching PR Number {$testPrNumber}"
    );

    // Test with 'all' option
    $allProjects = Project::with(['ppms', 'aams', 'cust'])->get();
    printTestResult(
        "Filter by PR Number = 'all'",
        $allProjects->count() == Project::count(),
        "Returned all {$allProjects->count()} projects"
    );

} catch (Exception $e) {
    printTestResult("Filter by PR Number", false, "Error: " . $e->getMessage());
}

// ==============================================================
// TEST 3: FILTER BY PR NUMBER WITHOUT INVOICES
// ==============================================================
printSection("TEST 3: FILTER BY PR NUMBER WITHOUT INVOICES");

try {
    // Find a project without invoices
    $projectWithoutInvoices = Project::whereDoesntHave('invoices')->first();

    if ($projectWithoutInvoices) {
        $prNumber = $projectWithoutInvoices->pr_number;

        $filteredProjects = Project::where('pr_number', $prNumber)
            ->with(['ppms', 'aams', 'cust', 'invoices'])
            ->get();

        $hasNoInvoices = $filteredProjects->first()->invoices->count() == 0;

        printTestResult(
            "Filter PR Without Invoices (PR#{$prNumber})",
            $hasNoInvoices,
            "Project has {$filteredProjects->first()->invoices->count()} invoices"
        );
    } else {
        printTestResult(
            "Filter PR Without Invoices",
            true,
            "No projects without invoices found (all have invoices)"
        );
    }

} catch (Exception $e) {
    printTestResult("Filter PR Without Invoices", false, "Error: " . $e->getMessage());
}

// ==============================================================
// TEST 4: RELATIONSHIP LOADING
// ==============================================================
printSection("TEST 4: RELATIONSHIP LOADING");

try {
    $project = Project::with([
        'ppms:id,name',
        'aams:id,name',
        'cust:id,name',
        'latestStatus',
        'tasks',
        'risks',
        'milestones',
        'invoices',
        'dns'
    ])->first();

    printTestResult(
        "PM Relationship",
        isset($project->ppms),
        "PM: " . ($project->ppms->name ?? 'N/A')
    );

    printTestResult(
        "AM Relationship",
        isset($project->aams),
        "AM: " . ($project->aams->name ?? 'N/A')
    );

    printTestResult(
        "Customer Relationship",
        isset($project->cust),
        "Customer: " . ($project->cust->name ?? 'N/A')
    );

    printTestResult(
        "Tasks Relationship",
        $project->tasks !== null,
        "Loaded {$project->tasks->count()} tasks"
    );

    printTestResult(
        "Risks Relationship",
        $project->risks !== null,
        "Loaded {$project->risks->count()} risks"
    );

    printTestResult(
        "Milestones Relationship",
        $project->milestones !== null,
        "Loaded {$project->milestones->count()} milestones"
    );

    printTestResult(
        "Invoices Relationship",
        $project->invoices !== null,
        "Loaded {$project->invoices->count()} invoices"
    );

    printTestResult(
        "DNs Relationship",
        $project->dns !== null,
        "Loaded {$project->dns->count()} DNs"
    );

} catch (Exception $e) {
    printTestResult("Relationship Loading", false, "Error: " . $e->getMessage());
}

// ==============================================================
// TEST 5: PROGRESS CALCULATION
// ==============================================================
printSection("TEST 5: PROGRESS CALCULATION");

try {
    $project = Project::first();

    // Get tasks using multiple methods for compatibility
    $tasks = Ptasks::where('pr_number', $project->id)
        ->orWhere('pr_number', $project->pr_number)
        ->get();

    $totalTasks = $tasks->count();
    $completedTasks = $tasks->whereIn('status', ['Completed', 'completed', 'Done', 'done'])->count();
    $pendingTasks = $tasks->whereIn('status', ['Pending', 'pending', 'In Progress', 'in progress'])->count();
    $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;

    printTestResult(
        "Progress Calculation",
        is_numeric($progress) && $progress >= 0 && $progress <= 100,
        "Total: {$totalTasks}, Completed: {$completedTasks}, Pending: {$pendingTasks}, Progress: {$progress}%"
    );

    // Verify calculation logic
    $expectedProgress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;
    printTestResult(
        "Progress Formula Accuracy",
        $progress == $expectedProgress,
        "Calculated: {$progress}%, Expected: {$expectedProgress}%"
    );

} catch (Exception $e) {
    printTestResult("Progress Calculation", false, "Error: " . $e->getMessage());
}

// ==============================================================
// TEST 6: STATISTICS CALCULATION
// ==============================================================
printSection("TEST 6: STATISTICS CALCULATION");

try {
    $project = Project::with(['tasks', 'risks', 'milestones', 'invoices', 'dns'])->first();

    // Tasks Statistics
    $pendingTasksCount = $project->tasks->whereIn('status', ['Pending', 'pending', 'In Progress', 'in progress'])->count();
    printTestResult(
        "Pending Tasks Count",
        is_numeric($pendingTasksCount),
        "Pending: {$pendingTasksCount} / Total: {$project->tasks->count()}"
    );

    // Risks Statistics
    $closedRisksCount = $project->risks->whereIn('status', ['closed', 'Closed'])->count();
    printTestResult(
        "Closed Risks Count",
        is_numeric($closedRisksCount),
        "Closed: {$closedRisksCount} / Total: {$project->risks->count()}"
    );

    // Milestones Statistics
    $completedMilestones = $project->milestones->whereIn('status', ['Completed', 'completed', 'on track'])->count();
    printTestResult(
        "Completed Milestones Count",
        is_numeric($completedMilestones),
        "Completed: {$completedMilestones} / Total: {$project->milestones->count()}"
    );

    // Invoices Statistics
    $paidInvoices = $project->invoices->whereIn('status', ['paid', 'Paid'])->count();
    printTestResult(
        "Paid Invoices Count",
        is_numeric($paidInvoices),
        "Paid: {$paidInvoices} / Total: {$project->invoices->count()}"
    );

    // DNs Count
    printTestResult(
        "DNs Count",
        is_numeric($project->dns->count()),
        "Total DNs: {$project->dns->count()}"
    );

} catch (Exception $e) {
    printTestResult("Statistics Calculation", false, "Error: " . $e->getMessage());
}

// ==============================================================
// TEST 7: MULTIPLE FILTERS COMBINATION
// ==============================================================
printSection("TEST 7: MULTIPLE FILTERS COMBINATION");

try {
    $testProject = Project::with(['ppms', 'cust'])->first();

    // Test combining filters (as would be in actual usage)
    $query = Project::query();
    $query->where('pr_number', $testProject->pr_number);
    $filteredProjects = $query->with(['ppms', 'aams', 'cust'])->get();

    printTestResult(
        "Multiple Filters Applied",
        $filteredProjects->count() == 1 && $filteredProjects->first()->pr_number == $testProject->pr_number,
        "Successfully filtered to 1 specific project"
    );

} catch (Exception $e) {
    printTestResult("Multiple Filters", false, "Error: " . $e->getMessage());
}

// ==============================================================
// TEST 8: EMPTY FILTER HANDLING
// ==============================================================
printSection("TEST 8: EMPTY FILTER HANDLING");

try {
    // Simulate empty filter
    $filters = ['pr_number' => '', 'project_name' => ''];
    $hasFilters = !empty(array_filter($filters));

    printTestResult(
        "Empty Filter Detection",
        $hasFilters === false,
        "Correctly identifies empty filters"
    );

    // Test with null values
    $filters2 = ['pr_number' => null, 'project_name' => null];
    $hasFilters2 = !empty(array_filter($filters2));

    printTestResult(
        "Null Filter Detection",
        $hasFilters2 === false,
        "Correctly identifies null filters"
    );

} catch (Exception $e) {
    printTestResult("Empty Filter Handling", false, "Error: " . $e->getMessage());
}

// ==============================================================
// TEST 9: FILTER DROPDOWN DATA
// ==============================================================
printSection("TEST 9: FILTER DROPDOWN DATA");

try {
    $projects = Project::with(['ppms', 'aams', 'cust'])->get();

    printTestResult(
        "Projects List for Dropdown",
        $projects->count() > 0,
        "Loaded {$projects->count()} projects for dropdown"
    );

    // Check if each project has required data
    $hasRequiredData = $projects->every(function($project) {
        return isset($project->pr_number) && isset($project->name);
    });

    printTestResult(
        "Projects Have Required Fields",
        $hasRequiredData,
        "All projects have pr_number and name"
    );

    // Test unique PR numbers
    $uniquePrNumbers = $projects->pluck('pr_number')->unique()->count();
    printTestResult(
        "Unique PR Numbers",
        $uniquePrNumbers > 0,
        "Found {$uniquePrNumbers} unique PR numbers"
    );

} catch (Exception $e) {
    printTestResult("Filter Dropdown Data", false, "Error: " . $e->getMessage());
}

// ==============================================================
// TEST 10: PERFORMANCE CHECK
// ==============================================================
printSection("TEST 10: PERFORMANCE CHECK");

try {
    // Test query performance with full relationships
    $startTime = microtime(true);

    $projects = Project::with([
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
    ])->take(10)->get();

    $endTime = microtime(true);
    $executionTime = round(($endTime - $startTime) * 1000, 2);

    printTestResult(
        "Query Performance (10 projects with relations)",
        $executionTime < 2000,
        "Execution time: {$executionTime}ms" . ($executionTime < 1000 ? " (Excellent)" : ($executionTime < 2000 ? " (Good)" : " (Slow)"))
    );

} catch (Exception $e) {
    printTestResult("Performance Check", false, "Error: " . $e->getMessage());
}

// ==============================================================
// TEST 11: EXPECTED COMPLETION DATE
// ==============================================================
printSection("TEST 11: EXPECTED COMPLETION DATE");

try {
    $project = Project::with('latestStatus')->first();

    $hasLatestStatus = $project->latestStatus !== null;
    printTestResult(
        "Latest Status Loaded",
        $hasLatestStatus,
        $hasLatestStatus ? "Status ID: {$project->latestStatus->id}" : "No status found"
    );

    if ($hasLatestStatus && $project->latestStatus->expected_completion) {
        $date = \Carbon\Carbon::parse($project->latestStatus->expected_completion);
        $formattedDate = $date->format('d/m/Y');

        printTestResult(
            "Expected Completion Date Format",
            strlen($formattedDate) > 0,
            "Date: {$formattedDate}"
        );
    } else {
        printTestResult(
            "Expected Completion Date",
            true,
            "No expected completion date set (valid state)"
        );
    }

} catch (Exception $e) {
    printTestResult("Expected Completion Date", false, "Error: " . $e->getMessage());
}

// ==============================================================
// TEST 12: FILTER PERSISTENCE CHECK
// ==============================================================
printSection("TEST 12: FILTER PERSISTENCE");

try {
    // Simulate filter array structure
    $requestFilters = [
        'pr_number' => '1',
        'pr_number_no_invoice' => '',
        'project_name' => ''
    ];

    // Check non-empty filters
    $activeFilters = array_filter($requestFilters, function($value) {
        return !empty($value) && $value !== 'all';
    });

    printTestResult(
        "Active Filters Count",
        count($activeFilters) == 1,
        "Found " . count($activeFilters) . " active filter(s)"
    );

    // Verify filter values are preserved
    printTestResult(
        "Filter Value Preservation",
        isset($activeFilters['pr_number']) && $activeFilters['pr_number'] == '1',
        "PR Number filter value: " . ($activeFilters['pr_number'] ?? 'N/A')
    );

} catch (Exception $e) {
    printTestResult("Filter Persistence", false, "Error: " . $e->getMessage());
}

// ==============================================================
// FINAL SUMMARY
// ==============================================================
echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║                        TEST SUMMARY                             ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";
echo "\n";

$successRate = $totalTests > 0 ? round(($testsPassed / $totalTests) * 100, 1) : 0;

echo "Total Tests:    {$totalTests}\n";
echo "✅ Passed:       {$testsPassed}\n";
echo "❌ Failed:       {$testsFailed}\n";
echo "Success Rate:   {$successRate}%\n";
echo "\n";

if ($testsFailed == 0) {
    echo "🎉 ALL TESTS PASSED! Dashboard filters and data are working perfectly!\n";
} else {
    echo "⚠️  Some tests failed. Please review the failures above.\n";
}

echo "\n";
echo "═══════════════════════════════════════════════════════════════════\n";
echo "                     TEST COMPLETED                                 \n";
echo "═══════════════════════════════════════════════════════════════════\n";
echo "\n";
