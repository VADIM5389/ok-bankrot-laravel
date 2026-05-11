<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Восстановление пароля — ОК Банкрот')
            ->markdown('reset-password-mail', [
                'user' => $notifiable,
                'resetUrl' => $resetUrl,
                'logoUrl' => 'https://static.tildacdn.com/tild6335-3635-4135-b737-656238303137/logo.png',
            ]);
    }
}