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
        ], [
            'text.required' => 'Введите текст отзыва.',
            'text.min' => 'Отзыв должен содержать не менее 10 символов.',
            'text.max' => 'Отзыв не должен быть слишком длинным.',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'name' => auth()->user()->full_name,
            'text' => $validated['text'],
            'status' => 'pending',
        ]);

        return back()->with('success', 'Отзыв отправлен на модерацию.');
    }
}