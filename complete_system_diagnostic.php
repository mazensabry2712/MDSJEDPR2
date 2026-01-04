<?php
// Complete System Diagnostic for Hosting
// Upload this file to your hosting root directory and access it via browser

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>System Diagnostic</title>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
.container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
h2 { color: #677EEA; border-bottom: 2px solid #677EEA; padding-bottom: 10px; }
.success { color: #28a745; }
.error { color: #dc3545; }
.warning { color: #ffc107; }
.section { margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 5px; }
pre { background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 5px; overflow-x: auto; }
table { width: 100%; border-collapse: collapse; margin: 10px 0; }
table th, table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
table th { background: #677EEA; color: white; }
.delete-warning { background: #fff3cd; border: 2px solid #ffc107; padding: 20px; margin: 20px 0; border-radius: 8px; text-align: center; font-size: 18px; font-weight: bold; }
</style></head><body><div class='container'>";

echo "<h1 style='text-align: center; color: #677EEA;'>🔍 MDSJEDPR System Diagnostic</h1>";
echo "<p style='text-align: center; color: #666;'>Generated: " . date('Y-m-d H:i:s') . "</p>";

// 1. PHP Environment
echo "<div class='section'><h2>1. PHP Environment</h2>";
echo "<table>";
echo "<tr><th>Property</th><th>Value</th></tr>";
echo "<tr><td>PHP Version</td><td class='success'>" . phpversion() . "</td></tr>";
echo "<tr><td>Server Software</td><td>" . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</td></tr>";
echo "<tr><td>Document Root</td><td>" . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "</td></tr>";
echo "<tr><td>Script Filename</td><td>" . __FILE__ . "</td></tr>";
echo "</table></div>";

// 2. Laravel Bootstrap
echo "<div class='section'><h2>2. Laravel Application</h2>";
if (file_exists(__DIR__.'/vendor/autoload.php')) {
    echo "<p class='success'>✓ Composer autoload found</p>";
    require __DIR__.'/vendor/autoload.php';

    if (file_exists(__DIR__.'/bootstrap/app.php')) {
        echo "<p class='success'>✓ Laravel bootstrap found</p>";
        try {
            $app = require_once __DIR__.'/bootstrap/app.php';
            $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
            $kernel->bootstrap();
            echo "<p class='success'>✓ Laravel loaded successfully</p>";

            // Check environment
            echo "<table>";
            echo "<tr><th>Laravel Config</th><th>Value</th></tr>";
            echo "<tr><td>APP_ENV</td><td>" . config('app.env') . "</td></tr>";
            echo "<tr><td>APP_DEBUG</td><td>" . (config('app.debug') ? 'true' : 'false') . "</td></tr>";
            echo "<tr><td>APP_URL</td><td>" . config('app.url') . "</td></tr>";
            echo "<tr><td>DB_CONNECTION</td><td>" . config('database.default') . "</td></tr>";
            echo "</table>";

        } catch (Exception $e) {
            echo "<p class='error'>✗ Error loading Laravel: " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        }
    } else {
        echo "<p class='error'>✗ bootstrap/app.php not found</p>";
    }
} else {
    echo "<p class='error'>✗ vendor/autoload.php not found - Run: composer install</p>";
}
echo "</div>";

// 3. Directory Permissions
echo "<div class='section'><h2>3. Directory Permissions</h2>";
echo "<table><tr><th>Directory</th><th>Exists</th><th>Permissions</th><th>Writable</th></tr>";
$dirs = ['storage', 'storage/logs', 'storage/framework', 'storage/framework/cache', 'storage/framework/sessions', 'storage/framework/views', 'bootstrap/cache'];
foreach ($dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    $exists = file_exists($path);
    $perms = $exists ? substr(sprintf('%o', fileperms($path)), -4) : 'N/A';
    $writable = $exists && is_writable($path);

    $statusClass = $writable ? 'success' : 'error';
    $statusIcon = $writable ? '✓' : '✗';

    echo "<tr>";
    echo "<td>$dir</td>";
    echo "<td class='$statusClass'>" . ($exists ? 'Yes' : 'No') . "</td>";
    echo "<td>$perms</td>";
    echo "<td class='$statusClass'>$statusIcon " . ($writable ? 'Writable' : 'Not Writable') . "</td>";
    echo "</tr>";
}
echo "</table></div>";

// 4. Required PHP Extensions
echo "<div class='section'><h2>4. PHP Extensions</h2>";
echo "<table><tr><th>Extension</th><th>Status</th></tr>";
$required = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath', 'fileinfo'];
foreach ($required as $ext) {
    $loaded = extension_loaded($ext);
    $class = $loaded ? 'success' : 'error';
    $icon = $loaded ? '✓' : '✗';
    echo "<tr><td>$ext</td><td class='$class'>$icon " . ($loaded ? 'Loaded' : 'Missing') . "</td></tr>";
}
echo "</table></div>";

// 5. Database Connection
echo "<div class='section'><h2>5. Database Connection</h2>";
try {
    $pdo = new PDO(
        'mysql:host=' . config('database.connections.mysql.host') . ';dbname=' . config('database.connections.mysql.database'),
        config('database.connections.mysql.username'),
        config('database.connections.mysql.password')
    );
    echo "<p class='success'>✓ Database connection successful</p>";

    // Check tables
    $tables = ['users', 'projects', 'pepos', 'milestones', 'invoices', 'permissions', 'roles'];
    echo "<table><tr><th>Table</th><th>Records</th></tr>";
    foreach ($tables as $table) {
        try {
            $result = $pdo->query("SELECT COUNT(*) as count FROM $table");
            $count = $result->fetch(PDO::FETCH_ASSOC)['count'];
            echo "<tr><td>$table</td><td class='success'>$count records</td></tr>";
        } catch (Exception $e) {
            echo "<tr><td>$table</td><td class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }
    }
    echo "</table>";
} catch (Exception $e) {
    echo "<p class='error'>✗ Database connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

// 6. Test Critical Models
echo "<div class='section'><h2>6. Models & Relationships Test</h2>";
$modelsToTest = [
    'Pepo' => 'App\\Models\\Pepo',
    'Milestones' => 'App\\Models\\Milestones',
    'Project' => 'App\\Models\\Project',
    'Invoice' => 'App\\Models\\Invoices',
];

echo "<table><tr><th>Model</th><th>Status</th><th>Count</th><th>Relationship</th></tr>";
foreach ($modelsToTest as $name => $class) {
    try {
        $count = $class::count();
        $first = $class::with('project')->first();
        $projectName = $first && $first->project ? $first->project->name : 'N/A';

        echo "<tr>";
        echo "<td>$name</td>";
        echo "<td class='success'>✓ Working</td>";
        echo "<td>$count</td>";
        echo "<td>" . htmlspecialchars($projectName) . "</td>";
        echo "</tr>";
    } catch (Exception $e) {
        echo "<tr>";
        echo "<td>$name</td>";
        echo "<td class='error'>✗ Error</td>";
        echo "<td colspan='2'>" . htmlspecialchars($e->getMessage()) . "</td>";
        echo "</tr>";
    }
}
echo "</table></div>";

// 7. Routes Test
echo "<div class='section'><h2>7. Important Routes</h2>";
echo "<table><tr><th>Route Name</th><th>URL</th><th>Status</th></tr>";
$routesToTest = ['epo.index', 'milestones.index', 'invoices.index', 'customer.index', 'dashboard'];
foreach ($routesToTest as $routeName) {
    try {
        $url = route($routeName);
        echo "<tr><td>$routeName</td><td class='success'><a href='$url' target='_blank'>$url</a></td><td class='success'>✓ Found</td></tr>";
    } catch (Exception $e) {
        echo "<tr><td>$routeName</td><td class='error'>N/A</td><td class='error'>✗ Missing</td></tr>";
    }
}
echo "</table></div>";

// 8. Recent Laravel Logs
echo "<div class='section'><h2>8. Recent Laravel Logs</h2>";
$logFile = __DIR__.'/storage/logs/laravel.log';
if (file_exists($logFile)) {
    $logs = file_get_contents($logFile);
    $lines = explode("\n", $logs);
    $recent = array_slice($lines, -50);
    echo "<p class='success'>✓ Log file found - Last 50 lines:</p>";
    echo "<pre>" . htmlspecialchars(implode("\n", $recent)) . "</pre>";
} else {
    echo "<p class='warning'>⚠ No log file found at: $logFile</p>";
}
echo "</div>";

// 9. Cache Status
echo "<div class='section'><h2>9. Cache Status</h2>";
try {
    if (Cache::has('milestones_list')) {
        echo "<p class='warning'>⚠ Milestones cache exists (may cause issues)</p>";
    } else {
        echo "<p class='success'>✓ No milestones cache</p>";
    }

    echo "<p><strong>To clear all caches, run these commands:</strong></p>";
    echo "<pre>php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear</pre>";
} catch (Exception $e) {
    echo "<p class='error'>Error checking cache: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

// 10. Permissions Test
echo "<div class='section'><h2>10. Permissions System</h2>";
try {
    $permissions = Spatie\Permission\Models\Permission::all();
    $roles = Spatie\Permission\Models\Role::all();

    echo "<p class='success'>✓ Total Permissions: {$permissions->count()}</p>";
    echo "<p class='success'>✓ Total Roles: {$roles->count()}</p>";

    $ownerRole = Spatie\Permission\Models\Role::where('name', 'owner')->first();
    if ($ownerRole) {
        $ownerPermissions = $ownerRole->permissions->pluck('name')->toArray();
        echo "<p class='success'>✓ Owner role has " . count($ownerPermissions) . " permissions</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

// Delete Warning
echo "<div class='delete-warning'>";
echo "⚠️ IMPORTANT: DELETE THIS FILE IMMEDIATELY AFTER CHECKING! ⚠️<br>";
echo "This file exposes sensitive system information.<br>";
echo "File to delete: " . basename(__FILE__);
echo "</div>";

echo "</div></body></html>";
?>
