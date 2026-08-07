<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aizap Creatives - About Us</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/pages/about-us.css') }}">
</head>
<body class="about-us-page">
    @include('header.header')
    <main id="app-content">
        <div class="about-page-shell">
        <section class="about-hero-block">
            <div class="about-copy">
                <h1 class="about-title">
                    We’re more than<br>
                    creators.<br>
                    <span>We’re your creative partners.</span>
                </h1>

                <p>
                    At AI Creatives, we combine the power of artificial intelligence with human imagination to create content that connects, inspires, and delivers real results.
                </p>

                <p>
                    From high-converting ads to cinematic storytelling, we help brands communicate with impact in the digital world.
                </p>
                
            </div>

            <div class="about-hero-visual">
                <div class="about-hero-media" style="background-image: url('{{ asset('about-us.png') }}');"></div>
            </div>
        </section>

        <section class="value-strip">
            <article class="value-card">
                <div class="value-head">
                    <span class="value-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9.5 3.5a2.5 2.5 0 0 0-2.45 2A2.5 2.5 0 0 0 5 8v1a2.5 2.5 0 0 0-1 4.5v1A2.5 2.5 0 0 0 6.5 17H8v2a2.5 2.5 0 0 0 5 0V6a2.5 2.5 0 0 0-3.5-2.5Z"/>
                            <path d="M14.5 3.5a2.5 2.5 0 0 1 2.45 2A2.5 2.5 0 0 1 19 8v1a2.5 2.5 0 0 1 1 4.5v1a2.5 2.5 0 0 1-2.5 2.5H16v2a2.5 2.5 0 0 1-5 0"/>
                        </svg>
                    </span>
                    <h3>AI-Powered<br>Creativity</h3>
                </div>
                <p>We leverage cutting-edge AI tools to produce high-quality content faster, smarter, and better.</p>
            </article>

            <article class="value-card">
                <div class="value-head">
                    <span class="value-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="7" r="3"/>
                            <path d="M2.5 19.5c0-3.31 2.91-6 6.5-6s6.5 2.69 6.5 6"/>
                            <circle cx="17" cy="8" r="2.4"/>
                            <path d="M15.7 13.6c2.7.4 4.8 2.5 4.8 5.4"/>
                        </svg>
                    </span>
                    <h3>Human Touch,<br>Real Impact</h3>
                </div>
                <p>Behind every AI-generated piece is a team of storytellers, editors, and designers who care.</p>
            </article>

            <article class="value-card">
                <div class="value-head">
                    <span class="value-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="8.5"/>
                            <circle cx="12" cy="12" r="4.5"/>
                            <circle cx="12" cy="12" r="0.9" fill="currentColor" stroke="none"/>
                        </svg>
                    </span>
                    <h3>Focused on<br>Results</h3>
                </div>
                <p>We create content that doesn’t just look good — it works. Built for engagement, conversions, and growth.</p>
            </article>

            <article class="value-card">
                <div class="value-head">
                    <span class="value-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13.5 3.5c3 .6 6 3.6 6 7.5-2.7 1.2-5 1-6.6-.6-1.6-1.6-1.8-3.9-.6-6.6 .4-.1.8-.2 1.2-.3Z"/>
                            <path d="M13 11 5.5 18.5"/>
                            <path d="M8 15.5c-1.6-.3-3 .3-4 2.5 2.2-1 2.8.4 2.5-2.5Z"/>
                            <path d="M9.2 6.6c-2.3-.4-4 .3-5.2 3 1.9.9 3.4.6 4.5-.6"/>
                            <path d="M17.4 14.8c.4 2.3-.3 4-3 5.2-.9-1.9-.6-3.4.6-4.5"/>
                        </svg>
                    </span>
                    <h3>Built for the<br>Future</h3>
                </div>
                <p>We stay ahead of trends and technology so your brand always stays one step ahead.</p>
            </article>
        </section>

        <section class="impact-strip">
            <article class="impact-card impact-story">
                <div class="impact-top">
                    <div class="impact-eyebrow">Our Impact</div>
                    <div class="impact-title">Numbers that<br>tell our story</div>
                </div>
            </article>

            <article class="impact-card">
                <span class="impact-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2.5" y="5" width="19" height="13" rx="2.5"/>
                        <path d="M10 9.3v5.4l4.6-2.7Z" fill="currentColor" stroke="none"/>
                    </svg>
                </span>
                <div class="impact-number">500+</div>
                <div class="impact-label">Projects completed</div>
                <p>Across different industries and platforms</p>
            </article>

            <article class="impact-card">
                <span class="impact-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="7" r="3"/>
                        <path d="M2.5 19.5c0-3.31 2.91-6 6.5-6s6.5 2.69 6.5 6"/>
                        <circle cx="17" cy="8" r="2.4"/>
                        <path d="M15.7 13.6c2.7.4 4.8 2.5 4.8 5.4"/>
                    </svg>
                </span>
                <div class="impact-number">100+</div>
                <div class="impact-label">Happy clients</div>
                <p>Brands that trust us with their story</p>
            </article>

            <article class="impact-card">
                <span class="impact-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12s3.6-6.5 10-6.5S22 12 22 12s-3.6 6.5-10 6.5S2 12 2 12Z"/>
                        <circle cx="12" cy="12" r="2.8"/>
                    </svg>
                </span>
                <div class="impact-number">50M+</div>
                <div class="impact-label">Views generated</div>
                <p>Content that connects and gets results</p>
            </article>

            <article class="impact-card">
                <span class="impact-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M3 12h18"/>
                        <path d="M12 3c2.6 2.4 4 5.6 4 9s-1.4 6.6-4 9c-2.6-2.4-4-5.6-4-9s1.4-6.6 4-9Z"/>
                    </svg>
                </span>
                <div class="impact-number">Global</div>
                <div class="impact-label">Client reach</div>
                <p>Working with brands around the world</p>
            </article>
        </section>
        </div>
    </main>
    @include('footer.footer')
</body>
</html>