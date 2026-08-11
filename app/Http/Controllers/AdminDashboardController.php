<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Feedback;
use App\Models\ProjectVideo;
use App\Models\SiteVisit;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $messagesCount = ContactMessage::count();
        $feedbackCount = Feedback::count();
        $videosCount = ProjectVideo::count();
        $bookingsCount = Booking::count();

        $unreadMessagesCount = ContactMessage::where('is_read', false)->count();
        $unreadBookingsCount = Booking::where('is_read', false)->count();

        $latestMessages = ContactMessage::latest()->take(4)->get();
        $latestBookings = Booking::latest()->take(4)->get();

        $notifications = collect()
            ->concat($latestMessages->map(function (ContactMessage $message) {
                return [
                    'id' => 'message-'.$message->id,
                    'type' => 'Message',
                    'type_slug' => 'message',
                    'model_id' => $message->id,
                    'title' => $message->subject ?: 'New message from '.$message->name,
                    'description' => Str::limit($message->message, 72),
                    'meta' => $message->created_at->diffForHumans(),
                    'url' => route('admin.messages'),
                    'icon' => 'message',
                    'is_read' => $message->is_read,
                    'created_at' => $message->created_at,
                ];
            }))
            ->concat($latestBookings->map(function (Booking $booking) {
                return [
                    'id' => 'booking-'.$booking->id,
                    'type' => 'Booking',
                    'type_slug' => 'booking',
                    'model_id' => $booking->id,
                    'title' => $booking->company ?: $booking->name,
                    'description' => Str::limit($booking->message ?: $booking->service, 72),
                    'meta' => optional($booking->starts_at)->format('M j, H:i') ?: 'Scheduled soon',
                    'url' => route('admin.boards'),
                    'icon' => 'booking',
                    'is_read' => $booking->is_read,
                    'created_at' => $booking->created_at ?? now(),
                ];
            }))
            ->sortByDesc('created_at')
            ->take(6)
            ->values();

        $notificationsCount = $unreadMessagesCount + $unreadBookingsCount;

        $todayVisits = SiteVisit::whereDate('created_at', Carbon::today())->distinct('ip_address')->count('ip_address');
        $weekVisits = SiteVisit::whereBetween('created_at', [Carbon::today()->subDays(6)->startOfDay(), Carbon::today()->endOfDay()])->distinct('ip_address')->count('ip_address');
        $previousWeekVisits = SiteVisit::whereBetween('created_at', [Carbon::today()->subDays(13)->startOfDay(), Carbon::today()->subDays(7)->endOfDay()])->distinct('ip_address')->count('ip_address');

        $siteVisits = max(0, $weekVisits);
        $totalVisits = max(0, SiteVisit::query()->selectRaw('date(created_at) as visit_date, ip_address')->groupBy('visit_date', 'ip_address')->get()->count());
        $recentVisits = SiteVisit::latest()->take(6)->get();

        $visitsTrendPercent = $previousWeekVisits > 0
            ? round((($weekVisits - $previousWeekVisits) / $previousWeekVisits) * 100)
            : ($weekVisits > 0 ? 100 : 0);

        $visitsTrendLabel = $visitsTrendPercent >= 0
            ? '+'.$visitsTrendPercent.'% this week'
            : $visitsTrendPercent.'% this week';

        $dailyTrafficCounts = SiteVisit::query()
            ->selectRaw('date(created_at) as date, count(distinct ip_address) as count')
            ->whereBetween('created_at', [Carbon::today()->subDays(30)->startOfDay(), Carbon::today()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $dailyTraffic = collect(range(30, 0, -1))->map(function ($days) use ($dailyTrafficCounts) {
            $date = Carbon::today()->subDays($days)->format('Y-m-d');

            return (object) [
                'date' => $date,
                'count' => $dailyTrafficCounts->get($date, 0),
            ];
        });

        $topPages = SiteVisit::query()
            ->selectRaw('url, count(*) as count')
            ->whereNotNull('url')
            ->groupBy('url')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return view('admin.admin-dashboard.admin-dashboard', compact(
            'messagesCount',
            'feedbackCount',
            'videosCount',
            'bookingsCount',
            'notifications',
            'notificationsCount',
            'siteVisits',
            'totalVisits',
            'todayVisits',
            'visitsTrendLabel',
            'recentVisits',
            'dailyTraffic',
            'topPages'
        ));
    }

    public function traffic()
    {
        $dailyTrafficCounts = SiteVisit::query()
            ->selectRaw('date(created_at) as date, count(distinct ip_address) as count')
            ->whereBetween('created_at', [Carbon::today()->subDays(30)->startOfDay(), Carbon::today()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $points = collect(range(30, 0, -1))->map(function ($days) use ($dailyTrafficCounts) {
            $date = Carbon::today()->subDays($days)->format('Y-m-d');

            return [
                'date' => $date,
                'count' => (int) $dailyTrafficCounts->get($date, 0),
            ];
        });

        return response()->json([
            'chartMax' => max(1250, ceil(($points->max('count') ?: 1) / 250) * 250),
            'points' => $points->values(),
        ]);
    }
}
