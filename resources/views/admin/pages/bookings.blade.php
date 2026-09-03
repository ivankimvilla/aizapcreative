@extends('admin.layouts.app')

@section('title', 'Aizap Creatives - Bookings')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/pages/bookings.css') }}">
@endsection

@section('content')
  @if (session('status'))
    <div class="admin-booking-alert admin-booking-alert--success" role="status">{{ session('status') }}</div>
  @endif
  @if ($errors->any())
    <div class="admin-booking-alert admin-booking-alert--error" role="alert">{{ $errors->first() }}</div>
  @endif

  <div class="topbar">
    <div class="topbar-left">
      <button class="menu-toggle" id="menuToggle" aria-label="Open menu" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
      <div class="topbar-title">
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
    </div>

    <div class="topbar-stats" id="topbarStats">
      <span class="topbar-stat topbar-stat-all">
        <strong>{{ $stats['all'] ?? 0 }}</strong> All bookings
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
@endsection

@section('scripts')
<script src="{{ asset('js/admin/pages/bookings.js') }}?v={{ filemtime(public_path('js/admin/pages/bookings.js')) }}"></script>
@endsection