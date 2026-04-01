@extends('layout.index')

@section('main')
<div class="admin-page">
    <div class="admin-container">
        <h1 class="admin-title">Админ-панель</h1>

        <div class="admin-grid">
            <a href="{{ route('admin.requests') }}" class="admin-stat-card">
                <h2>Заявки</h2>
                <p>Всего: {{ $requestsCount }}</p>
                <strong>Новых: {{ $newRequestsCount }}</strong>
            </a>

            <a href="{{ route('admin.reviews') }}" class="admin-stat-card">
                <h2>Отзывы</h2>
                <p>На модерации: {{ $pendingReviewsCount }}</p>
            </a>

            <a href="{{ route('admin.users') }}" class="admin-stat-card">
                <h2>Пользователи</h2>
                <p>Всего: {{ $usersCount }}</p>
            </a>
        </div>
    </div>
</div>
@endsection