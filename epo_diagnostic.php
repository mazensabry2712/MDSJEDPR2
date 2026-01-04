<?php

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== EPO SYSTEM DIAGNOSTIC ===\n\n";

// 1. Check Pepo Model
echo "1. Checking Pepo Model...\n";
try {
    $pepoCount = App\Models\Pepo::count();
    echo "   ✓ Pepo model loaded successfully\n";
    echo "   ✓ Total EPO records: $pepoCount\n";

    if ($pepoCount > 0) {
        $firstPepo = App\Models\Pepo::first();
        echo "   ✓ Sample record ID: {$firstPepo->id}\n";
        echo "   ✓ Fields: pr_number={$firstPepo->pr_number}, category={$firstPepo->category}\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// 2. Check Project Relationship
echo "\n2. Checking Project Relationship...\n";
try {
    $pepoWithProject = App\Models\Pepo::with('project')->first();
    if ($pepoWithProject) {
        echo "   ✓ Relationship loaded successfully\n";
        if ($pepoWithProject->project) {
            echo "   ✓ Project found: {$pepoWithProject->project->name}\n";
            echo "   ✓ PR Number: {$pepoWithProject->project->pr_number}\n";
        } else {
            echo "   ⚠ Warning: No project linked to this EPO\n";
        }
    } else {
        echo "   ⚠ No EPO records to test relationship\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// 3. Check Controller
echo "\n3. Checking PepoController...\n";
try {
    $controller = new App\Http\Controllers\PepoController();
    echo "   ✓ Controller instantiated successfully\n";
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// 4. Check Routes
echo "\n4. Checking Routes...\n";
try {
    $routes = Route::getRoutes();
    $epoRoutes = [];
    foreach ($routes as $route) {
        if (str_contains($route->getName() ?? '', 'epo')) {
            $epoRoutes[] = $route->getName();
        }
    }
    echo "   ✓ Total EPO routes: " . count($epoRoutes) . "\n";
    foreach ($epoRoutes as $routeName) {
        echo "     - $routeName\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// 5. Check Permissions
echo "\n5. Checking Permissions...\n";
try {
    $epoPermissions = Spatie\Permission\Models\Permission::where('name', 'like', '%epo%')->get();
    echo "   ✓ EPO Permissions found: " . $epoPermissions->count() . "\n";
    foreach ($epoPermissions as $perm) {
        echo "     - {$perm->name}\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// 6. Check View Files
echo "\n6. Checking View Files...\n";
$viewPath = __DIR__ . '/resources/views/dashboard/PEPO';
if (is_dir($viewPath)) {
    echo "   ✓ PEPO views directory exists\n";
    $files = scandir($viewPath);
    foreach ($files as $file) {
        if (str_ends_with($file, '.blade.php')) {
            echo "     - $file\n";
        }
    }
} else {
    echo "   ✗ PEPO views directory not found\n";
}

// 7. Test Query
echo "\n7. Testing EPO Query (like index page)...\n";
try {
    $pepo = App\Models\Pepo::with(['project:id,pr_number,name'])->latest()->get();
    echo "   ✓ Query executed successfully\n";
    echo "   ✓ Records retrieved: {$pepo->count()}\n";

    if ($pepo->count() > 0) {
        $first = $pepo->first();
        echo "   ✓ First record:\n";
        echo "     - ID: {$first->id}\n";
        echo "     - PR Number Field: {$first->pr_number}\n";
        echo "     - Category: {$first->category}\n";
        echo "     - Planned Cost: {$first->planned_cost}\n";
        echo "     - Selling Price: {$first->selling_price}\n";
        echo "     - Project: " . ($first->project ? $first->project->name : 'NULL') . "\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    echo "   Stack trace:\n" . $e->getTraceAsString() . "\n";
}

// 8. Check Database Structure
echo "\n8. Checking Database Structure...\n";
try {
    $columns = DB::select("DESCRIBE pepos");
    echo "   ✓ Table 'pepos' structure:\n";
    foreach ($columns as $col) {
        echo "     - {$col->Field} ({$col->Type})\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== DIAGNOSTIC COMPLETE ===\n";
echo "Delete this file after checking!\n";
