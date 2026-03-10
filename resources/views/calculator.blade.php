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
                            type="number"
                            name="totalDebt"
                            id="totalDebt"
                            min="0"
                            step="0.01"
                            value="{{ old('totalDebt', $input['totalDebt'] ?? '') }}"
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
                            type="number"
                            name="incomePerMonth"
                            id="incomePerMonth"
                            min="0"
                            step="0.01"
                            value="{{ old('incomePerMonth', $input['incomePerMonth'] ?? '') }}"
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
                            type="number"
                            name="monthlyExpenses"
                            id="monthlyExpenses"
                            min="0"
                            step="0.01"
                            value="{{ old('monthlyExpenses', $input['monthlyExpenses'] ?? '') }}"
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
                            type="number"
                            name="monthlyDebtPayment"
                            id="monthlyDebtPayment"
                            min="0"
                            step="0.01"
                            value="{{ old('monthlyDebtPayment', $input['monthlyDebtPayment'] ?? '') }}"
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
                                    Укажите примерную стоимость имущества, которое не относится к предметам первой необходимости и потенциально может учитываться при погашении долгов. Например: автомобиль, дополнительная недвижимость, дорогостоящая техника или иное ценное имущество.
                                </span>
                            </span>
                        </label>
                        <input
                            type="number"
                            name="realizableAssets"
                            id="realizableAssets"
                            min="0"
                            step="0.01"
                            value="{{ old('realizableAssets', $input['realizableAssets'] ?? '') }}"
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

        @if(isset($result))
            <div class="calculator-result calculator-result--{{ $result['type'] }}">
                <h2>{{ $result['title'] }}</h2>
                <p class="calculator-result__text">{{ $result['description'] }}</p>
            </div>
        @endif

        <div class="calculator-note">
            Полученный результат носит исключительно информационный и предварительный характер.
            Расчёт выполняется на основании введённых пользователем данных и заложенных в систему формул,
            поэтому не является окончательным юридическим заключением. Итоговая оценка финансовой ситуации
            зависит от совокупности обстоятельств, включая состав задолженности, структуру имущества,
            наличие исполнительных производств и иных индивидуальных факторов.
        </div>
    </div>
</div>
@endsection