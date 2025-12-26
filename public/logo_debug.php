<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Logo Debug</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .test-box { background: white; padding: 20px; margin: 10px 0; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .success { border-left: 4px solid #28a745; }
        .error { border-left: 4px solid #dc3545; }
        img { border: 3px solid #007bff; padding: 10px; background: white; }
    </style>
</head>
<body>
    <h1>🔍 Logo Debug Dashboard</h1>

    <?php
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

    use App\Models\Project;
    use App\Models\Cust;

    // Test 1: Check Customer
    echo '<div class="test-box">';
    echo '<h2>✅ Test 1: Customer Data</h2>';
    $customer = Cust::first();
    if ($customer) {
        echo "<p><strong>Customer ID:</strong> {$customer->id}</p>";
        echo "<p><strong>Name:</strong> {$customer->name}</p>";
        echo "<p><strong>Logo in DB:</strong> {$customer->logo}</p>";
        $logoPath = public_path($customer->logo);
        echo "<p><strong>Full Path:</strong> {$logoPath}</p>";
        echo "<p><strong>File Exists:</strong> " . (file_exists($logoPath) ? '✅ YES' : '❌ NO') . "</p>";
    }
    echo '</div>';

    // Test 2: Check Projects
    echo '<div class="test-box">';
    echo '<h2>✅ Test 2: Projects with Customer Relationship</h2>';
    $projects = Project::with('cust')->get();
    foreach ($projects as $project) {
        echo "<div style='margin: 10px 0; padding: 10px; background: #f8f9fa; border-radius: 5px;'>";
        echo "<strong>{$project->pr_number}</strong> - {$project->name}<br>";
        echo "cust_id: {$project->cust_id}<br>";

        if ($project->cust) {
            echo "✅ Customer: {$project->cust->name}<br>";
            echo "Logo: {$project->cust->logo}<br>";
        } else {
            echo "❌ No customer relationship<br>";
        }
        echo "</div>";
    }
    echo '</div>';

    // Test 3: Display Logo
    echo '<div class="test-box">';
    echo '<h2>✅ Test 3: Logo Display</h2>';
    if ($customer && $customer->logo) {
        $logoUrl = '/' . $customer->logo;
        echo "<p><strong>Logo URL:</strong> {$logoUrl}</p>";
        echo "<img src='{$logoUrl}' alt='Logo' width='150' onload=\"this.style.borderColor='green'; this.nextElementSibling.innerHTML='✅ Logo loaded successfully!'\" onerror=\"this.style.borderColor='red'; this.nextElementSibling.innerHTML='❌ Logo failed to load'\"><br>";
        echo "<p id='status' style='font-weight: bold;'>⏳ Loading...</p>";
    }
    echo '</div>';

    // Test 4: Simulate Dashboard Code
    echo '<div class="test-box">';
    echo '<h2>✅ Test 4: Dashboard Simulation</h2>';
    $project = Project::with('cust')->where('pr_number', 'PR003')->first();
    if ($project) {
        echo "<p><strong>Project:</strong> {$project->name}</p>";
        echo "<p><strong>\$project->cust exists:</strong> " . ($project->cust ? 'YES' : 'NO') . "</p>";
        echo "<p><strong>\$project->cust->logo exists:</strong> " . ($project->cust && $project->cust->logo ? 'YES' : 'NO') . "</p>";

        if ($project->cust && $project->cust->logo) {
            echo "<p><strong>Blade Code Would Show:</strong></p>";
            echo "<div style='background: #e9ecef; padding: 15px; border-radius: 5px; font-family: monospace;'>";
            echo "src=\"/{$project->cust->logo}\"<br>";
            echo "Result: <img src='/{$project->cust->logo}' width='100' style='margin-top: 10px;' onload=\"this.nextElementSibling.innerHTML='✅ Works!'\" onerror=\"this.nextElementSibling.innerHTML='❌ Failed!'\"><br>";
            echo "<span style='font-weight: bold;'>⏳ Loading...</span>";
            echo "</div>";
        }
    }
    echo '</div>';

    // Test 5: Browser Console Code
    echo '<div class="test-box">';
    echo '<h2>✅ Test 5: Browser Network Check</h2>';
    echo '<p>Open DevTools (F12) → Network tab → Reload page</p>';
    echo '<p>Look for requests to <code>/storge/neom_logo.png</code></p>';
    echo '<p>Check if it returns 200 (success) or 404 (not found)</p>';
    echo '</div>';
    ?>

    <script>
        console.log('Logo Debug Page Loaded');
        console.log('Check Network tab for logo requests');
    </script>
</body>
</html>
