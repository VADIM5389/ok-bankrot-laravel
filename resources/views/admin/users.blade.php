@extends('layout.index')

@section('main')
<div class="admin-page">
    <div class="admin-container">
        <h1 class="admin-title">Пользователи</h1>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ФИО</th>
                        <th>Email</th>
                        <th>Телефон</th>
                        <th>Роль</th>
                        <th>Дата</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->full_name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->role }}</td>
                            <td>{{ optional($item->created_at)->format('d.m.Y H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.users.role', $item) }}" method="POST">
                                    @csrf
                                    <select name="role" class="admin-select">
                                        <option value="user" @selected($item->role === 'user')>Пользователь</option>
                                        <option value="admin" @selected($item->role === 'admin')>Администратор</option>
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