@extends('layout.index')

@section('main')
<div class="calculator-page">
    <div class="calculator-container">
        <h1 class="calculator-title">Калькулятор оценки финансового положения</h1>

        <p class="calculator-subtitle">
            Заполните данные ниже, чтобы получить предварительную оценку вашей финансовой ситуации.
        </p>

        <div class="calculator-card">
            <form action="{{ route('calculator.calculate') }}" method="POST" class="calculator-form">
                @csrf

                <div class="calculator-grid">
                    <div class="calculator-field">
                        <label for="totalDebt">
                            Общая сумма задолженности, ₽
                            <span class="tooltip-icon">
                                ?
                                <span class="tooltip-text">
                                    Укажите общую сумму всех ваших долгов: кредиты, микрозаймы, задолженности по распискам, налогам, штрафам и иным финансовым обязательствам.
                                </span>
                            </span>
                        </label>
                        <input
                            type="text"
                            class="money"
                            id="totalDebt"
                            name="totalDebt"
                            value="{{ old('totalDebt', $input['totalDebt'] ?? '') }}"
                            placeholder="Например: 500000"
                            autocomplete="off"
                            required
                        >
                        @error('totalDebt')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="calculator-field">
                        <label for="incomePerMonth">
                            Ваш средний ежемесячный доход, ₽
                            <span class="tooltip-icon">
                                ?
                                <span class="tooltip-text">
                                    Укажите средний доход, который вы получаете ежемесячно. Это может быть заработная плата, пенсия, доход от предпринимательства, аренды или иные регулярные поступления.
                                </span>
                            </span>
                        </label>
                        <input
                            type="text"
                            class="money"
                            id="incomePerMonth"
                            name="incomePerMonth"
                            value="{{ old('incomePerMonth', $input['incomePerMonth'] ?? '') }}"
                            placeholder="Например: 120000"
                            autocomplete="off"
                            required
                        >
                        @error('incomePerMonth')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="calculator-field">
                        <label for="monthlyExpenses">
                            Обязательные ежемесячные расходы, ₽
                            <span class="tooltip-icon">
                                ?
                                <span class="tooltip-text">
                                    Укажите ваши регулярные расходы, необходимые для жизни: оплата коммунальных услуг, питание, транспорт, лекарства, расходы на детей и другие обязательные платежи.
                                </span>
                            </span>
                        </label>
                        <input
                            type="text"
                            class="money"
                            id="monthlyExpenses"
                            name="monthlyExpenses"
                            value="{{ old('monthlyExpenses', $input['monthlyExpenses'] ?? '') }}"
                            placeholder="Например: 40000"
                            autocomplete="off"
                            required
                        >
                        @error('monthlyExpenses')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="calculator-field">
                        <label for="monthlyDebtPayment">
                            Ежемесячный платёж по кредитам и займам, ₽
                            <span class="tooltip-icon">
                                ?
                                <span class="tooltip-text">
                                    Укажите сумму, которую вы ежемесячно выплачиваете по кредитам, займам и другим долговым обязательствам.
                                </span>
                            </span>
                        </label>
                        <input
                            type="text"
                            class="money"
                            id="monthlyDebtPayment"
                            name="monthlyDebtPayment"
                            value="{{ old('monthlyDebtPayment', $input['monthlyDebtPayment'] ?? '') }}"
                            placeholder="Например: 25000"
                            autocomplete="off"
                            required
                        >
                        @error('monthlyDebtPayment')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="calculator-field calculator-field--full">
                        <label for="realizableAssets">
                            Стоимость имущества, которое можно реализовать, ₽
                            <span class="tooltip-icon">
                                ?
                                <span class="tooltip-text">
                                    Укажите примерную стоимость имущества, которое не относится к предметам первой необходимости и потенциально может учитываться при погашении долгов.
                                </span>
                            </span>
                        </label>
                        <input
                            type="text"
                            class="money"
                            id="realizableAssets"
                            name="realizableAssets"
                            value="{{ old('realizableAssets', $input['realizableAssets'] ?? '') }}"
                            placeholder="Например: 300000"
                            autocomplete="off"
                            required
                        >
                        @error('realizableAssets')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="calculator-btn">Рассчитать</button>
            </form>
        </div>

        @if(isset($result) && isset($chartData))
            <div class="calculator-result calculator-result--{{ $result['type'] }}">
                <h2>{{ $result['title'] }}</h2>
                <p class="calculator-result__text">{{ $result['description'] }}</p>

                <div class="calculator-visual">
                    <div class="calculator-visual__chart">
                        <canvas id="financeChart"></canvas>
                    </div>

                    <div class="calculator-visual__info">
                        <div class="visual-info-card">
                            <span>Ежемесячный доход</span>
                            <strong>{{ number_format($chartData['income'], 0, ',', ' ') }} ₽</strong>
                        </div>

                        <div class="visual-info-card">
                            <span>Обязательные расходы</span>
                            <strong>{{ number_format($chartData['expenses'], 0, ',', ' ') }} ₽</strong>
                        </div>

                        <div class="visual-info-card">
                            <span>Текущий платёж</span>
                            <strong>{{ number_format($chartData['currentPayment'], 0, ',', ' ') }} ₽</strong>
                        </div>

                        <div class="visual-info-card">
                            <span>Свободный остаток</span>
                            <strong>{{ number_format($chartData['freeMoney'], 0, ',', ' ') }} ₽</strong>
                        </div>

                        <div class="visual-info-card">
                            <span>Платёж при реструктуризации (36 мес.)</span>
                            <strong>{{ number_format($chartData['restructPayment'], 0, ',', ' ') }} ₽</strong>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const ctx = document.getElementById('financeChart');

                    if (ctx) {
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: [
                                    'Доход',
                                    'Расходы',
                                    'Текущий платёж',
                                    'Свободный остаток',
                                    'Реструктуризация'
                                ],
                                datasets: [{
                                    label: 'Сумма, ₽',
                                    data: [
                                        {{ $chartData['income'] }},
                                        {{ $chartData['expenses'] }},
                                        {{ $chartData['currentPayment'] }},
                                        {{ $chartData['freeMoney'] }},
                                        {{ $chartData['restructPayment'] }}
                                    ],
                                    borderWidth: 1,
                                    borderRadius: 8
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return context.raw.toLocaleString('ru-RU') + ' ₽';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return value.toLocaleString('ru-RU') + ' ₽';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
            </script>
        @endif

        <div class="calculator-note">
            Полученный результат носит исключительно информационный и предварительный характер.
            Расчёт выполняется на основании введённых пользователем данных и заложенных в систему условий,
            поэтому не является окончательным юридическим заключением. Итоговая оценка финансовой ситуации
            зависит от совокупности обстоятельств, включая состав задолженности, структуру имущества,
            наличие исполнительных производств и иных индивидуальных факторов.
        </div>
    </div>
</div>
@endsection