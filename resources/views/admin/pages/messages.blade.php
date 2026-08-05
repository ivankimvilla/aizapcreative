<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AIZAP Creatives — Clients</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin/pages/messages.css') }}">
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
          <p class="crumb">Studio / Message</p>
        </div>
      </div>

      <!-- MESSAGES -->
      <div class="inbox" id="inbox">

        <!-- THREAD LIST -->
        <div class="thread-list">
          <div class="thread-list-head">
            <h2>Conversations</h2>
            <span class="thread-count">{{ $messages->count() }}</span>
          </div>

          <div class="thread-items">
            @forelse ($messages as $message)
              <button class="thread-item{{ $loop->first ? ' active' : '' }}" data-name="{{ e($message->name) }}" data-role="{{ e($message->role ?: 'Client') }}" data-subject="{{ e($message->subject ?: 'New message') }}" data-email="{{ e($message->email ?: 'No email provided') }}" data-message="{{ e($message->message) }}" data-created-at="{{ $message->created_at?->format('M j, Y H:i') ?: '' }}">
                <span class="thread-avatar hue-{{ ($loop->index % 4) + 1 }}">{{ strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $message->name), 0, 2)) }}</span>
                <span class="thread-body">
                  <span class="thread-top">
                    <span class="thread-name">{{ $message->name }}</span>
                    <span class="thread-time">{{ $message->created_at?->format('M j') ?? 'Now' }}</span>
                  </span>
                  <span class="thread-preview">{{ \Illuminate\Support\Str::limit($message->subject ?: $message->message, 40) }}</span>
                </span>
              </button>
            @empty
              <div class="thread-empty">
                <p class="thread-empty__text">no message</p>
              </div>
            @endforelse
          </div>
        </div>

        <!-- THREAD VIEW -->
        <div class="thread-view">
          @php $firstMessage = $messages->first(); @endphp
          <div class="thread-view-head">
            <div class="thread-view-title">
              <span class="thread-avatar hue-1">{{ $firstMessage ? strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $firstMessage->name), 0, 2)) : 'CM' }}</span>
              <div>
                <h3>{{ $firstMessage->name ?? 'Contact Messages' }}</h3>
                <div class="thread-info-list">
                  <div class="thread-info-item">
                    <span class="thread-info-label">Email</span>
                    <span class="thread-info-value">{{ $firstMessage->email ?? 'Not provided' }}</span>
                  </div>
                  <div class="thread-info-item">
                    <span class="thread-info-label">Company / Role</span>
                    <span class="thread-info-value">{{ $firstMessage->role ?? 'Not provided' }}</span>
                  </div>
                  <div class="thread-info-item">
                    <span class="thread-info-label">Subject</span>
                    <span class="thread-info-value">{{ $firstMessage->subject ?? 'No subject' }}</span>
                  </div>
                </div>
                <p class="thread-subject">{{ $firstMessage->subject ? '' : 'Select a message on the left to review it.' }}</p>
              </div>
            </div>
          </div>

          <div class="thread-messages" id="threadMessages">
            @if ($firstMessage)
              <div class="message received">
                <span class="thread-avatar hue-1">{{ strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $firstMessage->name), 0, 2)) }}</span>
                <div class="message-bubble">
                  <p>{{ $firstMessage->message }}</p>
                  <span class="message-time">{{ $firstMessage->created_at?->format('M j, Y H:i') }}</span>
                </div>
              </div>
            @else
              <div class="message received message--empty">
                <div class="message-bubble">
                  <p>no message</p>
                </div>
              </div>
            @endif
          </div>

          <div class="thread-meta" id="threadMeta">
            @if ($firstMessage)
              <div class="thread-meta-item">
                <span class="thread-meta-label">Email</span>
                <span class="thread-meta-value">{{ $firstMessage->email ?: 'Not provided' }}</span>
              </div>
              <div class="thread-meta-item">
                <span class="thread-meta-label">Company / Role</span>
                <span class="thread-meta-value">{{ $firstMessage->role ?: 'Not provided' }}</span>
              </div>
              <div class="thread-meta-item">
                <span class="thread-meta-label">Subject</span>
                <span class="thread-meta-value">{{ $firstMessage->subject ?: 'No subject' }}</span>
              </div>
            @endif
          </div>
        </div>

      </div>
    </main>
  </div>

  <script>
    var threadItems = document.querySelectorAll('.thread-item');
    var threadAvatar = document.querySelector('.thread-view-title .thread-avatar');
    var threadName = document.querySelector('.thread-view-title h3');
    var threadSubject = document.querySelector('.thread-view-title .thread-subject');
    var threadMessages = document.getElementById('threadMessages');
    var threadMeta = document.getElementById('threadMeta');

    function renderThread(button) {
      threadItems.forEach(function (item) { item.classList.remove('active'); });
      button.classList.add('active');

      var name = button.dataset.name || 'Contact Message';
      var subject = button.dataset.subject || 'New message';
      var email = button.dataset.email || 'Not provided';
      var role = button.dataset.role || 'Not provided';
      var message = button.dataset.message || 'No message';
      var createdAt = button.dataset.createdAt || 'Now';
      var initials = (name.match(/\b([A-Za-z])/g) || []).slice(0, 2).join('').toUpperCase() || 'CM';

      if (threadAvatar) threadAvatar.textContent = initials;
      if (threadName) threadName.textContent = name;
      if (threadSubject) threadSubject.textContent = subject;

      if (threadMessages) {
        threadMessages.innerHTML = '<div class="message received">'
          + '<span class="thread-avatar hue-1">' + initials + '</span>'
          + '<div class="message-bubble">'
          + '<p>' + message + '</p>'
          + '<span class="message-time">' + createdAt + '</span>'
          + '</div></div>';
      }

      if (threadMeta) {
        threadMeta.innerHTML = '<div class="thread-meta-item">'
          + '<span class="thread-meta-label">Email</span>'
          + '<span class="thread-meta-value">' + email + '</span>'
          + '</div>'
          + '<div class="thread-meta-item">'
          + '<span class="thread-meta-label">Company / Role</span>'
          + '<span class="thread-meta-value">' + role + '</span>'
          + '</div>'
          + '<div class="thread-meta-item">'
          + '<span class="thread-meta-label">Subject</span>'
          + '<span class="thread-meta-value">' + subject + '</span>'
          + '</div>';
      }
    }

    threadItems.forEach(function (item) {
      item.addEventListener('click', function () {
        renderThread(item);
      });
    });
  </script>
</body>
</html>