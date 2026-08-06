<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aizap Creative - Contact</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/pages/contact.css') }}">
    <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
</head>
<body class="contact-page">
    @include('header.header')

    <main class="contact-shell">
        <section class="contact-hero">
            <div class="contact-hero__copy">
                <div class="eyebrow"></div>
                <h1 class="contact-hero__title">We're here to<br><span>bring your vision<br>to life.</span></h1>
                <p class="contact-hero__text">
                    Have a project in mind or need more information? Send us a message and our team will get back to you as soon as possible.
                </p>

                <div class="contact-hero__badges">
                    <div class="contact-badge">
                        <span class="contact-badge__icon">
                            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        </span>
                        <span>Fast Response<br><small>We reply within 24 hours.</small></span>
                    </div>
                    <div class="contact-badge">
                        <span class="contact-badge__icon">
                            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M9 12l2 2 4-4"></path></svg>
                        </span>
                        <span>Confidential<br><small>Your ideas are safe.</small></span>
                    </div>
                </div>
            </div>

            <div class="contact-hero__visual">
                <div class="contact-hero__media" style="background-image: url('{{ asset('home-bg.png') }}');"></div>
            </div>
        </section>

        <section class="contact-main">
            <div class="contact-form-panel">
                <div class="section-heading">
                    <div class="eyebrow">Send Us a Message</div>
                </div>

                <form id="contactForm" class="form-grid" action="{{ route('contact.store') }}" method="POST">
                    @csrf

                    <label class="field">
                        <span>First name*</span>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required>
                    </label>
                    <label class="field">
                        <span>Last name*</span>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required>
                    </label>
                    <label class="field">
                        <span>Email*</span>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                    </label>
                    <label class="field field--full">
                        <span>Tell us about your inquiry*</span>
                        <textarea name="message" rows="5" required>{{ old('message') }}</textarea>
                    </label>

                    <div class="field field--full field--recaptcha">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}" data-action="LOGIN" data-callback="onRecaptchaSuccess" data-expired-callback="onRecaptchaExpired"></div>
                        @error('g-recaptcha-response')
                            <div class="recaptcha-error" role="alert">
                                <strong>reCAPTCHA required</strong>
                                <span>Please complete the reCAPTCHA<br>before sending your message.</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-footer">
                        <div class="form-footer__left">
                            @if ($errors->any())
                                <div class="form-alert form-alert--error" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <p class="contact-note">
                                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                We respect your privacy. Your information will never be shared.
                            </p>
                        </div>

                        <button class="contact-submit" type="submit">
                            Send Message
                            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="contact-info-panel">
                <div class="section-heading">
                    <div class="eyebrow">Get in Touch</div>
                </div>

                <div class="contact-info-body">
                    <div class="contact-info-list">
                        <div class="contact-info-item">
                            <span class="contact-info-icon">
                                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="M2 6l10 7 10-7"></path></svg>
                            </span>
                            <div>
                                <div class="contact-info-label">Email Us</div>
                                <div class="contact-info-value">hello@aicreatives.com</div>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <span class="contact-info-icon">
                                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.68 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.32 1.85.55 2.81.68A2 2 0 0 1 22 16.92z"></path></svg>
                            </span>
                            <div>
                                <div class="contact-info-label">Call Us</div>
                                <div class="contact-info-value">+1 (929) 123-4567</div>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <span class="contact-info-icon">
                                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                            </span>
                            <div>
                                <div class="contact-info-label">Location</div>
                                <div class="contact-info-value">Remote Worldwide</div>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <span class="contact-info-icon">
                                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </span>
                            <div>
                                <div class="contact-info-label">Business Hours</div>
                                <div class="contact-info-value">Mon – Fri<br>9:00 AM – 6:00 PM (EST)</div>
                            </div>
                        </div>
                    </div>

                    <div class="contact-info-map">
                        <iframe
                            src="https://www.google.com/maps?q=7.0480456,125.5047614&z=17&output=embed"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Location Map">
                        </iframe>
                    </div>
                </div>

                <div class="contact-callout">
                    <div class="contact-callout__text">
                        <span>Let's Create Something Extraordinary Together.</span>
                    </div>
                    <span class="contact-callout__icon">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M8 12l2 2 4-4"/></svg>
                    </span>
                </div>
            </div>
        </section>

        <section class="contact-footer-cta">
            <div class="contact-footer-cta__left">
                <span class="contact-footer-cta__icon">
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path></svg>
                </span>
                <div>
                    <h3>Ready to Start Your Project?</h3>
                    <p>We're excited to learn about your goals and explore how Aizap Creatives can help you achieve them.</p>
                </div>
            </div>
        </section>
    </main>
    @include('footer.footer')
    <script src="{{ asset('js/pages/contact.js') }}"></script>
</body>
</html>