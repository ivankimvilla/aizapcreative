<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AIZAP Creatives — Bookings</title>
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
            <span class="stat-count">7</span><span class="stat-label">All bookings</span>
          </button>
          <button type="button" class="stat-tile status-confirmed" data-filter="confirmed">
            <span class="stat-count">3</span><span class="stat-label">Confirmed</span>
          </button>
          <button type="button" class="stat-tile status-pending" data-filter="pending">
            <span class="stat-count">1</span><span class="stat-label">Pending</span>
          </button>
          <button type="button" class="stat-tile status-completed" data-filter="completed">
            <span class="stat-count">2</span><span class="stat-label">Completed</span>
          </button>
          <button type="button" class="stat-tile status-cancelled" data-filter="cancelled">
            <span class="stat-count">1</span><span class="stat-label">Cancelled</span>
          </button>
        </div>

        <div class="booking-list" id="bookingList">

          <!-- Friday, July 24 -->
          <div class="day-divider"><span>Friday, July 24</span></div>

          <div class="booking-card" data-status="completed">
            <div class="booking-card-top">
              <span class="thread-avatar hue-1">NR</span>
              <div class="booking-heading">
                <h3>Nova Retail</h3>
                <p class="booking-type">Budget check-in</p>
              </div>
              <span class="status-pill completed">Completed</span>
            </div>
            <div class="booking-card-details">
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                11:30 PM – 12:00 AM · 30 min
              </span>
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                Phone
              </span>
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.5 2.6 4 5.8 4 9s-1.5 6.4-4 9c-2.5-2.6-4-5.8-4-9s1.5-6.4 4-9Z"/></svg>
                Client sees EDT (UTC-4)
              </span>
            </div>
            <div class="booking-card-actions">
              <button class="btn-ghost">View notes</button>
            </div>
          </div>

          <!-- Wednesday, July 29 -->
          <div class="day-divider"><span>Wednesday, July 29</span></div>

          <div class="booking-card" data-status="cancelled">
            <div class="booking-card-top">
              <span class="thread-avatar hue-2">FC</span>
              <div class="booking-heading">
                <h3>Fen &amp; Co.</h3>
                <p class="booking-type">Testimonial planning call</p>
              </div>
              <span class="status-pill cancelled">Cancelled</span>
            </div>
            <div class="booking-card-details">
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                6:00 AM – 6:30 AM · 30 min
              </span>
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                Cancelled by client
              </span>
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.5 2.6 4 5.8 4 9s-1.5 6.4-4 9c-2.5-2.6-4-5.8-4-9s1.5-6.4 4-9Z"/></svg>
                Client sees BST (UTC+1)
              </span>
            </div>
            <div class="booking-card-actions">
              <button class="btn-ghost">Rebook</button>
            </div>
          </div>

          <!-- Thursday, July 30 -->
          <div class="day-divider"><span>Thursday, July 30</span></div>

          <div class="booking-card" data-status="completed">
            <div class="booking-card-top">
              <span class="thread-avatar hue-4">MR</span>
              <div class="booking-heading">
                <h3>Marlowe &amp; Rae</h3>
                <p class="booking-type">Final review — Event Recap</p>
              </div>
              <span class="status-pill completed">Completed</span>
            </div>
            <div class="booking-card-details">
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                4:00 AM – 4:30 AM · 30 min
              </span>
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                Google Meet
              </span>
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.5 2.6 4 5.8 4 9s-1.5 6.4-4 9c-2.5-2.6-4-5.8-4-9s1.5-6.4 4-9Z"/></svg>
                Client sees AEST (UTC+10)
              </span>
            </div>
            <div class="booking-card-actions">
              <button class="btn-ghost">View notes</button>
            </div>
          </div>

          <!-- Monday, August 3 -->
          <div class="day-divider"><span>Monday, August 3</span></div>

          <div class="booking-card" data-status="confirmed">
            <div class="booking-card-top">
              <span class="thread-avatar hue-1">NR</span>
              <div class="booking-heading">
                <h3>Nova Retail</h3>
                <p class="booking-type">Discovery call — Summer Campaign</p>
              </div>
              <span class="status-pill confirmed">Confirmed</span>
            </div>
            <div class="booking-card-details">
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                5:00 AM – 5:30 AM · 30 min
              </span>
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                Google Meet
              </span>
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.5 2.6 4 5.8 4 9s-1.5 6.4-4 9c-2.5-2.6-4-5.8-4-9s1.5-6.4 4-9Z"/></svg>
                Client sees EDT (UTC-4)
              </span>
            </div>
            <div class="booking-card-actions">
              <button class="btn-ghost">Reschedule</button>
              <button class="btn-primary-sm">Join call</button>
            </div>
          </div>

          <div class="booking-card" data-status="pending">
            <div class="booking-card-top">
              <span class="thread-avatar hue-2">FC</span>
              <div class="booking-heading">
                <h3>Fen &amp; Co.</h3>
                <p class="booking-type">Revision review — Product Launch Reel</p>
              </div>
              <span class="status-pill pending">Pending</span>
            </div>
            <div class="booking-card-details">
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                8:30 AM – 9:00 AM · 30 min
              </span>
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                Awaiting confirmation
              </span>
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.5 2.6 4 5.8 4 9s-1.5 6.4-4 9c-2.5-2.6-4-5.8-4-9s1.5-6.4 4-9Z"/></svg>
                Client sees BST (UTC+1)
              </span>
            </div>
            <div class="booking-card-actions">
              <button class="btn-ghost">Decline</button>
              <button class="btn-primary-sm">Confirm</button>
            </div>
          </div>

          <!-- Tuesday, August 4 -->
          <div class="day-divider"><span>Tuesday, August 4</span></div>

          <div class="booking-card" data-status="confirmed">
            <div class="booking-card-top">
              <span class="thread-avatar hue-3">AS</span>
              <div class="booking-heading">
                <h3>Ardent Studio</h3>
                <p class="booking-type">Kickoff call — Holiday Promo</p>
              </div>
              <span class="status-pill confirmed">Confirmed</span>
            </div>
            <div class="booking-card-details">
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                2:00 AM – 2:45 AM · 45 min
              </span>
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                Zoom
              </span>
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.5 2.6 4 5.8 4 9s-1.5 6.4-4 9c-2.5-2.6-4-5.8-4-9s1.5-6.4 4-9Z"/></svg>
                Client sees PHT (UTC+8)
              </span>
            </div>
            <div class="booking-card-actions">
              <button class="btn-ghost">Reschedule</button>
              <button class="btn-primary-sm">Join call</button>
            </div>
          </div>

          <!-- Thursday, August 6 -->
          <div class="day-divider"><span>Thursday, August 6</span></div>

          <div class="booking-card" data-status="confirmed">
            <div class="booking-card-top">
              <span class="thread-avatar hue-3">AS</span>
              <div class="booking-heading">
                <h3>Ardent Studio</h3>
                <p class="booking-type">Shot list walkthrough</p>
              </div>
              <span class="status-pill confirmed">Confirmed</span>
            </div>
            <div class="booking-card-details">
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                12:00 AM – 1:00 AM · 60 min
              </span>
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                Zoom
              </span>
              <span class="booking-detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.5 2.6 4 5.8 4 9s-1.5 6.4-4 9c-2.5-2.6-4-5.8-4-9s1.5-6.4 4-9Z"/></svg>
                Client sees PHT (UTC+8)
              </span>
            </div>
            <div class="booking-card-actions">
              <button class="btn-ghost">Reschedule</button>
              <button class="btn-primary-sm">Join call</button>
            </div>
          </div>

        </div>

      </div>
    </main>
  </div>
</body>
</html>