<?php

namespace App\Models;

use App\Models\CallbackRequest;
use App\Models\Review;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Атрибуты, которые можно массово заполнять.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'full_name',
        'phone',
        'password',
        'role',
    ];

    /**
     * Атрибуты, которые нужно скрывать при сериализации.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Приведение типов атрибутов.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Отправка кастомного письма для подтверждения email.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * Заявки пользователя на обратный звонок.
     */
    public function callbackRequests()
    {
        return $this->hasMany(CallbackRequest::class);
    }

    /**
     * Заявки, обработанные администратором.
     */
    public function processedRequests()
    {
        return $this->hasMany(CallbackRequest::class, 'processed_by');
    }

    /**
     * Отзывы пользователя.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Отзывы, проверенные администратором.
     */
    public function approvedReviews()
    {
        return $this->hasMany(Review::class, 'approved_by');
    }
}