<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aizap Creative - Process</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/pages/process.css') }}">
</head>
<body class="process-page">
    @include('header.header')

    <main class="process-shell">
        <section class="process-hero">
            <div class="process-hero__copy">
                <h1 class="process-hero__title">Our process.<br><span>Simple. clear.</span><br>Powerful.</h1>
                <p class="process-hero__text">
                    Our proven process ensures every project is strategic, creative, and delivered with precision from concept to final cut.
                </p>
            </div>

            <div class="process-hero__media-wrap">
                <div class="process-hero__media" style="background-image: url('{{ asset('home-bg.png') }}');"></div>
            </div>
        </section>

        <section class="process-section">
            <div class="section-heading">
                <div class="eyebrow">How We Work</div>
                <h2>A clear process. Exceptional results.</h2>
                <p>From your idea to a powerful final video — we handle everything.</p>
            </div>

            <!-- Icon row with connecting line -->
            <div class="process-icons-row">
                <div class="process-icons-line"></div>

                <div class="process-icon-node">
                    <div class="process-circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                </div>

                <div class="process-icon-node">
                    <div class="process-circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18h6"/><path d="M10 22h4"/><path d="M12 2a7 7 0 0 0-4 12.7c.6.44 1 1.15 1 1.9V17a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-.4c0-.75.4-1.46 1-1.9A7 7 0 0 0 12 2z"/></svg>
                    </div>
                </div>

                <div class="process-icon-node">
                    <div class="process-circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M9 13h6"/><path d="M9 17h6"/><path d="M9 9h1"/></svg>
                    </div>
                </div>

                <div class="process-icon-node">
                    <div class="process-circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4.5a2.5 2.5 0 0 0-4.96-.46 2.5 2.5 0 0 0-1.98 3 2.5 2.5 0 0 0-1.32 4.24 2.5 2.5 0 0 0 1.32 4.26 2.5 2.5 0 0 0 1.98 3 2.5 2.5 0 0 0 4.96-.44"/><path d="M12 4.5a2.5 2.5 0 0 1 4.96-.46 2.5 2.5 0 0 1 1.98 3 2.5 2.5 0 0 1 1.32 4.24 2.5 2.5 0 0 1-1.32 4.26 2.5 2.5 0 0 1-1.98 3 2.5 2.5 0 0 1-4.96-.44"/><path d="M12 4.5v15"/></svg>
                    </div>
                </div>

                <div class="process-icon-node">
                    <div class="process-circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><path d="M20 4 8.12 15.88"/><path d="M14.47 14.48 20 20"/><path d="M8.12 8.12 12 12"/></svg>
                    </div>
                </div>

                <div class="process-icon-node">
                    <div class="process-circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4 20-7z"/></svg>
                    </div>
                </div>
            </div>

            <div class="process-steps">
                <article class="process-step-card">
                    <span class="process-number">01</span>
                    <h3>Discovery Call</h3>
                    <div class="process-step-image" style="background-image: url('{{ asset('process/discovery-call.jpg') }}');"></div>
                    <p class="process-step-desc">We get to know your goals, audience, and vision.</p>
                    <ul>
                        <li>Project brief</li>
                        <li>Goal alignment</li>
                        <li>Scope &amp; timeline</li>
                    </ul>
                </article>

                <article class="process-step-card">
                    <span class="process-number">02</span>
                    <h3>Strategy &amp; Concept</h3>
                    <div class="process-step-image" style="background-image: url('{{ asset('process/strategy-concept.jpg') }}');"></div>
                    <p class="process-step-desc">We craft the right strategy and creative concept.</p>
                    <ul>
                        <li>Market &amp; audience insight</li>
                        <li>Creative direction</li>
                        <li>Concept approval</li>
                    </ul>
                </article>

                <article class="process-step-card">
                    <span class="process-number">03</span>
                    <h3>Script &amp; Storyboard</h3>
                    <div class="process-step-image" style="background-image: url('{{ asset('process/script-storyboard.jpg') }}');"></div>
                    <p class="process-step-desc">We write the script and visualize the entire story.</p>
                    <ul>
                        <li>Scriptwriting</li>
                        <li>Storyboard &amp; shot list</li>
                        <li>Client approval</li>
                    </ul>
                </article>

                <article class="process-step-card">
                    <span class="process-number">04</span>
                    <h3>AI Production</h3>
                    <div class="process-step-image" style="background-image: url('{{ asset('process/ai-production.jpg') }}');"></div>
                    <p class="process-step-desc">Our AI tools bring your story to life.</p>
                    <ul>
                        <li>AI image &amp; video generation</li>
                        <li>Voiceover &amp; SFX</li>
                        <li>Scene composition</li>
                    </ul>
                </article>

                <article class="process-step-card">
                    <span class="process-number">05</span>
                    <h3>Editing &amp; Revisions</h3>
                    <div class="process-step-image" style="background-image: url('{{ asset('process/editing-revisions.jpg') }}');"></div>
                    <p class="process-step-desc">We polish every frame until it's perfect.</p>
                    <ul>
                        <li>Editing &amp; color grading</li>
                        <li>Sound design &amp; music</li>
                        <li>Revisions included</li>
                    </ul>
                </article>

                <article class="process-step-card">
                    <span class="process-number">06</span>
                    <h3>Final Delivery</h3>
                    <div class="process-step-image" style="background-image: url('{{ asset('process/final-delivery.jpg') }}');"></div>
                    <p class="process-step-desc">We deliver a high-impact final video, ready to perform.</p>
                    <ul>
                        <li>Final quality check</li>
                        <li>Formats for all platforms</li>
                        <li>On-time delivery</li>
                    </ul>
                </article>
            </div>
        </section>

        <section class="process-cta">
            <div class="process-cta__left">
                <div class="process-cta__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>
                </div>
                <div>
                    <h3>Ready to bring your story to life?</h3>
                    <p>Let's create something extraordinary together.</p>
                </div>
            </div>
            <a href="/contact" class="process-cta__button">Let's Work Together</a>
        </section>
    </main>
    @include('footer.footer')
</body>
</html>