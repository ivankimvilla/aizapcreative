    <link rel="stylesheet" href="{{ asset('css/header/header.css') }}">

    <header class="site-header">
        <div class="site-header__brand">
            <img
                src="{{ asset('logo.png') }}"
                alt="AI Creatives Logo"
                width="168"
                height="168"
                loading="eager"
                fetchpriority="high"
            >
        </div>

        <nav class="site-header__nav" id="siteNav">
            <a href="{{ url('/') }}" class="site-header__nav-link {{ request()->is('/') ? 'site-header__nav-link--active' : '' }}">Home</a>
            <a href="{{ url('/about-us') }}" class="site-header__nav-link {{ request()->is('about-us') ? 'site-header__nav-link--active' : '' }}">About Us</a>

            @php
                $isServicesPage = request()->is('what-we-do/*');
            @endphp
            <div class="site-header__nav-item site-header__nav-item--services">
                <button id="servicesToggle"
                    class="site-header__nav-link site-header__nav-link--button {{ $isServicesPage ? 'site-header__nav-link--active' : '' }}"
                    aria-haspopup="true"
                    aria-expanded="false">
                    <span>Services</span>
                    <span class="site-header__nav-caret" aria-hidden="true">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </button>
                <div id="servicesDropdown" class="site-header__services-dropdown" hidden>
                    <div class="site-header__services-links">
                        <a href="{{ url('/what-we-do/ai-commercial-ads') }}" class="{{ request()->is('what-we-do/ai-commercial-ads') ? 'site-header__services-link--active' : '' }}">AI Commercial Ads</a>
                        <a href="{{ url('/what-we-do/ai-product-ads') }}" class="{{ request()->is('what-we-do/ai-product-ads') ? 'site-header__services-link--active' : '' }}">AI Product Ads</a>
                        <a href="{{ url('/what-we-do/ai-storytelling-drama') }}" class="{{ request()->is('what-we-do/ai-storytelling-drama') ? 'site-header__services-link--active' : '' }}">AI Storytelling / Drama</a>
                        <a href="{{ url('/what-we-do/ai-movie-trailers') }}" class="{{ request()->is('what-we-do/ai-movie-trailers') ? 'site-header__services-link--active' : '' }}">AI Movie Trailers</a>
                        <a href="{{ url('/what-we-do/ugc-style-ai-videos') }}" class="{{ request()->is('what-we-do/ugc-style-ai-videos') ? 'site-header__services-link--active' : '' }}">UGC-style AI Videos</a>
                        <a href="{{ url('/what-we-do/explainer-videos') }}" class="{{ request()->is('what-we-do/explainer-videos') ? 'site-header__services-link--active' : '' }}">Explainer Videos</a>
                    </div>

                </div>
            </div>

            <a href="{{ url('/portfolio') }}" class="site-header__nav-link {{ request()->is('portfolio') ? 'site-header__nav-link--active' : '' }}">Portfolio</a>
            <a href="{{ url('/pricing') }}" class="site-header__nav-link {{ request()->is('pricing') ? 'site-header__nav-link--active' : '' }}">Pricing</a>
            <a href="{{ url('/contact') }}" class="site-header__nav-link {{ request()->is('contact') ? 'site-header__nav-link--active' : '' }}">Contact</a>
        </nav>

        <a href="{{ url('/book-a-call') }}" class="site-header__cta {{ request()->is('book-a-call') ? 'site-header__cta--active' : '' }}">
            <span class="site-header__cta-icon">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            Book A Call
        </a>

        <button type="button" class="site-header__toggle" id="siteNavToggle" aria-label="Toggle navigation" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

        @if (session('feedback_status') || session('contact_status'))
            <div class="site-header__status" role="status">
                <span class="site-header__status-icon" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <div>
                    <div class="site-header__status-title">
                        {{ session('feedback_status') ? 'Feedback submitted' : 'Message sent' }}
                    </div>
                    <p>{{ session('feedback_status') ?? session('contact_status') }}</p>
                </div>
            </div>
        @endif
    </header>

    <script src="{{ asset('js/header/header.js') }}"></script>