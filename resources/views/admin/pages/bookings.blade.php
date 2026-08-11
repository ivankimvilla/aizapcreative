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
      @if (session('status'))
        <div class="admin-booking-alert admin-booking-alert--success" role="status">{{ session('status') }}</div>
      @endif
      @if ($errors->any())
        <div class="admin-booking-alert admin-booking-alert--error" role="alert">{{ $errors->first() }}</div>
      @endif

      <div class="topbar">
        <div class="topbar-title">
          <p class="crumb">Studio / Bookings</p>
          <form method="POST" action="{{ route('admin.boards.bulk-destroy') }}" id="bulkDeleteBookingsForm" class="booking-bulk-actions">
            @csrf
            @method('DELETE')
            <label class="booking-select-all">
              <input type="checkbox" id="selectAllBookings" aria-label="Select all bookings">
              <span>Select all</span>
            </label>
            <button type="submit" id="deleteSelectedBookings" class="booking-bulk-delete" disabled>Delete selected</button>
          </form>
        </div>

        <div class="topbar-stats" id="topbarStats">
          <span class="topbar-stat topbar-stat-all">
            <strong>{{ $stats['all'] ?? 0 }}</strong> All bookings
          </span>
          <span class="topbar-stat topbar-stat-confirmed">
            <strong>{{ $stats['confirmed'] ?? 0 }}</strong> Confirmed
          </span>
          <span class="topbar-stat topbar-stat-pending">
            <strong>{{ $stats['pending'] ?? 0 }}</strong> Pending
          </span>
          <span class="topbar-stat topbar-stat-completed">
            <strong>{{ $stats['completed'] ?? 0 }}</strong> Completed
          </span>
          <span class="topbar-stat topbar-stat-cancelled">
            <strong>{{ $stats['cancelled'] ?? 0 }}</strong> Cancelled
          </span>
        </div>
      </div>

      <div class="booking-panel" id="bookingPanel">

        <div class="booking-table-wrap">
          <table class="booking-table">
            <thead>
              <tr>
                <th class="booking-select-column" aria-label="Select booking"></th>
                <th>Client</th>
                <th>Service</th>
                <th>Time</th>
                <th>Platform</th>
                <th>Timezone</th>
                <th>Contact</th>
                <th>Note</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @include('admin.pages.partials.booking-rows', ['bookingsByDate' => $bookingsByDate])
            </tbody>
          </table>
        </div>

      </div>

      <div class="booking-note-modal" id="bookingNoteModal" hidden>
        <div class="booking-note-dialog" role="dialog" aria-modal="true" aria-labelledby="bookingNoteTitle">
          <div class="booking-note-dialog-header">
            <h2 id="bookingNoteTitle">Note</h2>
            <button type="button" class="booking-note-close" id="bookingNoteClose" aria-label="Close note">&times;</button>
          </div>
          <p class="booking-note-author" id="bookingNoteAuthor"></p>
          <p id="bookingNoteText"></p>
        </div>
      </div>
    </main>
  </div>
  <script src="{{ asset('js/admin/pages/bookings.js') }}?v={{ filemtime(public_path('js/admin/pages/bookings.js')) }}"></script>
</body>
</html>