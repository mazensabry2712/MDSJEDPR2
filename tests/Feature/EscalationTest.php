<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use App\Models\aams;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * اختبارات شاملة لقسم Escalation في Dashboard
 *
 * هذه الاختبارات تتحقق من:
 * 1. عرض بيانات Customer Contact
 * 2. عرض بيانات Account Manager (Name, Email, Phone)
 * 3. حالات الحافة (بدون AM، بدون email/phone)
 * 4. XSS Protection
 */
class EscalationTest extends TestCase
{
    // use RefreshDatabase; // استخدم هذا إذا كنت تريد تنظيف قاعدة البيانات بعد كل test

    /**
     * Test Case 1: التحقق من عرض Customer Contact
     *
     * @test
     */
    public function it_displays_customer_contact_in_escalation()
    {
        // Arrange: إنشاء مستخدم وتسجيل دخول
        $user = User::first() ?? User::factory()->create();
        $this->actingAs($user);

        // إنشاء أو استخدام مشروع موجود
        $project = Project::where('pr_number', 'PR003')->first();

        if (!$project) {
            $this->markTestSkipped('Project PR003 not found in database');
        }

        // Act: طلب صفحة Dashboard مع فلتر
        $response = $this->get('/dashboard?filter[pr_number]=PR003');

        // Assert: التحقق من النتائج
        $response->assertStatus(200);
        $response->assertSee('Escalation');
        $response->assertSee('Customer Contact');

        if ($project->customer_contact_details) {
            $response->assertSee($project->customer_contact_details);
        }
    }

    /**
     * Test Case 2: التحقق من عرض اسم Account Manager
     *
     * @test
     */
    public function it_displays_account_manager_name()
    {
        $user = User::first() ?? User::factory()->create();
        $this->actingAs($user);

        $project = Project::where('pr_number', 'PR003')->with('aams')->first();

        if (!$project || !$project->aams) {
            $this->markTestSkipped('Project with Account Manager not found');
        }

        $response = $this->get('/dashboard?filter[pr_number]=PR003');

        $response->assertStatus(200);
        $response->assertSee('Account Manager');
        $response->assertSee($project->aams->name);
    }

    /**
     * Test Case 3: التحقق من عرض Email للـ Account Manager
     *
     * @test
     */
    public function it_displays_account_manager_email()
    {
        $user = User::first() ?? User::factory()->create();
        $this->actingAs($user);

        $project = Project::where('pr_number', 'PR003')->with('aams')->first();

        if (!$project || !$project->aams || !$project->aams->email) {
            $this->markTestSkipped('Project with Account Manager email not found');
        }

        $response = $this->get('/dashboard?filter[pr_number]=PR003');

        $response->assertStatus(200);
        $response->assertSee($project->aams->email);
        $response->assertSee('fa-envelope'); // التحقق من أيقونة Email
    }

    /**
     * Test Case 4: التحقق من عرض Phone للـ Account Manager
     *
     * @test
     */
    public function it_displays_account_manager_phone()
    {
        $user = User::first() ?? User::factory()->create();
        $this->actingAs($user);

        $project = Project::where('pr_number', 'PR003')->with('aams')->first();

        if (!$project || !$project->aams || !$project->aams->phone) {
            $this->markTestSkipped('Project with Account Manager phone not found');
        }

        $response = $this->get('/dashboard?filter[pr_number]=PR003');

        $response->assertStatus(200);
        $response->assertSee($project->aams->phone);
        $response->assertSee('fa-phone'); // التحقق من أيقونة Phone
    }

    /**
     * Test Case 5: حالة حافة - مشروع بدون Account Manager
     *
     * @test
     */
    public function it_handles_project_without_account_manager_gracefully()
    {
        $user = User::first() ?? User::factory()->create();
        $this->actingAs($user);

        // البحث عن مشروع بدون AM أو إنشاء واحد
        $project = Project::whereNull('aams_id')->first();

        if (!$project) {
            $this->markTestSkipped('No project without Account Manager found');
        }

        $response = $this->get('/dashboard?filter[pr_number]=' . $project->pr_number);

        $response->assertStatus(200);
        $response->assertSee('No contact info');
    }

    /**
     * Test Case 6: حالة حافة - Account Manager بدون Email
     *
     * @test
     */
    public function it_handles_account_manager_without_email()
    {
        $user = User::first() ?? User::factory()->create();
        $this->actingAs($user);

        // إنشاء AM مؤقت بدون email للاختبار
        $am = aams::create([
            'name' => 'Test Manager No Email',
            'email' => null,
            'phone' => '01234567890'
        ]);

        $project = Project::first();
        $originalAmId = $project->aams_id;
        $project->aams_id = $am->id;
        $project->save();

        $response = $this->get('/dashboard?filter[pr_number]=' . $project->pr_number);

        // التحقق من عدم ظهور Email لكن Phone يظهر
        $response->assertStatus(200);
        $response->assertSee($am->phone);
        $response->assertDontSee('fa-envelope');

        // استعادة البيانات الأصلية
        $project->aams_id = $originalAmId;
        $project->save();
        $am->delete();
    }

