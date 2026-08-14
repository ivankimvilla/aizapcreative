<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class BookingStatusUpdated extends Mailable implements ShouldQueue
{
    use Queueable;

    public string $status;

    public function __construct(public Booking $booking, string $status)
    {
        $this->status = $status;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your booking status has been updated',
        );
    }

    public function content(): Content
    {
        $statusText = match ($this->status) {
            'confirmed' => 'confirmed',
            'completed' => 'completed',
            default => 'updated',
        };

        return new Content(
            view: 'emails.booking-status',
            with: [
                'booking' => $this->booking,
                'status' => $statusText,
            ],
        );
    }
}
