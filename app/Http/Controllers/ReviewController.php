<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'text' => ['required', 'string', 'min:10', 'max:1000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'name' => auth()->user()->full_name,
            'text' => $validated['text'],   
            'rating' => $validated['rating'],
            'status' => 'pending',
        ]);

        return back()->with('success', 'Отзыв отправлен на модерацию.');
    }
}