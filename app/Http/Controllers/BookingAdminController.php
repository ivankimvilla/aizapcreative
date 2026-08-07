<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class BookingAdminController extends Controller
{
    public function index()
    {
        $bookings = Booking::orderByDesc('starts_at')->get();

        $stats = [
            'all' => $bookings->count(),
            'confirmed' => $bookings->where('status', 'confirmed')->count(),
            'pending' => $bookings->where('status', 'pending')->count(),
            'completed' => $bookings->where('status', 'completed')->count(),
            'cancelled' => $bookings->where('status', 'cancelled')->count(),
        ];

        $bookingsByDate = $bookings->groupBy(function (Booking $booking) {
            return $booking->starts_at
                ->copy()
                ->setTimezone($booking->timezone ?: config('app.timezone'))
                ->format('l, F j');
        });

        return view('admin.pages.bookings', compact('bookings', 'stats', 'bookingsByDate'));
    }
}
