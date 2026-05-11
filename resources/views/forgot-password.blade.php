@extends('layout.index')

@section('main')
<div class="auth-page">
    <div class="auth-card">
        <h1>Восстановление пароля</h1>

        @if(session('success'))
            <div class="auth-alert success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="auth-alert error">
                {{ $errors->first() }}
            </div>
        @endif

        <p>
            Введите email, указанный при регистрации. Мы отправим ссылку для сброса пароля.
        </p>

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div class="auth-form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Введите email"
                    required
                >
            </div>

            <button type="submit" class="auth-submit-btn">
                Отправить ссылку
            </button>
        </form>

        <div class="auth-switch">
            Вспомнили пароль?
            <a href="{{ route('showLogin') }}">Войти в аккаунт</a>
        </div>
    </div>
</div>
@endsection