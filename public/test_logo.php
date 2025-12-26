<!DOCTYPE html>
<html>
<head>
    <title>Logo Test</title>
</head>
<body>
    <h2>Testing Customer Logo Display</h2>

    <?php
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

    use App\Models\Cust;

    $customer = Cust::first();

    if ($customer) {
        echo "<h3>Customer: {$customer->name}</h3>";
        echo "<p>Logo path in DB: {$customer->logo}</p>";

        $logoPath = $customer->logo;
        $pathParts = explode('/', $logoPath);
        $filename = array_pop($pathParts);
        $encodedFilename = rawurlencode($filename);
        $encodedPath = implode('/', $pathParts) . '/' . $encodedFilename;

        echo "<p>Encoded path: {$encodedPath}</p>";
        echo "<p>Asset URL: " . asset($encodedPath) . "</p>";
        echo "<p>Full path: " . public_path($logoPath) . "</p>";
        echo "<p>File exists: " . (file_exists(public_path($logoPath)) ? 'YES' : 'NO') . "</p>";

        echo "<hr>";
        echo "<h4>Test 1: Direct path (no encoding)</h4>";
        echo "<img src='/{$customer->logo}' style='width: 100px; border: 2px solid red;' onerror=\"this.parentElement.innerHTML += '<br>ERROR: Image failed to load'\">";

        echo "<hr>";
        echo "<h4>Test 2: Asset helper (no encoding)</h4>";
        echo "<img src='" . asset($customer->logo) . "' style='width: 100px; border: 2px solid blue;' onerror=\"this.parentElement.innerHTML += '<br>ERROR: Image failed to load'\">";

        echo "<hr>";
        echo "<h4>Test 3: Encoded path</h4>";
        echo "<img src='" . asset($encodedPath) . "' style='width: 100px; border: 2px solid green;' onerror=\"this.parentElement.innerHTML += '<br>ERROR: Image failed to load'\">";

        echo "<hr>";
        echo "<h4>Test 4: Check actual files in storge folder</h4>";
        $files = glob(public_path('storge/*'));
        echo "<ul>";
        foreach($files as $file) {
            echo "<li>" . basename($file) . "</li>";
        }
        echo "</ul>";
    }
    ?>
</body>
</html>
