<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aizap Creatives - Home</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/home-page/home-page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/process.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-page/contact-section.css') }}">
</head>
<body class="home-page-page">
    @include('header.header')
    <main id="app-content">
        <div class="background-glow">
            <div class="container">

            <section class="hero-section" id="services">
                <div class="hero-copy">
                    <h1 class="hero-title">
                        AI-Powered<br>
                        Creativity<br>
                        That <span class="gold">Builds Brands.</span>
                    </h1>
                    <p class="hero-sub">
                        We create high-quality AI-generated videos, ads, and creative content that helps brands stand out, connect, and grow in the digital world.
                    </p>
                </div>
                <div class="hero-panels hero-panel">
                    <div class="hero-panel-media" style="background-image: url('{{ asset('home-bg.png') }}');"></div>
                </div>
            </section>

            <section class="projects-section" id="projects">
                <div class="projects-header">
                    <div>
                        <div class="eyebrow">Our Work</div>
                        <h2>Featured Projects</h2>
                    </div>
                    <a href="/portfolio" class="btn btn-secondary">View All Projects</a>
                </div>
                <div class="projects-grid">
                    @forelse ($featuredProjects as $project)
                        <article class="project-card">
                            @if ($project->video_url)
                                <div class="project-thumb">
                                    <video playsinline preload="metadata" poster="{{ $project->cover_url ?? 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'600\' height=\'338\'%3E%3Cdefs%3E%3CradialGradient id=\'g\'%3E%3Cstop offset=\'0%25\' stop-color=\'%23141414\'/%3E%3Cstop offset=\'100%25\' stop-color=\'%23000000\'/%3E%3C/radialGradient%3E%3C/defs%3E%3Crect width=\'100%25\' height=\'100%25\' fill=\'url(%23g)\'/%3E%3C/svg%3E' }}" src="{{ $project->video_url }}"></video>
                                </div>
                            @else
                                <div class="project-thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                                    <span class="project-play-icon" aria-hidden="true"></span>
                                </div>
                            @endif
                            <div class="project-card__content">
                                <h3>
                                    {{ $project->title }}
                                    <span class="project-category">
                                        {{ $project->client && strcasecmp($project->client, $project->title) !== 0 ? $project->client . ' • ' : '' }}{{ $project->getCategoryLabelAttribute() }}
                                    </span>
                                </h3>
                            </div>
                        </article>
                    @empty
                        <div class="feedback-form-wrap" style="grid-column: 1 / -1;">
                            <p style="margin: 0; color: #6b7280;">No featured videos yet.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <main class="process-shell">
                <section class="process-hero">
                    <div class="process-hero__media-wrap">
                        <div class="process-hero__media">
                            <div class="process-hero__slide" style="animation-delay: 0s;">
                                <div class="process-hero__slide-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
                                </div>
                                <div class="process-hero__slide-label">AI Commercial Ads</div>
                            </div>
                            <div class="process-hero__slide" style="animation-delay: -5s;">
                                <div class="process-hero__slide-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".7" fill="currentColor" stroke="none"/></svg>
                                </div>
                                <div class="process-hero__slide-label">AI Product Ads</div>
                            </div>
                            <div class="process-hero__slide" style="animation-delay: -10s;">
                                <div class="process-hero__slide-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg>
                                </div>
                                <div class="process-hero__slide-label">AI Storytelling / Drama</div>
                            </div>
                            <div class="process-hero__slide" style="animation-delay: -15s;">
                                <div class="process-hero__slide-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20.2 6 3 11l-.9-2.4c-.3-1.1.3-2.2 1.3-2.5l13.5-4c1.1-.3 2.2.3 2.5 1.3Z"/><path d="m6.2 5.3 3.1 3.9"/><path d="m12.4 3.4 3.1 4"/><path d="M3 11h18v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"/></svg>
                                </div>
                                <div class="process-hero__slide-label">AI Movie Trailers</div>
                            </div>
                            <div class="process-hero__slide" style="animation-delay: -20s;">
                                <div class="process-hero__slide-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                                </div>
                                <div class="process-hero__slide-label">UGC-style AI Videos</div>
                            </div>
                            <div class="process-hero__slide" style="animation-delay: -25s;">
                                <div class="process-hero__slide-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>
                                </div>
                                <div class="process-hero__slide-label">Explainer Videos</div>
                            </div>
                        </div>
                    </div>
                    <div class="process-hero__copy process-hero__copy--wide">
                        <h1 class="process-hero__title">Our process.<br><span>Simple. clear.</span><br>Powerful.</h1>
                        <p class="process-hero__text">
                            Our proven process ensures every project is strategic, creative, and delivered with precision from concept to final cut.
                        </p>
                    </div>
                </section>

                <section class="process-section">
                    <div class="section-heading">
                        <div class="eyebrow">How We Work</div>
                        <h2>A clear process. Exceptional results.</h2>
                        <p>From your idea to a powerful final video — we handle everything.</p>
                    </div>

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
                            <div class="process-step-image">
                                <img src="{{ asset('images/process/discovery-call.png') }}" alt="Discovery Call" loading="lazy">
                            </div>
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
                            <div class="process-step-image">
                                <img src="{{ asset('images/process/strategy-concept.png') }}" alt="Strategy &amp; Concept" loading="lazy">
                            </div>
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
                            <div class="process-step-image">
                                <img src="{{ asset('images/process/script.png') }}" alt="Script &amp; Storyboard" loading="lazy">
                            </div>
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
                            <div class="process-step-image">
                                <img src="{{ asset('images/process/production.png') }}" alt="AI Production" loading="lazy">
                            </div>
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
                            <div class="process-step-image">
                                <img src="{{ asset('images/process/editing-revisions.png') }}" alt="Editing &amp; Revisions" loading="lazy">
                            </div>
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
                            <div class="process-step-image">
                                <img src="{{ asset('images/process/final-delivery.png') }}" alt="Final Delivery" loading="lazy">
                            </div>
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
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M8 12l2 2 4-4"/></svg>
                        </div>
                        <div>
                            <h3>Ready to bring your story to life?</h3>
                            <p>Let's create something extraordinary together.</p>
                        </div>
                    </div>
                    <a href="/contact" class="process-cta__button">Let's Work Together</a>
                </section>
            </main>

            <section class="feedback-section" id="feedback">
                <div class="feedback-layout">
                    <aside class="feedback-summary">
                        <div class="feedback-header">
                            <div class="eyebrow">Client Feedback</div>
                            <h2>What Our Clients Say</h2>
                            <p class="feedback-header__sub">Real feedback from the brands and creators we've worked with — see what it's like to bring your project to Aizap Creatives.</p>
                        </div>

                        @php
                            $totalReviews = $feedbackCount ?? $feedbackItems->count();
                            $avgRating = $totalReviews ? round($feedbackAverage ?? $feedbackItems->avg('rating'), 1) : 0;
                            $ratingBarWidths = [5 => 100, 4 => 60, 3 => 35, 2 => 15, 1 => 8];
                        @endphp

                        <div class="rating-summary rating-summary--panel">
                            <div class="rating-summary__score">
                                <div class="rating-summary__number">{{ number_format($avgRating, 1) }}</div>
                                <div class="rating-summary__stars" aria-hidden="true">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="opacity: {{ $i <= round($avgRating) ? '1' : '0.2' }};">
                                            <path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <div class="rating-summary__count" id="feedbackSummaryCount">{{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}</div>
                            </div>

                            <div class="rating-summary__bars">
                                @foreach ($ratingBarWidths as $star => $pct)
                                    <div class="rating-bar-row">
                                        <span class="rating-bar-row__label">{{ $star }}</span>
                                        <span class="rating-bar-row__track">
                                            <span class="rating-bar-row__fill" style="width: {{ $pct }}%;"></span>
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-primary rating-summary__cta" id="openReviewModalBtn">Write a review</button>
                        </div>

                        <div class="feedback-summary__note">
                            <strong>New reviews appear instantly</strong> once submitted, and each entry includes the post date so visitors can see recent praise.
                        </div>
                    </aside>

                    <div class="feedback-panel">
                        <div class="feedback-panel__top">
                            <div class="feedback-panel__title">
                                <span class="feedback-panel__icon" aria-hidden="true">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 4h16v11H8l-4 4V4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                Feedback List
                                <span class="feedback-panel__count" id="feedbackCount">{{ $totalReviews }}</span>
                            </div>
                        </div>

                        <div class="feedback-table__wrap">
                            <div class="feedback-table__body" id="feedbackBody">
                                @forelse ($feedbackItems as $feedback)
                                    <div class="review-card" data-search="{{ strtolower($feedback->name . ' ' . ($feedback->role ?? '') . ' ' . $feedback->message) }}">
                                        <div class="review-card__top">
                                            <span class="review-card__avatar">
                                                @if (!empty($feedback->avatar_url))
                                                    <img src="{{ $feedback->avatar_url }}" alt="{{ $feedback->name }}">
                                                @else
                                                    {{ strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $feedback->name), 0, 2)) }}
                                                @endif
                                            </span>
                                            <strong class="review-card__name">{{ $feedback->name }}</strong>
                                        </div>
                                        <div class="review-card__stars-date">
                                            <span class="review-card__stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" style="opacity: {{ $i <= $feedback->rating ? '1' : '0.25' }};">
                                                        <path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/>
                                                    </svg>
                                                @endfor
                                            </span>
                                            <span class="review-card__date">{{ optional($feedback->created_at)->format('M j, Y') ?? now()->format('M j, Y') }}</span>
                                        </div>
                                        <p class="review-card__message">{{ $feedback->message }}</p>
                                    </div>
                                @empty
                                    <div class="review-card review-card--empty">
                                        <p class="review-card__message">No client feedback is available yet.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $reviewModalShouldOpen = $errors->any();
                @endphp

                <div class="review-modal__backdrop{{ $reviewModalShouldOpen ? ' is-open' : '' }}" id="reviewModalBackdrop">
                    <div class="review-modal" role="dialog" aria-modal="true" aria-labelledby="reviewModalTitle">
                        <button type="button" class="review-modal__close" id="closeReviewModalBtn" aria-label="Close">&times;</button>

                        <div class="feedback-form-header">
                            <div class="eyebrow">Share Your Experience</div>
                            <h3 id="reviewModalTitle">Write a Feedback</h3>
                            <p class="feedback-form-sub">Tell us what you think about working with Aizap Creatives.</p>
                        </div>

                        <form id="feedbackForm" class="feedback-form" action="{{ route('feedback.store') }}" method="POST">
                            @csrf
                            @if ($errors->any())
                                <div class="form-alert form-alert--error" role="alert">
                                    <div class="form-alert__icon" aria-hidden="true">!</div>
                                    <div>
                                        <div class="form-alert__title">Couldn't submit feedback</div>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="fb-first-name">First name<span class="required-asterisk">*</span></label>
                                    <input type="text" id="fb-first-name" name="first_name" autocomplete="given-name" value="{{ old('first_name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="fb-last-name">Last name<span class="required-asterisk">*</span></label>
                                    <input type="text" id="fb-last-name" name="last_name" autocomplete="family-name" value="{{ old('last_name') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="fb-rating">Your Rating<span class="required-asterisk">*</span></label>
                                <select id="fb-rating" name="rating" required>
                                    <option value="5" {{ old('rating', '5') === '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ — 5 (Excellent)</option>
                                    <option value="4" {{ old('rating') === '4' ? 'selected' : '' }}>⭐⭐⭐⭐☆ — 4 (Good)</option>
                                    <option value="3" {{ old('rating') === '3' ? 'selected' : '' }}>⭐⭐⭐☆☆ — 3 (Average)</option>
                                    <option value="2" {{ old('rating') === '2' ? 'selected' : '' }}>⭐⭐☆☆☆ — 2 (Poor)</option>
                                    <option value="1" {{ old('rating') === '1' ? 'selected' : '' }}>⭐☆☆☆☆ — 1 (Terrible)</option>
                                </select>
                            </div>

                            <div class="form-group form-group--grow">
                                <label for="fb-message">Your Feedback<span class="required-asterisk">*</span></label>
                                <textarea id="fb-message" name="message" rows="4" autocomplete="off" required>{{ old('message') }}</textarea>
                            </div>

                            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-feedback-response" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY', config('services.recaptcha.site_key')) }}" value="">

                            <button type="submit" class="btn btn-primary feedback-submit">Submit Feedback</button>
                        </form>
                    </div>
                </div>
            </section>

            <section class="aizap-contact" id="contact">
                <div class="aizap-contact__inner">

                    <div class="aizap-contact__left">
                        <h2 class="aizap-contact__title">CONTACT US!</h2>
                        <p class="aizap-contact__desc">
                            Reaching out to <strong>Aizap Creatives</strong> couldn't be simpler.
                            Share the details of your next project through our form and one of our
                            experts will get back to you right away. We'd love to work with you.
                        </p>

                        <div class="aizap-contact__slideshow">
                            <img src="{{ asset('images/contact-section/call-1.png') }}" alt="Aizap Creatives work 1" class="aizap-contact__slide" loading="lazy">
                            <img src="{{ asset('images/contact-section/call-2.png') }}" alt="Aizap Creatives work 2" class="aizap-contact__slide" loading="lazy">
                            <img src="{{ asset('images/contact-section/call-3.png') }}" alt="Aizap Creatives work 3" class="aizap-contact__slide" loading="lazy">
                           </div>
                    </div>

                    <div class="aizap-contact__right">
                        <div class="aizap-contact__card">
                            <div class="aizap-contact__heading">Get in touch</div>

                            @if ($errors->any())
                                <div class="form-alert form-alert--error" role="alert">
                                    <div class="form-alert__icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none"><path d="M12 2.5L23 21H1L12 2.5Z" fill="#ef4444"/><rect x="11" y="9" width="2" height="6" rx="1" fill="#fff"/><rect x="11" y="16.5" width="2" height="2" rx="1" fill="#fff"/></svg>
                                    </div>
                                    <div>
                                        <div class="form-alert__title">Couldn't send message</div>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <form id="contactForm" class="aizap-form" action="{{ route('contact.store') }}" method="POST">
                                @csrf

                                <div class="aizap-form__group">
                                    <label class="aizap-form__label" for="cf-first-name">First name*</label>
                                    <input class="aizap-form__input" id="cf-first-name" type="text" name="first_name" value="{{ old('first_name') }}" required autocomplete="given-name">
                                </div>

                                <div class="aizap-form__group">
                                    <label class="aizap-form__label" for="cf-last-name">Last name*</label>
                                    <input class="aizap-form__input" id="cf-last-name" type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name">
                                </div>

                                <div class="aizap-form__group">
                                    <label class="aizap-form__label" for="cf-email">Email*</label>
                                    <input class="aizap-form__input" id="cf-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                                </div>

                                <div class="aizap-form__group aizap-form__group--grow">
                                    <label class="aizap-form__label" for="cf-message">Message*</label>
                                    <textarea class="aizap-form__textarea" id="cf-message" name="message" rows="4" required>{{ old('message') }}</textarea>
                                </div>

                                <div class="aizap-form__recaptcha">
                                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-contact-response" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY', config('services.recaptcha.site_key')) }}" value="">
                                    @error('g-recaptcha-response')
                                        <div class="recaptcha-error" role="alert">
                                            <strong>reCAPTCHA required</strong>
                                            <span>Please complete the reCAPTCHA before sending your message.</span>
                                        </div>
                                    @enderror
                                </div>

                                <button class="aizap-form__submit" type="submit">
                                    Send Message
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                </button>
                            </form>

                        </div>
                    </div>

                </div>
            </section>

            </div>
        </div>
    </main>
    @include('footer.footer')
    <script src="{{ asset('js/video-player.js') }}"></script>
    <script src="{{ asset('js/home-page.js') }}"></script>
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