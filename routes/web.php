<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\CallbackRequestController;
use App\Http\Controllers\ReviewController;
use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Основные страницы сайта
|--------------------------------------------------------------------------
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
|--------------------------------------------------------------------------
| Калькулятор
|--------------------------------------------------------------------------
*/

Route::get('/calculator', [CalculatorController::class, 'index'])
    ->name('calculator');

Route::post('/calculator', [CalculatorController::class, 'calculate'])
    ->name('calculator.calculate');

/*
|--------------------------------------------------------------------------
| Авторизация и регистрация
|--------------------------------------------------------------------------
*/

Route::get('/register', [AuthController::class, 'showRegister'])
    ->middleware('guest')
    ->name('showRegister');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest')
    ->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('showLogin');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Восстановление пароля
|--------------------------------------------------------------------------
*/

Route::get('/forgot-password', function () {
    return view('forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
    ], [
        'email.required' => 'Введите email.',
        'email.email' => 'Введите корректный email.',
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::ResetLinkSent
        ? back()->with('success', 'Ссылка для восстановления пароля отправлена на указанную почту.')
        : back()->withErrors(['email' => 'Пользователь с таким email не найден.']);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token, Request $request) {
    return view('reset-password', [
        'token' => $token,
        'email' => $request->email,
    ]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => ['required'],
        'email' => ['required', 'email'],
        'password' => ['required', 'string', 'min:6', 'confirmed'],
    ], [
        'email.required' => 'Введите email.',
        'email.email' => 'Введите корректный email.',
        'password.required' => 'Введите новый пароль.',
        'password.min' => 'Пароль должен содержать не менее 6 символов.',
        'password.confirmed' => 'Пароли не совпадают.',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PasswordReset
        ? redirect()->route('main')->with('success', 'Пароль успешно изменён. Теперь вы можете войти в аккаунт.')
        : back()->withErrors(['email' => 'Не удалось изменить пароль. Возможно, ссылка устарела.']);
})->middleware('guest')->name('password.update');

/*
|--------------------------------------------------------------------------
| Подтверждение почты
|--------------------------------------------------------------------------
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
|--------------------------------------------------------------------------
| Заявка на обратный звонок
|--------------------------------------------------------------------------
*/

Route::post('/callback-request', [CallbackRequestController::class, 'store'])
    ->name('callback-request.store');

/*
|--------------------------------------------------------------------------
| Личный кабинет и отзывы
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/account', [AccountController::class, 'showAccount'])
        ->name('account');

    Route::post('/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');
});

/*
|--------------------------------------------------------------------------
| Админ-панель
|--------------------------------------------------------------------------
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

        Route::delete('/requests/{callbackRequest}', [AdminController::class, 'deleteRequest'])
            ->name('requests.delete');

        Route::get('/reviews', [AdminController::class, 'reviews'])
            ->name('reviews');

        Route::post('/reviews/{review}/status', [AdminController::class, 'updateReviewStatus'])
            ->name('reviews.status');

        Route::get('/users', [AdminController::class, 'users'])
            ->name('users');

        Route::post('/users/{user}/role', [AdminController::class, 'updateUserRole'])
            ->name('users.role');
    });