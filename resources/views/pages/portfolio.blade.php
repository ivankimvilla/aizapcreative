<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aizap Creative - Portfolio</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800|fraunces:400,500,600,600i,700i" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/pages/portfolio.css') }}">
    <script>document.documentElement.classList.add('has-js');</script>
</head>
<body class="portfolio-page">
    @include('header.header')

    <div class="intro-curtain" data-intro-curtain aria-hidden="true">
        <span class="intro-curtain__panel intro-curtain__panel--l"></span>
        <span class="intro-curtain__panel intro-curtain__panel--r"></span>
        <span class="intro-curtain__seam"></span>
    </div>

    <main id="app-content">
        <div class="portfolio-shell">
        <section class="portfolio-hero" data-parallax>
            <div class="portfolio-hero__bg" data-parallax-layer style="background-image: url('{{ asset('portfolio.png') }}');"></div>
            <div class="portfolio-hero-overlay"></div>

            <div class="portfolio-hero__copy">
                <h1 class="portfolio-hero__title" data-reveal style="--i:0">
                    Our<br>
                    <span>Portfolio.</span>
                </h1>
                <p class="portfolio-hero__text" data-reveal style="--i:1">
                    A collection of stories.<br>
                    Built with <span class="gold">AI</span>. Delivered with <span class="gold">impact</span>.
                </p>

                <ul class="hero-specs" data-reveal style="--i:2">
                    <li>
                        <span class="hero-specs__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="4"/>
                                <path d="M10 8.5v7l6-3.5Z" fill="currentColor" stroke="none"/>
                            </svg>
                        </span>
                        <span>AI-powered creation</span>
                    </li>
                    <li>
                        <span class="hero-specs__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 8.5 8 6l2 2.5L5 11Z"/>
                                <rect x="3" y="11" width="18" height="9.5" rx="2"/>
                            </svg>
                        </span>
                        <span>Cinematic drama</span>
                    </li>
                    <li>
                        <span class="hero-specs__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 3 3 8l9 5 9-5Z"/>
                                <path d="M3 13l9 5 9-5"/>
                            </svg>
                        </span>
                        <span>Diverse categories</span>
                    </li>
                    <li>
                        <span class="hero-specs__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m12 3 2.6 5.8 6.4.6-4.8 4.3 1.4 6.3L12 16.9 6.4 20l1.4-6.3L3 9.4l6.4-.6Z"/>
                            </svg>
                        </span>
                        <span>Results that connect</span>
                    </li>
                </ul>

                <p class="hero-caption" data-reveal style="--i:3">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M10 8.5v7l6-3.5Z" fill="currentColor" stroke="none"/></svg>
                    Explore. Watch. Get inspired.
                </p>
            </div>

            <a href="#selected-work" class="hero-scroll-cue" data-reveal style="--i:4" aria-label="Scroll to selected work">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
            </a>
        </section>

        <section class="portfolio-grid" id="selected-work">
            <div class="section-head" data-reveal>
                <h2 class="section-head__title">Sample works</h2>
                @if(!empty($videos) && count($videos) > 0)
                    <span class="section-head__meta">{{ str_pad(count($videos), 2, '0', STR_PAD_LEFT) }} videos</span>
                @endif
            </div>

            <div class="video-grid projects-grid">
                @forelse ($videos ?? [] as $video)
                    <div class="project-tile is-loading" data-reveal style="--i:{{ $loop->index % 8 }}">
                        <span class="project-tile__index">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <x-frontend.video-card
                            :title="$video->title"
                            :subtitle="$video->getCategoryLabelAttribute()"
                            :image-url="$video->cover_url"
                            :video-url="$video->video_url"
                        />
                    </div>
                @empty
                    <div class="project-tile" data-reveal style="--i:0">
                        <x-frontend.video-card />
                    </div>
                @endforelse
            </div>
        </section>

        <section class="portfolio-footer-cta" data-reveal>
            <div class="portfolio-footer-cta__content">
                <span class="portfolio-footer-cta__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M8 12l2 2 4-4"/></svg>
                </span>
                <div>
                    <div class="eyebrow">Have a project in mind?</div>
                    <p>Let's create something extraordinary together.</p>
                </div>
            </div>
            <a href="/contact" class="portfolio-footer-cta__button" data-magnetic>Let's work together</a>
        </section>
        </div>
    </main>
    @include('footer.footer')
    <script src="{{ asset('js/video-player.js') }}"></script>
    <script src="{{ asset('js/portfolio-animations.js') }}"></script>
</body>
</html>