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
        ], [
            'full_name.required' => 'Введите ФИО.',
            'phone.required' => 'Введите телефон.',
        ]);

        $callbackRequest = CallbackRequest::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'status' => 'new',
        ]);

        try {
            $webhookUrl = (string) (config('services.bitrix.webhook_url') ?: env('BITRIX_WEBHOOK_URL'));
            $webhookUrl = rtrim($webhookUrl, '/');

            if (empty($webhookUrl)) {
                throw new \Exception('BITRIX_WEBHOOK_URL не настроен');
            }

            $url = $webhookUrl . '/crm.lead.add.json';

            $response = Http::asForm()->post($url, [
                'fields[TITLE]' => 'Заявка на обратный звонок с сайта',
                'fields[NAME]' => $validated['full_name'],
                'fields[PHONE][0][VALUE]' => $validated['phone'],
                'fields[PHONE][0][VALUE_TYPE]' => 'WORK',
                'fields[COMMENTS]' => 'Заявка оставлена через форму "Заказать звонок" на сайте OK-Банкрот.',
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

                Log::error('Bitrix send failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'json' => $responseData,
                ]);
            }
        } catch (\Throwable $e) {
            $callbackRequest->update([
                'status' => 'error',
            ]);

            Log::error('Bitrix exception', [
                'message' => $e->getMessage(),
            ]);
        }

        return back()->with('success', 'Заявка успешно отправлена. Мы свяжемся с вами в ближайшее время.');
    }
}