<!DOCTYPE html>
<html>
<head>
    <title>Invoice Display Test</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }
        .stat-card {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
            margin-bottom: 20px;
            max-width: 400px;
        }
        .invoice-item {
            padding: 6px 0;
            margin-bottom: 4px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }
        .invoice-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
        }
        .invoice-number {
            font-weight: 600;
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .invoice-value {
            background: rgba(255,255,255,0.3);
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            flex-shrink: 0;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <h1>Testing Invoice Display from Database</h1>

<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;

$projects = Project::with(['invoices' => function($q) {
    $q->select('id', 'pr_number', 'invoice_number', 'value', 'status');
}])->get();

foreach ($projects as $project) {
    echo '<h2>Project: ' . $project->pr_number . ' - ' . $project->name . '</h2>';

    echo '<div class="stat-card">';
    echo '<small style="opacity: 0.9; font-weight: 600; font-size: 12px;">Invoices</small>';
    echo '<div style="font-size: 13px; line-height: 1.6; max-height: 100px; overflow-y: auto; margin-top: 10px;">';

    if ($project->invoices->count() > 0) {
        foreach ($project->invoices as $invoice) {
            echo '<div class="invoice-item">';
            echo '<div class="invoice-content">';
            echo '<span class="invoice-number">' . ($invoice->invoice_number ?? 'N/A') . '</span>';
            echo '<i class="fas fa-long-arrow-alt-right" style="font-size: 11px; opacity: 0.7; flex-shrink: 0;"></i>';
            echo '<span class="invoice-value">' . number_format($invoice->value ?? 0, 0) . ' SAR</span>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div style="opacity: 0.7; padding: 10px 0;">No invoices</div>';
    }

    echo '</div>';

    $paidCount = $project->invoices->whereIn('status', ['paid', 'Paid'])->count();
    $totalCount = $project->invoices->count();
    echo '<small style="opacity: 0.85; display: block; margin-top: 10px; font-weight: 600;">' . $paidCount . '/' . $totalCount . ' Paid</small>';
    echo '</div>';
}
?>

<hr>
<h2>Direct Query Test:</h2>
<?php
use App\Models\invoices;

$allInvoices = invoices::with('project')->get();
echo '<p>Total invoices in database: ' . $allInvoices->count() . '</p>';

foreach ($allInvoices as $inv) {
    echo '<div style="padding: 10px; background: white; margin: 5px 0; border-radius: 5px;">';
    echo '<strong>' . $inv->invoice_number . '</strong><br>';
    echo 'PR Number (field): ' . $inv->pr_number . '<br>';
    echo 'Value: ' . number_format($inv->value, 2) . ' SAR<br>';
    echo 'Status: ' . $inv->status . '<br>';
    if ($inv->project) {
        echo 'Project: ' . $inv->project->pr_number . ' - ' . $inv->project->name;
    } else {
        echo '<span style="color: red;">⚠️ Project not found!</span>';
    }
    echo '</div>';
}
?>

</body>
</html>
