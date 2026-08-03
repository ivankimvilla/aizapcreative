<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AIZAP Creatives — Projects</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin/pages/projects.css') }}">

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
          <button class="menu-toggle" id="menuToggle" aria-label="Open menu">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
          </button>
          <p class="crumb">Studio / Projects</p>
        </div>
      </div>

      <!-- TOOLBAR: sort, delete selected, new video -->
      <div class="toolbar">
        <div class="toolbar-left">
          <label class="select-all">
            <input type="checkbox" id="selectAll">
            <span>Select all</span>
          </label>
          <span class="selected-count" id="selectedCount">0 selected</span>
        </div>
        <div class="toolbar-actions">
          <button class="btn-danger" id="deleteSelected" disabled>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
            Delete
          </button>
          <div class="sort-select">
            <select id="sortVideos">
              <option value="recent">Newest first</option>
              <option value="oldest">Oldest first</option>
              <option value="name">Name A–Z</option>
              <option value="duration">Duration</option>
            </select>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
          </div>
          <a href="#" class="btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            New video
          </a>
        </div>
      </div>

      <!-- VIDEO GRID -->
      <div class="video-grid">

        <div class="video-card">
          <div class="video-thumb hue-1">
            <label class="video-select">
              <input type="checkbox" class="video-checkbox">
              <span></span>
            </label>
            <button class="play-btn" aria-label="Play video">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7Z"/></svg>
            </button>
            <span class="duration">2:14</span>
          </div>
          <div class="video-info">
            <div class="video-title-row"><h3>Summer Campaign — Teaser</h3></div>
            <p class="video-meta">Nova Retail · Aug 1, 2026</p>
          </div>
        </div>

        <div class="video-card">
          <div class="video-thumb hue-2">
            <label class="video-select">
              <input type="checkbox" class="video-checkbox">
              <span></span>
            </label>
            <button class="play-btn" aria-label="Play video">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7Z"/></svg>
            </button>
            <span class="duration">1:02</span>
          </div>
          <div class="video-info">
            <div class="video-title-row"><h3>Product Launch Reel</h3></div>
            <p class="video-meta">Fen &amp; Co. · Jul 29, 2026</p>
          </div>
        </div>

        <div class="video-card">
          <div class="video-thumb hue-3">
            <label class="video-select">
              <input type="checkbox" class="video-checkbox">
              <span></span>
            </label>
            <button class="play-btn" aria-label="Play video">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7Z"/></svg>
            </button>
            <span class="duration">4:47</span>
          </div>
          <div class="video-info">
            <div class="video-title-row"><h3>Brand Story — Long Cut</h3></div>
            <p class="video-meta">Ardent Studio · Jul 27, 2026</p>
          </div>
        </div>

        <div class="video-card">
          <div class="video-thumb hue-4">
            <label class="video-select">
              <input type="checkbox" class="video-checkbox">
              <span></span>
            </label>
            <button class="play-btn" aria-label="Play video">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7Z"/></svg>
            </button>
            <span class="duration">0:31</span>
          </div>
          <div class="video-info">
            <div class="video-title-row"><h3>Instagram Cutdown v2</h3></div>
            <p class="video-meta">Nova Retail · Jul 24, 2026</p>
          </div>
        </div>

        <div class="video-card">
          <div class="video-thumb hue-1">
            <label class="video-select">
              <input type="checkbox" class="video-checkbox">
              <span></span>
            </label>
            <button class="play-btn" aria-label="Play video">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7Z"/></svg>
            </button>
            <span class="duration">3:08</span>
          </div>
          <div class="video-info">
            <div class="video-title-row"><h3>Behind the Scenes</h3></div>
            <p class="video-meta">Marlowe &amp; Rae · Jul 22, 2026</p>
          </div>
        </div>

        <div class="video-card">
          <div class="video-thumb hue-2">
            <label class="video-select">
              <input type="checkbox" class="video-checkbox">
              <span></span>
            </label>
            <button class="play-btn" aria-label="Play video">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7Z"/></svg>
            </button>
            <span class="duration">1:35</span>
          </div>
          <div class="video-info">
            <div class="video-title-row"><h3>Client Testimonial — Priya</h3></div>
            <p class="video-meta">Fen &amp; Co. · Jul 18, 2026</p>
          </div>
        </div>

        <div class="video-card">
          <div class="video-thumb hue-3">
            <label class="video-select">
              <input type="checkbox" class="video-checkbox">
              <span></span>
            </label>
            <button class="play-btn" aria-label="Play video">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7Z"/></svg>
            </button>
            <span class="duration">2:50</span>
          </div>
          <div class="video-info">
            <div class="video-title-row"><h3>Holiday Promo Draft</h3></div>
            <p class="video-meta">Ardent Studio · Jul 15, 2026</p>
          </div>
        </div>

        <div class="video-card">
          <div class="video-thumb hue-4">
            <label class="video-select">
              <input type="checkbox" class="video-checkbox">
              <span></span>
            </label>
            <button class="play-btn" aria-label="Play video">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7Z"/></svg>
            </button>
            <span class="duration">5:12</span>
          </div>
          <div class="video-info">
            <div class="video-title-row"><h3>Event Recap</h3></div>
            <p class="video-meta">Marlowe &amp; Rae · Jul 9, 2026</p>
          </div>
        </div>

      </div>
    </main>
  </div>

  <script>
    var toggle = document.getElementById('menuToggle');
    var sidebar = document.getElementById('sidebar');
    if (toggle && sidebar) {
      toggle.addEventListener('click', function () {
        sidebar.classList.toggle('open');
      });
    }

    var checkboxes = document.querySelectorAll('.video-checkbox');
    var selectAll = document.getElementById('selectAll');
    var selectedCount = document.getElementById('selectedCount');
    var deleteBtn = document.getElementById('deleteSelected');

    function updateSelectionState() {
      var checked = document.querySelectorAll('.video-checkbox:checked');
      selectedCount.textContent = checked.length + ' selected';
      deleteBtn.disabled = checked.length === 0;
      selectAll.checked = checked.length === checkboxes.length;
      selectAll.indeterminate = checked.length > 0 && checked.length < checkboxes.length;
    }

    checkboxes.forEach(function (box) {
      box.addEventListener('change', function () {
        box.closest('.video-card').classList.toggle('selected', box.checked);
        updateSelectionState();
      });
    });

    selectAll.addEventListener('change', function () {
      checkboxes.forEach(function (box) {
        box.checked = selectAll.checked;
        box.closest('.video-card').classList.toggle('selected', box.checked);
      });
      updateSelectionState();
    });

    deleteBtn.addEventListener('click', function () {
      var checked = document.querySelectorAll('.video-checkbox:checked');
      if (checked.length === 0) return;
      var confirmed = confirm('Delete ' + checked.length + ' selected video' + (checked.length > 1 ? 's' : '') + '? This cannot be undone.');
      if (!confirmed) return;
      checked.forEach(function (box) {
        box.closest('.video-card').remove();
      });
      checkboxes = document.querySelectorAll('.video-checkbox');
      updateSelectionState();
    });
  </script>
</body>
</html>