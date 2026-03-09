<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Валидация данных
        $validate 

        $request->validate([
            'email' => 'required|email|unique:users,email',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|text|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Создаем нового пользователя
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Можно выполнить вход пользователя или перенаправить
        return redirect('/login')->with('success', 'Регистрация прошла успешно. Войдите на сайт.');
    }
}

