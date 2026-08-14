<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewBookingRequest extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build(): self
    {
        $adminEmail = env('MAIL_TO_ADDRESS', config('mail.from.address'));

        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('New booking request from '.$this->booking->name)
            ->to($adminEmail)
            ->markdown('emails.new-booking-request', [
                'booking' => $this->booking,
            ]);
    }
}
