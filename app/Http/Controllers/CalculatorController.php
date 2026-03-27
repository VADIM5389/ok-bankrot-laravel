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

        $freeMoney = $incomePerMonth - ($monthlyExpenses + $monthlyDebtPayment);

        // Для отображения в графике отрицательное значение не даём,
        // чтобы график не ломался визуально
        $freeMoneyForChart = max($freeMoney, 0);

        $restructPayment = $totalDebt / 36;

        if ($monthlyDebtPayment <= ($incomePerMonth - $monthlyExpenses)) {
            $result = [
                'type' => 'success',
                'title' => 'Критических признаков неплатёжеспособности не выявлено',
                'description' => 'По введённым данным текущий ежемесячный платёж по обязательствам не превышает объём денежных средств, остающихся после обязательных расходов. Это может свидетельствовать о том, что на данный момент долговая нагрузка является контролируемой.',
            ];
        } elseif ($restructPayment <= ($incomePerMonth - $monthlyExpenses)) {
            $result = [
                'type' => 'warning',
                'title' => 'Рекомендуется рассмотреть реструктуризацию задолженности',
                'description' => 'По предварительному расчёту текущая долговая нагрузка превышает доступный остаток денежных средств, однако при условном распределении общей суммы долга на 36 месяцев предполагаемый ежемесячный платёж может оказаться приемлемым.',
            ];
        } else {
            $result = [
                'type' => 'danger',
                'title' => 'Рекомендуется рассмотреть процедуру банкротства',
                'description' => 'По предварительному расчёту ни текущий ежемесячный платёж, ни условный платёж при реструктуризации на 36 месяцев не укладываются в доступный остаток денежных средств после обязательных расходов.',
            ];
        }

        $chartData = [
            'income' => round($incomePerMonth, 2),
            'expenses' => round($monthlyExpenses, 2),
            'currentPayment' => round($monthlyDebtPayment, 2),
            'freeMoney' => round($freeMoneyForChart, 2),
            'realFreeMoney' => round($freeMoney, 2),
            'restructPayment' => round($restructPayment, 2),
        ];

        return view('calculator', [
            'result' => $result,
            'input' => $validated,
            'chartData' => $chartData,
        ]);
    }
}