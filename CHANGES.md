# التعديلات (Refactor + مراجعة الأخطاء)

## الهيكل الجديد

```
app/Http/Controllers/
├── Auth/AuthController.php          ← دخول/خروج/تسجيل (مشترك)
├── ProfileController.php            ← البروفايل (مشترك لكل الأدوار)
├── Admin/        DashboardController, UserController, CategoryController, CourseController
├── Instructor/   DashboardController, CourseController, SectionController, LessonController
├── Student/      HomeController, CourseController, EnrollmentController
└── Api/          AuthController, Admin/UserController

app/Services/
├── AuthService.php, ProfileService.php        ← مشتركين
├── Admin/        AdminDashboardService, AdminUserService, AdminCategoryService, AdminCourseService
├── Instructor/   InstructorDashboardService, InstructorCourseService, InstructorSectionService, InstructorLessonService
└── Student/      StudentCourseService, StudentEnrollmentService
```

القاعدة: الـ Controller يستقبل الطلب ويتأكد من الصلاحية ويرجّع الصفحة، والـ Service فيها الشغل الفعلي (الداتابيز والملفات).
الـ Service مبتاخدش Request، بتاخد array عادي.

## الأخطاء اللي اتصلحت

1. `api.php` كان بيشاور على 8 controllers مش موجودة (`route:list` كان هيقع). اتشال المحذوف وفضل اللي شغال.
2. أسماء فولدرات `student` و`instructor` بحروف صغيرة والـ routes بتستورد `Instructor` بحرف كبير: شغال على Windows وبيقع على Linux/السيرفر.
3. `admin.courses.index` كان موجود في الـ routes والمنيو بس مفيش method ولا view. اتعمل Controller + view.
4. صفحة البروفايل للمدرس والأدمن كانت بتبعت على route الطالب (`role:student`) فكانت بترجع 403. دلوقتي routes مشتركة لأي مستخدم مسجل.
5. المدرس مكنش يقدر يعدّل كورسه: قايمة المدربين كانت فاضية و`instructor_id` required.
6. فورم إنشاء مستخدم كان بيبعت `role=user` والداتابيز فيها `student` (خطأ SQL). اتصلح في الفورم والـ Request، واتشال الدور الافتراضي "admin" من الفورم.
7. `status` مكنتش في `$fillable` فتعديل حالة المستخدم (نشط/معطل) كان بيتتجاهل بصمت.
8. الحساب المعطل (`inactive`) كان يقدر يسجل دخول. دلوقتي بيترفض.
9. `ApiResponseTrait::error()` ترتيب الباراميترات غلط: كل أخطاء الـ API كانت بترجع 400 والرسالة "500".
10. `Api\UserController` كان بيعمل `$user->delete()` مباشرة (بيتخطى حماية "ماتحذفش نفسك" وحذف الصورة) ويبلع كل الأخطاء بـ `catch (Throwable)`. دلوقتي بيستخدم الـ Service والـ handler المركزي.
11. `avg('rating')` في لوحة المدرس: العمود اسمه `average_rating`.
12. `total_students` مكنش بيتزود عند الاشتراك. دلوقتي `StudentEnrollmentService::enroll` بتزوده.
13. `LoginRequest` فيه مفتاح `remember_token` بحرف عربي مخفي (ـ) ومكنش بيشتغل. اتصلح، وشيلنا `min:6` من الدخول.
14. `RegisterRequest` مفيهوش `unique` على الموبايل فالتكرار كان بيطلع Error 500 من الداتابيز.
15. `CourseRequest`: `instructor_id` دلوقتي لازم يكون مدرس أو أدمن (مش أي مستخدم).
16. `Route::resource('users')` كان بيسجل `show` من غير method، وبقى `except(['show'])`.
17. `User` model: اتشالت الـ attributes المكررة (`#[Fillable]`/`#[Hidden]`) وكتبنا `$fillable` و`$hidden` بشكل واضح، وأضفنا `HasApiTokens` (Sanctum محتاجه).
18. N+1 queries: `with('lessons')` في السيكشنات و`with('category')` في لوحة المدرس.
19. اتضاف حذف السيكشن والدرس (الـ views كانت مستنياه بـ `Route::has`).

## لسه مش معمول (قررت أسيبه)

- تعديل السيكشن/الدرس: محتاج views جديدة.
- عمود `courses.price` نوعه string في الـ migration. الأحسن decimal (محتاج migration جديدة).
- `LessonCompleted` و`UpdateCourseProgress` لسه stubs فاضية ومش متسجلة.
- `resources/views/admins/users/profile.blade.php` مش مستخدم.
- API الطالب والمدرس: هنبنيها بنفس الـ Services.

## بعد ما تنزّل الملفات

```bash
composer dump-autoload
php artisan optimize:clear
php artisan route:list
```
