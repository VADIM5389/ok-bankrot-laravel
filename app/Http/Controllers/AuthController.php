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

    public function register(Request $request){

        $validate = $request->validate([
            'email' => 'required:unique:users',
        ], ['email.unique'=>'Эта почта уже занята!'
        ]);
        $password = Hash::make($request->password);

        // Создаем нового пользователя
        User::create([

            'email' => $request->email,
            'full_name' => $request->full_name,
            'phone' => $request->phone,            
            'password' => $password,
        ]);

        // Можно выполнить вход пользователя или перенаправить
        return redirect('/')->with('success', 'Регистрация прошла успешно.');
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