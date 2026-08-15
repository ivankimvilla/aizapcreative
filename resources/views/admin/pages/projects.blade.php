<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aizap Creatives - Projects</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin/pages/projects.css') }}">
  <link rel="stylesheet" href="{{ asset('css/video-cards.css') }}">

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
          <button type="button" class="btn-primary" id="newVideoBtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            New video
          </button>
        </div>
      </div>

      <form id="deleteSelectedForm" method="POST" action="{{ route('admin.projects.destroy') }}">
        @csrf
        @method('DELETE')
        <div id="deleteInputs"></div>
      </form>

      <!-- VIDEO GRID -->
      <div class="video-grid" id="videoGrid">
        @if (session('status'))
          <div class="feedback-form-wrap" style="grid-column: 1 / -1; margin-bottom: 1rem;">
            <p style="margin: 0; color: #0f766e;">{{ session('status') }}</p>
          </div>
        @endif

        @forelse ($videos ?? [] as $video)
          <article class="project-card video-card admin-video-card" data-id="{{ $video->id }}">
            <div class="project-thumb video-thumb hue-{{ ($loop->iteration % 4) + 1 }} {{ $video->video_url ? 'has-video' : '' }}">
              <label class="video-select">
                <input type="checkbox" class="video-checkbox">
                <span></span>
              </label>
              @if ($video->video_url)
                <video
                  playsinline
                  preload="metadata"
                  @if ($video->cover_url) poster="{{ $video->cover_url }}" @endif
                  src="{{ $video->video_url }}">
                </video>
              @else
                <button class="play-btn" aria-label="Play video">
                  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7Z"/></svg>
                </button>
              @endif
              <span class="duration"></span>
            </div>
            <div class="project-card__content video-info">
              <h3>
                {{ $video->title }} {{ $video->getCategoryLabelAttribute() }}
              </h3>
              <span class="status-pill {{ $video->is_featured ? 'approved' : 'review' }}">
                {{ $video->is_featured ? 'Featured' : 'Not featured' }}
              </span>
            </div>
          </article>
        @empty
          <div class="feedback-form-wrap" style="grid-column: 1 / -1;">
            <p style="margin: 0; color: #6b7280;">No videos yet. Use the form above to add your first project.</p>
          </div>
        @endforelse
      </div>
    </main>
  </div>

  <!-- NEW VIDEO MODAL -->
  <div class="modal-overlay" id="newVideoOverlay">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="newVideoTitle">
      <div class="modal-header">
        <h2 id="newVideoTitle">New video</h2>
        <button type="button" class="modal-close" id="newVideoClose" aria-label="Close">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>
      </div>

      <form id="newVideoForm" method="POST" action="{{ route('admin.projects.store') ?? '#' }}" enctype="multipart/form-data">
        @csrf

        <div class="modal-body">

          <!-- Upload -->
          <label class="field">
            <span class="field-label">Video file</span>
            <label class="upload-drop" id="uploadDrop" for="videoFile">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 16V4M12 4 7 9M12 4l5 5"/><path d="M4 16v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3"/></svg>
              <span class="upload-text" id="uploadText">Drop a video here, or <b>browse</b></span>
              <span class="upload-hint">MP4, MOV, WEBM · up to 2GB</span>
              <input type="file" id="videoFile" name="video_file" accept="video/*" hidden>
            </label>
          </label>

          <!-- Title -->
          <label class="field">
            <span class="field-label">Title</span>
            <input type="text" name="title" class="text-input" placeholder="e.g. Summer Campaign — Teaser" required>
          </label>

          <div class="field-row">
            <!-- Category select -->
            <label class="field">
              <span class="field-label">Category</span>
              <div class="sort-select select-full">
                <select name="category" id="categorySelect" required>
                  <option value="" disabled selected>Choose a category</option>
                  <option value="ai-commercial-ads">AI Commercial Ads</option>
                  <option value="ai-product-ads">AI Product Ads</option>
                  <option value="ai-storytelling-drama">AI Storytelling / Drama</option>
                  <option value="ai-movie-trailers">AI Movie Trailers</option>
                  <option value="ugc-style-ai-videos">UGC-style AI Videos</option>
                  <option value="explainer-videos">Explainer Videos</option>
                </select>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
              </div>
            </label>
            <label class="field">
              <span class="field-label">Featured</span>
              <div class="feature-toggle">
                <label class="checkbox-field">
                  <input type="checkbox" name="is_featured" value="1">
                  Featured
                </label>
              </div>
            </label>
          </div>

          <!-- Featured category picker -->
          <div class="field">
            <span class="field-label">Feature category</span>
            <p class="field-hint">Pick the category card this video should be featured under. Selecting a card also sets the category above.</p>

            <div class="category-picker" id="categoryPicker">

              <label class="category-card" data-category="ai-commercial-ads" data-url="http://127.0.0.1:8000/what-we-do/ai-commercial-ads">
                <input type="radio" name="feature_category" value="ai-commercial-ads">
                <div class="category-card-icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m9 9 6 3-6 3z"/></svg>
                </div>
                <span class="category-card-title">AI Commercial Ads</span>
                <a class="category-card-link" href="http://127.0.0.1:8000/what-we-do/ai-commercial-ads" target="_blank" rel="noopener" aria-label="View AI Commercial Ads page">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M9 7h8v8"/></svg>
                </a>
              </label>

              <label class="category-card" data-category="ai-product-ads" data-url="http://127.0.0.1:8000/what-we-do/ai-product-ads">
                <input type="radio" name="feature_category" value="ai-product-ads">
                <div class="category-card-icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20.5 7.3 12 3 3.5 7.3 12 11.6z"/><path d="M3.5 7.3V16.7L12 21l8.5-4.3V7.3"/><path d="M12 11.6V21"/></svg>
                </div>
                <span class="category-card-title">AI Product Ads</span>
                <a class="category-card-link" href="http://127.0.0.1:8000/what-we-do/ai-product-ads" target="_blank" rel="noopener" aria-label="View AI Product Ads page">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M9 7h8v8"/></svg>
                </a>
              </label>

              <label class="category-card" data-category="ai-storytelling-drama" data-url="http://127.0.0.1:8000/what-we-do/ai-storytelling-drama">
                <input type="radio" name="feature_category" value="ai-storytelling-drama">
                <div class="category-card-icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.83 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                </div>
                <span class="category-card-title">AI Storytelling / Drama</span>
                <a class="category-card-link" href="http://127.0.0.1:8000/what-we-do/ai-storytelling-drama" target="_blank" rel="noopener" aria-label="View AI Storytelling / Drama page">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M9 7h8v8"/></svg>
                </a>
              </label>

              <label class="category-card" data-category="ai-movie-trailers" data-url="http://127.0.0.1:8000/what-we-do/ai-movie-trailers">
                <input type="radio" name="feature_category" value="ai-movie-trailers">
                <div class="category-card-icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 6v12M18 6v12M2 10h4M2 14h4M18 10h4M18 14h4"/></svg>
                </div>
                <span class="category-card-title">AI Movie Trailers</span>
                <a class="category-card-link" href="http://127.0.0.1:8000/what-we-do/ai-movie-trailers" target="_blank" rel="noopener" aria-label="View AI Movie Trailers page">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M9 7h8v8"/></svg>
                </a>
              </label>

              <label class="category-card" data-category="ugc-style-ai-videos" data-url="http://127.0.0.1:8000/what-we-do/ugc-style-ai-videos">
                <input type="radio" name="feature_category" value="ugc-style-ai-videos">
                <div class="category-card-icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="7" y="2" width="10" height="20" rx="2"/><path d="M11 18h2"/></svg>
                </div>
                <span class="category-card-title">UGC-style AI Videos</span>
                <a class="category-card-link" href="http://127.0.0.1:8000/what-we-do/ugc-style-ai-videos" target="_blank" rel="noopener" aria-label="View UGC-style AI Videos page">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M9 7h8v8"/></svg>
                </a>
              </label>

              <label class="category-card" data-category="explainer-videos" data-url="http://127.0.0.1:8000/what-we-do/explainer-videos">
                <input type="radio" name="feature_category" value="explainer-videos">
                <div class="category-card-icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 16v-4M12 8h.01"/></svg>
                </div>
                <span class="category-card-title">Explainer Videos</span>
                <a class="category-card-link" href="http://127.0.0.1:8000/what-we-do/explainer-videos" target="_blank" rel="noopener" aria-label="View Explainer Videos page">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M9 7h8v8"/></svg>
                </a>
              </label>

            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn-ghost" id="newVideoCancel">Cancel</button>
          <button type="submit" class="btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            Add video
          </button>
        </div>
      </form>
    </div>
  </div>
 <script src="{{ asset('js/admin/pages/projects.js') }}"></script>
  <script src="{{ asset('js/video-player.js') }}"></script>
</body>
</html>