@extends('layout.index')

@section('main')
<div class="admin-page">
    <div class="admin-container">
        <h1 class="admin-title">Отзывы</h1>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Автор</th>
                        <th>Текст</th>
                        <th>Статус</th>
                        <th>Одобрил</th>
                        <th>Дата</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->text }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->approvedBy->full_name ?? '—' }}</td>
                            <td>{{ optional($item->created_at)->format('d.m.Y H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.reviews.status', $item) }}" method="POST">
                                    @csrf
                                    <select name="status" class="admin-select">
                                        <option value="pending" @selected($item->status === 'pending')>На модерации</option>
                                        <option value="approved" @selected($item->status === 'approved')>Одобрен</option>
                                        <option value="rejected" @selected($item->status === 'rejected')>Отклонён</option>
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