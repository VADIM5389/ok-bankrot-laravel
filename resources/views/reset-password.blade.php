@extends('layout.index')

@section('main')
<div class="auth-page">
    <div class="auth-card">
        <h1>Новый пароль</h1>

        @if($errors->any())
            <div class="auth-alert error">
                {{ $errors->first() }}
            </div>
        @endif

        <p>
            Придумайте новый пароль для входа в личный кабинет.
        </p>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="auth-form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $email) }}"
                    required
                >
            </div>

            <div class="auth-form-group">
                <label for="password">Новый пароль</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Введите новый пароль"
                    required
                >
            </div>

            <div class="auth-form-group">
                <label for="password_confirmation">Повторите пароль</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Повторите новый пароль"
                    required
                >
            </div>

            <button type="submit" class="auth-submit-btn">
                Сохранить новый пароль
            </button>
        </form>
    </div>
</div>
@endsection