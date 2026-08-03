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
            <span class="thread-count">4</span>
          </div>

          <div class="thread-search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" placeholder="Filter conversations…">
          </div>

          <div class="thread-items">

            <button class="thread-item active" data-thread="nova">
              <span class="thread-avatar hue-1">NR</span>
              <span class="thread-body">
                <span class="thread-top">
                  <span class="thread-name">Nova Retail</span>
                  <span class="thread-time">10:42 AM</span>
                </span>
                <span class="thread-preview">Can we push the teaser render to Thursday?</span>
              </span>
              <span class="thread-unread">2</span>
            </button>

            <button class="thread-item" data-thread="fen">
              <span class="thread-avatar hue-2">FC</span>
              <span class="thread-body">
                <span class="thread-top">
                  <span class="thread-name">Fen &amp; Co.</span>
                  <span class="thread-time">Yesterday</span>
                </span>
                <span class="thread-preview">Loved the testimonial cut — approved.</span>
              </span>
            </button>

            <button class="thread-item" data-thread="ardent">
              <span class="thread-avatar hue-3">AS</span>
              <span class="thread-body">
                <span class="thread-top">
                  <span class="thread-name">Ardent Studio</span>
                  <span class="thread-time">Jul 29</span>
                </span>
                <span class="thread-preview">Sending over the holiday promo notes today.</span>
              </span>
            </button>

            <button class="thread-item" data-thread="marlowe">
              <span class="thread-avatar hue-4">MR</span>
              <span class="thread-body">
                <span class="thread-top">
                  <span class="thread-name">Marlowe &amp; Rae</span>
                  <span class="thread-time">Jul 24</span>
                </span>
                <span class="thread-preview">Event recap looks great, thank you!</span>
              </span>
            </button>

          </div>
        </div>

        <!-- THREAD VIEW -->
        <div class="thread-view">
          <div class="thread-view-head">
            <div class="thread-view-title">
              <span class="thread-avatar hue-1">NR</span>
              <div>
                <h3>Nova Retail</h3>
                <p>Summer Campaign — Teaser</p>
              </div>
            </div>
            <button class="thread-view-more" aria-label="More options">
              <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="1.8"/><circle cx="12" cy="12" r="1.8"/><circle cx="19" cy="12" r="1.8"/></svg>
            </button>
          </div>

          <div class="thread-messages">

            <div class="day-divider"><span>Today</span></div>

            <div class="message received">
              <span class="thread-avatar hue-1">NR</span>
              <div class="message-bubble">
                <p>Hey! Just watched the latest teaser cut — really strong opening shot.</p>
                <span class="message-time">10:31 AM</span>
              </div>
            </div>

            <div class="message received">
              <span class="thread-avatar hue-1">NR</span>
              <div class="message-bubble">
                <p>Can we push the teaser render to Thursday? Our launch date moved.</p>
                <span class="message-time">10:42 AM</span>
              </div>
            </div>

            <div class="message sent">
              <div class="message-bubble">
                <p>Thursday works on our end. I'll update the delivery schedule and confirm by EOD.</p>
                <span class="message-time">10:47 AM</span>
              </div>
            </div>

            <div class="message sent">
              <div class="message-bubble">
                <p>Also attaching the revised shot list for the extended cut, whenever you get a chance.</p>
                <span class="message-time">10:48 AM</span>
              </div>
            </div>

          </div>

          <form class="thread-composer">
            <textarea placeholder="Write a message…" rows="1"></textarea>
            <button type="submit" class="composer-send" aria-label="Send message">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4Z"/></svg>
            </button>
          </form>
        </div>

      </div>
    </main>
  </div>

  <script>
    var threadItems = document.querySelectorAll('.thread-item');
    threadItems.forEach(function (item) {
      item.addEventListener('click', function () {
        threadItems.forEach(function (i) { i.classList.remove('active'); });
        item.classList.add('active');
        var unread = item.querySelector('.thread-unread');
        if (unread) unread.remove();
      });
    });

    var textarea = document.querySelector('.thread-composer textarea');
    if (textarea) {
      textarea.addEventListener('input', function () {
        textarea.style.height = 'auto';
        textarea.style.height = Math.min(textarea.scrollHeight, 140) + 'px';
      });
    }

    var composer = document.querySelector('.thread-composer');
    if (composer) {
      composer.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!textarea.value.trim()) return;
        var messages = document.querySelector('.thread-messages');
        var msg = document.createElement('div');
        msg.className = 'message sent';
        msg.innerHTML = '<div class="message-bubble"><p></p><span class="message-time">Just now</span></div>';
        msg.querySelector('p').textContent = textarea.value.trim();
        messages.appendChild(msg);
        messages.scrollTop = messages.scrollHeight;
        textarea.value = '';
        textarea.style.height = 'auto';
      });
    }
  </script>
</body>
</html>