<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ОК-банкрот|Главная</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Remember to include jQuery :) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
</head>
<body>
    <header class="site-header">
    <div class="header-top">
        <a href="{{ route('main') }}" class="logo-link">
            <img src="https://static.tildacdn.com/tild6335-3635-4135-b737-656238303137/logo.png" alt="logo" class="site-logo">
        </a>
    </div>

    <div class="header">
        <div class="header-inner">
            <button class="burger" id="burgerBtn" type="button" aria-label="Открыть меню">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="nav-menu" id="navMenu">
                <a href="{{ route('about') }}">О компании</a>
                <a href="{{ route('Contacts') }}">Контакты</a>
                <a href="{{ route('faq') }}">FAQ</a>

                @guest
                    <a href="#ex2" rel="modal:open">Авторизация</a>
                    <a href="#ex3" rel="modal:open">Регистрация</a>
                @endguest

                @auth
                    @if (auth()->user()->role !== 'admin')
                        <a href="{{ route('calculator') }}">Калькулятор банкротства</a>
                        <a href="{{ route('account') }}">Личный кабинет</a>
                        <a href="{{ route('about') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Выход
                        </a>
                    @endif

                    @if (auth()->user()->role == 'admin')
                        <a href="{{ route('about') }}">Админ панель</a>
                        <a href="{{ route('about') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Выход
                        </a>
                    @endif

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth
            </nav>

            <div class="header-actions">
                <a href="#ex1" rel="modal:open" class="order_a_call">Заказать звонок</a>
            </div>
        </div>
    </div>

    {{-- Модальные окна --}}

        {{-- Модальные окна --}}

        {{-- Оставить заявку на консультацию --}}
        <div id="ex1" class="modal">
            <h2 class="Title">Оставить заявку на консультацию</h2>
            <form action="" method="" class="modal_form">

                @csrf
                <label for="">ФИО </label>
                <input type="text"  name="full_name" placeholder="Иванов Иван Иванович" required>

                <label for="">Телефон </label>
                <input type="text" class="phone" id="phone" name="phone" placeholder="+7 (___) ___-__-__" required>

                <input type="submit" value="отправить" >
            </form>
            <a href="#" rel="modal:close">Close</a>
        </div>
        {{-- Авторизация --}}
        <div id="ex2" class="modal">
            <h2 class="Title">Авторизация</h2>
            <form action="{{ route('login') }}" method="POST" class="modal_form">

                @csrf

                <label>Email:</label><br>
                <input type="email" name="email" required><br>

                <label>Пароль:</label><br>
                <input type="password" name="password" required><br><br>

                <input type="submit" class="registration_button" value="Войти">

            </form>
            <a href="#" rel="modal:close">Close</a>
        </div>
        {{-- Регистрация --}}
        <div id="ex3" class="modal">
            <h2 class="Title">Регистрация</h2>
            <form action="{{ route('register') }} " method="POST" class="modal_form">

                @csrf

                <label>Email:</label><br>
                <input type="email" name="email" required><br>

                <label>ФИО:</label><br>
                <input type="text" name="full_name" required><br>

                <label>Телефон: </label>
                <input type="text" id="phone" class="phone" name="phone" placeholder="+7 (___) ___-__-__" required><br>

                <label>Пароль:</label><br>
                <input type="password" name="password" required><br><br>

                <input type="submit" class="registration_button" value="Зарегистрироваться">
            </form>
            <a href="#" rel="modal:close">Close</a>
        </div>
        {{-- Конец модальных окон --}}
    </header>

    <main>  
        @yield('main')
        @if (session('success'))
            <div class="message-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="message-error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="message-validate">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
    </main>

    <footer>
        Все права защищены 
    </footer>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>

<script>
    $(document).ready(function(){
        $('.phone').inputmask({
            mask: '+7 (999) 999-99-99',
            placeholder:'_',
            clearMaskOnLostFocus: false
        });

        $('#burgerBtn').on('click', function () {
            $('#navMenu').toggleClass('active');
            $(this).toggleClass('active');
        });
    });
</script>


</body>
</html>