<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Feedback;
use App\Models\ProjectVideo;
use App\Models\SiteVisit;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $messagesCount = ContactMessage::count();
        $feedbackCount = Feedback::count();
        $videosCount = ProjectVideo::count();
        $bookingsCount = \App\Models\Booking::count();

        $todayVisits = SiteVisit::whereDate('created_at', Carbon::today())->count();
        $weekVisits = SiteVisit::whereBetween('created_at', [Carbon::today()->subDays(6)->startOfDay(), Carbon::today()->endOfDay()])->count();
        $previousWeekVisits = SiteVisit::whereBetween('created_at', [Carbon::today()->subDays(13)->startOfDay(), Carbon::today()->subDays(7)->endOfDay()])->count();

        $siteVisits = max(0, $weekVisits);
        $totalVisits = max(0, SiteVisit::count());
        $recentVisits = SiteVisit::latest()->take(6)->get();

        $visitsTrendPercent = $previousWeekVisits > 0
            ? round((($weekVisits - $previousWeekVisits) / $previousWeekVisits) * 100)
            : ($weekVisits > 0 ? 100 : 0);

        $visitsTrendLabel = $visitsTrendPercent >= 0
            ? '+'.$visitsTrendPercent.'% this week'
            : $visitsTrendPercent.'% this week';

        $dailyTrafficCounts = SiteVisit::query()
            ->selectRaw('date(created_at) as date, count(*) as count')
            ->whereBetween('created_at', [Carbon::today()->subDays(6)->startOfDay(), Carbon::today()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $dailyTraffic = collect(range(6, 0, -1))->map(function ($days) use ($dailyTrafficCounts) {
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
            'siteVisits',
            'totalVisits',
            'todayVisits',
            'visitsTrendLabel',
            'recentVisits',
            'dailyTraffic',
            'topPages'
        ));
    }
}
