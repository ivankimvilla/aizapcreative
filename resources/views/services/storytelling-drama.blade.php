<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aizap Creatives - AI Storytelling / Drama</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/services/storytelling-drama.css') }}">
</head>
<body class="service-page service-page--storytelling">
    @include('header.header')

    <main class="service-shell">
        <section class="service-hero-split">
            <div class="service-hero-split__copy">
                <div class="eyebrow">What We Do</div>
                <h1>AI Storytelling  Drama</h1>
                <p>We produce emotionally resonant AI-driven storytelling that connects audiences to your message.</p>
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
                    <h3>Echoes of Us</h3>
                    <p>AI Drama / Storytelling</p>
                </article>

                <article class="video-card">
                    <div class="video-card__thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                        <span class="video-card__play">▶</span>
                    </div>
                    <h3>Beyond the Realm</h3>
                    <p>AI Short Film</p>
                </article>
            </div>
        </section>

    </main>

    @include('footer.footer')
</body>
</html>
