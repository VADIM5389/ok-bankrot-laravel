@extends('layout.index')
@section('main')

<div class="about-compact">
    <div class="compact-hero">
        <h1>О нашей компании</h1>
        <p>Помогаем обрести финансовую свободу через банкротство физических лиц</p>
    </div>

    <div class="compact-content">
        <div class="main-info">
            <h2>Что мы делаем</h2>
            <p>Специализируемся на сопровождении процедуры банкротства физических лиц. Помогаем законно списать долги и начать жизнь с чистого листа.</p>
            
            <h2>Почему выбирают нас</h2>
            <div class="advantages-compact">
                <div class="advantage-item">
                    <span class="advantage-icon">⚡</span>
                    <div>
                        <strong>Быстро</strong>
                        <p>Процедура от 3 до 9 месяцев</p>
                    </div>
                </div>
                <div class="advantage-item">
                    <span class="advantage-icon">🛡️</span>
                    <div>
                        <strong>Надежно</strong>
                        <p>Гарантия конфиденциальности</p>
                    </div>
                </div>
                <div class="advantage-item">
                    <span class="advantage-icon">💼</span>
                    <div>
                        <strong>Профессионально</strong>
                        <p>Опытные юристы и финансовые управляющие</p>
                    </div>
                </div>
                <div class="advantage-item">
                    <span class="advantage-icon">💰</span>
                    <div>
                        <strong>Выгодно</strong>
                        <p>Прозрачные цены, рассрочка платежа</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="stats-compact">
            <div class="stat-card">
                <div class="stat-number">500+</div>
                <div class="stat-desc">успешных дел о банкротстве</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">95%</div>
                <div class="stat-desc">положительных решений суда</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">7 лет</div>
                <div class="stat-desc">опыта работы в банкротстве</div>
            </div>
        </div>
    </div>

    <div class="compact-cta">
        <h3>Готовы избавиться от долгов?</h3>
        <p>Оставьте заявку и получите бесплатную консультацию</p>
        <a href="#ex1"><button class="cta-btn">Получить консультацию</button></a>
    </div>
</div>

<style>

</style>

@endsection