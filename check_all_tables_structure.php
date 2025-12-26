<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║        CHECK ALL RELATED TABLES STRUCTURE                      ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

$tables = [
    'risks' => 'Risks',
    'milestones' => 'Milestones',
    'invoices' => 'Invoices',
    'dns' => 'DNs (Delivery Notes)'
];

foreach ($tables as $table => $name) {
    echo "📋 {$name} ({$table}) TABLE COLUMNS:\n";
    echo "══════════════════════════════════════════════════════════════════\n";

    try {
        $columns = DB::select("DESCRIBE {$table}");

        foreach ($columns as $column) {
            echo "• {$column->Field} ({$column->Type})\n";
        }

        // Check existing records
        $count = DB::table($table)->count();
        echo "\n📊 Existing Records: {$count}\n";

    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }

    echo "\n";
}

echo "✅ Structure check complete!\n\n";
