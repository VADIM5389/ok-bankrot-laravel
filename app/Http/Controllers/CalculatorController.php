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

        $freeMoney = $incomePerMonth - $monthlyExpenses - $monthlyDebtPayment;
        $debtToIncomeRatio = $incomePerMonth > 0 ? $totalDebt / ($incomePerMonth * 12) : 0;
        $assetToDebtRatio = $totalDebt > 0 ? $realizableAssets / $totalDebt : 0;
        $paymentLoad = $incomePerMonth > 0 ? $monthlyDebtPayment / $incomePerMonth : 0;

        if (($freeMoney < 0 && $debtToIncomeRatio > 2) || ($debtToIncomeRatio > 5 && $assetToDebtRatio < 0.5)) {
            $result = [
                'type' => 'danger',
                'title' => 'Рекомендуется рассмотреть процедуру банкротства',
                'description' => 'По введённым данным финансовая нагрузка является высокой, а имеющихся ресурсов может быть недостаточно для самостоятельного погашения задолженности. В такой ситуации целесообразно обратиться за консультацией для оценки возможности применения процедуры банкротства.',
            ];
        } elseif ($paymentLoad > 0.5 || $debtToIncomeRatio > 2 || $freeMoney < 0) {
            $result = [
                'type' => 'warning',
                'title' => 'Рекомендуется дополнительно оценить варианты урегулирования задолженности',
                'description' => 'По предварительному расчёту финансовая ситуация является напряжённой. В зависимости от структуры задолженности и иных обстоятельств может быть целесообразно рассмотреть реструктуризацию долга или иные законные способы урегулирования обязательств.',
            ];
        } else {
            $result = [
                'type' => 'success',
                'title' => 'Критических признаков неплатёжеспособности не выявлено',
                'description' => 'По указанным данным явных признаков критической неплатёжеспособности не выявлено. Вместе с тем окончательная оценка ситуации требует учёта всех обстоятельств, включая характер задолженности, состав имущества и наличие иных обязательств.',
            ];
        }

        return view('calculator', [
            'result' => $result,
            'input' => $validated
        ]);
    }
}