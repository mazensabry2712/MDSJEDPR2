<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;
use App\Models\invoices;

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║            INVOICES DEBUGGING                                  ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "📊 INVOICES TABLE CHECK:\n";
echo "══════════════════════════════════════════════════════════════════\n";

// Check total invoices
$totalInvoices = invoices::count();
echo "Total Invoices in Database: {$totalInvoices}\n\n";

// Check invoices details
$invoices = invoices::with('project')->get();
if ($invoices->count() > 0) {
    foreach ($invoices as $invoice) {
        echo "Invoice: {$invoice->invoice_number}\n";
        echo "  PR Number (field): {$invoice->pr_number}\n";
        echo "  Value: " . number_format($invoice->value, 2) . " SAR\n";
        echo "  Status: {$invoice->status}\n";

        // Check if project exists
        if ($invoice->project) {
            echo "  ✅ Project Found: {$invoice->project->pr_number} - {$invoice->project->name}\n";
        } else {
            echo "  ❌ Project NOT Found!\n";
        }
        echo "─────────────────────────────────────────────────────────────────\n";
    }
}

echo "\n📋 PROJECTS AND THEIR INVOICES:\n";
echo "══════════════════════════════════════════════════════════════════\n";

$projects = Project::with('invoices')->get();
foreach ($projects as $project) {
    echo "Project: {$project->pr_number} - {$project->name}\n";
    echo "  Project ID: {$project->id}\n";
    echo "  Invoices Count: {$project->invoices->count()}\n";

    if ($project->invoices->count() > 0) {
        foreach ($project->invoices as $inv) {
            echo "    ✅ {$inv->invoice_number} - {$inv->value} SAR\n";
        }
    } else {
        echo "    ❌ No invoices found\n";
    }
    echo "─────────────────────────────────────────────────────────────────\n";
}

echo "\n🔍 RELATIONSHIP CHECK:\n";
echo "══════════════════════════════════════════════════════════════════\n";

// Check the relationship definition
echo "Project Model Relationship (invoices):\n";
$project = Project::first();
if ($project) {
    echo "  Project ID: {$project->id}\n";
    echo "  Project PR Number: {$project->pr_number}\n";

    // Try different relationship queries
    echo "\nTrying different queries:\n";

    // Query 1: Using project->invoices relationship
    $rel1 = $project->invoices()->get();
    echo "  1. Using project->invoices(): {$rel1->count()} invoices\n";

    // Query 2: Direct where on pr_number = id
    $rel2 = invoices::where('pr_number', $project->id)->get();
    echo "  2. Where pr_number = project ID ({$project->id}): {$rel2->count()} invoices\n";

    // Query 3: Direct where on pr_number = pr_number string
    $rel3 = invoices::where('pr_number', $project->pr_number)->get();
    echo "  3. Where pr_number = pr_number string ({$project->pr_number}): {$rel3->count()} invoices\n";
}

echo "\n✅ Debug complete!\n\n";
