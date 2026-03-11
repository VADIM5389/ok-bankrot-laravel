<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\CallbackRequestController;




Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::get('/about', function () {
    return view('about'); // возвращает шаблон resources/views/about.blade.php
})->name('about');

Route::get('/Contacts', function () {
    return view('Contacts'); // возвращает шаблон resources/views/contacts.blade.php
})->name('Contacts');

Route::get('/faq', function () {
    return view('faq'); // возвращает шаблон resources/views/faq.blade.php
})->name('faq');

Route::get('/account', function () {
    return view('account'); // возвращает шаблон resources/views/account.blade.php
})->name('account');

Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator'); //открыть страницу калькулятора
Route::post('/calculator', [CalculatorController::class, 'calculate'])->name('calculator.calculate');

Route::get('/register',[AuthController::class, 'showRegister'])->name('showRegister');
Route::post('/register',[AuthController::class, 'register'])->name('register');

Route::get('/login',[AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login',[AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard',[AccountController::class, 'showAccount'])->name('showAccount');

Route::get('/dashboard/admin',[AdminController::class, 'showAdmin'])->name('showAdmin');


Route::post('/callback-request', [CallbackRequestController::class, 'store'])->name('callback-request.store');





