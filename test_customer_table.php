<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Cust;

echo "========================================\n";
echo "🧪 CUSTOMER TABLE LOGO TEST\n";
echo "========================================\n\n";

$customers = Cust::all();

echo "Total Customers: {$customers->count()}\n\n";

foreach ($customers as $index => $cust) {
    echo "Customer #" . ($index + 1) . "\n";
    echo "-------------------\n";
    echo "ID: {$cust->id}\n";
    echo "Name: {$cust->name}\n";
    echo "Logo field value: " . ($cust->logo ?? 'NULL') . "\n";

    if ($cust->logo) {
        $logoPath = public_path($cust->logo);
        echo "Full path: {$logoPath}\n";
        echo "File exists: " . (file_exists($logoPath) ? '✅ YES' : '❌ NO') . "\n";

        if (file_exists($logoPath)) {
            echo "File size: " . filesize($logoPath) . " bytes\n";
            echo "URL would be: /{$cust->logo}\n";

            // Test if we can read the file
            $imageInfo = @getimagesize($logoPath);
            if ($imageInfo) {
                echo "Image type: {$imageInfo['mime']}\n";
                echo "Dimensions: {$imageInfo[0]}x{$imageInfo[1]}\n";
                echo "✅ Image is valid and readable\n";
            } else {
                echo "❌ File exists but may not be a valid image\n";
            }
        }

        // Check if accessible via HTTP
        $url = "http://mdsjedpr.test/{$cust->logo}";
        echo "Testing HTTP access: {$url}\n";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        echo "HTTP Status: {$httpCode} " . ($httpCode == 200 ? '✅ OK' : '❌ FAILED') . "\n";
    } else {
        echo "❌ No logo field value\n";
    }

    echo "\n";
}

echo "========================================\n";
echo "📋 BLADE CONDITION SIMULATION\n";
echo "========================================\n\n";

foreach ($customers as $cust) {
    echo "{$cust->name}:\n";
    echo "  if(\$cust->logo): " . ($cust->logo ? 'TRUE ✅' : 'FALSE ❌') . "\n";
    echo "  Would display: " . ($cust->logo ? "IMAGE" : "ICON") . "\n\n";
}

echo "========================================\n";
echo "✅ TEST COMPLETE\n";
echo "========================================\n";
