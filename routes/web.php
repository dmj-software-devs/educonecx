<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/academy', [PageController::class, 'academy'])->name('academy');
Route::get('/neo-ed-tech', [PageController::class, 'neoEdTech'])->name('neo-ed-tech');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/our-team', [PageController::class, 'ourTeam'])->name('our-team');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/courses', [PageController::class, 'courses'])->name('courses');
Route::get('/crowd-quiz', [PageController::class, 'quiz'])->name('quiz');
Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
Route::get('/membership-pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/refund-policy', [PageController::class, 'refund'])->name('refund');
Route::get('/terms-conditions', [PageController::class, 'terms'])->name('terms');