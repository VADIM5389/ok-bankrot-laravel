@extends('layout.index')

@section('main')
<div class="services-page">
    <div class="services-container">
        <h1 class="services-title">Наши услуги</h1>
        <p class="services-subtitle">
            Мы оказываем юридическую помощь по вопросам списания долгов, банкротства и защиты интересов клиентов.
        </p>

        <div class="services-grid">

            <div class="service-card">
                <div class="service-card__image">
                    <img src="https://sun9-69.userapi.com/s/v1/ig2/EmAG0bZ_wYoclzwkGL3faB1D04Yp6xeb8untEcb-WYWA5wyf3PHRqd9Uvj5XXrr_rLqIGmKDofRVCKsqNGTpwdVz.jpg?quality=96&as=32x32,48x48,72x72,108x108,160x160,240x240,360x360,480x480,540x540,640x640,720x720,1080x1080&from=bu&u=9mCEYHc7FzAKqTGFWZfsyR85US6wng_8rK-aEQO8vA0&cs=540x0" alt="Консультация">
                </div>
                <div class="service-card__content">
                    <h2>Консультация</h2>
                    <div class="service-price">Бесплатно</div>
                    <p>
                        Первичная консультация по вопросам банкротства, задолженности и возможным способам решения финансовых проблем.
                    </p>
                    <a href="#ex1" rel="modal:open" class="service-btn">Заказать звонок</a>
                </div>
            </div>

            <div class="service-card">
                <div class="service-card__image">
                    <img src="https://sun9-3.userapi.com/s/v1/ig2/bGjR6yBl1EsL5e6yoyMjVnvCkX-cM23OF3oZMsoo2K2lTMBcZ9Bxaqz0v84lGqo-YZMRpyi-9_xKSO9Fsat59w-B.jpg?quality=96&as=32x32,48x48,72x72,108x108,160x160,240x240,360x360,480x480,540x540,640x640,720x720,1080x1080&from=bu&u=O1oJpLOIWZ3i6OgK7KjzSi7XH-45EsIUTzWEwNpK8OI&cs=540x0" alt="Внесудебное банкротство">
                </div>
                <div class="service-card__content">
                    <h2>Внесудебное банкротство</h2>
                    <div class="service-price">от 10 000 ₽</div>
                    <p>
                        Сопровождение процедуры внесудебного банкротства, подготовка документов и помощь на всех этапах обращения.
                    </p>
                    <a href="#ex1" rel="modal:open" class="service-btn">Заказать звонок</a>
                </div>
            </div>

            <div class="service-card">
                <div class="service-card__image">
                    <img src="https://sun9-11.userapi.com/s/v1/ig2/YgOhir25GC6PJqCjZb0FeUFYxFIshGJLP5WQPZrXhKIK9hgs6PkvHDOKOxLDx3klp-v4VauyQN8JuoCwlEtVKJbl.jpg?quality=96&as=32x32,48x48,72x72,108x108,160x160,240x240,360x360,480x480,540x540,640x640,720x720,1080x1080&from=bu&u=8Q-r1KCfdFNeHAzyEFIG-Gj-yZmRi9zOfKxjSnni_KM&cs=540x0" alt="Банкротство физических лиц">
                </div>
                <div class="service-card__content">
                    <h2>Банкротство физических лиц</h2>
                    <div class="service-price">от 80 000 ₽</div>
                    <p>
                        Полное юридическое сопровождение процедуры банкротства физического лица с учётом особенностей конкретной ситуации.
                    </p>
                    <a href="#ex1" rel="modal:open" class="service-btn">Заказать звонок</a>
                </div>
            </div>

            <div class="service-card">
                <div class="service-card__image">
                    <img src="https://sun9-27.userapi.com/s/v1/ig2/UMED5u5GIJ1UDh_KsM63EEgyPdD42hY1xnxUAEC38Ys0HLcnoK4QapUXwmwdhGX6mjYsJKFr2Wpep1zYN4K8EHwP.jpg?quality=96&as=32x32,48x48,72x72,108x108,160x160,240x240,360x360,480x480,540x540,640x640,720x720,1080x1080&from=bu&u=KCApnDGIv9WgSz-GcCWJYQ5Ah2vycZaIjqxJr3XC4jI&cs=540x0" alt="Отмена судебного приказа">
                </div>
                <div class="service-card__content">
                    <h2>Отмена судебного приказа</h2>
                    <div class="service-price">от 1 000 ₽</div>
                    <p>
                        Подготовка необходимых документов и юридическая помощь при отмене судебного приказа в установленные сроки.
                    </p>
                    <a href="#ex1" rel="modal:open" class="service-btn">Заказать звонок</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection