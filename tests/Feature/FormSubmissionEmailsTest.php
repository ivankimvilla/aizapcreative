<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('sends a booking request email with all details', function () {
    Mail::fake();

    $this->post(route('book-a-call.store'), [
        'service' => 'AI Commercial Ads',
        'name' => 'Maria Dela Cruz',
        'email' => 'maria@example.com',
        'phone' => '09171234567',
        'company' => 'Aizap Studio',
        'message' => 'Need a video for a product launch.',
        'selected_slot' => '2026-08-20 1:00 PM',
        'timezone' => 'Asia/Manila',
        'timezone_label' => 'Philippine Time',
    ]);

    Mail::assertSent(\App\Mail\NewBookingRequest::class, function ($mail) {
        return $mail->hasTo(env('MAIL_TO_ADDRESS', config('mail.from.address')))
            && $mail->booking->service === 'AI Commercial Ads'
            && $mail->booking->email === 'maria@example.com'
            && $mail->booking->phone === '09171234567';
    });
});

it('sends a contact message email with all details', function () {
    Mail::fake();

    $this->post(route('contact.store'), [
        'first_name' => 'John',
        'last_name' => 'Smith',
        'email' => 'john@example.com',
        'message' => 'I want to know more about your packages.',
        'subject' => 'General Inquiry',
        'g-recaptcha-response' => 'test-token',
    ]);

    Mail::assertSent(\App\Mail\NewContactMessage::class, function ($mail) {
        return $mail->hasTo(env('MAIL_TO_ADDRESS', config('mail.from.address')))
            && $mail->messageData['name'] === 'John Smith'
            && $mail->messageData['email'] === 'john@example.com'
            && $mail->messageData['subject'] === 'General Inquiry';
    });
});

it('sends a quote request email with all details', function () {
    Mail::fake();

    $this->post(route('quote.store'), [
        'first_name' => 'Ana',
        'last_name' => 'Lorenzo',
        'email' => 'ana@example.com',
        'phone' => '09223334444',
        'company' => 'Bluewave Labs',
        'service' => 'Product Advertising',
        'message' => 'Need a 30-second product ad for our launch.',
        'g-recaptcha-response' => 'test-token',
    ]);

    Mail::assertSent(\App\Mail\NewQuoteRequest::class, function ($mail) {
        return $mail->hasTo(env('MAIL_TO_ADDRESS', config('mail.from.address')))
            && $mail->quoteData['name'] === 'Ana Lorenzo'
            && $mail->quoteData['email'] === 'ana@example.com'
            && $mail->quoteData['service'] === 'Product Advertising';
    });
});

it('uses the configured admin email as the recipient for contact, booking, and quote mailables', function () {
    $adminEmail = env('MAIL_TO_ADDRESS', config('mail.from.address'));

    $bookingMail = new \App\Mail\NewBookingRequest(\App\Models\Booking::factory()->make([
        'name' => 'Maria Dela Cruz',
        'email' => 'maria@example.com',
    ]));
    $contactMail = new \App\Mail\NewContactMessage([
        'name' => 'John Smith',
        'email' => 'john@example.com',
        'subject' => 'General Inquiry',
        'message' => 'Test message',
    ]);
    $quoteMail = new \App\Mail\NewQuoteRequest([
        'name' => 'Ana Lorenzo',
        'email' => 'ana@example.com',
        'service' => 'Product Advertising',
    ]);

    $this->assertSame([$adminEmail], array_column($bookingMail->build()->to, 'address'));
    $this->assertSame([$adminEmail], array_column($contactMail->build()->to, 'address'));
    $this->assertSame([$adminEmail], array_column($quoteMail->build()->to, 'address'));
});
