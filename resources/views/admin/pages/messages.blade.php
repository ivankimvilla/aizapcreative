<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Aizap Creatives - Messages</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin/pages/messages.css') }}?v={{ filemtime(public_path('css/admin/pages/messages.css')) }}">
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

      <div class="inbox-panel" id="inbox" data-delete-url="{{ route('admin.messages.destroy') }}">

        <div class="inbox-toolbar">
          <div class="inbox-toolbar-left">
            <label class="select-all-control" title="Select all messages">
              <input type="checkbox" id="selectAllMessages" aria-label="Select all messages">
              <span>Select all</span>
            </label>
            <h2>Messages</h2>
            <span class="message-count">{{ $messages->count() }}</span>
          </div>
          <button type="button" class="delete-selected-btn" id="deleteSelectedMessages" hidden aria-label="Delete selected messages" title="Delete selected messages">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
              <path d="M4 7h16M10 11v6M14 11v6M6 7l1 14h10l1-14M9 7V4h6v3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Delete</span>
          </button>
        </div>

        <div class="message-list-wrap" id="messageListWrap">
          <div class="message-list" id="messageList">
            @include('admin.pages.partials.message-rows', ['messages' => $messages])
          </div>
        </div>

        <div class="message-full-view" id="messageFullView">
          <button type="button" class="back-btn" id="backToList">← Back to Messages</button>

          <div class="message-full-header">
            <h3 id="fullViewName"></h3>
          </div>

          <div class="message-full-meta">
            <div class="message-detail-field">
              <span class="detail-label">Email</span>
              <span id="fullViewEmail"></span>
            </div>
            <div class="message-detail-field" id="fullViewPhoneField" style="display: none;">
              <span class="detail-label">Phone</span>
              <span id="fullViewPhone"></span>
            </div>
            <div class="message-detail-field">
              <span class="detail-label">Company / Brand</span>
              <span id="fullViewRole"></span>
            </div>
            <div class="message-detail-field">
              <span class="detail-label">Date</span>
              <span id="fullViewDate"></span>
            </div>
          </div>

          <div class="message-body-block">
            <span class="detail-label">Message</span>
            <p class="message-full-body" id="fullViewBody"></p>
          </div>

          <button type="button" class="reply-btn" id="replyBtn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M9 17L4 12L9 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M4 12H14C17.3137 12 20 14.6863 20 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Reply
          </button>
        </div>

      </div>
    </main>
  </div>

  <script src="{{ asset('js/admin/pages/message.js') }}?v={{ filemtime(public_path('js/admin/pages/message.js')) }}"></script>
</body>
</html>