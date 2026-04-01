<?php

namespace App\Http\Controllers;

use App\Models\CallbackRequest;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function showAccount()
    {
        $user = Auth::user();

        $callbackRequests = collect();

        if ($user && !empty($user->phone)) {
            $normalizedPhone = preg_replace('/\D+/', '', $user->phone);

            $callbackRequests = CallbackRequest::query()
                ->where(function ($query) use ($user, $normalizedPhone) {
                    $query->where('user_id', $user->id)
                          ->orWhereRaw("REGEXP_REPLACE(phone, '[^0-9]', '') = ?", [$normalizedPhone]);
                })
                ->with(['processedBy'])
                ->orderByDesc('created_at')
                ->get();
        }

        $reviews = Review::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('account', [
            'user' => $user,
            'callbackRequests' => $callbackRequests,
            'reviews' => $reviews,
        ]);
    }
}