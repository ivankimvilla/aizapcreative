<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public array $messageData;

    public function __construct(array $messageData)
    {
        $this->messageData = $messageData;
    }

    public function build(): self
    {
        $adminEmail = env('MAIL_TO_ADDRESS', config('mail.from.address'));

        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('New contact message from '.$this->messageData['name'])
            ->to($adminEmail)
            ->markdown('emails.new-contact-message', [
                'messageData' => $this->messageData,
            ]);
    }
}
