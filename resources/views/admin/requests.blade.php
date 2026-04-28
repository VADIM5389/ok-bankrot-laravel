@extends('layout.index')

@section('main')
<div class="admin-page">
    <div class="admin-container">
        <h1 class="admin-title">Заявки</h1>

        @if(session('success'))
            <div class="admin-alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.requests') }}" method="GET" class="admin-filters">
            <div class="admin-filters-row">
                <div class="admin-filter-item admin-filter-search">
                    <label for="search">Поиск</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="ФИО или email"
                        class="admin-input"
                    >
                </div>

                <div class="admin-filter-item">
                    <label for="phone">Телефон</label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="{{ request('phone') }}"
                        placeholder="+7 (___) ___-__-__"
                        class="admin-input phone-mask"
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
            </div>

            <div class="admin-filters-row">
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
                    <a href="{{ route('admin.requests') }}" class="admin-reset-btn">Сбросить</a>
                </div>
            </div>
        </form>

        <div class="admin-table-info">
            Найдено заявок: {{ $requests->total() }}
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ФИО</th>
                        <th>Телефон</th>
                        <th>Статус</th>
                        <th>Пользователь</th>
                        <th>Обработал</th>
                        <th>Дата</th>
                        <th>Действие</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($requests as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->full_name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>
                                <span class="request-status request-status-{{ $item->status }}">
                                    {{ $statusLabels[$item->status] ?? $item->status }}
                                </span>
                            </td>
                            <td>{{ $item->user->full_name ?? '—' }}</td>
                            <td>{{ $item->processedBy->full_name ?? '—' }}</td>
                            <td>{{ optional($item->created_at)->format('d.m.Y H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.requests.status', $item) }}" method="POST" class="admin-status-form">
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="admin-empty">
                                Заявки по выбранным фильтрам не найдены.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-pagination">
            {{ $requests->links() }}
        </div>

        <div class="admin-back">
            <a href="{{ route('admin.index') }}" class="admin-link">← Назад в админку</a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Inputmask !== 'undefined') {
        const phoneInputs = document.querySelectorAll('.phone-mask');

        phoneInputs.forEach(function (input) {
            Inputmask({
                mask: '+7 (999) 999-99-99',
                showMaskOnHover: false,
                clearIncomplete: false
            }).mask(input);
        });
    }
});
</script>
@endsection