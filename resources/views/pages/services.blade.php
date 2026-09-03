<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aizap Creatives - Services</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=instrument-serif:400,400i" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/video-cards.css') }}">
    <link rel="stylesheet" href="{{ asset('css/services/services-cinematic.css') }}?v={{ filemtime(public_path('css/services/services-cinematic.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/home-page/contact-cta.css') }}?v={{ filemtime(public_path('css/home-page/contact-cta.css')) }}">
</head>
<body class="service-page service-page--services-unified">
    @include('header.header')

    <main id="app-content">
        <div class="ambient-glow" aria-hidden="true"></div>

        <div class="service-shell">
            <section class="service-masthead" data-reveal-fade>
                <div class="service-masthead__title">
                    <div class="eyebrow">What We Do</div>
                    <h1>Services</h1>
                </div>

                <div class="service-masthead__leader" aria-hidden="true">
                    <svg viewBox="0 0 120 120">
                        <circle class="leader-ring" cx="60" cy="60" r="52"/>
                        <circle class="leader-ring leader-ring--inner" cx="60" cy="60" r="38"/>
                        <g class="leader-ticks">
                            <line x1="60" y1="16" x2="60" y2="8"/>
                            <line x1="91.1" y1="28.9" x2="96.8" y2="23.2"/>
                            <line x1="104" y1="60" x2="112" y2="60"/>
                            <line x1="91.1" y1="91.1" x2="96.8" y2="96.8"/>
                            <line x1="60" y1="104" x2="60" y2="112"/>
                            <line x1="28.9" y1="91.1" x2="23.2" y2="96.8"/>
                            <line x1="16" y1="60" x2="8" y2="60"/>
                            <line x1="28.9" y1="28.9" x2="23.2" y2="23.2"/>
                        </g>
                        <line class="leader-sweep" x1="60" y1="60" x2="60" y2="8"/>
                        <text class="leader-count" id="leaderCount" x="60" y="65">01</text>
                        <text class="leader-label" x="60" y="80">VIDEOS</text>
                    </svg>
                </div>

                <div class="service-masthead__side">
                    <p>Three formats, one pipeline. Tell us the brief - we generate, direct, and deliver.</p>

                </div>
            </section>

            <section class="unified-services-grid">
                @php
                    $services = [
                        [
                            'id' => 'commercial-ads',
                            'category' => 'SVC / 01',
                            'title' => 'AI Commercial Ads',
                            'description' => 'Broadcast-style spots generated from a script and your brand kit - no crew, no set, no reshoot fees.',
                            'button_label' => 'Avail this service',
                            'bgcolor' => '#8b4513',
                            'category_key' => 'ai-commercial-ads',
                            'duration' => '0:15 - 0:30',
                            'tags' => ['Script to screen', 'Brand-safe visuals', 'Multi-platform cuts'],
                            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>',
                        ],
                        [
                            'id' => 'explainer-videos',
                            'category' => 'SVC / 02',
                            'title' => 'AI Videos Explainer',
                            'description' => 'Hero shots and lifestyle scenes for products that don\'t need a photo shoot to look like they sell themselves.',
                            'button_label' => 'Avail this service',
                            'bgcolor' => '#1a3a52',
                            'category_key' => 'explainer-videos',
                            'duration' => '0:15 - 0:45',
                            'tags' => ['Studio-grade hero shots', 'Lifestyle scenes', 'Zero physical samples'],
                            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
                        ],
                        [
                            'id' => 'storytelling-drama',
                            'category' => 'SVC / 03',
                            'title' => 'AI Drama',
                            'description' => 'Character-driven short films and serialized drama - scripted, cast, and shot entirely inside the engine.',
                            'button_label' => 'Avail this service',
                            'bgcolor' => '#3d1a5c',
                            'category_key' => 'ai-storytelling-drama',
                            'duration' => '2:00 - 5:00',
                            'tags' => ['Original characters', 'Episodic structure', 'Cinematic score'],
                            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
                        ],
                    ];
                @endphp

                @foreach ($services as $i => $service)
                    @php
                        $video = $latestVideos[$service['category_key']] ?? null;
                    @endphp
                    <div
                        class="unified-service-card"
                        data-category-label="{{ $service['title'] }}"
                        data-reveal-wipe
                        style="--reveal-order: {{ $i }};"
                    >
                        <div class="unified-service-card__thumb" style="background: linear-gradient(155deg, {{ $service['bgcolor'] }} 0%, #05050699 75%);">
                            @if (optional($video)->video_url)
                                <video
                                    class="unified-service-card__video"
                                    autoplay
                                    muted
                                    loop
                                    playsinline
                                    preload="metadata"
                                    tabindex="-1"
                                    aria-hidden="true"
                                    @if ($video->cover_url) poster="{{ $video->cover_url }}" @endif
                                    src="{{ $video->video_url }}"
                                ></video>
                            @elseif (optional($video)->cover_url)
                                <img
                                    class="unified-service-card__video"
                                    src="{{ $video->cover_url }}"
                                    alt=""
                                >
                            @else
                                <div class="unified-service-card__icon">
                                    {!! $service['icon'] !!}
                                </div>
                            @endif
                            <span class="unified-service-card__duration">{{ $service['duration'] }}</span>
                        </div>

                        <div class="unified-service-card__content">
                            <span class="unified-service-card__eyebrow">{{ $service['category'] }}</span>
                            <h2 class="unified-service-card__title">{{ $service['title'] }}</h2>
                            <p class="unified-service-card__description">{{ $service['description'] }}</p>

                            <div class="unified-service-card__tags">
                                @foreach ($service['tags'] as $tag)
                                    <span class="unified-service-card__tag">{{ $tag }}</span>
                                @endforeach
                            </div>

                            <div class="unified-service-card__footer">
                                <button type="button" class="btn btn-primary unified-service-card__cta" data-open-contact-modal data-service-title="{{ $service['title'] }}"><span>{{ $service['button_label'] }}</span></button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>

            <section class="sample-reel-section" id="samples">
                <div class="sample-reel-header" data-reveal-fade>
                    <div class="sample-reel-header__left">
                        <h2 class="sample-reel-title">Sample videos</h2>
                    </div>
                    <div class="sample-reel-header__right">
                        <p class="sample-reel-subtitle">A few frames from recent generations. Filter by format or click a card for a closer look.</p>
                    </div>
                </div>

                <div class="sample-reel-filters" data-reveal-fade role="tablist" aria-label="Filter sample reel by format">
                    <button class="sample-reel-filter sample-reel-filter--active" data-filter="all" role="tab" aria-selected="true">All work</button>
                    <button class="sample-reel-filter" data-filter="ai-commercial-ads" role="tab" aria-selected="false">Commercial Ads</button>
                    <button class="sample-reel-filter" data-filter="ai-storytelling-drama" role="tab" aria-selected="false">Drama</button>
                    <button class="sample-reel-filter" data-filter="explainer-videos" role="tab" aria-selected="false">Explainers</button>
                </div>

                <div class="projects-grid video-grid" id="sampleReelGrid">
                    @php
                        $allVideos = \App\Models\ProjectVideo::where('is_featured', true)->latest()->get();
                    @endphp
                    @forelse ($allVideos as $video)
                        <x-frontend.video-card
                            :title="$video->title"
                            :subtitle="$video->getCategoryLabelAttribute()"
                            :image-url="$video->cover_url"
                            :video-url="$video->video_url"
                            :data-category="$video->category"
                        />
                    @empty
                        <x-frontend.video-card />
                    @endforelse
                </div>
            </section>
        </div>
    </main>

    @include('footer.footer')
    @include('home-page.sections.contact-modal')

    <script src="{{ asset('js/contact-cta.js') }}?v={{ filemtime(public_path('js/contact-cta.js')) }}"></script>
    <script src="{{ asset('js/video-player.js') }}?v={{ filemtime(public_path('js/video-player.js')) }}"></script>
    <script src="{{ asset('js/scroll-animations.js') }}?v={{ filemtime(public_path('js/scroll-animations.js')) }}"></script>
    <script src="{{ asset('js/scroll-cinematic.js') }}?v={{ filemtime(public_path('js/scroll-cinematic.js')) }}"></script>
    <script src="{{ asset('js/header/header.js') }}?v={{ filemtime(public_path('js/header/header.js')) }}"></script>
    <script src="{{ asset('js/service-leader.js') }}?v={{ filemtime(public_path('js/service-leader.js')) }}"></script>
</body>
</html>