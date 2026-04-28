@extends('layout.index')

@section('main')
<div class="verify-page">
    <div class="verify-card">
        <h1>Подтверждение почты</h1>

        @if(session('success'))
            <div class="verify-alert success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="verify-alert warning">
                {{ session('warning') }}
            </div>
        @endif

        <p>
            Регистрация почти завершена. Мы отправили письмо со ссылкой для подтверждения на вашу электронную почту.
        </p>

        <p>
            Чтобы пользоваться личным кабинетом, необходимо перейти по ссылке из письма.
        </p>

        <form action="{{ route('verification.send') }}" method="POST">
            @csrf
            <button type="submit" class="verify-btn">
                Отправить письмо повторно
            </button>
        </form>

        <form action="{{ route('logout') }}" method="POST" class="verify-logout">
            @csrf
            <button type="submit">
                Выйти из аккаунта
            </button>
        </form>
    </div>
</div>
@endsection