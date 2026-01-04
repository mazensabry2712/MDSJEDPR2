<?php

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== MILESTONES SYSTEM DIAGNOSTIC ===\n\n";

// 1. Check Milestones Model
echo "1. Checking Milestones Model...\n";
try {
    $count = App\Models\Milestones::count();
    echo "   ✓ Milestones model loaded successfully\n";
    echo "   ✓ Total Milestone records: $count\n";

    if ($count > 0) {
        $first = App\Models\Milestones::first();
        echo "   ✓ Sample record ID: {$first->id}\n";
        echo "   ✓ Fields: pr_number={$first->pr_number}, milestone={$first->milestone}\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// 2. Check Project Relationship
echo "\n2. Checking Project Relationship...\n";
try {
    $milestone = App\Models\Milestones::with('project')->first();
    if ($milestone) {
        echo "   ✓ Relationship loaded successfully\n";
        if ($milestone->project) {
            echo "   ✓ Project found: {$milestone->project->name}\n";
            echo "   ✓ PR Number: {$milestone->project->pr_number}\n";
        } else {
            echo "   ⚠ Warning: No project linked to this milestone\n";
        }
    } else {
        echo "   ⚠ No milestone records to test relationship\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// 3. Check Controller
echo "\n3. Checking MilestonesController...\n";
try {
    $controller = new App\Http\Controllers\MilestonesController();
    echo "   ✓ Controller instantiated successfully\n";
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// 4. Check Routes
echo "\n4. Checking Routes...\n";
try {
    $routes = Route::getRoutes();
    $milestoneRoutes = [];
    foreach ($routes as $route) {
        if (str_contains($route->getName() ?? '', 'milestones')) {
            $milestoneRoutes[] = $route->getName();
        }
    }
    echo "   ✓ Total Milestone routes: " . count($milestoneRoutes) . "\n";
    foreach ($milestoneRoutes as $routeName) {
        echo "     - $routeName\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// 5. Check Permissions
echo "\n5. Checking Permissions...\n";
try {
    $permissions = Spatie\Permission\Models\Permission::where('name', 'like', '%milestones%')->get();
    echo "   ✓ Milestone Permissions found: " . $permissions->count() . "\n";
    foreach ($permissions as $perm) {
        echo "     - {$perm->name}\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// 6. Check View Files
echo "\n6. Checking View Files...\n";
$viewPath = __DIR__ . '/resources/views/dashboard/Milestones';
if (is_dir($viewPath)) {
    echo "   ✓ Milestones views directory exists\n";
    $files = scandir($viewPath);
    foreach ($files as $file) {
        if (str_ends_with($file, '.blade.php')) {
            echo "     - $file\n";
        }
    }
} else {
    echo "   ✗ Milestones views directory not found\n";
}

// 7. Test Query (like index page)
echo "\n7. Testing Milestones Query (like index page)...\n";
try {
    $milestones = App\Models\Milestones::with(['project:id,pr_number,name'])->get();
    echo "   ✓ Query executed successfully\n";
    echo "   ✓ Records retrieved: {$milestones->count()}\n";

    if ($milestones->count() > 0) {
        $first = $milestones->first();
        echo "   ✓ First record:\n";
        echo "     - ID: {$first->id}\n";
        echo "     - PR Number Field: {$first->pr_number}\n";
        echo "     - Milestone: {$first->milestone}\n";
        echo "     - Planned Completion: {$first->planned_com}\n";
        echo "     - Actual Completion: {$first->actual_com}\n";
        echo "     - Status: {$first->status}\n";
        echo "     - Project: " . ($first->project ? $first->project->name : 'NULL') . "\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    echo "   Stack trace:\n" . $e->getTraceAsString() . "\n";
}

// 8. Check Database Structure
echo "\n8. Checking Database Structure...\n";
try {
    $columns = DB::select("DESCRIBE milestones");
    echo "   ✓ Table 'milestones' structure:\n";
    foreach ($columns as $col) {
        echo "     - {$col->Field} ({$col->Type})\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// 9. Check Cache
echo "\n9. Checking Cache...\n";
try {
    if (Cache::has('milestones_list')) {
        echo "   ⚠ Cache exists - may show old data\n";
        echo "   ℹ Run: php artisan cache:clear\n";
    } else {
        echo "   ✓ No cache found\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== DIAGNOSTIC COMPLETE ===\n";
echo "If everything looks OK here but page is blank on hosting:\n";
echo "1. Clear cache on hosting: php artisan cache:clear\n";
echo "2. Check storage permissions: chmod -R 775 storage\n";
echo "3. Check .env file APP_DEBUG=true temporarily\n";
echo "4. Check hosting error logs\n\n";
echo "Delete this file after checking!\n";
