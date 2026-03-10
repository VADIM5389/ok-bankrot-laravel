@extends('layout.index')

@section('main')
<div class="calculator-page">
    <div class="calculator-container">
        <h1 class="calculator-title">Калькулятор оценки финансового положения</h1>
        <p class="calculator-subtitle">
            Заполните данные ниже, чтобы получить предварительную оценку финансовой ситуации
            и возможные рекомендации.
        </p>

        <div class="calculator-card">
            <form action="{{ route('calculator.calculate') }}" method="POST" class="calculator-form">
                @csrf

                <div class="calculator-grid">
                    <div class="calculator-field">
                        <label for="incomePerMonth">Ежемесячный доход, ₽</label>
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
                        <label for="totalDebt">Общая сумма долга, ₽</label>
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
                        <label for="totalAssets">Стоимость имущества, ₽</label>
                        <input
                            type="number"
                            name="totalAssets"
                            id="totalAssets"
                            min="0"
                            step="0.01"
                            value="{{ old('totalAssets', $input['totalAssets'] ?? '') }}"
                            required
                        >
                        @error('totalAssets')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="calculator-field">
                        <label for="monthlyObligations">Ежемесячные обязательства, ₽</label>
                        <input
                            type="number"
                            name="monthlyObligations"
                            id="monthlyObligations"
                            min="0"
                            step="0.01"
                            value="{{ old('monthlyObligations', $input['monthlyObligations'] ?? '') }}"
                            required
                        >
                        @error('monthlyObligations')
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

                <div class="calculator-result__stats">
                    <div class="stat-box">
                        <span>Коэффициент долговой нагрузки</span>
                        <strong>{{ $result['debtToIncomeRatio'] }}</strong>
                    </div>
                    <div class="stat-box">
                        <span>Соотношение имущества к долгу</span>
                        <strong>{{ $result['assetToDebtRatio'] }}</strong>
                    </div>
                    <div class="stat-box">
                        <span>Доля обязательств от дохода</span>
                        <strong>{{ $result['obligationsToIncomeRatio'] }}</strong>
                    </div>
                </div>
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