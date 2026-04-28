<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:25'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',
            'email.unique' => 'Аккаунт с таким email уже существует.',
            'full_name.required' => 'Введите ФИО.',
            'phone.required' => 'Введите телефон.',
            'password.required' => 'Введите пароль.',
            'password.min' => 'Пароль должен содержать не менее 6 символов.',
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
            'role' => 'user',
        ]);

        event(new Registered($user));

        auth()->login($user);

        return redirect()
            ->route('verification.notice')
            ->with('success', 'Регистрация прошла успешно. Подтвердите почту, чтобы пользоваться личным кабинетом.');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',
            'password.required' => 'Введите пароль.',
        ]);

        if (!auth()->attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Аккаунт не найден или указан неверный пароль.');
        }

        $request->session()->regenerate();

        if (!auth()->user()->hasVerifiedEmail()) {
            return redirect()
                ->route('verification.notice')
                ->with('warning', 'Сначала подтвердите адрес электронной почты.');
        }

        return redirect()->route('account');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('main');
    }
}