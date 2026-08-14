<?php

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the booking page and stores a booking from the modal form', function () {
    $createAt = Carbon::now()->addDays(1)->setTime(14, 30);
    $selectedSlot = $createAt->format('Y-m-d g:i A');

    $response = $this->post('/book-a-call', [
        'service' => 'AI Product Ads',
        'name' => 'Test Booker',
        'email' => 'test@example.com',
        'phone' => '+15555550123',
        'company' => 'Test Co',
        'message' => 'Looking to schedule a campaign review.',
        'selected_slot' => $selectedSlot,
        'timezone' => 'UTC',
    ]);

    $response->assertRedirect('/book-a-call');
    $response->assertSessionHas('status', 'Your booking request was sent successfully.');

    $this->assertDatabaseHas('bookings', [
        'service' => 'AI Product Ads',
        'name' => 'Test Booker',
        'email' => 'test@example.com',
        'phone' => '+15555550123',
        'company' => 'Test Co',
    ]);

    $booking = Booking::where('email', 'test@example.com')->first();
    expect($booking)->not()->toBeNull();
    expect($booking->starts_at->eq($createAt))->toBeTrue();
});

it('returns booked slots for a date and disables them on availability lookup', function () {
    $targetDate = Carbon::now()->addDays(2)->startOfDay();
    $selectedSlot = $targetDate->copy()->setTime(15, 0)->format('Y-m-d g:i A');

    $this->post('/book-a-call', [
        'service' => 'AI Commercial Ads',
        'name' => 'Existing Client',
        'email' => 'existing@example.com',
        'phone' => '+15555550999',
        'company' => 'Existing Co',
        'message' => 'Already booked slot.',
        'selected_slot' => $selectedSlot,
        'timezone' => 'UTC',
    ]);

    $response = $this->get('/book-a-call/availability?date=' . $targetDate->format('Y-m-d') . '&timezone=UTC');

    $response->assertStatus(200);
    $response->assertJsonFragment(['booked_slots' => ['3:00 PM']]);
});

it('does not count completed bookings as unavailable slots', function () {
    $targetDate = Carbon::now()->addDays(4)->startOfDay();
    $selectedSlot = $targetDate->copy()->setTime(9, 0)->format('Y-m-d g:i A');

    Booking::factory()->create([
        'service' => 'AI Commercial Ads',
        'name' => 'Completed Client',
        'email' => 'completed@example.com',
        'phone' => '+15555550111',
        'company' => 'Completed Co',
        'message' => 'Already completed slot.',
        'starts_at' => $targetDate->copy()->setTime(9, 0),
        'timezone' => 'UTC',
        'status' => 'completed',
    ]);

    $response = $this->get('/book-a-call/availability?date=' . $targetDate->format('Y-m-d') . '&timezone=UTC');

    $response->assertStatus(200);
    $response->assertJson(['booked_slots' => [], 'fully_booked' => false]);
});

it('does not mark a future date fully booked when there are no bookings', function () {
    $targetDate = Carbon::now()->addDays(3)->startOfDay();

    $response = $this->get('/book-a-call/availability?date=' . $targetDate->format('Y-m-d') . '&timezone=UTC');

    $response->assertStatus(200);
    $response->assertJson(['booked_slots' => [], 'fully_booked' => false]);
});
