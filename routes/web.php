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
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\TranslationController;
use App\Services\DeepLService;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Auth\GoogleController;

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// routes/web.php
Route::get('/deepl-usage', function () {
    try {
        $deepLService = app(App\Services\DeepLService::class);
        $usage = $deepLService->getUsage();

        return response()->json([
            'success' => true,
            'usage' => $usage
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// Add to routes/web.php for testing
Route::get('/test-deepl', function () {
    $deepl = app(DeepLService::class);
    return $deepl->translate('Hello world', 'en', 'es');
});

// Add this temporarily to debug
Route::get('/test-translate', function () {
    return response()->json([
        'route_exists' => true,
        'translate_url' => route('translate', [], false),
        'full_url' => route('translate', [], true),
        'api_key_configured' => config('deepl.api_key') ? 'Yes' : 'No',
        'api_key' => substr(config('deepl.api_key'), 0, 10) . '...'
    ]);
});

// Add to routes/web.php temporarily
Route::get('/debug-translate', function () {
    return response()->json([
        'routes' => [
            'translate_named' => route('translate', [], false),
            'translate_url' => url('/translate'),
        ],
        'csrf_token' => csrf_token(),
        'session_has' => session()->has('_token'),
        'api_key' => config('deepl.api_key') ? 'Configured' : 'Not configured',
        'middleware' => 'Check that /translate is in web middleware group'
    ]);
});

Route::get('/test-deepl-direct', function () {
    try {
        $deepl = app(\App\Services\DeepLService::class);
        $result = $deepl->translate('Hello world', 'en', 'es');
        return response()->json([
            'success' => true,
            'original' => 'Hello world',
            'translated' => $result,
            'api_key' => substr(config('deepl.api_key'), 0, 10) . '...'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});

Route::get('/debug-deepl-raw', function () {
    $apiKey = config('deepl.api_key');

    // Test with proper header authentication
    $response = Http::withHeaders([
        'Authorization' => 'DeepL-Auth-Key ' . $apiKey,
        'Content-Type' => 'application/json',
    ])->post('https://api-free.deepl.com/v2/translate', [
        'text' => ['Hello world', 'How are you?'],
        'source_lang' => 'EN',
        'target_lang' => 'ES',
    ]);

    return response()->json([
        'status' => $response->status(),
        'headers' => $response->headers(),
        'body' => $response->json(),
        'api_key_preview' => substr($apiKey, 0, 10) . '...',
    ]);
});

Route::get('/test-deepl-api', function () {
    $apiKey = config('deepl.api_key');

    // Test DeepL API directly with curl
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api-free.deepl.com/v2/translate');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'auth_key' => $apiKey,
        'text' => 'Hello world',
        'source_lang' => 'EN',
        'target_lang' => 'ES'
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    return response()->json([
        'api_key_configured' => $apiKey ? 'Yes' : 'No',
        'api_key_preview' => substr($apiKey, 0, 10) . '...',
        'http_code' => $httpCode,
        'curl_error' => $error,
        'response' => json_decode($response, true) ?: $response
    ]);
});

// Language Switcher Route
Route::get('/language/{lang}', [App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');
Route::get('/api/current-language', [App\Http\Controllers\LanguageController::class, 'getCurrentLanguage'])->name('language.current');

// ==================== EMAIL VERIFICATION ROUTES ====================
// These routes should be accessible without authentication
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->name('verification.verify');

Route::get('/email/verification-notification', [VerificationController::class, 'resend'])
    ->name('verification.resend');

// Email verification notice - requires auth to show
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');
});

Route::post('/translate', [App\Http\Controllers\TranslationController::class, 'translate'])->name('translate');

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

    // Certificate Routes for authenticated users
    Route::get('/certificates', [App\Http\Controllers\CertificateController::class, 'index'])->name('certificates');
    Route::get('/certificates/{id}', [App\Http\Controllers\CertificateController::class, 'show'])->name('certificates.show');
    Route::post('/courses/{course}/certificate/generate', [App\Http\Controllers\CertificateController::class, 'generate'])->name('certificates.generate');
    Route::get('/certificates/{id}/download', [App\Http\Controllers\CertificateController::class, 'download'])->name('certificates.download');

    // ==================== SUBSCRIPTION ROUTES ====================
    Route::get('/subscription/plans', [PaymentController::class, 'subscriptionPlans'])->name('subscription.plans');
    Route::get('/subscription/checkout/{plan}', [PaymentController::class, 'subscriptionCheckout'])->name('subscription.checkout');
    Route::post('/subscription/process', [PaymentController::class, 'processSubscription'])->name('subscription.process');
    Route::get('/subscription/success', [PaymentController::class, 'subscriptionSuccess'])->name('payment.subscription.success');

    // Enrollment routes with subscription support
    Route::post('/courses/{course}/enroll', [App\Http\Controllers\EnrollmentController::class, 'enroll'])->name('courses.enroll');
    Route::post('/courses/{course}/enroll-ajax', [App\Http\Controllers\EnrollmentController::class, 'enrollAjax'])->name('courses.enroll.ajax');
    Route::get('/courses/{course}/enroll-subscription', [App\Http\Controllers\EnrollmentController::class, 'enrollWithSubscription'])->name('courses.enroll.subscription');
    Route::get('/courses/{slug}/learn', [App\Http\Controllers\EnrollmentController::class, 'learning'])->name('courses.learning');
    Route::post('/courses/{course}/lessons/{lesson}/progress', [App\Http\Controllers\EnrollmentController::class, 'updateProgress'])->name('courses.progress');

    // Learning Routes
    Route::get('/courses/{course}/learn', [CourseController::class, 'learn'])->name('courses.learn');
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
Route::get('/quiz-competition', [PageController::class, 'quizCompetition'])->name('quiz-competition');
Route::get('/neo-ed-tech', [PageController::class, 'neoEdTech'])->name('neo-ed-tech');
Route::get('/our-team', [PageController::class, 'ourTeam'])->name('our-team');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/membership-pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/refund-policy', [PageController::class, 'refund'])->name('refund');
Route::get('/terms-conditions', [PageController::class, 'terms'])->name('terms');
Route::post('/contact/submit', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

// ==================== PUBLIC COURSE ROUTES ====================
Route::get('/courses', [CourseController::class, 'index'])->name('courses');
// IMPORTANT: Put the filter route BEFORE the show route to prevent routing conflicts
Route::get('/courses/filter', [App\Http\Controllers\CourseController::class, 'filter'])->name('courses.filter');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/course-category/{slug}', [CourseController::class, 'category'])->name('courses.category');

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

// ==================== STRIPE PAYMENT ROUTES ====================
Route::middleware('auth')->group(function () {
    Route::post('/stripe/create-checkout-session', [App\Http\Controllers\StripePaymentController::class, 'createCheckoutSession'])
        ->name('stripe.create-checkout-session');
    Route::get('/stripe/success', [App\Http\Controllers\StripePaymentController::class, 'success'])
        ->name('stripe.success');
    Route::get('/stripe/cancel', [App\Http\Controllers\StripePaymentController::class, 'cancel'])
        ->name('stripe.cancel');
});

// Stripe webhook (no auth required)
Route::post('/stripe/webhook', [App\Http\Controllers\StripePaymentController::class, 'handleWebhook'])
    ->name('stripe.webhook');

// Public verification route (no auth required)
Route::get('/verify-certificate/{certificateNumber}', [App\Http\Controllers\CertificateController::class, 'verify'])->name('certificates.verify');

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
    Route::post('courses/{course}/clone', [App\Http\Controllers\Admin\CourseController::class, 'clone'])->name('courses.clone');
    Route::get('courses/lessons/{lesson}/edit-data', [App\Http\Controllers\Admin\CourseController::class, 'editLessonData'])->name('courses.lessons.edit-data');

    // Reordering
    Route::post('courses/sections/reorder', [App\Http\Controllers\Admin\CourseController::class, 'reorderSections'])->name('courses.sections.reorder');
    Route::post('courses/lessons/reorder', [App\Http\Controllers\Admin\CourseController::class, 'reorderLessons'])->name('courses.lessons.reorder');

    // Sections Management
    Route::post('courses/{course}/sections', [App\Http\Controllers\Admin\CourseController::class, 'storeSection'])->name('courses.sections.store');
    Route::put('courses/sections/{section}', [App\Http\Controllers\Admin\CourseController::class, 'updateSection'])->name('courses.sections.update');
    Route::delete('courses/sections/{section}', [App\Http\Controllers\Admin\CourseController::class, 'destroySection'])->name('courses.sections.destroy');

    // Subscription Plans Management
    Route::resource('subscription-plans', App\Http\Controllers\Admin\SubscriptionPlanController::class);
    Route::post('subscription-plans/reorder', [App\Http\Controllers\Admin\SubscriptionPlanController::class, 'reorder'])->name('subscription-plans.reorder');

    // User Subscriptions Management
    Route::get('subscriptions', [App\Http\Controllers\Admin\UserSubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('subscriptions/{subscription}', [App\Http\Controllers\Admin\UserSubscriptionController::class, 'show'])->name('subscriptions.show');
    Route::post('subscriptions/{subscription}/cancel', [App\Http\Controllers\Admin\UserSubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
    Route::post('subscriptions/{subscription}/renew', [App\Http\Controllers\Admin\UserSubscriptionController::class, 'renew'])->name('subscriptions.renew');

    // Quizzes Management
    Route::resource('quizzes', App\Http\Controllers\Admin\QuizController::class);
    Route::get('quizzes/{quiz}/questions', [App\Http\Controllers\Admin\QuizController::class, 'questions'])->name('quizzes.questions');
    Route::post('quizzes/{quiz}/questions', [App\Http\Controllers\Admin\QuizController::class, 'storeQuestion'])->name('quizzes.questions.store');
    Route::get('quizzes/questions/{question}/edit', [App\Http\Controllers\Admin\QuizController::class, 'editQuestion'])->name('quizzes.questions.edit');
    Route::put('quizzes/questions/{question}', [App\Http\Controllers\Admin\QuizController::class, 'updateQuestion'])->name('quizzes.questions.update');
    Route::delete('quizzes/questions/{question}', [App\Http\Controllers\Admin\QuizController::class, 'destroyQuestion'])->name('quizzes.questions.destroy');
    Route::post('quizzes/questions/reorder', [App\Http\Controllers\Admin\QuizController::class, 'reorderQuestions'])->name('quizzes.questions.reorder');

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

    // Reports - New subscription reports
    Route::get('reports/subscriptions', [App\Http\Controllers\Admin\ReportController::class, 'subscriptions'])->name('reports.subscriptions');
    Route::get('reports/subscription-revenue', [App\Http\Controllers\Admin\ReportController::class, 'subscriptionRevenue'])->name('reports.subscription-revenue');

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
    Route::post('/profile/avatar', [App\Http\Controllers\Admin\ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::post('/profile/change-password', [App\Http\Controllers\Admin\ProfileController::class, 'changePassword'])->name('profile.password');

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

// Add this route temporarily
Route::get('/test-url', function (Request $request) {
    return response()->json([
        'app_url_config' => config('app.url'),
        'request_url' => $request->getSchemeAndHttpHost(),
        'success_url' => route('stripe.success', [], false),
        'full_success_url' => route('stripe.success', [], true),
    ]);
});

// Add to routes/web.php
Route::get('/stripe/success-test', function (Request $request) {
    return response()->json([
        'route_exists' => true,
        'session_id' => $request->get('session_id'),
        'url' => $request->fullUrl(),
        'routes' => collect(Route::getRoutes())->map(function ($route) {
            return $route->uri();
        })->filter(function ($uri) {
            return str_contains($uri, 'stripe');
        })->values()
    ]);
})->name('stripe.success.test');

// Add this with your other lesson routes
Route::post('/save-current-lesson', function (Request $request) {
    try {
        $request->validate([
            'course_id' => 'required|integer',
            'lesson_id' => 'required|integer'
        ]);

        session(['current_lesson_' . $request->course_id => $request->lesson_id]);

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
})->name('save.current.lesson')->middleware('auth');

// Lesson routes (add these in the authenticated routes section)
Route::post('/courses/lesson/{lesson}/complete', [CourseController::class, 'completeLesson'])->name('courses.lesson.complete');
Route::get('/courses/lesson/{lesson}/data', [CourseController::class, 'getLessonData'])->name('courses.lesson.data');
Route::post('/courses/lesson/{lesson}/progress', [CourseController::class, 'updateLessonProgress'])->name('courses.lesson.progress');
// Translation debugging routes
Route::get('/translation/test', [TranslationController::class, 'test'])->name('translation.test');
Route::get('/translation/debug', [TranslationController::class, 'debug'])->name('translation.debug');
Route::post('/translation/force-test', [TranslationController::class, 'forceTest'])->name('translation.force-test');

// ==================== SUBSCRIPTION ROUTES ====================
Route::get('/subscription/plans', [PaymentController::class, 'subscriptionPlans'])->name('subscription.plans');
Route::get('/subscription/checkout/{plan}', [PaymentController::class, 'subscriptionCheckout'])->name('subscription.checkout');
Route::post('/subscription/process', [PaymentController::class, 'processSubscription'])->name('subscription.process');
Route::get('/subscription/success', [PaymentController::class, 'subscriptionSuccess'])->name('payment.subscription.success');

// Enrollment routes with subscription support
Route::post('/courses/{course}/enroll', [App\Http\Controllers\EnrollmentController::class, 'enroll'])->name('courses.enroll');
Route::post('/courses/{course}/enroll-ajax', [App\Http\Controllers\EnrollmentController::class, 'enrollAjax'])->name('courses.enroll.ajax');
Route::get('/courses/{course}/enroll-subscription', [App\Http\Controllers\EnrollmentController::class, 'enrollWithSubscription'])->name('courses.enroll.subscription');
Route::get('/courses/{slug}/learn', [App\Http\Controllers\EnrollmentController::class, 'learning'])->name('courses.learning');

// ==================== FALLBACK ROUTE ====================
// Route::fallback(function () {
//     return view('errors.404');
// });