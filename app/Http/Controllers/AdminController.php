<?php

namespace App\Http\Controllers;

use App\Models\CallbackRequest;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function checkAdmin()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

    public function index()
    {
        $this->checkAdmin();

        return view('admin.index', [
            'requestsCount' => CallbackRequest::count(),
            'newRequestsCount' => CallbackRequest::where('status', 'new')->count(),
            'pendingReviewsCount' => Review::where('status', 'pending')->count(),
            'usersCount' => User::count(),
        ]);
    }

    public function requests()
    {
        $this->checkAdmin();

        $requests = CallbackRequest::with(['user', 'processedBy'])
            ->latest()
            ->get();

        return view('admin.requests', compact('requests'));
    }

    public function updateRequestStatus(Request $request, CallbackRequest $callbackRequest)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'status' => ['required', 'string'],
        ]);

        $callbackRequest->update([
            'status' => $validated['status'],
            'processed_by' => auth()->id(),
        ]);

        return back()->with('success', 'Статус заявки обновлён.');
    }

    public function reviews()
    {
        $this->checkAdmin();

        $reviews = Review::with(['user', 'approvedBy'])
            ->latest()
            ->get();

        return view('admin.reviews', compact('reviews'));
    }

    public function updateReviewStatus(Request $request, Review $review)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $review->update([
            'status' => $validated['status'],
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Статус отзыва обновлён.');
    }

    public function users()
    {
        $this->checkAdmin();

        $users = User::latest()->get();

        return view('admin.users', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'role' => ['required', 'in:user,admin'],
        ]);

        $user->update([
            'role' => $validated['role'],
        ]);

        return back()->with('success', 'Роль пользователя обновлена.');
    }
}