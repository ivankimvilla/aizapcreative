@forelse ($messages as $message)
  <div class="message-row-wrap{{ $message->is_read ? ' viewed' : '' }}"
       data-msg-id="{{ $message->id }}"
       data-is-read="{{ $message->is_read ? '1' : '0' }}"
       data-name="{{ e($message->name) }}"
       data-email="{{ e($message->email ?: 'Not provided') }}"
      data-phone="{{ e($message->phone ?: 'Not provided') }}"
       data-role="{{ e($message->role) }}"
      data-subject="{{ e($message->subject) }}"
       data-date="{{ e($message->created_at?->format('M j, Y g:i A') ?: '—') }}"
       data-message="{{ e($message->message) }}">
    <input type="checkbox" class="message-select" value="{{ $message->id }}" aria-label="Select message from {{ e($message->name) }}">
    <button type="button" class="message-row" aria-expanded="false">
      <span class="msg-name">{{ $message->name }}</span>
      <span class="new-badge">New</span>
      <span class="msg-preview">
        <span class="msg-label">
          {{ in_array($message->subject, ['AI Commercial Ads', 'Product Advertising', 'Storytelling & Short Films', 'Custom Projects'], true) ? 'Quote Request:' : 'Message:' }}
        </span>
        {{ \Illuminate\Support\Str::limit($message->message, 70) }}
      </span>
      <span class="msg-date">{{ $message->created_at?->format('M j') ?: '—' }}</span>
    </button>
    <button type="button" class="delete-message-btn" data-message-id="{{ $message->id }}" aria-label="Delete message from {{ e($message->name) }}" title="Delete message">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
        <path d="M4 7h16M10 11v6M14 11v6M6 7l1 14h10l1-14M9 7V4h6v3" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </button>
  </div>
@empty
  <div class="table-empty">no message</div>
@endforelse
