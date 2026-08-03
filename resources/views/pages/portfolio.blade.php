<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aizap Creative - Portfolio</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/pages/portfolio.css') }}">
</head>
<body class="portfolio-page">
    @include('header.header')

    <main class="portfolio-shell">
        <section class="portfolio-hero">
            <div class="portfolio-hero__copy">
                <h1 class="portfolio-hero__title">Creative work.<br><span>Real impact.</span></h1>
                <p class="portfolio-hero__text">
                    Explore a selection of AI-powered videos, ads, and content we’ve created for brands, businesses, and agencies around the world.
                </p>
             
            </div>

            <div class="portfolio-hero__media-wrap">
                <div class="portfolio-hero__media portfolio-hero__media--portrait" style="background-image: url('{{ asset('home-bg.png') }}');"></div>
            </div>
        </section>

        <section class="portfolio-grid">
            <article class="portfolio-card">
                <div class="portfolio-card__thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                    <span class="portfolio-play">▶</span>
                    <span class="portfolio-duration">0:30</span>
                </div>
                <div class="portfolio-card__meta">
                    <h3>Nike Commercial</h3>
                    <p>AI Commercial Ad</p>
                </div>
            </article>

            <article class="portfolio-card">
                <div class="portfolio-card__thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                    <span class="portfolio-play">▶</span>
                    <span class="portfolio-duration">0:15</span>
                </div>
                <div class="portfolio-card__meta">
                    <h3>Lumière Perfume AD</h3>
                    <p>AI Product Ad</p>
                </div>
            </article>

            <article class="portfolio-card">
                <div class="portfolio-card__thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                    <span class="portfolio-play">▶</span>
                    <span class="portfolio-duration">1:02</span>
                </div>
                <div class="portfolio-card__meta">
                    <h3>Echoes of Us</h3>
                    <p>AI Drama / Storytelling</p>
                </div>
            </article>

            <article class="portfolio-card">
                <div class="portfolio-card__thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                    <span class="portfolio-play">▶</span>
                    <span class="portfolio-duration">0:45</span>
                </div>
                <div class="portfolio-card__meta">
                    <h3>Beyond the Realm</h3>
                    <p>AI Short Film</p>
                </div>
            </article>

            <article class="portfolio-card">
                <div class="portfolio-card__thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                    <span class="portfolio-play">▶</span>
                    <span class="portfolio-duration">0:20</span>
                </div>
                <div class="portfolio-card__meta">
                    <h3>Fresh Max Campaign</h3>
                    <p>AI Brand Campaign</p>
                </div>
            </article>

            <article class="portfolio-card">
                <div class="portfolio-card__thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                    <span class="portfolio-play">▶</span>
                    <span class="portfolio-duration">0:35</span>
                </div>
                <div class="portfolio-card__meta">
                    <h3>Cyber City</h3>
                    <p>AI Short Film</p>
                </div>
            </article>

            <article class="portfolio-card">
                <div class="portfolio-card__thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                    <span class="portfolio-play">▶</span>
                    <span class="portfolio-duration">0:20</span>
                </div>
                <div class="portfolio-card__meta">
                    <h3>Timeless Precision</h3>
                    <p>AI Product Ad</p>
                </div>
            </article>

            <article class="portfolio-card">
                <div class="portfolio-card__thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                    <span class="portfolio-play">▶</span>
                    <span class="portfolio-duration">0:30</span>
                </div>
                <div class="portfolio-card__meta">
                    <h3>Finance App Explainer</h3>
                    <p>Explainer Video</p>
                </div>
            </article>
        </section>

        <section class="portfolio-footer-cta">
            <div class="portfolio-footer-cta__content">
                <span class="portfolio-footer-cta__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>
                </span>
                <div>
                    <div class="eyebrow">Have a project in mind?</div>
                    <p>Let's create something extraordinary together.</p>
                </div>
            </div>
            <a href="/contact" class="portfolio-footer-cta__button">Let's Work Together</a>
        </section>
    </main>
    @include('footer.footer')
</body>
</html>