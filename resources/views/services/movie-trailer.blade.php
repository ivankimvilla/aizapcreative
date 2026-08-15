<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aizap Creatives - AI Movie Trailers</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/services/movie-trailer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-page/home-page.css') }}">
</head>
<body class="service-page service-page--trailers">
    @include('header.header')

    <main id="app-content">
        <div class="service-shell">
        <section class="service-hero-split">
            <div class="service-hero-split__copy">
                <div class="eyebrow">What We Do</div>
                <h1>AI Movie Trailers</h1>
                <p>Craft dramatic teasers, cinematic previews, and trailer-style videos that build audience excitement.</p>
                <div class="hero-actions">
                </div>
            </div>

            <div class="service-hero-split__visual">
                <div class="service-hero-split__media" style="background-image: url('{{ asset('home-bg.png') }}');"></div>
            </div>
        </section>

        <section class="video-grid-section">
            <div class="video-grid">
                @forelse ($videos ?? [] as $video)
                    <x-frontend.video-card
                        :title="$video->title"
                        :image-url="$video->cover_url ?? asset('home-bg.png')"
                        :video-url="$video->video_url"
                    />
                @empty
                    <x-frontend.video-card />
                @endforelse
            </div>
        </section>

        </div>
    </main>

    @include('footer.footer')
    <script src="{{ asset('js/video-player.js') }}"></script>
</body>
</html>