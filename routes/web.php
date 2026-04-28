<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\CallbackRequestController;
use App\Http\Controllers\ReviewController;
use App\Models\Review;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
| Основные страницы сайта
*/

Route::get('/', function () {
    $reviews = Review::where('status', 'approved')->latest()->get();

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

/*
| Калькулятор
*/

Route::get('/calculator', [CalculatorController::class, 'index'])
    ->name('calculator');

Route::post('/calculator', [CalculatorController::class, 'calculate'])
    ->name('calculator.calculate');

/*
| Авторизация и регистрация
*/

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('showRegister');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('showLogin');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
| Подтверждение почты
*/

Route::get('/email/verify', function () {
    return view('verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()
        ->route('account')
        ->with('success', 'Email успешно подтверждён.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'Письмо для подтверждения отправлено повторно.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*

| Заявка на обратный звонок
*/

Route::post('/callback-request', [CallbackRequestController::class, 'store'])
    ->name('callback-request.store');

/*

| Личный кабинет и отзывы
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/account', [AccountController::class, 'showAccount'])
        ->name('account');

    Route::post('/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');
});

/*

| Админ-панель

*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])
            ->name('index');

        Route::get('/requests', [AdminController::class, 'requests'])
            ->name('requests');

        Route::post('/requests/{callbackRequest}/status', [AdminController::class, 'updateRequestStatus'])
            ->name('requests.status');

        Route::get('/reviews', [AdminController::class, 'reviews'])
            ->name('reviews');

        Route::post('/reviews/{review}/status', [AdminController::class, 'updateReviewStatus'])
            ->name('reviews.status');

        Route::get('/users', [AdminController::class, 'users'])
            ->name('users');

        Route::post('/users/{user}/role', [AdminController::class, 'updateUserRole'])
            ->name('users.role');
    });