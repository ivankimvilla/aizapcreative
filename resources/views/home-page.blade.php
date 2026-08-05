<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aizap Creatives - Home</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/home-page/home-page.css') }}">
</head>
<body class="home-page-page">
    @include('header.header')
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
                            <p style="margin: 0; color: #6b7280;">No featured videos yet. Add one from the admin projects page to see it here.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="feedback-section" id="feedback">
                <div class="feedback-layout">
                    <aside class="feedback-summary">
                        <div class="feedback-header">
                            <div class="eyebrow">Client Feedback</div>
                            <h2>What Our Clients Say</h2>
                            <p class="feedback-header__sub">Real feedback from the brands and creators we've worked with — see what it's like to bring your project to Aizap Creatives.</p>
                        </div>

                        @php
                            $totalReviews = $feedbackItems->count();
                            $avgRating = $totalReviews ? round($feedbackItems->avg('rating'), 1) : 0;
                            $ratingCounts = [];
                            for ($r = 5; $r >= 1; $r--) {
                                $ratingCounts[$r] = $feedbackItems->where('rating', $r)->count();
                            }
                            $maxCount = max(array_merge($ratingCounts, [1]));
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
                                <div class="rating-summary__count">{{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}</div>
                            </div>

                            <div class="rating-summary__bars">
                                @foreach ($ratingCounts as $star => $count)
                                    <div class="rating-bar-row">
                                        <span class="rating-bar-row__label">
                                            @for ($i = 1; $i <= $star; $i++)
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFD400" class="rating-bar-row__label-star" aria-hidden="true">
                                                    <path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/>
                                                </svg>
                                            @endfor
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
                                <span class="feedback-panel__count">{{ $feedbackItems->count() }}</span>
                            </div>
                        </div>

                        <div class="feedback-table__wrap">
                            <div class="feedback-table__body">
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
                    $reviewModalShouldOpen = session('status') || $errors->any();
                @endphp

                <div class="review-modal__backdrop{{ $reviewModalShouldOpen ? ' is-open' : '' }}" id="reviewModalBackdrop">
                    <div class="review-modal" role="dialog" aria-modal="true" aria-labelledby="reviewModalTitle">
                        <button type="button" class="review-modal__close" id="closeReviewModalBtn" aria-label="Close">&times;</button>

                        <div class="feedback-form-header">
                            <div class="eyebrow">Share Your Experience</div>
                            <h3 id="reviewModalTitle">Write a Feedback</h3>
                            <p class="feedback-form-sub">Tell us what you think about working with Aizap Creatives.</p>
                        </div>

                        <form class="feedback-form" action="{{ route('feedback.store') }}" method="POST">
                            @csrf
                            @if (session('status'))
                                <div class="form-alert form-alert--success" role="status">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="form-alert form-alert--error" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="fb-name">Full Name</label>
                                    <input type="text" id="fb-name" name="name" autocomplete="name" placeholder="Enter your full name" value="{{ old('name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="fb-role">Role / Company</label>
                                    <input type="text" id="fb-role" name="role" autocomplete="organization" placeholder="Role, Company Name" value="{{ old('role') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <span class="form-group-label">Your Rating</span>
                                <div class="rating-input">
                                    <input type="radio" id="star5" name="rating" value="5" {{ old('rating', '5') === '5' ? 'checked' : '' }}>
                                    <label for="star5" title="5 stars">★</label>
                                    <input type="radio" id="star4" name="rating" value="4" {{ old('rating') === '4' ? 'checked' : '' }}>
                                    <label for="star4" title="4 stars">★</label>
                                    <input type="radio" id="star3" name="rating" value="3" {{ old('rating') === '3' ? 'checked' : '' }}>
                                    <label for="star3" title="3 stars">★</label>
                                    <input type="radio" id="star2" name="rating" value="2" {{ old('rating') === '2' ? 'checked' : '' }}>
                                    <label for="star2" title="2 stars">★</label>
                                    <input type="radio" id="star1" name="rating" value="1" {{ old('rating') === '1' ? 'checked' : '' }}>
                                    <label for="star1" title="1 star">★</label>
                                </div>
                            </div>

                            <div class="form-group form-group--grow">
                                <label for="fb-message">Your Feedback</label>
                                <textarea id="fb-message" name="message" rows="4" autocomplete="off" placeholder="Share details about your experience working with us..." required>{{ old('message') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary feedback-submit">Submit Feedback</button>
                        </form>
                    </div>
                </div>
            </section>

        </div>
    </div>
    @include('footer.footer')
    <script src="{{ asset('js/video-player.js') }}"></script>
    <script src="{{ asset('js/home-page.js') }}"></script>
</body>
</html>