@extends('admin.layouts.app')

@section('title', 'Aizap Creatives - Projects')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/admin/pages/projects.css') }}">
  <link rel="stylesheet" href="{{ asset('css/video-cards.css') }}">
@endsection

@section('content')
  <div class="projects-page">
    <div class="topbar">
      <div class="topbar-left">
        <div class="topbar-title">
          <button class="menu-toggle" id="menuToggle" aria-label="Open menu">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
          </button>
        </div>
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
  <div class="projects-grid" id="videoGrid">
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
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/admin/pages/projects.js') }}?v={{ filemtime(public_path('js/admin/pages/projects.js')) }}"></script>
  <script src="{{ asset('js/video-player.js') }}"></script>
@endsection