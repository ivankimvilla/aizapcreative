<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function markRead(string $type, int $id)
    {
        if ($type === 'message') {
            ContactMessage::findOrFail($id)->update(['is_read' => true]);
        } elseif ($type === 'booking') {
            Booking::findOrFail($id)->update(['is_read' => true]);
        }

        if (request()->expectsJson()) {
            return response()->json(['status' => 'success']);
        }

        return back();
    }

    public function markAllRead(Request $request)
    {
        ContactMessage::where('is_read', false)->update(['is_read' => true]);
        Booking::where('is_read', false)->update(['is_read' => true]);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success']);
        }

        return back();
    }
}
