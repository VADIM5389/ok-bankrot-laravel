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
            'incomePerMonth' => 'required|numeric|min:0',
            'totalDebt' => 'required|numeric|min:0',
            'totalAssets' => 'required|numeric|min:0',
            'monthlyObligations' => 'required|numeric|min:0',
        ]);

        $incomePerMonth = (float) $validated['incomePerMonth'];
        $totalDebt = (float) $validated['totalDebt'];
        $totalAssets = (float) $validated['totalAssets'];
        $monthlyObligations = (float) $validated['monthlyObligations'];

        $debtToIncomeRatio = $incomePerMonth > 0 ? $totalDebt / ($incomePerMonth * 12) : 0;
        $assetToDebtRatio = $totalDebt > 0 ? $totalAssets / $totalDebt : 0;
        $obligationsToIncomeRatio = $incomePerMonth > 0 ? $monthlyObligations / $incomePerMonth : 0;

        if ($debtToIncomeRatio > 5 && $assetToDebtRatio < 0.5) {
            $result = [
                'type' => 'danger',
                'title' => 'Рекомендуется рассмотреть процедуру банкротства',
                'description' => 'По введённым данным наблюдается высокая долговая нагрузка и недостаточный объём имущества для покрытия обязательств. Такая ситуация может свидетельствовать о признаках устойчивой неплатёжеспособности.',
            ];
        } elseif ($debtToIncomeRatio > 2 || $obligationsToIncomeRatio > 0.5) {
            $result = [
                'type' => 'warning',
                'title' => 'Рекомендуется рассмотреть реструктуризацию задолженности',
                'description' => 'Финансовая нагрузка является существенной. В данной ситуации целесообразно дополнительно оценить возможность реструктуризации долга и иных способов урегулирования обязательств.',
            ];
        } else {
            $result = [
                'type' => 'success',
                'title' => 'Критических признаков неплатёжеспособности не выявлено',
                'description' => 'По указанным данным текущая финансовая ситуация не демонстрирует явных признаков необходимости немедленного запуска процедуры банкротства. Однако рекомендуется учитывать и иные обстоятельства.',
            ];
        }

        $result['debtToIncomeRatio'] = number_format($debtToIncomeRatio, 2, '.', ' ');
        $result['assetToDebtRatio'] = number_format($assetToDebtRatio, 2, '.', ' ');
        $result['obligationsToIncomeRatio'] = number_format($obligationsToIncomeRatio, 2, '.', ' ');

        return view('calculator', [
            'result' => $result,
            'input' => $validated
        ]);
    }
}