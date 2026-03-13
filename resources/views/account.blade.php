@extends('layout.index')

@section('main')

@php
$user = auth()->user();
@endphp

<div class="account-page">
    <div class="account-container">

        <h1 class="account-title">Личный кабинет</h1>

        <div class="account-card">

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
                        @if($user->role === 'admin')
                            Администратор
                        @else
                            Пользователь
                        @endif
                    </span>
                </div>

                <div class="account-row">
                    <span class="account-label">Дата регистрации</span>
                    <span class="account-value">
                        {{ $user->created_at ? $user->created_at->format('d.m.Y') : 'Не указано' }}
                    </span>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection