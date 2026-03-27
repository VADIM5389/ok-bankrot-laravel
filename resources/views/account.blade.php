@extends('layout.index')

@section('main')
<div class="account-page">
    <div class="account-container">
        <h1 class="account-title">Личный кабинет</h1>

        <div class="account-card">
            <h2 class="account-card__title">Данные профиля</h2>

            <div class="account-info">
                <div class="account-row">
                    <span class="account-label">ФИО</span>
                    <span class="account-value">{{ $user->full_name ?? 'Не указано' }}</span>
                </div>

                <div class="account-row">
                    <span class="account-label">Email</span>
                    <span class="account-value">{{ $user->email ?? 'Не указано' }}</span>
                </div>

                <div class="account-row">
                    <span class="account-label">Телефон</span>
                    <span class="account-value">{{ $user->phone ?? 'Не указано' }}</span>
                </div>

                <div class="account-row">
                    <span class="account-label">Роль</span>
                    <span class="account-value">
                        @if(($user->role ?? null) === 'admin')
                            Администратор
                        @else
                            Пользователь
                        @endif
                    </span>
                </div>

                <div class="account-row">
                    <span class="account-label">Дата регистрации</span>
                    <span class="account-value">
                        {{ $user && $user->created_at ? $user->created_at->format('d.m.Y') : 'Не указано' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="account-card">
            <h2 class="account-card__title">Мои заявки</h2>

            @if($callbackRequests->isEmpty())
                <div class="account-empty">
                    По вашему номеру телефона заявки пока не найдены.
                </div>
            @else
                <div class="account-requests">
                    @foreach($callbackRequests as $request)
                        <div class="request-card">
                            <div class="request-card__top">
                                <div>
                                    <div class="request-card__name">{{ $request->full_name }}</div>
                                    <div class="request-card__date">
                                        {{ $request->created_at ? $request->created_at->format('d.m.Y H:i') : '' }}
                                    </div>
                                </div>

                                <div class="request-status request-status--{{ $request->status }}">
                                    @if($request->status === 'sent')
                                        Отправлена
                                    @elseif($request->status === 'error')
                                        Ошибка отправки
                                    @elseif($request->status === 'new')
                                        Новая
                                    @else
                                        {{ $request->status }}
                                    @endif
                                </div>
                            </div>

                            <div class="request-card__body">
                                <div class="request-card__row">
                                    <span>Телефон:</span>
                                    <strong>{{ $request->phone }}</strong>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection