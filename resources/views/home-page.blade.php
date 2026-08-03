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
                    <article class="project-card">
                        <div class="project-thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                            <span class="play-badge">▶</span>
                        </div>
                        <h3>Nike Commercial</h3>
                        <p>AI Commercial Ad</p>
                    </article>

                    <article class="project-card">
                        <div class="project-thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                            <span class="play-badge">▶</span>
                        </div>
                        <h3>Luxury Perfume AD</h3>
                        <p>AI Product Ad</p>
                    </article>

                    <article class="project-card">
                        <div class="project-thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                            <span class="play-badge">▶</span>
                        </div>
                        <h3>Echoes of Us</h3>
                        <p>AI Drama / Storytelling</p>
                    </article>

                    <article class="project-card">
                        <div class="project-thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                            <span class="play-badge">▶</span>
                        </div>
                        <h3>Beyond the Realm</h3>
                        <p>AI Short Film</p>
                    </article>

                    <article class="project-card">
                        <div class="project-thumb" style="background-image: url('{{ asset('home-bg.png') }}');">
                            <span class="play-badge">▶</span>
                        </div>
                        <h3>Fresh Max Campaign</h3>
                        <p>AI Brand Campaign</p>
                    </article>
                </div>
            </section>

            <section class="feedback-section" id="feedback">
                <div class="feedback-header">
                    <div class="eyebrow">Client Feedback</div>
                    <h2>What Our Clients Say</h2>
                </div>

                <div class="feedback-layout">
                    <div class="feedback-panel">
                        <div class="feedback-panel__top">
                            <div class="feedback-panel__title">
                                <span class="feedback-panel__icon" aria-hidden="true">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 4h16v11H8l-4 4V4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                Feedback List
                                <span class="feedback-panel__count">6</span>
                            </div>
                        </div>

                        <div class="feedback-table__head" aria-hidden="true">
                            <span>Client</span>
                            <span>Feedback Details</span>
                            <span>Rating</span>
                        </div>

                        <div class="feedback-table__body" id="feedbackRows">
                            <div class="feedback-row" data-search="lia pascual founder from concept to delivery">
                                <div class="feedback-row__user" data-label="Client">
                                    <span class="feedback-row__avatar">LP</span>
                                    <div class="feedback-row__user-meta">
                                        <strong>Lia Pascual</strong>
                                        <small>Founder</small>
                                    </div>
                                </div>
                                <div class="feedback-row__details" data-label="Feedback">
                                    <p>“From concept to delivery, the team made the process smooth and strategic. Our audience response doubled after launch.”</p>
                                    <span class="feedback-row__id">REV-001</span>
                                </div>
                                <div class="feedback-row__rating" data-label="Rating">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                </div>
                            </div>

                            <div class="feedback-row" data-search="anna martinez brand director aizap turned our product launch">
                                <div class="feedback-row__user" data-label="Client">
                                    <span class="feedback-row__avatar">AM</span>
                                    <div class="feedback-row__user-meta">
                                        <strong>Anna Martinez</strong>
                                        <small>Brand Director</small>
                                    </div>
                                </div>
                                <div class="feedback-row__details" data-label="Feedback">
                                    <p>“Aizap turned our product launch into a bold visual story. The campaign felt premium, fast, and incredibly on-brand.”</p>
                                    <span class="feedback-row__id">REV-002</span>
                                </div>
                                <div class="feedback-row__rating" data-label="Rating">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                </div>
                            </div>

                            <div class="feedback-row" data-search="jordan reyes marketing lead ai creative workflow">
                                <div class="feedback-row__user" data-label="Client">
                                    <span class="feedback-row__avatar">JR</span>
                                    <div class="feedback-row__user-meta">
                                        <strong>Jordan Reyes</strong>
                                        <small>Marketing Lead</small>
                                    </div>
                                </div>
                                <div class="feedback-row__details" data-label="Feedback">
                                    <p>“Their AI creative workflow gave us polished commercial visuals in days, not weeks. Every frame felt intentional and high-end.”</p>
                                    <span class="feedback-row__id">REV-003</span>
                                </div>
                                <div class="feedback-row__rating" data-label="Rating">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                </div>
                            </div>

                            <div class="feedback-row" data-search="daniel kim creative director turnaround time was unreal">
                                <div class="feedback-row__user" data-label="Client">
                                    <span class="feedback-row__avatar">DK</span>
                                    <div class="feedback-row__user-meta">
                                        <strong>Daniel Kim</strong>
                                        <small>Creative Director</small>
                                    </div>
                                </div>
                                <div class="feedback-row__details" data-label="Feedback">
                                    <p>“The turnaround time was unreal without sacrificing quality. Aizap gets the brief right on the first pass, every time.”</p>
                                    <span class="feedback-row__id">REV-004</span>
                                </div>
                                <div class="feedback-row__rating" data-label="Rating">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                </div>
                            </div>

                            <div class="feedback-row" data-search="sofia cruz growth manager tested three agencies">
                                <div class="feedback-row__user" data-label="Client">
                                    <span class="feedback-row__avatar">SC</span>
                                    <div class="feedback-row__user-meta">
                                        <strong>Sofia Cruz</strong>
                                        <small>Growth Manager</small>
                                    </div>
                                </div>
                                <div class="feedback-row__details" data-label="Feedback">
                                    <p>“We tested three agencies before Aizap. Nobody else understood our brand voice this fast or executed it this cleanly.”</p>
                                    <span class="feedback-row__id">REV-005</span>
                                </div>
                                <div class="feedback-row__rating" data-label="Rating">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                </div>
                            </div>

                            <div class="feedback-row" data-search="rico tan founder fresh max storytelling ads emotional edge">
                                <div class="feedback-row__user" data-label="Client">
                                    <span class="feedback-row__avatar">RT</span>
                                    <div class="feedback-row__user-meta">
                                        <strong>Rico Tan</strong>
                                        <small>Founder, Fresh Max</small>
                                    </div>
                                </div>
                                <div class="feedback-row__details" data-label="Feedback">
                                    <p>“Their storytelling ads gave our campaign an emotional edge competitors just don't have. Worth every peso.”</p>
                                    <span class="feedback-row__id">REV-006</span>
                                </div>
                                <div class="feedback-row__rating" data-label="Rating">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="feedback-form-wrap">
                        <div class="feedback-form-header">
                            <div class="eyebrow">Share Your Experience</div>
                            <h3>Write a Feedback</h3>
                            <p class="feedback-form-sub">Tell us what you think about working with Aizap Creatives.</p>
                        </div>

                        <form class="feedback-form" action="#" method="POST">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="fb-name">Full Name</label>
                                    <input type="text" id="fb-name" name="name" autocomplete="name" placeholder="Enter your full name" required>
                                </div>
                                <div class="form-group">
                                    <label for="fb-role">Role / Company</label>
                                    <input type="text" id="fb-role" name="role" autocomplete="organization" placeholder="Role, Company Name">
                                </div>
                            </div>

                            <div class="form-group">
                                <span class="form-group-label">Your Rating</span>
                                <div class="rating-input">
                                    <input type="radio" id="star5" name="rating" value="5" checked>
                                    <label for="star5" title="5 stars">★</label>
                                    <input type="radio" id="star4" name="rating" value="4">
                                    <label for="star4" title="4 stars">★</label>
                                    <input type="radio" id="star3" name="rating" value="3">
                                    <label for="star3" title="3 stars">★</label>
                                    <input type="radio" id="star2" name="rating" value="2">
                                    <label for="star2" title="2 stars">★</label>
                                    <input type="radio" id="star1" name="rating" value="1">
                                    <label for="star1" title="1 star">★</label>
                                </div>
                            </div>

                            <div class="form-group form-group--grow">
                                <label for="fb-message">Your Feedback</label>
                                <textarea id="fb-message" name="message" rows="4" autocomplete="off" placeholder="Share details about your experience working with us..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary feedback-submit">Submit Feedback</button>
                        </form>
                    </div>
                </div>
            </section>

        </div>
    </div>
    @include('footer.footer')
</body>
</html>