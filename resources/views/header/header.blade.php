<link rel="stylesheet" href="{{ asset('css/header/header.css') }}">
@php
    $recaptchaSiteKey = config('services.recaptcha.site_key');
    $recaptchaUseEnterprise = config('services.recaptcha.use_enterprise', false);
    $recaptchaScript = $recaptchaUseEnterprise
        ? "https://www.google.com/recaptcha/enterprise.js?render={$recaptchaSiteKey}"
        : "https://www.google.com/recaptcha/api.js?render={$recaptchaSiteKey}";
@endphp
@if (!empty($recaptchaSiteKey))
    <script src="{{ $recaptchaScript }}" async defer></script>
@endif

<header class="site-header">
    <div class="site-header__scroll-progress" aria-hidden="true">
        <span id="siteHeaderScrollProgress"></span>
    </div>

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
        <a href="{{ url('/') }}" class="site-header__nav-link {{ request()->is('/') ? 'site-header__nav-link--active' : '' }}" data-no-ajax>Home</a>
        <a href="{{ url('/about-us') }}" class="site-header__nav-link {{ request()->is('about-us') ? 'site-header__nav-link--active' : '' }}" data-no-ajax>About Us</a>

        @php
            $isServicesPage = request()->is('what-we-do/*');
        @endphp
        <div class="site-header__nav-item site-header__nav-item--services">
            <a href="{{ url('/what-we-do/services') }}"
               class="site-header__nav-link {{ $isServicesPage ? 'site-header__nav-link--active' : '' }}"
               data-no-ajax>
                <span>Services</span>
            </a>
        </div>

        <a href="{{ url('/portfolio') }}" class="site-header__nav-link {{ request()->is('portfolio') ? 'site-header__nav-link--active' : '' }}" data-no-ajax>Portfolio</a>
        <a href="{{ url('/contact') }}" class="site-header__nav-link {{ request()->is('contact') ? 'site-header__nav-link--active' : '' }}" data-no-ajax>Contact</a>

    </nav>

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