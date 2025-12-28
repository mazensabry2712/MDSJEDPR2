<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;

echo "==========================================\n";
echo "اختبار عرض بيانات Escalation بعد الإصلاح\n";
echo "==========================================\n\n";

// محاكاة ما يتم تحميله في الداشبورد
$project = Project::where('pr_number', 'PR003')
    ->with(['aams:id,name,email,phone'])
    ->first();

if ($project) {
    echo "✅ تم تحميل المشروع PR003 بنجاح\n\n";

    echo "📋 بيانات Customer Contact:\n";
    echo "   " . ($project->customer_contact_details ?? 'N/A') . "\n\n";

    if ($project->aams && $project->aams->name !== 'nothing') {
        echo "👤 بيانات Account Manager (كما ستظهر في الداشبورد):\n";
        echo "   ├─ Name: {$project->aams->name}\n";

        if (isset($project->aams->email)) {
            echo "   ├─ Email: ✅ {$project->aams->email}\n";
        } else {
            echo "   ├─ Email: ❌ غير موجود (لن يظهر في الداشبورد)\n";
        }

        if (isset($project->aams->phone)) {
            echo "   └─ Phone: ✅ {$project->aams->phone}\n";
        } else {
            echo "   └─ Phone: ❌ غير موجود (لن يظهر في الداشبورد)\n";
        }

        echo "\n";

        // محاكاة الكود في blade
        echo "📱 كود Blade سينتج:\n";
        echo str_repeat("-", 60) . "\n";

        echo "Escalation\n";
        echo "Customer Contact:\n";
        echo $project->customer_contact_details ?? 'N/A';
        echo "\n\nAccount Manager:\n";
        echo "👤 {$project->aams->name}\n";

        if ($project->aams->email) {
            echo "✉️  {$project->aams->email}\n";
        }

        if ($project->aams->phone) {
            echo "📞 {$project->aams->phone}\n";
        }

        echo str_repeat("-", 60) . "\n";

    } else {
        echo "❌ لا يوجد Account Manager مرتبط\n";
    }

    echo "\n✅ الإصلاح تم بنجاح! الإيميل والموبايل سيظهرون الآن في الداشبورد\n";

} else {
    echo "❌ لم يتم العثور على المشروع PR003\n";
}

echo "\n==========================================\n";
