<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewQuoteRequest extends Mailable
{
    use Queueable, SerializesModels;

    public array $quoteData;

    public function __construct(array $quoteData)
    {
        $this->quoteData = $quoteData;
    }

    public function build(): self
    {
        $adminEmail = env('MAIL_TO_ADDRESS', config('mail.from.address'));

        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('New quote request from '.$this->quoteData['name'])
            ->to($adminEmail)
            ->markdown('emails.new-quote-request', [
                'quoteData' => $this->quoteData,
            ]);
    }
}
