<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\DashboardController; // Student Dashboard
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdminDashboardController; // Renamed Admin Dashboard

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== AUTHENTICATION ROUTES ====================
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Registration Routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Enrollment routes
Route::middleware(['auth'])->group(function () {
    Route::post('/courses/{course}/enroll', [App\Http\Controllers\EnrollmentController::class, 'enroll'])->name('courses.enroll');
    Route::post('/courses/{course}/enroll-ajax', [App\Http\Controllers\EnrollmentController::class, 'enrollAjax'])->name('courses.enroll.ajax');
    Route::get('/courses/{slug}/learn', [App\Http\Controllers\EnrollmentController::class, 'learning'])->name('courses.learning');
    Route::post('/courses/{course}/lessons/{lesson}/progress', [App\Http\Controllers\EnrollmentController::class, 'updateProgress'])->name('courses.progress');
});

// ==================== AUTHENTICATED USER ROUTES ====================
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    //Quiz page for loggedin users
    Route::get('/crowd-quiz', [PageController::class, 'quiz'])->name('quiz');

    // Student Dashboard - Using DashboardController (student)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-courses', [DashboardController::class, 'courses'])->name('my-courses');
    Route::get('/my-quizzes', [DashboardController::class, 'quizzes'])->name('my-quizzes');
    Route::get('/certificates', [DashboardController::class, 'certificates'])->name('certificates');

    // Learning Routes
    Route::get('/courses/{course}/learn', [CourseController::class, 'learn'])->name('courses.learn');
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::post('/courses/{course}/rate', [CourseController::class, 'rate'])->name('courses.rate');
    Route::post('/lessons/{lesson}/complete', [CourseController::class, 'completeLesson'])->name('lessons.complete');

    // Quiz Routes
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/{quiz:slug}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::post('/quizzes/{quiz}/start', [QuizController::class, 'start'])->name('quizzes.start');
    Route::get('/quizzes/{quiz}/attempt/{attempt}', [QuizController::class, 'take'])->name('quizzes.take');
    Route::post('/quizzes/{quiz}/attempt/{attempt}', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])->name('quizzes.results');

    // Wishlist Routes
    Route::post('/wishlist/{course}', [DashboardController::class, 'addToWishlist'])->name('wishlist.add');
    Route::delete('/wishlist/{course}', [DashboardController::class, 'removeFromWishlist'])->name('wishlist.remove');

    // Profile Routes
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [DashboardController::class, 'updateAvatar'])->name('profile.avatar');
    Route::post('/profile/change-password', [DashboardController::class, 'changePassword'])->name('profile.password');
});

// ==================== PUBLIC PAGE ROUTES ====================
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/academy', [PageController::class, 'academy'])->name('academy');
Route::get('/neo-ed-tech', [PageController::class, 'neoEdTech'])->name('neo-ed-tech');
Route::get('/our-team', [PageController::class, 'ourTeam'])->name('our-team');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/membership-pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/refund-policy', [PageController::class, 'refund'])->name('refund');
Route::get('/terms-conditions', [PageController::class, 'terms'])->name('terms');

// ==================== PUBLIC COURSE ROUTES ====================
Route::get('/courses', [CourseController::class, 'index'])->name('courses');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/course-category/{slug}', [CourseController::class, 'category'])->name('courses.category');
Route::post('/courses/filter', [CourseController::class, 'filter'])->name('courses.filter');

