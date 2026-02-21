<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page Routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/academy', [PageController::class, 'academy'])->name('academy');
Route::get('/neo-ed-tech', [PageController::class, 'neoEdTech'])->name('neo-ed-tech');
Route::get('/our-team', [PageController::class, 'ourTeam'])->name('our-team');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/crowd-quiz', [PageController::class, 'quiz'])->name('quiz');
Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
Route::get('/membership-pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/refund-policy', [PageController::class, 'refund'])->name('refund');
Route::get('/terms-conditions', [PageController::class, 'terms'])->name('terms');

// Course Routes
Route::get('/courses', [CourseController::class, 'index'])->name('courses');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/course-category/{slug}', [CourseController::class, 'category'])->name('courses.category');
Route::post('/courses/filter', [CourseController::class, 'filter'])->name('courses.filter');

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');