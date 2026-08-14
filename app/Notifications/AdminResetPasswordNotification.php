<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $token,
        public string $email,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = url('/admin/password/reset/' . $this->token . '?email=' . urlencode($this->email));

        return (new MailMessage)
            ->subject('Reset your Aizap Creatives admin password')
            ->view('emails.password-reset', ['resetUrl' => $resetUrl]);
    }
}
