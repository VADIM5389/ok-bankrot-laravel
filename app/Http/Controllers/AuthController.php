<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\user;


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

    public function login(Request $request) {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // ИСПРАВЛЕНО: используем Auth::login() вместо Auth::email()
            Auth::login($user);

            if ($user->role == 'user') {
                return redirect()->route('showAccount')->with('success','Добро пожаловать в личный кабинет пользователя');
            } else {
                return redirect()->route('showAdmin')->with('success','Добро пожаловать в админ панель');
            }
        }
        
        // ИСПРАВЛЕНО: заменил 'email' на правильный маршрут для формы входа
        return redirect()->route('showLogin')->with('error','Неверный логин или пароль!');
    }

   

    public function logout()
    {
        Auth::logout();
        return redirect()->route('main');
    }
}