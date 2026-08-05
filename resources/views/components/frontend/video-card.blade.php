@props(['title' => null, 'subtitle' => null, 'imageUrl' => null, 'videoUrl' => null, 'extraClass' => ''])

@once
<link rel="stylesheet" href="{{ asset('css/video-cards.css') }}">
@endonce

@if (!empty($title))
    <article class="project-card video-card {{ $extraClass }}">
        @if (!empty($videoUrl))
            <div class="project-thumb video-card__thumb has-video">
                <video
                    playsinline
                    preload="metadata"
                    poster="{{ $imageUrl ?: asset('home-bg.png') }}"
                    src="{{ $videoUrl }}"
                ></video>
            </div>
        @else
            <div class="project-thumb video-card__thumb video-card__thumb--empty" style="background: transparent;">
                {{-- no play button for cards without video --}}
            </div>
        @endif
        <div class="project-card__content">
            <h3>
                {{ $title }}
                @if (!empty($subtitle))
                    <span class="project-category">{{ $subtitle }}</span>
                @endif
            </h3>
        </div>
    </article>
@else
    <div class="videos-empty-state">
        <article class="project-card video-card {{ $extraClass }}">
            <div class="project-thumb video-card__thumb video-card__thumb--empty" style="background: transparent;">
                <span class="video-card__placeholder">NO VIDEOS YET</span>
            </div>
        </article>
    </div>
@endif