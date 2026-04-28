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

    public function requests(Request $request)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'status' => ['nullable', 'in:new,sent,in_progress,done,error'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $query = CallbackRequest::with(['user', 'processedBy'])
            ->latest();

        if (!empty($validated['search'])) {
            $search = trim($validated['search']);

            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('full_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($validated['phone'])) {
            $phone = trim($validated['phone']);

            $query->where(function ($q) use ($phone) {
                $q->where('phone', 'like', "%{$phone}%")
                    ->orWhereHas('user', function ($userQuery) use ($phone) {
                        $userQuery->where('phone', 'like', "%{$phone}%");
                    });
            });
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (!empty($validated['date_from'])) {
            $query->whereDate('created_at', '>=', $validated['date_from']);
        }

        if (!empty($validated['date_to'])) {
            $query->whereDate('created_at', '<=', $validated['date_to']);
        }

        $requests = $query->paginate(10)->withQueryString();

        $statusLabels = [
            'new' => 'Новая',
            'sent' => 'Отправлена',
            'in_progress' => 'В работе',
            'done' => 'Завершена',
            'error' => 'Ошибка',
        ];

        return view('admin.requests', compact('requests', 'statusLabels'));
    }

    public function updateRequestStatus(Request $request, CallbackRequest $callbackRequest)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'status' => ['required', 'in:new,sent,in_progress,done,error'],
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