    /**
     * Test Case 7: حالة حافة - Account Manager بدون Phone
     *
     * @test
     */
    public function it_handles_account_manager_without_phone()
    {
        $user = User::first() ?? User::factory()->create();
        $this->actingAs($user);

        // إنشاء AM مؤقت بدون phone للاختبار
        $am = aams::create([
            'name' => 'Test Manager No Phone',
            'email' => 'test@example.com',
            'phone' => null
        ]);

        $project = Project::first();
        $originalAmId = $project->aams_id;
        $project->aams_id = $am->id;
        $project->save();

        $response = $this->get('/dashboard?filter[pr_number]=' . $project->pr_number);

        // التحقق من عدم ظهور Phone لكن Email يظهر
        $response->assertStatus(200);
        $response->assertSee($am->email);
        $response->assertDontSee('fa-phone');

        // استعادة البيانات الأصلية
        $project->aams_id = $originalAmId;
        $project->save();
        $am->delete();
    }

    /**
     * Test Case 8: XSS Protection - اختبار الحماية من الأكواد الضارة
     *
     * @test
     */
    public function it_protects_against_xss_in_account_manager_data()
    {
        $user = User::first() ?? User::factory()->create();
        $this->actingAs($user);

        // إنشاء AM بـ XSS payload
        $am = aams::create([
            'name' => '<script>alert("XSS")</script>',
            'email' => 'test@example.com',
            'phone' => '01234567890'
        ]);

        $project = Project::first();
        $originalAmId = $project->aams_id;
        $project->aams_id = $am->id;
        $project->save();

        $response = $this->get('/dashboard?filter[pr_number]=' . $project->pr_number);

        // التحقق من أن الكود لم ينفذ
        $response->assertStatus(200);
        $response->assertDontSee('<script>', false); // false = don't escape (للتحقق من HTML الخام)
        $response->assertSee('&lt;script&gt;'); // التحقق من أنه escaped

        // استعادة البيانات الأصلية
        $project->aams_id = $originalAmId;
        $project->save();
        $am->delete();
    }

    /**
     * Test Case 9: اختبار Eager Loading - التحقق من عدم وجود N+1 Query Problem
     *
     * @test
     */
    public function it_uses_eager_loading_for_account_manager()
    {
        $user = User::first() ?? User::factory()->create();
        $this->actingAs($user);

        // تفعيل query log
        \DB::enableQueryLog();

        $response = $this->get('/dashboard?filter[pr_number]=PR003');

        $queries = \DB::getQueryLog();

        // التحقق من أن بيانات aams محملة في query واحد (أو عدد قليل)
        // وليس query لكل مشروع
        $aamsQueries = array_filter($queries, function($query) {
            return strpos($query['query'], 'aams') !== false;
        });

        // يجب ألا يكون هناك queries كثيرة لـ aams
        $this->assertLessThan(5, count($aamsQueries), 'Too many queries for aams table. Possible N+1 problem.');

        $response->assertStatus(200);
    }

    /**
     * Test Case 10: اختبار تحديث البيانات
     *
     * @test
     */
    public function it_reflects_data_changes_in_real_time()
    {
        $user = User::first() ?? User::factory()->create();
        $this->actingAs($user);

        $project = Project::where('pr_number', 'PR003')->with('aams')->first();

        if (!$project || !$project->aams) {
            $this->markTestSkipped('Project with Account Manager not found');
        }

        $originalEmail = $project->aams->email;
        $newEmail = 'updated_' . time() . '@test.com';

        // تحديث Email
        $project->aams->email = $newEmail;
        $project->aams->save();

        // طلب Dashboard
        $response = $this->get('/dashboard?filter[pr_number]=PR003');

        // التحقق من ظهور Email الجديد
        $response->assertStatus(200);
        $response->assertSee($newEmail);
        $response->assertDontSee($originalEmail);

        // استعادة البيانات الأصلية
        $project->aams->email = $originalEmail;
        $project->aams->save();
    }

    /**
     * Test Case 11: اختبار أن البيانات تأتي من قاعدة البيانات الصحيحة
     *
     * @test
     */
    public function it_loads_correct_account_manager_for_each_project()
    {
        $user = User::first() ?? User::factory()->create();
        $this->actingAs($user);

        // الحصول على مشروعين مختلفين بـ AMs مختلفين
        $projects = Project::with('aams')
            ->whereNotNull('aams_id')
            ->limit(2)
            ->get();

        if ($projects->count() < 2) {
            $this->markTestSkipped('Not enough projects with different Account Managers');
        }

        foreach ($projects as $project) {
            $response = $this->get('/dashboard?filter[pr_number]=' . $project->pr_number);

            $response->assertStatus(200);
            $response->assertSee($project->aams->name);

            // التحقق من أن AM الخاص بالمشروع الآخر لا يظهر
            $otherProjects = $projects->where('id', '!=', $project->id);
            foreach ($otherProjects as $otherProject) {
                if ($otherProject->aams->id != $project->aams->id) {
                    $response->assertDontSee($otherProject->aams->name);
                }
            }
        }
    }
}
