<?php

namespace App\Http\Controllers;

use App\Models\CallbackRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CallbackRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:25'],
        ]);

        $callbackRequest = CallbackRequest::create([
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'status' => 'new',
        ]);

        try {
            $webhookUrl = rtrim(config('services.bitrix.webhook_url'), '/');

            if (empty($webhookUrl)) {
                throw new \Exception('BITRIX_WEBHOOK_URL не настроен');
            }

            $response = Http::asForm()->post($webhookUrl . '/crm.lead.add.json', [
                'fields' => [
                    'TITLE' => 'Заявка на обратный звонок с сайта',
                    'NAME' => $validated['full_name'],
                    'PHONE' => [
                        [
                            'VALUE' => $validated['phone'],
                            'VALUE_TYPE' => 'WORK',
                        ]
                    ],
                    'COMMENTS' => 'Заявка оставлена через форму "Заказать звонок" на сайте OK-Банкрот.',
                ],
            ]);

            $responseData = $response->json();

            if ($response->successful() && !isset($responseData['error'])) {
                $callbackRequest->update([
                    'status' => 'sent',
                ]);
            } else {
                $callbackRequest->update([
                    'status' => 'error',
                ]);

                Log::error('Ошибка отправки заявки в Bitrix', [
                    'response' => $responseData,
                ]);
            }

        } catch (\Throwable $e) {
            $callbackRequest->update([
                'status' => 'error',
            ]);

            Log::error('Исключение при отправке заявки в Bitrix', [
                'message' => $e->getMessage(),
            ]);
        }

        return back()->with('success', 'Заявка успешно отправлена. Мы свяжемся с вами в ближайшее время.');
    }
}