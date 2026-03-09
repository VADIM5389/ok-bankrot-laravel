@extends('layout.index')
@section('main')
    <div class="contacts-wrapper">
        <div class="contacts-container">
            <div class="contact-info">
                <h2 class="contact-title">Контакты</h2>
                <div class="contact-details">
                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <div class="contact-text">
                            Курган, ул. Коли Мяготина, 56а, оф. 506
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📞</div>
                        <div class="contact-text">
                            <a href="tel:+73522225310" class="contact-phone">+7 (3522) 22-53-10</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">✉️</div>
                        <div class="contact-text">
                            <a href="mailto:kurgan.okbankrot@yandex.ru" class="contact-email">kurgan.okbankrot@yandex.ru</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="map-container">
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A8e17b90550ce078e1e138cf419bbfab7ae90de2c21a2b550800029cca54978d2&amp;source=constructor" frameborder="0"></iframe>
            </div>
        </div>
    </div>
    
@endsection()
