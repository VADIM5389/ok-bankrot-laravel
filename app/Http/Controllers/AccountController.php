<?php

namespace App\Http\Controllers;

use App\Models\CallbackRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function showAccount()
    {
        $user = Auth::user();

        $callbackRequests = collect();

        if ($user && !empty($user->phone)) {
            $normalizedPhone = preg_replace('/\D+/', '', $user->phone);

            $callbackRequests = CallbackRequest::all()->filter(function ($request) use ($normalizedPhone) {
                $requestPhone = preg_replace('/\D+/', '', $request->phone);
                return $requestPhone === $normalizedPhone;
            })->sortByDesc('created_at');
        }

        return view('account', [
            'user' => $user,
            'callbackRequests' => $callbackRequests,
        ]);
    }
}