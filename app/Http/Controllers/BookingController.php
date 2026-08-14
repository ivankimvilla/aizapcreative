<?php

namespace App\Http\Controllers;

use App\Mail\NewBookingRequest;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking-calendar.booking-calendar');
    }

    public function availability(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date_format:Y-m-d'],
            'timezone' => ['nullable', 'string', 'max:255'],
        ]);

        $date = Carbon::createFromFormat('Y-m-d', $validated['date']);

        $bookings = Booking::whereDate('starts_at', $date->toDateString())
            ->whereIn('status', ['pending'])
            ->get()
            ->map(function (Booking $booking) {
                return $booking->starts_at->format('g:i A');
            })
            ->values()
            ->all();

        $availableSlots = [
            '12:30 PM','1:00 PM','1:30 PM','2:00 PM','2:30 PM','3:00 PM','3:30 PM','4:00 PM','4:30 PM',
            '5:00 PM','5:30 PM','6:00 PM','6:30 PM','7:00 PM','7:30 PM','8:00 PM','8:30 PM','9:00 PM',
            '9:30 PM','10:00 PM','10:30 PM',
        ];

        $bookedSlots = array_values(array_unique($bookings));
        $fullyBooked = ! empty($bookedSlots) && count($bookedSlots) === count($availableSlots)
            && empty(array_diff($availableSlots, $bookedSlots));

        return response()->json([
            'booked_slots' => $bookedSlots,
            'fully_booked' => $fullyBooked,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
            'selected_slot' => ['required', 'string'],
            'timezone' => ['nullable', 'string', 'max:255'],
            'timezone_label' => ['nullable', 'string', 'max:255'],
        ]);

        $selectedSlot = Carbon::createFromFormat('Y-m-d g:i A', $validated['selected_slot']);

        if (! $selectedSlot || $selectedSlot->format('Y-m-d g:i A') !== $validated['selected_slot']) {
            return back()->withErrors(['selected_slot' => 'Please choose a valid time slot.']);
        }

        $timezone = $validated['timezone'] ?? config('app.timezone');

        $booking = Booking::create([
            'service' => $validated['service'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'] ?? null,
            'message' => $validated['message'] ?? null,
            'starts_at' => $selectedSlot,
            'timezone' => $timezone,
            'timezone_label' => $validated['timezone_label'] ?? $timezone,
            'status' => 'pending',
            'is_read' => false,
        ]);

        try {
            Mail::to(env('MAIL_TO_ADDRESS', config('mail.from.address')))->send(new NewBookingRequest($booking));
        } catch (\Throwable $e) {
            Log::warning('Booking request email failed to send.', [
                'booking_id' => $booking->id,
                'email' => $booking->email,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('book-a-call')->with('status', 'Your booking request was sent successfully.');
    }
}
