<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║            CHECK PSTATUSES TABLE STRUCTURE                     ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Get table columns
$columns = DB::select("DESCRIBE pstatuses");

echo "📋 PSTATUSES TABLE COLUMNS:\n";
echo "══════════════════════════════════════════════════════════════════\n";

foreach ($columns as $column) {
    echo "• {$column->Field}\n";
    echo "  Type: {$column->Type}\n";
    echo "  Null: {$column->Null}\n";
    echo "  Key: {$column->Key}\n";
    echo "  Default: " . ($column->Default ?? 'NULL') . "\n";
    echo "─────────────────────────────────────────────────────────────────\n";
}

// Check existing records
$records = DB::table('pstatuses')->get();
echo "\n📊 EXISTING RECORDS: " . $records->count() . "\n";
if ($records->count() > 0) {
    echo "══════════════════════════════════════════════════════════════════\n";
    foreach ($records as $record) {
        echo "PR Number: {$record->pr_number}\n";
        echo "Status: " . ($record->status ?? 'N/A') . "\n";
        if (property_exists($record, 'expected_completion')) {
            echo "Expected: {$record->expected_completion}\n";
        }
        echo "─────────────────────────────────────────────────────────────────\n";
    }
}

echo "\n✅ Structure check complete!\n\n";
