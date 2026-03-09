@extends('layout.index')
@section('main')

    <div class="faq-container">
        <h1 class="faq-title">❓ Часто задаваемые вопросы</h1>
    
        <div class="faq-list">
            <div class="faq-item">
                <div class="faq-question">
                    <span>1. Что такое банкротство физического лица?</span>
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Банкротство — это юридическая процедура, при которой гражданин, не способный выполнять денежные обязательства, освобождается от части или всех долгов на основании решения суда.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>2. Кто может подать заявление о банкротстве?</span>
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Инициатором может быть сам гражданин-должник либо кредитор, если задолженность превышает установленный законом порог (от 300 000 ₽) и просрочка более трёх месяцев.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>3. Какие долги можно списать?</span>
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Займы, кредиты, налоги, штрафы ЖКХ и другие обязательства.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>4. Какие долги не подлежат списанию?</span>
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Алименты, вред здоровью, штрафы за правонарушения.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>5. Сколько времени занимает процедура?</span>
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>6-9 месяцев в суде или около 3 месяцев через МФЦ.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>6. Защищено ли единственное жильё?</span>
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Да, если оно не находится в залоге.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>7. Можно ли выезжать за границу во время процедуры?</span>
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Да, но суд может ввести ограничения.</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');
            
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                
                question.addEventListener('click', () => {
                    // Закрываем все остальные элементы
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item && otherItem.classList.contains('active')) {
                            otherItem.classList.remove('active');
                        }
                    });
                    
                    // Переключаем текущий элемент
                    item.classList.toggle('active');
                });
            });
        });
    </script>
@endsection()
