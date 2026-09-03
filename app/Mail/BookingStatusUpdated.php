<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingStatusUpdated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Booking $booking;

    public string $status;

    public function __construct(Booking $booking, string $status)
    {
        $this->booking = $booking;
        $this->status = $status;
    }

    public function build(): self
    {
        $subject = match ($this->status) {
            'confirmed' => 'Your booking has been confirmed',
            'completed' => 'Your booking has been completed',
            default => 'Booking status updated',
        };

        return $this->subject($subject)
            ->to($this->booking->email)
            ->markdown('emails.booking-status-updated', [
                'booking' => $this->booking,
                'status' => $this->status,
            ]);
    }
}
