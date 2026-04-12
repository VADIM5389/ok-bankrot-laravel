<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="https://avatars.mds.yandex.net/i?id=c93efa4ee54a2f270564355a35d3daf1_l-9181971-images-thumbs&n=13" type="image/x-icon">
    <link rel="shortcut icon" href="https://avatars.mds.yandex.net/i?id=c93efa4ee54a2f270564355a35d3daf1_l-9181971-images-thumbs&n=13" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />   

    <title>ОК-банкрот|Главная</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask/dist/jquery.inputmask.min.js"></script>
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
                <nav class="nav-menu" id="navMenu">
                    <a href="{{ route('main') }}">Главная</a>
                    <a href="{{ route('about') }}">Почему выбирают нас</a>
                    <a href="{{ route('contacts') }}">Контакты</a>
                    <a href="{{ route('faq') }}">FAQ</a>
                    <a href="{{ route('services') }}">Услуги</a>
                    <a href="{{ route('calculator') }}">Калькулятор</a>

                    @guest
                        <a href="#ex2" rel="modal:open" class="menu-modal-link">Авторизация</a>
                        <a href="#ex3" rel="modal:open" class="menu-modal-link">Регистрация</a>
                    @endguest

                    @auth
                        @if (auth()->user()->role !== 'admin')
                            
                            <a href="{{ route('account') }}">Личный кабинет</a>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Выход
                            </a>
                        @endif

                        @if (auth()->user()->role == 'admin')
                            <a href="{{ route('account') }}">Личный кабинет</a>
                            <a href="{{ route('admin.index') }}">Админ панель</a>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

                    <button class="burger" id="burgerBtn" type="button" aria-label="Открыть меню">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Оставить заявку на консультацию --}}
        <div id="ex1" class="modal custom-modal">
            <h2 class="modal-title">Оставить заявку на консультацию</h2>

            <form action="{{ route('callback-request.store') }}" method="POST" class="modal_form">
                @csrf

                <label>ФИО</label>
                <input
                    type="text"
                    name="full_name"
                    placeholder="Иванов Иван Иванович"
                    value="{{ old('full_name') }}"
                    required
                >

                <label>Телефон</label>
                <input
                    type="text"
                    class="phone"
                    name="phone"
                    placeholder="+7 (___) ___-__-__"
                    value="{{ old('phone') }}"
                    required
                >

                <input type="submit" value="Отправить" class="modal-submit">
            </form>
        </div>

        {{-- Авторизация --}}
        <div id="ex2" class="modal custom-modal">
            <h2 class="modal-title">Авторизация</h2>

            <form action="{{ route('login') }}" method="POST" class="modal_form">
                @csrf

                <label>Email</label>
                <input type="email" name="email" placeholder="Введите email" required>

                <label>Пароль</label>
                <input type="password" name="password" placeholder="Введите пароль" required>

                <input type="submit" class="modal-submit" value="Войти">
            </form>
        </div>

        {{-- Регистрация --}}
        <div id="ex3" class="modal custom-modal">
            <h2 class="modal-title">Регистрация</h2>

            <form action="{{ route('register') }}" method="POST" class="modal_form">
                @csrf

                <label>Email</label>
                <input type="email" name="email" placeholder="Введите email" required>

                <label>ФИО</label>
                <input type="text" name="full_name" placeholder="Иванов Иван Иванович" required>

                <label>Телефон</label>
                <input type="text" class="phone" name="phone" placeholder="+7 (___) ___-__-__" required>

                <label>Пароль</label>
                <input type="password" name="password" placeholder="Введите пароль" required>

                <input type="submit" class="modal-submit" value="Зарегистрироваться">
            </form>
        </div>
    </header>

    <main>
        @yield('main')

    @if (session('success') || session('error') || $errors->any())
        <div class="toast-container" id="toastContainer">
            @if (session('success'))
                <div class="toast toast--success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="toast toast--error">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="toast toast--error">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>
    @endif
    </main>

    <footer>
        Все права защищены
    </footer>

    <script>
        $(document).ready(function () {
            $('.phone').inputmask({
                mask: '+7 (999) 999-99-99',
                placeholder: '_',
                clearMaskOnLostFocus: false
            });

            $('.money').inputmask({
                alias: 'numeric',
                groupSeparator: ' ',
                autoGroup: true,
                digits: 0,
                digitsOptional: false,
                radixPoint: '.',
                allowMinus: false,
                rightAlign: false,
                removeMaskOnSubmit: true,
                placeholder: '',
                showMaskOnHover: false,
                showMaskOnFocus: false
            });

            $('#burgerBtn').on('click', function () {
                $('#navMenu').toggleClass('active');
                $(this).toggleClass('active');
            });

            $('#navMenu a').on('click', function () {
                if (window.innerWidth <= 992) {
                    $('#navMenu').removeClass('active');
                    $('#burgerBtn').removeClass('active');
                }
            });

            $('#navMenu a[rel="modal:open"]').on('click', function () {
                $('#navMenu').removeClass('active');
                $('#burgerBtn').removeClass('active');
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toasts = document.querySelectorAll('.toast');

            if (toasts.length) {
                setTimeout(() => {
                    toasts.forEach(toast => {
                        toast.classList.add('hide');
                    });

                    setTimeout(() => {
                        const container = document.getElementById('toastContainer');
                        if (container) {
                            container.remove();
                        }
                    }, 400);
                }, 4000);
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>
</html>