// ==================== PUBLIC BLOG ROUTES ====================
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// ==================== PAYMENT ROUTES ====================
Route::middleware('auth')->group(function () {
    Route::get('/checkout/{course}', [PaymentController::class, 'checkout'])->name('checkout');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');
});

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard - Using AdminDashboardController
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AdminDashboardController::class, 'analytics'])->name('analytics');

    // Courses Management
    Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);
    Route::get('courses/{course}/lessons', [App\Http\Controllers\Admin\CourseController::class, 'lessons'])->name('courses.lessons');
    Route::post('courses/{course}/lessons', [App\Http\Controllers\Admin\CourseController::class, 'storeLesson'])->name('courses.lessons.store');
    Route::put('courses/lessons/{lesson}', [App\Http\Controllers\Admin\CourseController::class, 'updateLesson'])->name('courses.lessons.update');
    Route::delete('courses/lessons/{lesson}', [App\Http\Controllers\Admin\CourseController::class, 'destroyLesson'])->name('courses.lessons.destroy');

    // Sections Management
    Route::post('courses/{course}/sections', [App\Http\Controllers\Admin\CourseController::class, 'storeSection'])->name('courses.sections.store');
    Route::put('courses/sections/{section}', [App\Http\Controllers\Admin\CourseController::class, 'updateSection'])->name('courses.sections.update');
    Route::delete('courses/sections/{section}', [App\Http\Controllers\Admin\CourseController::class, 'destroySection'])->name('courses.sections.destroy');
    Route::post('courses/sections/reorder', [App\Http\Controllers\Admin\CourseController::class, 'reorderSections'])->name('courses.sections.reorder');

    // Quizzes Management
    Route::resource('quizzes', App\Http\Controllers\Admin\QuizController::class);
    Route::get('quizzes/{quiz}/questions', [App\Http\Controllers\Admin\QuizController::class, 'questions'])->name('quizzes.questions');
    Route::post('quizzes/{quiz}/questions', [App\Http\Controllers\Admin\QuizController::class, 'storeQuestion'])->name('quizzes.questions.store');
    Route::put('quizzes/questions/{question}', [App\Http\Controllers\Admin\QuizController::class, 'updateQuestion'])->name('quizzes.questions.update');
    Route::delete('quizzes/questions/{question}', [App\Http\Controllers\Admin\QuizController::class, 'destroyQuestion'])->name('quizzes.questions.destroy');
    Route::post('quizzes/questions/reorder', [App\Http\Controllers\Admin\QuizController::class, 'reorderQuestions'])->name('quizzes.questions.reorder');
    // In your web.php, make sure this route exists:
    Route::post('quizzes/{quiz}/questions', [App\Http\Controllers\Admin\QuizController::class, 'storeQuestion'])
        ->name('quizzes.questions.store');
    // Categories Management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);

    // Tags Management
    Route::resource('tags', App\Http\Controllers\Admin\TagController::class);

    // Users Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::get('users/students', [App\Http\Controllers\Admin\UserController::class, 'students'])->name('users.students');
    Route::get('users/instructors', [App\Http\Controllers\Admin\UserController::class, 'instructors'])->name('users.instructors');
    Route::post('users/{user}/impersonate', [App\Http\Controllers\Admin\UserController::class, 'impersonate'])->name('users.impersonate');
    Route::post('users/stop-impersonating', [App\Http\Controllers\Admin\UserController::class, 'stopImpersonating'])->name('users.stop-impersonating');

    // Orders Management
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'destroy']);
    Route::post('orders/{order}/refund', [App\Http\Controllers\Admin\OrderController::class, 'refund'])->name('orders.refund');

    // Coupons Management
    Route::resource('coupons', App\Http\Controllers\Admin\CouponController::class);

    // Reviews Management
    Route::resource('reviews', App\Http\Controllers\Admin\ReviewController::class)->only(['index', 'show', 'destroy']);
    Route::post('reviews/{review}/approve', [App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('reviews/{review}/reject', [App\Http\Controllers\Admin\ReviewController::class, 'reject'])->name('reviews.reject');

    // Reports
    Route::get('reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/sales', [App\Http\Controllers\Admin\ReportController::class, 'sales'])->name('reports.sales');
    Route::get('reports/students', [App\Http\Controllers\Admin\ReportController::class, 'students'])->name('reports.students');
    Route::get('reports/courses', [App\Http\Controllers\Admin\ReportController::class, 'courses'])->name('reports.courses');
    Route::get('reports/quizzes', [App\Http\Controllers\Admin\ReportController::class, 'quizzes'])->name('reports.quizzes');
    Route::get('reports/export/{type}/{format}', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');

    // Notifications
    Route::get('notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications');
    Route::post('notifications/mark-all-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::delete('notifications/{notification}', [App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Settings
    Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings');
    Route::post('settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Admin Profile
    Route::get('profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile');
    Route::put('profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

    // Search
    Route::get('search', [App\Http\Controllers\Admin\SearchController::class, 'index'])->name('search');

    // Backup
    Route::get('backup', [App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backup');
    Route::post('backup/create', [App\Http\Controllers\Admin\BackupController::class, 'create'])->name('backup.create');
    Route::get('backup/download/{file}', [App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backup.download');
    Route::delete('backup/{file}', [App\Http\Controllers\Admin\BackupController::class, 'destroy'])->name('backup.destroy');
});

// ==================== INSTRUCTOR ROUTES ====================
// Route::prefix('instructor')->name('instructor.')->middleware(['auth', 'instructor'])->group(function () {
//     Route::get('/dashboard', [App\Http\Controllers\Instructor\DashboardController::class, 'index'])->name('dashboard');
//     Route::resource('courses', App\Http\Controllers\Instructor\CourseController::class);
//     Route::resource('quizzes', App\Http\Controllers\Instructor\QuizController::class);
//     Route::get('/students', [App\Http\Controllers\Instructor\StudentController::class, 'index'])->name('students');
//     Route::get('/earnings', [App\Http\Controllers\Instructor\EarningController::class, 'index'])->name('earnings');
// });

// ==================== TEST ROUTES (Remove in production) ====================
if (app()->environment('local')) {
    Route::get('/test-email', function () {
        return view('emails.test');
    });

    Route::get('/test-admin', function () {
        return view('admin.dashboard');
    });
}

// ==================== FALLBACK ROUTE ====================
// Route::fallback(function () {
//     return view('errors.404');
// });