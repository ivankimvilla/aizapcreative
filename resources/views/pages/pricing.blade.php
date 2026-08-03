<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aizap Creative - Pricing</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/pages/pricing.css') }}">
</head>
<body class="pricing-page">
    @include('header.header')

    <main class="pricing-shell">
        <section class="pricing-hero">
            <div class="pricing-hero__copy">
                <h1 class="pricing-hero__title">Flexible <span>Pricing</span></h1>
                <p class="pricing-hero__text">
                    Every project is unique. We create custom AI videos tailored to your vision, timeline, and campaign needs.
                </p>
            </div>

            <div class="pricing-hero__visual">
                <div class="pricing-hero__media" style="background-image: url('{{ asset('home-bg.png') }}');"></div>
            </div>
        </section>

        <section class="pricing-grid">
            <article class="pricing-card">
                <div class="pricing-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l1.2-3.4h3.1L6.2 9" />
                        <path d="M8.6 9l1.2-3.4h3.1L11.8 9" />
                        <path d="M14.2 9l1.2-3.4h3.1L17.4 9" />
                        <rect x="3" y="9" width="18" height="11" rx="1.2" />
                        <path d="M10.2 12.8v3.6l3.1-1.8-3.1-1.8z" />
                    </svg>
                </div>
                <h3>AI Commercial Ads</h3>
                <p>High-converting cinematic advertisements for brands.</p>
                <ul>
                    <li>30-60 sec AI commercial</li>
                    <li>Script assistance</li>
                    <li>Cinematic quality</li>
                    <li>Fast turnaround</li>
                    <li>Multiple formats</li>
                    <li>Commercial use</li>
                </ul>
                <a href="#contact" class="pricing-card__button">
                    <span>Request a Quote</span>
                    <svg class="btn-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="7" y1="17" x2="17" y2="7" />
                        <polyline points="7 7 17 7 17 17" />
                    </svg>
                </a>
            </article>

            <article class="pricing-card">
                <div class="pricing-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6.5 8.2h11l-1 12.3h-9l-1-12.3z" />
                        <path d="M9 8.2V6.4a3 3 0 0 1 6 0v1.8" />
                        <line x1="12" y1="12.4" x2="12" y2="16.4" />
                        <line x1="10" y1="14.4" x2="14" y2="14.4" />
                    </svg>
                </div>
                <h3>Product Advertising</h3>
                <p>Showcase your product with premium AI visuals.</p>
                <ul>
                    <li>Product-focused videos</li>
                    <li>Social media ready</li>
                    <li>Multiple aspect ratios</li>
                    <li>High-quality visuals</li>
                    <li>Engaging storytelling</li>
                    <li>Commercial use</li>
                </ul>
                <a href="#contact" class="pricing-card__button">
                    <span>Request a Quote</span>
                    <svg class="btn-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="7" y1="17" x2="17" y2="7" />
                        <polyline points="7 7 17 7 17 17" />
                    </svg>
                </a>
            </article>

            <article class="pricing-card">
                <div class="pricing-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9.5" cy="10.5" r="6" />
                        <path d="M7.2 12.3c.6.9 1.4 1.4 2.3 1.4s1.7-.5 2.3-1.4" />
                        <circle cx="7.5" cy="9.2" r="0.6" fill="currentColor" stroke="none" />
                        <circle cx="11.5" cy="9.2" r="0.6" fill="currentColor" stroke="none" />
                        <path d="M14 15.3c1.7.5 3.7 1.6 4.6 3.1a5.7 5.7 0 0 0 .9-3.1c0-2.9-2.1-5.3-5-5.7" />
                    </svg>
                </div>
                <h3>Storytelling & Short Films</h3>
                <p>Emotional AI films that connect with audiences.</p>
                <ul>
                    <li>Story development</li>
                    <li>Cinematic scenes</li>
                    <li>Character consistency</li>
                    <li>Creative direction</li>
                    <li>Background score</li>
                    <li>Multiple revisions</li>
                </ul>
                <a href="#contact" class="pricing-card__button">
                    <span>Request a Quote</span>
                    <svg class="btn-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="7" y1="17" x2="17" y2="7" />
                        <polyline points="7 7 17 7 17 17" />
                    </svg>
                </a>
            </article>

            <article class="pricing-card">
                <div class="pricing-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18 4 19l1-4L16.5 3.5z" />
                        <path d="M14.5 5.5l3 3" />
                    </svg>
                </div>
                <h3>Custom Projects</h3>
                <p>Need something unique? We'll build it together.</p>
                <ul>
                    <li>Brand campaigns</li>
                    <li>Music videos</li>
                    <li>Explainer videos</li>
                    <li>Social media content</li>
                    <li>Creative concepts</li>
                    <li>And more</li>
                </ul>
                <a href="#contact" class="pricing-card__button">
                    <span>Let's Talk</span>
                    <svg class="btn-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="7" y1="17" x2="17" y2="7" />
                        <polyline points="7 7 17 7 17 17" />
                    </svg>
                </a>
            </article>
        </section>

        <section class="pricing-benefits">
            <article class="benefit-card">
                <div class="benefit-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="13 2 4 14 11 14 10 22 20 9 13 9 13 2" />
                    </svg>
                </div>
                <h3>Fast Turnaround</h3>
                <p>Quick delivery without compromising quality.</p>
            </article>

            <article class="benefit-card">
                <div class="benefit-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 3h12l4 6.2L12 21 2 9.2 6 3z" />
                        <path d="M2 9.2h20" />
                        <path d="M9 3l3 6.2L9.5 21" />
                        <path d="M15 3l-3 6.2L14.5 21" />
                    </svg>
                </div>
                <h3>Premium Quality</h3>
                <p>Cinematic AI visuals that stand out.</p>
            </article>

            <article class="benefit-card">
                <div class="benefit-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3l7.5 2.8v5.4c0 4.7-3.2 7.9-7.5 8.9-4.3-1-7.5-4.2-7.5-8.9V5.8L12 3z" />
                        <path d="M8.7 12.2l2.1 2.1 4.2-4.4" />
                    </svg>
                </div>
                <h3>Commercial Use</h3>
                <p>100% safe for your brand and business.</p>
            </article>

            <article class="benefit-card">
                <div class="benefit-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4.5 13v-1.2a7.5 7.5 0 0 1 15 0V13" />
                        <rect x="2.2" y="13" width="4" height="6.2" rx="1.2" />
                        <rect x="17.8" y="13" width="4" height="6.2" rx="1.2" />
                        <path d="M19.5 19.2v.8a3 3 0 0 1-3 3h-3.4" />
                    </svg>
                </div>
                <h3>Dedicated Support</h3>
                <p>We're with you from concept to delivery.</p>
            </article>

            <article class="pricing-benefits__actions">
                <a href="/book-a-call" class="pricing-benefits__button pricing-benefits__button--ghost">
                    <span class="pricing-benefits__button-icon">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span>Book a Call</span>
                </a>
            </article>
        </section>
    </main>
    @include('footer.footer')
</body>
</html>