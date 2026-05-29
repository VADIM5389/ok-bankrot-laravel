@extends('layout.index')

@section('main')
<div class="admin-page">
    <div class="admin-container">
        <h1 class="admin-title">Отзывы</h1>

        @if(session('success'))
            <div class="admin-alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.reviews') }}" method="GET" class="admin-filters">
            <div class="admin-filters-row">
                <div class="admin-filter-item admin-filter-search">
                    <label for="search">Поиск</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Автор, email или текст отзыва"
                        class="admin-input"
                    >
                </div>

                <div class="admin-filter-item">
                    <label for="status">Статус</label>
                    <select id="status" name="status" class="admin-input">
                        <option value="">Все статусы</option>

                        @foreach($statusLabels as $statusValue => $statusName)
                            <option value="{{ $statusValue }}" @selected(request('status') === $statusValue)>
                                {{ $statusName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-filter-item">
                    <label for="date_from">Дата от</label>
                    <input
                        type="date"
                        id="date_from"
                        name="date_from"
                        value="{{ request('date_from') }}"
                        class="admin-input"
                    >
                </div>
            </div>

            <div class="admin-filters-row">
                <div class="admin-filter-item">
                    <label for="date_to">Дата до</label>
                    <input
                        type="date"
                        id="date_to"
                        name="date_to"
                        value="{{ request('date_to') }}"
                        class="admin-input"
                    >
                </div>

                <div class="admin-filter-actions">
                    <button type="submit" class="admin-btn">Найти</button>
                    <a href="{{ route('admin.reviews') }}" class="admin-reset-btn">Сбросить</a>
                </div>
            </div>
        </form>

        <div class="admin-table-info">
            Найдено отзывов: {{ $reviews->total() }}
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Автор</th>
                        <th>Текст</th>
                        <th>Статус</th>
                        <th>Дата</th>
                        <th>Действие</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reviews as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->text }}</td>
                            <td>
                                <span class="request-status request-status-{{ $item->status }}">
                                    {{ $statusLabels[$item->status] ?? $item->status }}
                                </span>
                            </td>
                            <td>{{ optional($item->created_at)->format('d.m.Y H:i') }}</td>
                            <td>
                                <div class="admin-actions-cell">
                                    <form action="{{ route('admin.reviews.status', $item) }}" method="POST" class="admin-status-form">
                                        @csrf

                                        <select name="status" class="admin-select">
                                            @foreach($statusLabels as $statusValue => $statusName)
                                                <option value="{{ $statusValue }}" @selected($item->status === $statusValue)>
                                                    {{ $statusName }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="submit" class="admin-btn">Сохранить</button>
                                    </form>

                                    <form
                                        action="{{ route('admin.reviews.delete', $item) }}"
                                        method="POST"
                                        class="admin-delete-form"
                                        onsubmit="return confirm('Вы действительно хотите удалить этот отзыв?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="admin-delete-btn">
                                            Удалить отзыв
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="admin-empty">
                                Отзывы по выбранным фильтрам не найдены.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-pagination">
            {{ $reviews->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>

        <div class="admin-back">
            <a href="{{ route('admin.index') }}" class="admin-link">← Назад в админку</a>
        </div>
    </div>
</div>
@endsection