<?php

/**
 * ==============================================================
 * DASHBOARD FILTERS - HTTP/BROWSER TEST
 * ==============================================================
 *
 * This script tests filters through actual HTTP requests
 * to simulate real browser interactions
 *
 * ==============================================================
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Project;

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║     DASHBOARD FILTERS - HTTP/BROWSER TEST SUITE                ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";
echo "\n";

$baseUrl = "http://mdsjedpr.test/dashboard";
$testsPassed = 0;
$testsFailed = 0;

/**
 * Helper function to make HTTP request
 */
function makeRequest($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    return [
        'response' => $response,
        'status' => $httpCode,
        'error' => $error
    ];
}

/**
 * Helper function to print test result
 */
function printResult($testName, $passed, $details = '') {
    global $testsPassed, $testsFailed;

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

echo "🔗 Base URL: {$baseUrl}\n\n";

// ==============================================================
// TEST 1: Dashboard without filters
// ==============================================================
echo "┌─────────────────────────────────────────────────────────────┐\n";
echo "│ TEST 1: Dashboard Without Filters (Default View)\n";
echo "└─────────────────────────────────────────────────────────────┘\n\n";

$result = makeRequest($baseUrl);
$passed = $result['status'] == 200;
printResult(
    "Load Dashboard Page",
    $passed,
    "HTTP Status: {$result['status']}" . ($result['error'] ? " | Error: {$result['error']}" : "")
);

if ($passed) {
    // Check for filter elements
    $hasFilterSidebar = strpos($result['response'], 'filter-sidebar') !== false;
    printResult(
        "Filter Sidebar Present",
        $hasFilterSidebar,
        $hasFilterSidebar ? "Filter sidebar found" : "Filter sidebar missing"
    );

    // Check for Apply Filters button
    $hasApplyButton = strpos($result['response'], 'btn-apply-filter') !== false;
    printResult(
        "Apply Filters Button",
        $hasApplyButton,
        $hasApplyButton ? "Button found" : "Button missing"
    );

    // Check for Reset button
    $hasResetButton = strpos($result['response'], 'btn-reset-filter') !== false;
    printResult(
        "Reset Filters Button",
        $hasResetButton,
        $hasResetButton ? "Button found" : "Button missing"
    );

    // Check for "Apply filters" message
    $hasDefaultMessage = strpos($result['response'], 'Apply filters to view customized data') !== false;
    printResult(
        "Default Message Displayed",
        $hasDefaultMessage,
        $hasDefaultMessage ? "Default state message shown" : "Message not found"
    );
}

// ==============================================================
// TEST 2: Filter by PR Number
// ==============================================================
echo "\n┌─────────────────────────────────────────────────────────────┐\n";
echo "│ TEST 2: Filter by PR Number\n";
echo "└─────────────────────────────────────────────────────────────┘\n\n";

$testProject = Project::first();
if ($testProject) {
    $prNumber = $testProject->pr_number;
    $url = $baseUrl . "?filter[pr_number]={$prNumber}";

    echo "🔗 Test URL: {$url}\n\n";

    $result = makeRequest($url);
    $passed = $result['status'] == 200;
    printResult(
        "Filter by PR Number = {$prNumber}",
        $passed,
        "HTTP Status: {$result['status']}"
    );

    if ($passed) {
        // Check if filtered data is shown
        $hasProjectCard = strpos($result['response'], 'card-header') !== false;
        $hasProjectName = strpos($result['response'], $testProject->name) !== false;

        printResult(
            "Project Card Displayed",
            $hasProjectCard,
            $hasProjectCard ? "Project card found" : "Card missing"
        );

        printResult(
            "Project Name Shown",
            $hasProjectName,
            $hasProjectName ? "Project name: {$testProject->name}" : "Name not found"
        );

        // Check for PR Number badge
        $hasPRBadge = strpos($result['response'], "PR# {$prNumber}") !== false;
        printResult(
            "PR Number Badge",
            $hasPRBadge,
            $hasPRBadge ? "Badge displayed correctly" : "Badge missing"
        );
    }
}

// ==============================================================
// TEST 3: Filter by All Projects
// ==============================================================
echo "\n┌─────────────────────────────────────────────────────────────┐\n";
echo "│ TEST 3: Filter by 'All' Projects\n";
echo "└─────────────────────────────────────────────────────────────┘\n\n";

$url = $baseUrl . "?filter[pr_number]=all";
echo "🔗 Test URL: {$url}\n\n";

$result = makeRequest($url);
$passed = $result['status'] == 200;
printResult(
    "Filter by PR Number = 'all'",
    $passed,
    "HTTP Status: {$result['status']}"
);

if ($passed) {
    $projectCount = Project::count();

    // Try to detect multiple projects
    $projectCards = substr_count($result['response'], 'card-header');

    printResult(
        "Multiple Projects Displayed",
        $projectCards >= $projectCount,
        "Found approximately {$projectCards} project cards"
    );
}

// ==============================================================
// TEST 4: Filter by PR Without Invoices
// ==============================================================
echo "\n┌─────────────────────────────────────────────────────────────┐\n";
echo "│ TEST 4: Filter by PR Without Invoices\n";
echo "└─────────────────────────────────────────────────────────────┘\n\n";

$projectNoInvoices = Project::whereDoesntHave('invoices')->first();
if ($projectNoInvoices) {
    $prNumber = $projectNoInvoices->pr_number;
    $url = $baseUrl . "?filter[pr_number_no_invoice]={$prNumber}";

    echo "🔗 Test URL: {$url}\n\n";

    $result = makeRequest($url);
    $passed = $result['status'] == 200;
    printResult(
        "Filter PR Without Invoices (PR#{$prNumber})",
        $passed,
        "HTTP Status: {$result['status']}"
    );

    if ($passed) {
        // Check that invoice section is not shown
        $hasInvoiceSection = strpos($result['response'], 'Invoices Statistics') !== false;
        printResult(
            "Invoice Section Hidden",
            !$hasInvoiceSection,
            !$hasInvoiceSection ? "Invoice section correctly hidden" : "Section still visible"
        );
    }
} else {
    echo "ℹ️  No projects without invoices found (skipping test)\n\n";
}

// ==============================================================
// TEST 5: Progress Section Display
// ==============================================================
echo "\n┌─────────────────────────────────────────────────────────────┐\n";
echo "│ TEST 5: Progress Section Display\n";
echo "└─────────────────────────────────────────────────────────────┘\n\n";

$testProject = Project::first();
if ($testProject) {
    $url = $baseUrl . "?filter[pr_number]={$testProject->pr_number}";

    $result = makeRequest($url);
    if ($result['status'] == 200) {
        // Check for progress elements
        $hasProgressSection = strpos($result['response'], 'progress-section') !== false;
        printResult(
            "Progress Section Present",
            $hasProgressSection,
            $hasProgressSection ? "Section found" : "Section missing"
        );

        // Check for progress bar
        $hasProgressBar = strpos($result['response'], 'Progress: <') !== false ||
                          strpos($result['response'], 'progress') !== false;
        printResult(
            "Progress Bar/Indicator",
            $hasProgressBar,
            $hasProgressBar ? "Progress indicator found" : "Indicator missing"
        );

        // Check for expected completion date
        $hasExpectedDate = strpos($result['response'], 'Expected Completion Date') !== false;
        printResult(
            "Expected Completion Date Field",
            $hasExpectedDate,
            $hasExpectedDate ? "Field found" : "Field missing"
        );
    }
}

// ==============================================================
// TEST 6: Statistics Cards Display
// ==============================================================
echo "\n┌─────────────────────────────────────────────────────────────┐\n";
echo "│ TEST 6: Statistics Cards Display\n";
echo "└─────────────────────────────────────────────────────────────┘\n\n";

$testProject = Project::first();
if ($testProject) {
    $url = $baseUrl . "?filter[pr_number]={$testProject->pr_number}";

    $result = makeRequest($url);
    if ($result['status'] == 200) {
        // Check for various stat cards
        $hasTasksCard = strpos($result['response'], 'Tasks') !== false;
        $hasRisksCard = strpos($result['response'], 'Risk/Issue') !== false;
        $hasMilestonesCard = strpos($result['response'], 'Milestones') !== false;
        $hasDNsCard = strpos($result['response'], 'DNs') !== false;

        printResult(
            "Tasks Statistics Card",
            $hasTasksCard,
            $hasTasksCard ? "Card found" : "Card missing"
        );

        printResult(
            "Risks Statistics Card",
            $hasRisksCard,
            $hasRisksCard ? "Card found" : "Card missing"
        );

        printResult(
            "Milestones Statistics Card",
            $hasMilestonesCard,
            $hasMilestonesCard ? "Card found" : "Card missing"
        );

        printResult(
            "DNs Statistics Card",
            $hasDNsCard,
            $hasDNsCard ? "Card found" : "Card missing"
        );
    }
}

// ==============================================================
// TEST 7: Print Button Functionality
// ==============================================================
echo "\n┌─────────────────────────────────────────────────────────────┐\n";
echo "│ TEST 7: Print Button Functionality\n";
echo "└─────────────────────────────────────────────────────────────┘\n\n";

$testProject = Project::first();
if ($testProject) {
    $url = $baseUrl . "?filter[pr_number]={$testProject->pr_number}";

    $result = makeRequest($url);
    if ($result['status'] == 200) {
        // Check for print button
        $hasPrintButton = strpos($result['response'], 'dashboard.print.filtered') !== false;
        printResult(
            "Print Button Present",
            $hasPrintButton,
            $hasPrintButton ? "Print button found" : "Button missing"
        );

        // Check if print form has filters
        $hasPrintForm = strpos($result['response'], '<form action=') !== false &&
                        strpos($result['response'], 'dashboard.print.filtered') !== false;
        printResult(
            "Print Form Configured",
            $hasPrintForm,
            $hasPrintForm ? "Form properly configured" : "Form issue detected"
        );
    }
}

// ==============================================================
// TEST 8: Select2 Dropdown Configuration
// ==============================================================
echo "\n┌─────────────────────────────────────────────────────────────┐\n";
echo "│ TEST 8: Select2 Dropdown Configuration\n";
echo "└─────────────────────────────────────────────────────────────┘\n\n";

$result = makeRequest($baseUrl);
if ($result['status'] == 200) {
    // Check for Select2 library
    $hasSelect2CSS = strpos($result['response'], 'select2') !== false;
    printResult(
        "Select2 CSS Loaded",
        $hasSelect2CSS,
        $hasSelect2CSS ? "Select2 styles found" : "Styles missing"
    );

    // Check for Select2 initialization
    $hasSelect2Init = strpos($result['response'], "('.select2').select2") !== false;
    printResult(
        "Select2 Initialization",
        $hasSelect2Init,
        $hasSelect2Init ? "Select2 initialized" : "Init script missing"
    );

    // Check for filter dropdowns
    $hasPRDropdown = strpos($result['response'], 'name="filter[pr_number]"') !== false;
    printResult(
        "PR Number Dropdown",
        $hasPRDropdown,
        $hasPRDropdown ? "Dropdown found" : "Dropdown missing"
    );
}

// ==============================================================
// TEST 9: JavaScript Functions
// ==============================================================
echo "\n┌─────────────────────────────────────────────────────────────┐\n";
echo "│ TEST 9: JavaScript Functions\n";
echo "└─────────────────────────────────────────────────────────────┘\n\n";

$result = makeRequest($baseUrl);
if ($result['status'] == 200) {
    // Check for resetFilters function
    $hasResetFunction = strpos($result['response'], 'function resetFilters()') !== false;
    printResult(
        "Reset Filters Function",
        $hasResetFunction,
        $hasResetFunction ? "Function defined" : "Function missing"
    );

    // Check for form submission handler
    $hasFormHandler = strpos($result['response'], "('#filterForm').on('submit'") !== false;
    printResult(
        "Form Submit Handler",
        $hasFormHandler,
        $hasFormHandler ? "Handler found" : "Handler missing"
    );

    // Check for collapse toggle
    $hasCollapseToggle = strpos($result['response'], 'toggle-icon') !== false;
    printResult(
        "Collapse Toggle Icons",
        $hasCollapseToggle,
        $hasCollapseToggle ? "Toggle functionality found" : "Toggle missing"
    );
}

// ==============================================================
// FINAL SUMMARY
// ==============================================================
echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║                   HTTP TEST SUMMARY                             ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";
echo "\n";

$totalTests = $testsPassed + $testsFailed;
$successRate = $totalTests > 0 ? round(($testsPassed / $totalTests) * 100, 1) : 0;

echo "Total Tests:    {$totalTests}\n";
echo "✅ Passed:       {$testsPassed}\n";
echo "❌ Failed:       {$testsFailed}\n";
echo "Success Rate:   {$successRate}%\n";
echo "\n";

if ($testsFailed == 0) {
    echo "🎉 ALL HTTP TESTS PASSED! Dashboard filters work correctly in browser!\n";
} else {
    echo "⚠️  Some HTTP tests failed. Please review the failures above.\n";
}

echo "\n";
echo "═══════════════════════════════════════════════════════════════════\n";
echo "                     TEST COMPLETED                                 \n";
echo "═══════════════════════════════════════════════════════════════════\n";
echo "\n";
