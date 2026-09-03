<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aizap Creatives - Home</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=instrument-serif:400,400i" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/home-page/home-page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/format-ticker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/process.css') }}">
    <link rel="stylesheet" href="{{ asset('css/video-cards.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tools-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/process-animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-page/contact-cta.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
</head>
<body class="home-page-page">
    @include('header.header')

    <main id="app-content">
        <div class="background-glow">
            <div class="container">
                @include('home-page.sections.hero')
                @include('home-page.sections.formats')
                @include('home-page.sections.projects')

                <main class="process-shell">
                    @include('home-page.sections.tools')
                    @include('home-page.sections.process')
                    @include('home-page.sections.process-cta')
                </main>

                @include('home-page.sections.feedback')
                @include('home-page.sections.brief-cta')
            </div>
        </div>
    </main>

    @include('home-page.sections.contact-modal')
    @include('footer.footer')

    <script src="{{ asset('js/video-player.js') }}"></script>
    <script src="{{ asset('js/home-page.js') }}"></script>
    <script src="{{ asset('js/tools-section.js') }}"></script>
    <script src="{{ asset('js/process-animations.js') }}"></script>
    <script src="{{ asset('js/contact-cta.js') }}"></script>
    <script src="{{ asset('js/scroll-animations.js') }}"></script>
    <script>
        (function () {
            var svc = document.getElementById('cf-service');
            if (!svc) return;
            svc.addEventListener('change', function () {
                this.classList.toggle('has-value', this.value !== '');
            });
        })();
    </script>
</body>
</html>
