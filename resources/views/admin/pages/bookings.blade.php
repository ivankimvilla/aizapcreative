<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aizap Creatives - Bookings</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin/pages/bookings.css') }}">
</head>
<body>
  <div class="shell">
    @include('admin.sidebar.sidebar')

    <div class="seam" aria-hidden="true">
      <svg viewBox="0 0 10 800" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M5 0 L2 60 L8 130 L1 210 L9 280 L2 350 L8 420 L2 490 L8 560 L1 630 L9 700 L3 760 L5 800" />
      </svg>
    </div>

    <main class="main">
      <div class="topbar">
        <div class="topbar-title">
          <p class="crumb">Studio / Bookings</p>
        </div>
      </div>

      <!-- BOOKING REPOSITORY -->
      <div class="booking-panel" id="bookingPanel">

        <div class="booking-toolbar">
          <div class="booking-toolbar-left">
            <h2>Bookings</h2>
          </div>
        </div>

        <div class="booking-stats" id="bookingStats">
          <button type="button" class="stat-tile status-all active" data-filter="all">
            <span class="stat-count">{{ $stats['all'] ?? 0 }}</span><span class="stat-label">All bookings</span>
          </button>
          <button type="button" class="stat-tile status-confirmed" data-filter="confirmed">
            <span class="stat-count">{{ $stats['confirmed'] ?? 0 }}</span><span class="stat-label">Confirmed</span>
          </button>
          <button type="button" class="stat-tile status-pending" data-filter="pending">
            <span class="stat-count">{{ $stats['pending'] ?? 0 }}</span><span class="stat-label">Pending</span>
          </button>
          <button type="button" class="stat-tile status-completed" data-filter="completed">
            <span class="stat-count">{{ $stats['completed'] ?? 0 }}</span><span class="stat-label">Completed</span>
          </button>
          <button type="button" class="stat-tile status-cancelled" data-filter="cancelled">
            <span class="stat-count">{{ $stats['cancelled'] ?? 0 }}</span><span class="stat-label">Cancelled</span>
          </button>
        </div>

        <div class="booking-list" id="bookingList">
          @forelse($bookingsByDate as $dateLabel => $dayBookings)
            <div class="day-divider"><span>{{ $dateLabel }}</span></div>
            @foreach($dayBookings as $booking)
              @php
                $tz = $booking->timezone ?: config('app.timezone');
                $startTime = $booking->starts_at->copy()->setTimezone($tz);
                $endTime = $startTime->copy()->addMinutes(30);
                $initials = strtoupper(substr($booking->name, 0, 2));
              @endphp
              <div class="booking-card" data-status="{{ $booking->status }}">
                <div class="booking-card-top">
                  <span class="thread-avatar">{{ $initials }}</span>
                  <div class="booking-heading">
                    <h3>{{ $booking->company ?: $booking->name }}</h3>
                    <p class="booking-type">{{ $booking->service }}</p>
                  </div>
                  <span class="status-pill {{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                </div>
                <div class="booking-card-details">
                  <span class="booking-detail">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                    {{ $startTime->format('g:i A') }} – {{ $endTime->format('g:i A') }} · 30 min
                  </span>
                  <span class="booking-detail">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ $booking->meeting_link ? 'Google Meet' : 'Phone' }}
                  </span>
                  <span class="booking-detail">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.5 2.6 4 5.8 4 9s-1.5 6.4-4 9c-2.5-2.6-4-5.8-4-9s1.5-6.4 4-9Z"/></svg>
                    Client sees {{ $tz }}
                  </span>
                </div>
                <div class="booking-card-actions">
                  <button class="btn-ghost">View notes</button>
                </div>
              </div>
            @endforeach
          @empty
            <div class="day-divider"><span>No bookings yet</span></div>
          @endforelse
        </div>

      </div>
    </main>
  </div>
</body>
</html>