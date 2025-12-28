<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;
use App\Models\aams;

echo "==========================================\n";
echo "فحص بيانات Escalation (AM Email & Phone)\n";
echo "==========================================\n\n";

// 1. فحص جميع الـ AMs في الجدول
echo "1️⃣ جميع الـ Account Managers في النظام:\n";
echo str_repeat("-", 80) . "\n";

$allAMs = aams::all();

if ($allAMs->count() > 0) {
    foreach ($allAMs as $am) {
        echo "ID: {$am->id}\n";
        echo "Name: {$am->name}\n";
        echo "Email: " . ($am->email ?? '❌ غير موجود') . "\n";
        echo "Phone: " . ($am->phone ?? '❌ غير موجود') . "\n";
        echo str_repeat("-", 80) . "\n";
    }
} else {
    echo "⚠️ لا يوجد أي Account Managers في الجدول!\n\n";
}

// 2. فحص المشاريع والـ AM المرتبط بها
echo "\n2️⃣ المشاريع والـ Account Managers المرتبطين:\n";
echo str_repeat("=", 80) . "\n";

$projects = Project::with('aams')->get();

if ($projects->count() > 0) {
    foreach ($projects as $project) {
        echo "Project: {$project->pr_number}\n";
        echo "Customer Contact: " . ($project->customer_contact_details ?? 'N/A') . "\n";

        if ($project->aams && $project->aams->name !== 'nothing') {
            echo "✅ Account Manager موجود:\n";
            echo "   - Name: {$project->aams->name}\n";
            echo "   - Email: " . ($project->aams->email ?? '❌ غير موجود في الجدول') . "\n";
            echo "   - Phone: " . ($project->aams->phone ?? '❌ غير موجود في الجدول') . "\n";
        } else {
            echo "❌ لا يوجد Account Manager مرتبط بهذا المشروع\n";
        }

        echo str_repeat("-", 80) . "\n";
    }
} else {
    echo "⚠️ لا يوجد أي مشاريع في النظام!\n";
}

// 3. فحص محدد للمشروع PR003 (الظاهر في الصورة)
echo "\n3️⃣ فحص محدد للمشروع PR003:\n";
echo str_repeat("=", 80) . "\n";

$pr003 = Project::where('pr_number', 'PR003')->with('aams')->first();

if ($pr003) {
    echo "✅ المشروع PR003 موجود\n";
    echo "Customer Contact: " . ($pr003->customer_contact_details ?? 'N/A') . "\n";
    echo "AM ID في جدول projects: " . ($pr003->aams_id ?? 'NULL') . "\n";

    if ($pr003->aams && $pr003->aams->name !== 'nothing') {
        echo "\n✅ بيانات Account Manager:\n";
        echo "   - ID: {$pr003->aams->id}\n";
        echo "   - Name: {$pr003->aams->name}\n";
        echo "   - Email: " . ($pr003->aams->email ?? '❌ NULL') . "\n";
        echo "   - Phone: " . ($pr003->aams->phone ?? '❌ NULL') . "\n";

        // فحص إذا كانت القيم فارغة أو null
        if (empty($pr003->aams->email)) {
            echo "\n⚠️ المشكلة: حقل Email فارغ أو NULL في قاعدة البيانات!\n";
        }
        if (empty($pr003->aams->phone)) {
            echo "⚠️ المشكلة: حقل Phone فارغ أو NULL في قاعدة البيانات!\n";
        }
    } else {
        echo "❌ لا يوجد Account Manager مرتبط بالمشروع PR003\n";
    }
} else {
    echo "❌ المشروع PR003 غير موجود في قاعدة البيانات\n";
}

echo "\n==========================================\n";
echo "انتهى الفحص\n";
echo "==========================================\n";
