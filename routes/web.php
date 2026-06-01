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
use App\Http\Controllers\EduconecxAcademyController;
use App\Http\Controllers\DashboardAcademySessionController;
use App\Http\Controllers\DashboardEduconecxAcademyController;
use Illuminate\Support\Facades\Http;

// Add these imports for password reset
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
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


// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Progressive Quizzes
    Route::resource('progressive-quizzes', App\Http\Controllers\Admin\ProgressiveQuizController::class);

    // Progressive Quiz Levels - FIXED: Properly nested routes
    Route::prefix('progressive-quizzes/{progressiveQuiz}')->name('progressive-quizzes.')->group(function () {
        // Level management
        Route::get('levels', [App\Http\Controllers\Admin\ProgressiveQuizController::class, 'levels'])->name('levels');
        Route::post('levels', [App\Http\Controllers\Admin\ProgressiveQuizController::class, 'storeLevel'])->name('levels.store');
        Route::put('levels/{progressiveLevel}', [App\Http\Controllers\Admin\ProgressiveQuizController::class, 'updateLevel'])->name('levels.update');
        Route::delete('levels/{progressiveLevel}', [App\Http\Controllers\Admin\ProgressiveQuizController::class, 'destroyLevel'])->name('levels.destroy');
        Route::post('levels/reorder', [App\Http\Controllers\Admin\ProgressiveQuizController::class, 'reorderLevels'])->name('levels.reorder');

        // Question management for specific level - FIXED: Proper parameter order
        Route::get('levels/{progressiveLevel}/questions', [App\Http\Controllers\Admin\ProgressiveQuizController::class, 'questions'])->name('questions');
        Route::post('levels/{progressiveLevel}/questions', [App\Http\Controllers\Admin\ProgressiveQuizController::class, 'storeQuestion'])->name('questions.store');
    });

    // Progressive Questions (standalone) - FIXED: Proper route names with EDIT route added
    Route::get('progressive-questions/{progressiveQuestion}/edit', [App\Http\Controllers\Admin\ProgressiveQuizController::class, 'editQuestion'])->name('progressive-questions.edit');
    Route::put('progressive-questions/{progressiveQuestion}', [App\Http\Controllers\Admin\ProgressiveQuizController::class, 'updateQuestion'])->name('progressive-questions.update');
    Route::delete('progressive-questions/{progressiveQuestion}', [App\Http\Controllers\Admin\ProgressiveQuizController::class, 'destroyQuestion'])->name('progressive-questions.destroy');
    Route::post('progressive-questions/reorder', [App\Http\Controllers\Admin\ProgressiveQuizController::class, 'reorderQuestions'])->name('progressive-questions.reorder');
});

