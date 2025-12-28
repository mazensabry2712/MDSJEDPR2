<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\aams;

echo "تنظيف بيانات الاختبار المؤقتة...\n";

// حذف AMs المؤقتة
$deleted = aams::where('email', 'test@example.com')
    ->orWhere('name', 'like', 'Test Manager%')
    ->orWhere('name', 'like', '%script%')
    ->delete();

echo "✅ تم حذف {$deleted} سجل مؤقت\n";
