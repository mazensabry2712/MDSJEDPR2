# 🧪 دليل تشغيل اختبارات Escalation

## 📋 نظرة عامة

تم إنشاء مجموعة شاملة من الاختبارات لقسم **Escalation** في Dashboard. هذه الاختبارات تتحقق من:

- ✅ عرض بيانات Customer Contact
- ✅ عرض بيانات Account Manager (Name, Email, Phone)
- ✅ حالات الحافة (Edge Cases)
- ✅ XSS Protection
- ✅ Eager Loading Performance
- ✅ تحديث البيانات في الوقت الفعلي

---

## 🚀 كيفية تشغيل الاختبارات

### 1. تشغيل جميع اختبارات Escalation

```bash
php artisan test --filter EscalationTest
```

### 2. تشغيل اختبار محدد

```bash
# مثال: اختبار عرض Email فقط
php artisan test --filter it_displays_account_manager_email
```

### 3. تشغيل مع عرض تفاصيل أكثر

```bash
php artisan test --filter EscalationTest --verbose
```

### 4. تشغيل مع عرض coverage (إذا كان PHPUnit مُعد)

```bash
php artisan test --filter EscalationTest --coverage
```

---

## 📊 قائمة الاختبارات المتاحة

| # | اسم الاختبار | الوصف | الأولوية |
|---|--------------|-------|----------|
| 1 | `it_displays_customer_contact_in_escalation` | عرض Customer Contact | High |
| 2 | `it_displays_account_manager_name` | عرض اسم Account Manager | High |
| 3 | `it_displays_account_manager_email` | عرض Email للـ AM | High |
| 4 | `it_displays_account_manager_phone` | عرض Phone للـ AM | High |
| 5 | `it_handles_project_without_account_manager_gracefully` | مشروع بدون AM | High |
| 6 | `it_handles_account_manager_without_email` | AM بدون Email | Medium |
| 7 | `it_handles_account_manager_without_phone` | AM بدون Phone | Medium |
| 8 | `it_protects_against_xss_in_account_manager_data` | XSS Protection | Critical |
| 9 | `it_uses_eager_loading_for_account_manager` | Eager Loading | High |
| 10 | `it_reflects_data_changes_in_real_time` | تحديث البيانات | Medium |
| 11 | `it_loads_correct_account_manager_for_each_project` | صحة البيانات | High |

---

## 🛠️ متطلبات التشغيل

### 1. تأكد من وجود بيانات اختبار

```bash
php artisan db:seed # إذا كان لديك seeders
```

أو قم بإنشاء بيانات يدوياً:
- مشروع واحد على الأقل (مثال: PR003)
- Account Manager واحد على الأقل مع email و phone
- مستخدم واحد على الأقل للتسجيل

### 2. تأكد من أن قاعدة البيانات متصلة

تحقق من `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3. تأكد من تثبيت PHPUnit

```bash
composer require --dev phpunit/phpunit
```

---

## 📖 كيفية قراءة النتائج

### ✅ نتيجة ناجحة
```
PASS  Tests\Feature\EscalationTest
✓ it displays customer contact in escalation
✓ it displays account manager email

Tests:  2 passed
Time:   0.52s
```

### ❌ نتيجة فاشلة
```
FAIL  Tests\Feature\EscalationTest
✓ it displays customer contact in escalation
⨯ it displays account manager email

Expected to see text "test@example.com" but it was not found.
Failed asserting that response contains "test@example.com".

Tests:  1 passed, 1 failed
Time:   0.48s
```

---

## 🔧 استكشاف الأخطاء

### مشكلة: "Project not found"
```bash
# الحل: تأكد من وجود بيانات في جدول projects
php check_escalation_data.php
```

### مشكلة: "Unauthenticated"
```bash
# الحل: تأكد من وجود مستخدمين في جدول users
php artisan tinker
>>> User::count()
```

### مشكلة: "Class not found"
```bash
# الحل: إعادة تحميل autoload
composer dump-autoload
```

### مشكلة: "Database connection refused"
```bash
# الحل: تأكد من تشغيل MySQL/MariaDB
# Windows:
net start MySQL

# أو تحقق من Herd
herd start
```

---

## 📝 إضافة اختبارات جديدة

لإضافة اختبار جديد:

1. افتح `tests/Feature/EscalationTest.php`
2. أضف دالة جديدة:

```php
/**
 * Test Case: وصف الاختبار
 * 
 * @test
 */
public function it_does_something_new()
{
    // Arrange: إعداد البيانات
    $user = User::first();
    $this->actingAs($user);
    
    // Act: تنفيذ الإجراء
    $response = $this->get('/dashboard');
    
    // Assert: التحقق من النتيجة
    $response->assertStatus(200);
    $response->assertSee('Expected Text');
}
```

3. شغل الاختبار الجديد:
```bash
php artisan test --filter it_does_something_new
```

---

## 🎯 اختبار سريع (Quick Test)

لعمل اختبار سريع على كل شيء:

```bash
# 1. مسح الكاش
php artisan config:clear
php artisan cache:clear

# 2. تشغيل جميع اختبارات Escalation
php artisan test --filter EscalationTest

# 3. عرض تقرير موجز
php artisan test --filter EscalationTest --compact
```

---

## 📊 مثال على النتائج المتوقعة

```
   PASS  Tests\Feature\EscalationTest
  ✓ it displays customer contact in escalation                      0.12s
  ✓ it displays account manager name                                0.08s
  ✓ it displays account manager email                               0.09s
  ✓ it displays account manager phone                               0.08s
  ✓ it handles project without account manager gracefully           0.07s
  ✓ it handles account manager without email                        0.15s
  ✓ it handles account manager without phone                        0.14s
  ✓ it protects against xss in account manager data                 0.16s
  ✓ it uses eager loading for account manager                       0.11s
  ✓ it reflects data changes in real time                           0.13s
  ✓ it loads correct account manager for each project               0.22s

  Tests:    11 passed (22 assertions)
  Duration: 1.35s
```

---

## 🔄 CI/CD Integration

لإضافة هذه الاختبارات إلى pipeline:

### GitHub Actions
```yaml
# .github/workflows/tests.yml
name: Run Tests
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Install Dependencies
        run: composer install
      - name: Run Escalation Tests
        run: php artisan test --filter EscalationTest
```

### GitLab CI
```yaml
# .gitlab-ci.yml
test:
  script:
    - composer install
    - php artisan test --filter EscalationTest
```

---

## 📞 الدعم

إذا واجهت أي مشاكل:
1. تحقق من ملف `phpunit.xml` للتأكد من الإعدادات
2. راجع logs في `storage/logs/laravel.log`
3. شغل `php artisan test --filter EscalationTest --verbose` لعرض تفاصيل أكثر

---

**آخر تحديث:** 28 ديسمبر 2025
