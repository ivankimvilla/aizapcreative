@forelse($bookingsByDate as $dateLabel => $dayBookings)
  <tr class="date-row">
    <td colspan="10">{{ $dateLabel }}</td>
  </tr>
  @foreach($dayBookings as $booking)
    @php
      $tz = $booking->timezone ?: config('app.timezone');
      $startTime = $booking->starts_at->copy()->setTimezone($tz);
      $endTime = $startTime->copy()->addMinutes(30);
    @endphp
    <tr data-status="{{ $booking->status }}" data-name="{{ e($booking->name) }}" data-note="{{ e($booking->message ?: 'No note provided.') }}">
      <td class="booking-select-column">
        <input type="checkbox" class="booking-select" value="{{ $booking->id }}" aria-label="Select booking for {{ e($booking->name) }}">
      </td>
      <td>
        <span class="cell-title">{{ $booking->company ?: $booking->name }}</span>
        @if($booking->company)
          <span class="cell-sub">{{ $booking->name }}</span>
        @endif
      </td>
      <td>{{ $booking->service }}</td>
      <td>{{ $startTime->format('g:i A') }} – {{ $endTime->format('g:i A') }}</td>
      <td><a href="https://meet.google.com/new" target="_blank" rel="noopener noreferrer">Start Google Meet</a></td>
      <td>{{ $booking->timezone_label ?: $tz }}</td>
      <td>
        <span class="cell-title">{{ $booking->email }}</span>
        @if($booking->phone)
          <span class="cell-sub">{{ $booking->phone }}</span>
        @endif
      </td>
      <td class="cell-note"><button type="button" class="booking-note-view">View</button></td>
      <td><span class="status-pill {{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
      <td class="booking-actions">
        <button type="button" class="booking-menu-trigger" aria-label="Booking actions" aria-expanded="false">
          <span aria-hidden="true">&#8942;</span>
        </button>
        <div class="booking-menu" hidden>
          @if($booking->status === 'pending')
            <form method="POST" action="{{ route('admin.boards.confirm', $booking) }}">
              @csrf
              @method('PATCH')
              <button type="submit" class="booking-menu-item booking-menu-item-confirm">Confirm</button>
            </form>
          @endif
          @if($booking->status === 'confirmed')
            <form method="POST" action="{{ route('admin.boards.complete', $booking) }}">
              @csrf
              @method('PATCH')
              <button type="submit" class="booking-menu-item booking-menu-item-confirm">Mark Completed</button>
            </form>
          @endif
          <form method="POST" action="{{ route('admin.boards.destroy', $booking) }}" class="delete-booking-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="booking-menu-item booking-menu-item-danger">Delete</button>
          </form>
          @if(in_array($booking->status, ['pending', 'confirmed'], true))
            <form method="POST" action="{{ route('admin.boards.cancel', $booking) }}" class="cancel-booking-form">
              @csrf
              @method('PATCH')
              <button type="submit" class="booking-menu-item booking-menu-item-cancel">Cancel</button>
            </form>
          @endif
        </div>
      </td>
    </tr>
  @endforeach
@empty
  <tr>
    <td colspan="10" class="table-empty">No bookings yet</td>
  </tr>
@endforelse
