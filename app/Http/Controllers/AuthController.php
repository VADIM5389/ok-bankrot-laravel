<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{

    public function showRegister(){
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

        $user = \App\Models\User::create([
            'email' => $validated['email'],
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
            'role' => 'user',
        ]);

        auth()->login($user);

        return redirect()->route('account')->with('success', 'Регистрация прошла успешно.');
    }

    public function showLogin(){
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

        return redirect()->route('account');
    }

   

    public function logout()
    {
        Auth::logout();
        return redirect()->route('main');
    }
}