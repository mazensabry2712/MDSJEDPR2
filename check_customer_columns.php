<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use App\Models\Cust;

echo "=== Customer Table Structure ===\n";
$columns = Schema::getColumnListing('custs');
print_r($columns);

echo "\n=== Sample Customer Data ===\n";
$customer = Cust::first();
if ($customer) {
    print_r($customer->toArray());
} else {
    echo "No customers found\n";
}
