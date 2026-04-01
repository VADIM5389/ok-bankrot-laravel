<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\CallbackRequestController;
use App\Http\Controllers\ReviewController;
use App\Models\Review;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $reviews = Review::where('status', 'approved')->latest()->take(9)->get();
    return view('welcome', compact('reviews'));
})->name('main');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator');
Route::post('/calculator', [CalculatorController::class, 'calculate'])->name('calculator.calculate');

Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/callback-request', [CallbackRequestController::class, 'store'])->name('callback-request.store');

Route::get('/', function () {
    $reviews = Review::where('status', 'approved')->latest()->get();
    return view('welcome', compact('reviews'));
})->name('main');

Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'showAccount'])->name('account');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/requests', [AdminController::class, 'requests'])->name('admin.requests');
    Route::post('/admin/requests/{callbackRequest}/status', [AdminController::class, 'updateRequestStatus'])->name('admin.requests.status');

    Route::get('/admin/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
    Route::post('/admin/reviews/{review}/status', [AdminController::class, 'updateReviewStatus'])->name('admin.reviews.status');

    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.role');
});