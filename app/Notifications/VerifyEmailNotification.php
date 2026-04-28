<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends VerifyEmail
{
    use Queueable;

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Подтверждение регистрации на сайте ОК Банкрот')
            ->greeting('Здравствуйте!')
            ->line('Спасибо за регистрацию на сайте ОК Банкрот.')
            ->line('Для завершения регистрации и доступа к личному кабинету подтвердите адрес электронной почты.')
            ->action('Подтвердить почту', $verificationUrl)
            ->line('Если вы не регистрировались на сайте, просто проигнорируйте это письмо.')
            ->salutation('С уважением, команда ОК Банкрот');
    }
}