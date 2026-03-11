<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index()
    {
        return view('calculator');
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'totalDebt' => 'required|numeric|min:0',
            'incomePerMonth' => 'required|numeric|min:0',
            'monthlyExpenses' => 'required|numeric|min:0',
            'monthlyDebtPayment' => 'required|numeric|min:0',
            'realizableAssets' => 'required|numeric|min:0',
        ]);

        $totalDebt = (float) $validated['totalDebt'];
        $incomePerMonth = (float) $validated['incomePerMonth'];
        $monthlyExpenses = (float) $validated['monthlyExpenses'];
        $monthlyDebtPayment = (float) $validated['monthlyDebtPayment'];
        $realizableAssets = (float) $validated['realizableAssets'];

        $freeMoney = $incomePerMonth - $monthlyExpenses;
        $restructPayment = $totalDebt / 36;

        if ($monthlyDebtPayment <= $freeMoney) {
            $result = [
                'type' => 'success',
                'title' => 'Критических признаков неплатёжеспособности не выявлено',
                'description' => 'По введённым данным текущий ежемесячный платёж по обязательствам не превышает объём свободных денежных средств после обязательных расходов. Это может свидетельствовать о том, что на данный момент долговая нагрузка является контролируемой.',
            ];
        } elseif ($restructPayment <= $freeMoney) {
            $result = [
                'type' => 'warning',
                'title' => 'Рекомендуется рассмотреть реструктуризацию задолженности',
                'description' => 'По предварительному расчёту текущая долговая нагрузка превышает объём свободных денежных средств, однако при условном распределении общей суммы долга на 36 месяцев предполагаемый ежемесячный платёж укладывается в доступный остаток. В такой ситуации можно рассмотреть вариант реструктуризации задолженности.',
            ];
        } else {
            $result = [
                'type' => 'danger',
                'title' => 'Рекомендуется рассмотреть процедуру банкротства',
                'description' => 'По предварительному расчёту ни текущий ежемесячный платёж, ни условный платёж при реструктуризации на 36 месяцев не укладываются в объём свободных денежных средств после обязательных расходов. Это может свидетельствовать о существенной долговой нагрузке и необходимости дополнительной оценки возможности применения процедуры банкротства.',
            ];
        }

        return view('calculator', [
            'result' => $result,
            'input' => $validated
        ]);
    }
}