<?php

namespace App\Http\Controllers;

use App\Models\CallbackRequest;
use Illuminate\Http\Request;

class CallbackRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:25'],
        ]);

        CallbackRequest::create([
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'status' => 'new',
        ]);

        return back()->with('success', 'Заявка успешно отправлена. Мы свяжемся с вами в ближайшее время.');
    }
}