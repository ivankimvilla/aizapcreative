<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\RecaptchaEnterprise;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    use RecaptchaEnterprise;

    public function index()
    {
        return view('booking-calendar.booking-calendar');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'company' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:2000',
            'selected_slot' => 'required|string',
            'timezone' => 'required|string|max:100',
            'g-recaptcha-response' => ['required'],
        ], [
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA before booking.',
        ]);

        if (! $this->verifyRecaptcha($request, 'booking')) {
            return $this->recaptchaFailed($request);
        }

        $timezone = in_array($data['timezone'], timezone_identifiers_list())
            ? new \DateTimeZone($data['timezone'])
            : new \DateTimeZone(config('app.timezone'));

        $startsAt = Carbon::createFromFormat('Y-m-d g:i A', $data['selected_slot'], $timezone);
        if (! $startsAt) {
            return back()->withErrors(['selected_slot' => 'Invalid time slot selected.'])->withInput();
        }

        if ($startsAt->isPast()) {
            return back()->withErrors(['selected_slot' => 'Selected slot must be in the future.'])->withInput();
        }

        $startsAtUtc = $startsAt->copy()->setTimezone('UTC');
        $booked = Booking::where('starts_at', $startsAtUtc)->exists();
        if ($booked) {
            return back()->withErrors(['selected_slot' => 'This time slot is no longer available. Please choose another slot.'])->withInput();
        }

        $booking = Booking::create([
            'service' => $data['service'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'company' => $data['company'],
            'message' => $data['message'],
            'starts_at' => $startsAtUtc,
            'timezone' => $data['timezone'],
            'meeting_link' => 'https://meet.google.com/' . strtolower(substr(md5($data['email'] . now()), 0, 10)),
            'status' => 'confirmed',
        ]);

        // TODO: send emails, notifications, calendar event.

        return redirect('/book-a-call')->with('status', 'Booking confirmed! We sent your confirmation email.');
    }

    public function availability(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'timezone' => 'nullable|string|max:100',
        ]);

        $timezone = in_array($request->input('timezone'), timezone_identifiers_list())
            ? new \DateTimeZone($request->input('timezone'))
            : new \DateTimeZone(config('app.timezone'));

        $dayStart = Carbon::createFromFormat('Y-m-d', $data['date'], $timezone)->startOfDay();
        $dayEnd = $dayStart->copy()->endOfDay();

        $utcStart = $dayStart->copy()->setTimezone('UTC');
        $utcEnd = $dayEnd->copy()->setTimezone('UTC');

        $bookedSlots = Booking::whereBetween('starts_at', [$utcStart, $utcEnd])
            ->get()
            ->map(function (Booking $booking) use ($timezone) {
                return $booking->starts_at->copy()->setTimezone($timezone)->format('g:i A');
            })
            ->unique()
            ->values();

        $allSlots = $this->getDailyTimeSlots($timezone, $dayStart->toDateString());
        $now = Carbon::now($timezone);
        $fullyBooked = collect($allSlots)->every(function ($slot) use ($bookedSlots, $timezone, $now) {
            $slotDate = Carbon::createFromFormat('Y-m-d g:i A', $slot['date'] . ' ' . $slot['label'], $timezone);
            $isBooked = $bookedSlots->contains($slot['label']);
            $isPast = $slotDate->isPast();

            return $isBooked || $isPast;
        });

        return response()->json([
            'booked_slots' => $bookedSlots,
            'fully_booked' => $fullyBooked,
        ]);
    }

    private function getDailyTimeSlots(\DateTimeZone $timezone, string $date): array
    {
        $start = Carbon::createFromFormat('Y-m-d g:i A', $date . ' 12:30 PM', $timezone);
        $end = Carbon::createFromFormat('Y-m-d g:i A', $date . ' 10:30 PM', $timezone);

        $slots = [];
        $current = $start->copy();

        while ($current->lte($end)) {
            $slots[] = [
                'date' => $date,
                'label' => $current->format('g:i A'),
            ];
            $current->addMinutes(30);
        }

        return $slots;
    }
}
