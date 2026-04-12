@extends('layout.index')

@section('main')
<div class="admin-page">
    <div class="admin-container">
        <h1 class="admin-title">Заявки</h1>

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
                    @foreach($requests as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->full_name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->user->full_name ?? '—' }}</td>
                            <td>{{ $item->processedBy->full_name ?? '—' }}</td>
                            <td>{{ optional($item->created_at)->format('d.m.Y H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.requests.status', $item) }}" method="POST">
                                    @csrf
                                    <select name="status" class="admin-select">
                                        <option value="sent" @selected($item->status === 'sent')>Отправлена</option>
                                        <option value="in_progress" @selected($item->status === 'in_progress')>В работе</option>
                                        <option value="done" @selected($item->status === 'done')>Завершена</option>
                                        <option value="error" @selected($item->status === 'error')>Ошибка</option>
                                    </select>
                                    <button type="submit" class="admin-btn">Сохранить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="admin-back">
            <a href="{{ route('admin.index') }}" class="admin-link">← Назад в админку</a>
        </div>
    </div>
</div>
@endsection