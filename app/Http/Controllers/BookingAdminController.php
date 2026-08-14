<?php

namespace App\Http\Controllers;

use App\Mail\BookingStatusUpdated;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingAdminController extends Controller
{
    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'distinct', 'exists:bookings,id'],
        ]);

        $deleted = Booking::whereIn('id', $validated['ids'])->delete();

        return redirect()->route('admin.boards')->with('status', $deleted.' booking(s) deleted.');
    }

    public function cancel(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);

        return redirect()->route('admin.boards')->with('status', 'Booking cancelled.');
    }

    public function complete(Booking $booking)
    {
        $booking->update(['status' => 'completed']);

        try {
            Mail::to($booking->email)->send(new BookingStatusUpdated($booking, 'completed'));
        } catch (\Throwable $e) {
            \Log::warning('Booking completion email failed to send.', [
                'booking_id' => $booking->id,
                'email' => $booking->email,
                'exception' => $e->getMessage(),
            ]);
        }

        return redirect()->route('admin.boards')->with('status', 'Booking marked as completed.');
    }

    public function confirm(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);

        try {
            Mail::to($booking->email)->send(new BookingStatusUpdated($booking, 'confirmed'));
        } catch (\Throwable $e) {
            \Log::warning('Booking confirmation email failed to send.', [
                'booking_id' => $booking->id,
                'email' => $booking->email,
                'exception' => $e->getMessage(),
            ]);
        }

        return redirect()->route('admin.boards')->with('status', 'Booking confirmed.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.boards')->with('status', 'Booking deleted.');
    }

    public function index(Request $request)
    {
        $bookings = Booking::orderBy('starts_at')->get();

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

        if ($request->expectsJson()) {
            return response()->json([
                'html' => view('admin.pages.partials.booking-rows', compact('bookingsByDate'))->render(),
                'stats' => $stats,
            ]);
        }

        return view('admin.pages.bookings', compact('bookings', 'stats', 'bookingsByDate'));
    }
}
