<!DOCTYPE html>
<html>
<head>
    <title>Test Invoices Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }
        .project-card {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stat-card {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin: 10px 0;
        }
        .invoice-item {
            padding: 6px 0;
            margin-bottom: 4px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <h1>Testing Invoices Display</h1>

<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;

$query = Project::query();
$filteredProjects = $query->with([
    'ppms:id,name',
    'aams:id,name',
    'cust:id,name',
    'invoices' => function($q) {
        $q->select('id', 'pr_number', 'invoice_number', 'value', 'status');
    }
])->get();

foreach ($filteredProjects as $project) {
    echo '<div class="project-card">';
    echo '<h2>' . $project->pr_number . ' - ' . $project->name . '</h2>';
    echo '<p>Customer: ' . ($project->cust->name ?? 'N/A') . '</p>';

    echo '<div class="stat-card">';
    echo '<small style="opacity: 0.9; font-weight: 600; font-size: 12px;">Invoices</small>';
    echo '<div style="font-size: 13px; line-height: 1.6; margin-top: 10px;">';

    if ($project->invoices->count() > 0) {
        foreach ($project->invoices as $invoice) {
            echo '<div class="invoice-item">';
            echo '<span style="font-weight: 600;">' . $invoice->invoice_number . '</span>';
            echo '<span style="background: rgba(255,255,255,0.3); padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;">' . number_format($invoice->value, 0) . ' SAR</span>';
            echo '</div>';
        }
    } else {
        echo '<div style="opacity: 0.7; padding: 10px 0;">No invoices</div>';
    }

    $paidCount = $project->invoices->whereIn('status', ['paid', 'Paid'])->count();
    $totalCount = $project->invoices->count();
    echo '<small style="opacity: 0.85; display: block; margin-top: 10px; font-weight: 600;">' . $paidCount . '/' . $totalCount . ' Paid</small>';

    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>

</body>
</html>