// ==================== PROGRESSIVE QUIZZES FRONTEND ROUTES ====================
Route::prefix('progressive-quizzes')->name('progressive-quizzes.')->group(function () {
    // Public routes
    Route::get('/', [App\Http\Controllers\ProgressiveQuizFrontController::class, 'index'])->name('index');
    Route::get('{slug}', [App\Http\Controllers\ProgressiveQuizFrontController::class, 'show'])->name('show');
    Route::get('/history', [App\Http\Controllers\ProgressiveQuizFrontController::class, 'history'])->name('history')->middleware('auth');

    // Authenticated routes
    Route::middleware(['auth'])->group(function () {
        Route::post('{progressiveQuiz}/start', [App\Http\Controllers\ProgressiveQuizFrontController::class, 'start'])->name('start');
        Route::post('{progressiveQuiz}/restart', [App\Http\Controllers\ProgressiveQuizFrontController::class, 'restart'])->name('restart');
        Route::get('{progressiveQuiz}/continue', [App\Http\Controllers\ProgressiveQuizFrontController::class, 'continue'])->name('continue');
        Route::get('{progressiveQuiz}/results', [App\Http\Controllers\ProgressiveQuizFrontController::class, 'results'])->name('results');

        Route::get('{progressiveQuiz}/level/{level}/take', [App\Http\Controllers\ProgressiveQuizFrontController::class, 'take'])->name('take');
        Route::post('{progressiveQuiz}/level/{level}/submit', [App\Http\Controllers\ProgressiveQuizFrontController::class, 'submitAnswer'])->name('submit');
        Route::get('{progressiveQuiz}/level/{level}/results', [App\Http\Controllers\ProgressiveQuizFrontController::class, 'levelResults'])->name('level-results');
        
        // AJAX endpoint for getting question data
        Route::get('question/{questionId}', [App\Http\Controllers\ProgressiveQuizFrontController::class, 'getQuestion'])->name('question');
    });
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

    // ==================== PASSWORD RESET ROUTES (UPDATED) ====================
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

// ==================== AUTHENTICATED USER ROUTES ====================
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    //Quiz page for loggedin users
    Route::get('/crowd-quiz', [PageController::class, 'quiz'])->name('quiz');

    // Student Dashboard - Using DashboardController (student)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/educonecx-academy', [DashboardEduconecxAcademyController::class, 'index'])->name('dashboard.educonecx-academy.index');
    Route::post('/dashboard/educonecx-academy/avatar-preference', [DashboardEduconecxAcademyController::class, 'updateAvatarPreference'])->name('dashboard.educonecx-academy.avatar-preference');
    Route::post('/dashboard/educonecx-academy/scenario-preference', [DashboardEduconecxAcademyController::class, 'updateScenarioPreference'])->name('dashboard.educonecx-academy.scenario-preference');
    Route::get('/dashboard/educonecx-academy/history', [DashboardEduconecxAcademyController::class, 'history'])->name('dashboard.educonecx-academy.history');
    Route::get('/dashboard/educonecx-academy/sessions/{session}', [DashboardEduconecxAcademyController::class, 'showSession'])->name('dashboard.educonecx-academy.sessions.show');
    Route::get('/dashboard/academy-sessions/{session}', [DashboardAcademySessionController::class, 'show'])->name('dashboard.academy.sessions.show');
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
     Route::get('subscriptions/create', [App\Http\Controllers\Admin\UserSubscriptionController::class, 'create'])->name('subscriptions.create');
    Route::post('subscriptions', [App\Http\Controllers\Admin\UserSubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::get('subscriptions/export', [App\Http\Controllers\Admin\UserSubscriptionController::class, 'export'])->name('subscriptions.export');
    Route::get('subscriptions/{subscription}', [App\Http\Controllers\Admin\UserSubscriptionController::class, 'show'])->name('subscriptions.show');

    Route::get('subscriptions/{subscription}/edit', [App\Http\Controllers\Admin\UserSubscriptionController::class, 'edit'])->name('subscriptions.edit');
    Route::put('subscriptions/{subscription}', [App\Http\Controllers\Admin\UserSubscriptionController::class, 'update'])->name('subscriptions.update');
    Route::delete('subscriptions/{subscription}', [App\Http\Controllers\Admin\UserSubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
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


Route::get('/dev/liveavatar/check', function () {
    abort_unless(app()->environment('local'), 404);

    $apiKey = trim((string) (config('services.heygen.liveavatar_api_key') ?: config('services.heygen.api_key')));
    $avatarId = trim((string) config('services.heygen.default_avatar_id'));

    $headers = [
        'X-API-KEY' => $apiKey,
        'Accept' => 'application/json',
    ];

    $publicResponse = Http::withHeaders($headers)->get('https://api.liveavatar.com/v1/avatars/public');
    $customResponse = Http::withHeaders($headers)->get('https://api.liveavatar.com/v1/avatars/custom');

    $findAvatar = function ($payload) use ($avatarId) {
        if ($avatarId === '') {
            return false;
        }

        $stack = [$payload];
        while ($stack) {
            $current = array_pop($stack);
            if (!is_array($current)) {
                continue;
            }

            if (($current['avatar_id'] ?? null) === $avatarId || ($current['id'] ?? null) === $avatarId) {
                return true;
            }

            foreach ($current as $value) {
                if (is_array($value)) {
                    $stack[] = $value;
                }
            }
        }

        return false;
    };

    $publicJson = $publicResponse->json() ?? [];
    $customJson = $customResponse->json() ?? [];

    return response()->json([
        'success' => $publicResponse->successful() && $customResponse->successful(),
        'configured_avatar_id' => $avatarId,
        'avatar_exists_in_public' => $findAvatar($publicJson),
        'avatar_exists_in_custom' => $findAvatar($customJson),
        'checks' => [
            'avatar_id_exists_in_liveavatar' => $findAvatar($publicJson) || $findAvatar($customJson),
            'verify_context_is_active_published' => 'Check LiveAvatar dashboard context status.',
            'verify_voice_attached_to_context' => 'Check LiveAvatar dashboard voice/context setup.',
            'verify_account_credits' => 'Check LiveAvatar billing/credits/trial.',
            'verify_sandbox_and_concurrency' => 'Check sandbox mode and concurrency limits.',
        ],
        'public_avatars' => [
            'status' => $publicResponse->status(),
            'body' => $publicJson ?: $publicResponse->body(),
        ],
        'custom_avatars' => [
            'status' => $customResponse->status(),
            'body' => $customJson ?: $customResponse->body(),
        ],
    ]);
});

Route::get('/dev/liveavatar/config-check', function () {
    abort_unless(app()->environment('local'), 404);

    $apiKey = trim((string) (config('services.heygen.liveavatar_api_key') ?: config('services.heygen.api_key')));
    $avatarId = trim((string) config('services.heygen.default_avatar_id'));
    $voiceId = trim((string) config('services.heygen.default_voice_id'));
    $contextId = trim((string) config('services.heygen.default_context_id'));
    $baseUrl = rtrim((string) config('services.heygen.base_url', 'https://api.liveavatar.com'), '/');

    $embedPayloadPreview = [
        'avatar_id' => $avatarId,
        'context_id' => $contextId,
        'is_sandbox' => false,
        'orientation' => 'horizontal',
    ];

    $headers = [
        'X-API-KEY' => $apiKey,
        'Accept' => 'application/json',
    ];

    $avatarResponse = $avatarId !== '' ? Http::withHeaders($headers)->get("{$baseUrl}/v1/avatars/{$avatarId}") : null;
    $voiceResponse = $voiceId !== '' ? Http::withHeaders($headers)->get("{$baseUrl}/v1/voices/{$voiceId}") : null;
    $contextResponse = $contextId !== '' ? Http::withHeaders($headers)->get("{$baseUrl}/v1/contexts/{$contextId}") : null;

    $avatarsResponse = Http::withHeaders($headers)->get("{$baseUrl}/v1/avatars");
    $voicesResponse = Http::withHeaders($headers)->get("{$baseUrl}/v1/voices");
    $contextsResponse = Http::withHeaders($headers)->get("{$baseUrl}/v1/contexts");

    $findId = function ($payload, string $id): bool {
        if ($id === '') {
            return false;
        }

        $stack = [$payload];
        while ($stack) {
            $current = array_pop($stack);
            if (!is_array($current)) {
                continue;
            }

            if (($current['id'] ?? null) === $id || ($current['avatar_id'] ?? null) === $id || ($current['voice_id'] ?? null) === $id || ($current['context_id'] ?? null) === $id) {
                return true;
            }

            foreach ($current as $value) {
                if (is_array($value)) {
                    $stack[] = $value;
                }
            }
        }

        return false;
    };

    $avatarsJson = $avatarsResponse->json() ?? [];
    $voicesJson = $voicesResponse->json() ?? [];
    $contextsJson = $contextsResponse->json() ?? [];

    $avatarFound = ($avatarResponse?->successful() ?? false) || $findId($avatarsJson, $avatarId);
    $voiceFound = ($voiceResponse?->successful() ?? false) || $findId($voicesJson, $voiceId);
    $contextFound = ($contextResponse?->successful() ?? false) || $findId($contextsJson, $contextId);

    return response()->json([
        'success' => $avatarFound && $voiceFound && $contextFound,
        'api_base_url' => $baseUrl,
        'liveavatar_api_key_exists' => trim((string) config('services.heygen.liveavatar_api_key')) !== '',
        'resolved' => [
            'avatar_id' => $avatarId,
            'voice_id' => $voiceId,
            'context_id' => $contextId,
        ],
        'embed_payload_preview' => $embedPayloadPreview,
        'avatar_found' => $avatarFound,
        'voice_found' => $voiceFound,
        'context_found' => $contextFound,
        'detail_responses' => [
            'avatar' => [
                'status' => $avatarResponse?->status(),
                'body' => $avatarResponse ? ($avatarResponse->json() ?? $avatarResponse->body()) : 'Missing HEYGEN_DEFAULT_AVATAR_ID.',
            ],
            'voice' => [
                'status' => $voiceResponse?->status(),
                'body' => $voiceResponse ? ($voiceResponse->json() ?? $voiceResponse->body()) : 'Missing HEYGEN_DEFAULT_VOICE_ID.',
            ],
            'context' => [
                'status' => $contextResponse?->status(),
                'body' => $contextResponse ? ($contextResponse->json() ?? $contextResponse->body()) : 'Missing HEYGEN_DEFAULT_CONTEXT_ID.',
            ],
        ],
        'list_responses' => [
            'avatars' => ['status' => $avatarsResponse->status(), 'body' => $avatarsJson ?: $avatarsResponse->body()],
            'voices' => ['status' => $voicesResponse->status(), 'body' => $voicesJson ?: $voicesResponse->body()],
            'contexts' => ['status' => $contextsResponse->status(), 'body' => $contextsJson ?: $contextsResponse->body()],
        ],
    ]);
});

Route::get('/dev/liveavatar/validate-config', function () {
    abort_unless(app()->environment('local'), 404);

    $apiKey = trim((string) (config('services.heygen.liveavatar_api_key') ?: config('services.heygen.api_key')));
    $avatarId = trim((string) config('services.heygen.default_avatar_id'));
    $voiceId = trim((string) config('services.heygen.default_voice_id'));
    $contextId = trim((string) config('services.heygen.default_context_id'));

    $headers = [
        'X-API-KEY' => $apiKey,
        'Accept' => 'application/json',
    ];

    $avatarResponse = $avatarId !== ''
        ? Http::withHeaders($headers)->get("https://api.liveavatar.com/v1/avatars/{$avatarId}")
        : null;
    $voiceResponse = $voiceId !== ''
        ? Http::withHeaders($headers)->get("https://api.liveavatar.com/v1/voices/{$voiceId}")
        : null;
    $contextResponse = $contextId !== ''
        ? Http::withHeaders($headers)->get("https://api.liveavatar.com/v1/contexts/{$contextId}")
        : null;

    $avatarExists = $avatarResponse?->successful() ?? false;
    $voiceExists = $voiceResponse?->successful() ?? false;
    $contextExists = $contextResponse?->successful() ?? false;
    $allValid = $avatarExists && $voiceExists && $contextExists;

    return response()->json([
        'success' => $allValid,
        'message' => $allValid ? 'LiveAvatar config is valid.' : 'Invalid LiveAvatar config: avatar/voice/context not found.',
        'configured' => [
            'avatar_id' => $avatarId,
            'voice_id' => $voiceId,
            'context_id' => $contextId,
        ],
        'exists' => [
            'avatar' => $avatarExists,
            'voice' => $voiceExists,
            'context' => $contextExists,
        ],
        'responses' => [
            'avatar' => [
                'status' => $avatarResponse?->status(),
                'body' => $avatarResponse ? ($avatarResponse->json() ?? $avatarResponse->body()) : 'Missing HEYGEN_DEFAULT_AVATAR_ID.',
            ],
            'voice' => [
                'status' => $voiceResponse?->status(),
                'body' => $voiceResponse ? ($voiceResponse->json() ?? $voiceResponse->body()) : 'Missing HEYGEN_DEFAULT_VOICE_ID.',
            ],
            'context' => [
                'status' => $contextResponse?->status(),
                'body' => $contextResponse ? ($contextResponse->json() ?? $contextResponse->body()) : 'Missing HEYGEN_DEFAULT_CONTEXT_ID.',
            ],
        ],
    ], $allValid ? 200 : 422);
});

Route::post('/dev/liveavatar/test-embed', function () {
    abort_unless(app()->environment('local'), 404);

    $apiKey = trim((string) (config('services.heygen.liveavatar_api_key') ?: config('services.heygen.api_key')));
    $avatarId = trim((string) config('services.heygen.default_avatar_id'));
    $voiceId = trim((string) config('services.heygen.default_voice_id'));
    $contextId = trim((string) config('services.heygen.default_context_id'));

    if ($avatarId === '' || $contextId === '') {
        return response()->json([
            'success' => false,
            'message' => 'Test embed requires HEYGEN_DEFAULT_AVATAR_ID and HEYGEN_DEFAULT_CONTEXT_ID.',
            'avatar_id_present' => $avatarId !== '',
            'context_id_present' => $contextId !== '',
            'voice_id_present' => $voiceId !== '',
        ], 422);
    }

    $payload = [
        'avatar_id' => $avatarId,
        'context_id' => $contextId,
        'is_sandbox' => false,
        'orientation' => 'horizontal',
    ];

    $response = Http::withHeaders([
        'X-API-KEY' => $apiKey,
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ])->post('https://api.liveavatar.com/v2/embeddings', $payload);

    return response()->json([
        'success' => $response->successful(),
        'endpoint_url' => 'https://api.liveavatar.com/v2/embeddings',
        'payload' => $payload,
        'status' => $response->status(),
        'body' => $response->json() ?? $response->body(),
        'embed_url' => data_get($response->json(), 'data.url'),
        'embed_script' => data_get($response->json(), 'data.script'),
    ], $response->successful() ? 200 : 422);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/educonecx-academy', [EduconecxAcademyController::class, 'index'])->name('educonecx.academy.index');
    Route::post('/educonecx-academy/liveavatar/token', [EduconecxAcademyController::class, 'createLiveAvatarToken'])->name('educonecx.academy.liveavatar.token');
    Route::post('/educonecx-academy/liveavatar/embed', [EduconecxAcademyController::class, 'createLiveAvatarEmbed'])->name('educonecx.academy.liveavatar.embed');
    Route::post('/educonecx-academy/session/evaluate', [EduconecxAcademyController::class, 'evaluateSession'])->name('educonecx.academy.session.evaluate');
    Route::post('/educonecx-academy/session/evaluate-audio', [EduconecxAcademyController::class, 'evaluateAudioSession'])->name('educonecx.academy.session.evaluate.audio');
    Route::post('/educonecx-academy/session/end', [EduconecxAcademyController::class, 'endSession'])->name('educonecx.academy.session.end');
});
