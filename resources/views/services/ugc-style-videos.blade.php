<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aizap Creatives - UGC-style AI Videos</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/services/commercial-ads.css') }}">
</head>
<body class="service-page service-page--ugc">
    @include('header.header')

    <main class="service-shell">
        <section class="service-hero-split">
            <div class="service-hero-split__copy">
                <div class="eyebrow">What We Do</div>
                <h1>UGC-style AI Videos</h1>
                <p>Create authentic, thumb-stopping videos with a natural UGC feel that performs on social feeds.</p>
                <div class="hero-actions">
                </div>
            </div>

            <div class="service-hero-split__visual">
                <div class="service-hero-split__media" style="background-image: url('{{ asset('home-bg.png') }}');"></div>
            </div>
        </section>

        <section class="video-grid-section">
            <div class="video-grid">
                <article class="video-card">
                    <div class="video-card__thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                        <span class="video-card__play">▶</span>
                    </div>
                    <h3>Unboxing Reel</h3>
                    <p>UGC-style AI Video</p>
                </article>

                <article class="video-card">
                    <div class="video-card__thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                        <span class="video-card__play">▶</span>
                    </div>
                    <h3>Day-in-the-Life Promo</h3>
                    <p>UGC-style AI Video</p>
                </article>

                <article class="video-card">
                    <div class="video-card__thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                        <span class="video-card__play">▶</span>
                    </div>
                    <h3>Honest Review Style</h3>
                    <p>UGC-style AI Video</p>
                </article>

                <article class="video-card">
                    <div class="video-card__thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                        <span class="video-card__play">▶</span>
                    </div>
                    <h3>Get Ready With Me</h3>
                    <p>UGC-style AI Video</p>
                </article>

                <article class="video-card">
                    <div class="video-card__thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                        <span class="video-card__play">▶</span>
                    </div>
                    <h3>Testimonial-style Clip</h3>
                    <p>UGC-style AI Video</p>
                </article>
            </div>
        </section>

    </main>

    @include('footer.footer')
</body>
</html> 