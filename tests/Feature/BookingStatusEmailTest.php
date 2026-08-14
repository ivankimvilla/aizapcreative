<?php

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('sends a confirmation email when a booking is confirmed', function () {
    Mail::fake();

    $admin = User::factory()->create();
    $booking = Booking::factory()->create([
        'email' => 'client@example.com',
        'status' => 'pending',
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.boards.confirm', $booking));

    Mail::assertSent(\App\Mail\BookingStatusUpdated::class, function ($mail) use ($booking) {
        return $mail->hasTo($booking->email)
            && $mail->status === 'confirmed';
    });
});

it('sends a completed email when a booking is marked completed', function () {
    Mail::fake();

    $admin = User::factory()->create();
    $booking = Booking::factory()->create([
        'email' => 'client@example.com',
        'status' => 'confirmed',
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.boards.complete', $booking));

    Mail::assertSent(\App\Mail\BookingStatusUpdated::class, function ($mail) use ($booking) {
        return $mail->hasTo($booking->email)
            && $mail->status === 'completed';
    });
});
