@props(['title' => null, 'subtitle' => null, 'imageUrl' => null, 'videoUrl' => null, 'extraClass' => ''])

@once
<link rel="stylesheet" href="{{ asset('css/video-cards.css') }}">
@endonce

@if (!empty($title) || !empty($subtitle))
    <article class="project-card video-card project-card--overlay {{ $extraClass }}">
        @if (!empty($videoUrl))
            <div class="project-thumb video-card__thumb has-video">
                <video
                    playsinline
                    preload="metadata"
                    @if (!empty($imageUrl)) poster="{{ $imageUrl }}" @endif
                    src="{{ $videoUrl }}"
                ></video>
                <div class="project-card__content">
                    @if (!empty($subtitle))
                        <span class="project-category">{{ $subtitle }}</span>
                    @endif
                </div>
            </div>
        @else
            <div class="project-thumb video-card__thumb video-card__thumb--empty" style="background: transparent;">
                {{-- no play button for cards without video --}}
            </div>
        @endif
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