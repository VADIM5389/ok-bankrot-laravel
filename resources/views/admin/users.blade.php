@extends('layout.index')

@section('main')
<div class="admin-page">
    <div class="admin-container">
        <h1 class="admin-title">Пользователи</h1>

        @if(session('success'))
            <div class="admin-alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="admin-alert admin-alert-error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.users') }}" method="GET" class="admin-filters">
            <div class="admin-filters-row">
                <div class="admin-filter-item admin-filter-search">
                    <label for="search">Поиск</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="ФИО, email или телефон"
                        class="admin-input"
                    >
                </div>

                <div class="admin-filter-item">
                    <label for="role">Роль</label>
                    <select id="role" name="role" class="admin-input">
                        <option value="">Все роли</option>

                        @foreach($roleLabels as $roleValue => $roleName)
                            <option value="{{ $roleValue }}" @selected(request('role') === $roleValue)>
                                {{ $roleName }}
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
                    <a href="{{ route('admin.users') }}" class="admin-reset-btn">Сбросить</a>
                </div>
            </div>
        </form>

        <div class="admin-table-info">
            Найдено пользователей: {{ $users->total() }}
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ФИО</th>
                        <th>Email</th>
                        <th>Телефон</th>
                        <th>Роль</th>
                        <th>Дата регистрации</th>
                        <th>Действие</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->full_name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone ?? '—' }}</td>
                            <td>
                                <span class="request-status request-status-{{ $item->role }}">
                                    {{ $roleLabels[$item->role] ?? $item->role }}
                                </span>
                            </td>
                            <td>{{ optional($item->created_at)->format('d.m.Y H:i') }}</td>
                            <td>
                                <div class="admin-actions-cell">
                                    <form action="{{ route('admin.users.role', $item) }}" method="POST" class="admin-status-form">
                                        @csrf

                                        <select name="role" class="admin-select">
                                            @foreach($roleLabels as $roleValue => $roleName)
                                                <option value="{{ $roleValue }}" @selected($item->role === $roleValue)>
                                                    {{ $roleName }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="submit" class="admin-btn">Сохранить</button>
                                    </form>

                                    @if($item->id !== auth()->id())
                                        <form
                                            action="{{ route('admin.users.delete', $item) }}"
                                            method="POST"
                                            class="admin-delete-form"
                                            onsubmit="return confirm('Вы действительно хотите удалить этого пользователя?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="admin-delete-btn">
                                                Удалить пользователя
                                            </button>
                                        </form>
                                    @else
                                        <div class="admin-current-user-note">
                                            Текущий аккаунт
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="admin-empty">
                                Пользователи по выбранным фильтрам не найдены.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-pagination">
            {{ $users->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>

        <div class="admin-back">
            <a href="{{ route('admin.index') }}" class="admin-link">← Назад в админку</a>
        </div>
    </div>
</div>
@endsection