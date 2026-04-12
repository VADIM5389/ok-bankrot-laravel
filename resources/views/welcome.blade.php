@extends('layout.index')

@section('main')
<div class="welcome-page">
    <div class="welcome-container">
        <h1 class="Title">Почему стоит обратиться именно к нам</h1>

        <div class="welcome-section">
            <div class="welcome-section__image">
                <img src="https://assets.entrepreneur.com/content/3x2/2000/20160323151049-salesperson-men-coworkers-rep-hire-selling-agreement-handshake-successful.jpeg" alt="Опыт и результаты">
            </div>
            <div class="welcome-section__content">
                <h2>Более 800 успешно завершённых дел</h2>
                <p>
                    Наша команда профессионалов имеет богатый опыт в сопровождении процедур банкротства.
                    Мы уже помогли более 800 клиентам избавиться от долгов и начать финансовую жизнь
                    с чистого листа, гарантируя индивидуальный подход к каждому делу.
                </p>
            </div>
        </div>

        <div class="welcome-section welcome-section--reverse">
            <div class="welcome-section__image">
                <img src="https://img.freepik.com/premium-photo/hand-drawing-chart-graph-stock-growth_158104-911.jpg" alt="Максимальный шанс на успех">
            </div>
            <div class="welcome-section__content">
                <h2>Высокая вероятность положительного результата</h2>
                <p>
                    Мы тщательно анализируем каждую ситуацию и применяем проверенные стратегии,
                    чтобы обеспечить максимальный шанс успешного завершения процедуры банкротства.
                    Наш профессионализм — ваша гарантия.
                </p>
            </div>
        </div>

        <div class="welcome-section">
            <div class="welcome-section__image">
                <img src="https://i.pinimg.com/originals/a7/45/b7/a745b716d6950074fb0a9f96467a4c5b.png" alt="Комплексный подход">
            </div>
            <div class="welcome-section__content">
                <h2>Комплексная поддержка на всех этапах</h2>
                <p>
                    Мы сопровождаем клиентов на всех стадиях процедуры: от консультации и сбора
                    документов до завершения банкротства. Это позволяет снизить стресс и минимизировать
                    риски, обеспечивая прозрачность процесса.
                </p>
            </div>
        </div>

        <div class="welcome-section welcome-section--reverse">
            <div class="welcome-section__image">
                <img src="https://avatars.dzeninfra.ru/get-zen_doc/1811900/pub_5d91016aa06eaf00ae8b0187_5d91d685028d6800aece3694/scale_1200" alt="Гибкие условия">
            </div>
            <div class="welcome-section__content">
                <h2>Гибкие условия сотрудничества и прозрачное ценообразование</h2>
                <p>
                    Мы предлагаем прозрачные условия сотрудничества без скрытых платежей.
                    Все этапы работы обсуждаются заранее, а цены остаются фиксированными —
                    никакого стресса и неприятных сюрпризов.
                </p>
            </div>
        </div>

        <section class="reviews-section">
            <h2 class="reviews-title">Отзывы клиентов</h2>

            <div class="swiper reviewsSwiper">
                <div class="swiper-wrapper">

                    {{-- Статические отзывы --}}
                    <div class="swiper-slide">
                        <div class="review-card">
                            <h3>Жанна Александрова</h3>
                            <div class="stars">★★★★★</div>
                            <p>Очень надежные и порядочные профессионалы своего дела!</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="review-card">
                            <h3>Константин Бражнов</h3>
                            <div class="stars">★★★★★</div>
                            <p>Благодарю "ОК Банкрот" за помощь. Профессионалы своего дела. Всё просто и прозрачно, без скрытых расходов. Даже после завершения процедуры остаются на связи и помогают.</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="review-card">
                            <h3>Александр Пузырев</h3>
                            <div class="stars">★★★★★</div>
                            <p>Ольга Валерьевна и Андрей Иванович, спасибо вам огромное! Профессионалы своего дела. Подкупила честность и подробное объяснение всех нюансов без “сказок”.</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="review-card">
                            <h3>Лидия Пухова</h3>
                            <div class="stars">★★★★★</div>
                            <p>Очень долго сомневалась, но очень рада, что обратилась именно к вам. Спасибо большое за вашу работу 😊</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="review-card">
                            <h3>Надежда Сорокина</h3>
                            <div class="stars">★★★★★</div>
                            <p>Большие профессионалы! Всё прошло отлично, очень рекомендую.</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="review-card">
                            <h3>Ирина</h3>
                            <div class="stars">★★★★★</div>
                            <p>Очень рекомендую выбрать именно эту компанию. Всё подскажут, расскажут, всегда на связи, с ними была уверенность в положительном завершении.</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="review-card">
                            <h3>Наталья Горчакова</h3>
                            <div class="stars">★★★★★</div>
                            <p>Выражаю огромную благодарность за помощь в списании долгов. Очень хорошие люди и отличные специалисты.</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="review-card">
                            <h3>Галичина Екатерина</h3>
                            <div class="stars">★★★★★</div>
                            <p>Очень хорошие сотрудники, всё прошло отлично, долги списались быстро. Рекомендую!</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="review-card">
                            <h3>Александр Новиков</h3>
                            <div class="stars">★★★★★</div>
                            <p>Благодарю всю компанию и сотрудников за помощь в списании долгов. Работали и держали обратную связь на протяжении всей процедуры.</p>
                        </div>
                    </div>

                    {{-- Отзывы из БД, одобренные модерацией --}}
                    @if(isset($reviews) && $reviews->count())
                        @foreach($reviews as $review)
                            <div class="swiper-slide">
                                <div class="review-card">
                                    <h3>{{ $review->name }}</h3>
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </div>
                                    <p>{{ $review->text }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>

                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev reviews-prev"></div>
                <div class="swiper-button-next reviews-next"></div>
            </div>
        </section>
    </div>

    <div class="welcome-container">
        <section class="steps-section">
            <h2 class="steps-title">Этапы процедуры банкротства</h2>

            <div class="steps-grid">

                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3>Анализ ситуации</h3>
                    <p>
                        Оцениваем финансовое положение, долги и платежеспособность.
                        Определяем, подходит ли процедура банкротства.
                    </p>
                </div>

                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3>Подача заявления</h3>
                    <p>
                        Подготавливаем документы и подаём заявление в суд.
                        Формируем полный пакет данных о доходах и долгах.
                    </p>
                </div>

                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3>Запуск процедуры</h3>
                    <p>
                        Суд вводит процедуру банкротства и назначает управляющего,
                        который сопровождает процесс.
                    </p>
                </div>

            </div>
        </section>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.reviewsSwiper', {
            loop: true,
            spaceBetween: 20,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.reviews-next',
                prevEl: '.reviews-prev',
            },
            breakpoints: {
                0: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                }
            }
        });
    });
</script>
@endsection