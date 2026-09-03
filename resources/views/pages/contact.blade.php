<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aizap Creative - Contact</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/pages/contact.css') }}">
</head>
<body class="contact-page">
    @include('header.header')

    <main id="app-content">
        <div class="contact-shell">
        <section class="contact-hero">

            <div class="contact-hero__left">
                <div class="contact-info-block">
                    <div class="eyebrow">Get In Touch</div>
                    <p class="contact-info-block__text">
                        We're here to help and answer any question you might have.
                    </p>

                    <div class="contact-info-list">
                        <div class="contact-info-item">
                            <span class="contact-info-icon">
                                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="M2 6l10 7 10-7"></path></svg>
                            </span>
                            <div>
                                <div class="contact-info-label">Email Us</div>
                                <div class="contact-info-value">aizapcreatives@gmail.com</div>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <span class="contact-info-icon">
                                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.68 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.32 1.85.55 2.81.68A2 2 0 0 1 22 16.92z"></path></svg>
                            </span>
                            <div>
                                <div class="contact-info-label">Call Us</div>
                                <div class="contact-info-value">+63 (953) 578-6765</div>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <span class="contact-info-icon">
                                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            </span>
                            <div>
                                <div class="contact-info-label">Location</div>
                                <div class="contact-info-value">Davao City, Philippines</div>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <span class="contact-info-icon">
                                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </span>
                            <div>
                                <div class="contact-info-label">Business Hours</div>
                                <div class="contact-info-value">Mon – Fri<br>9:00 AM – 6:00 PM (PHT)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-hero__right">
                <div class="eyebrow">Contact Us</div>
                <h1 class="contact-hero__title">Let's Create<br>Something <span>Amazing.</span></h1>
                <p class="contact-hero__text">
                    Have a project in mind or want to collaborate? We'd love to hear from you.
                </p>

                <form id="contactForm" class="contact-form" action="{{ route('contact.store') }}" method="POST">
                    @csrf

                    <div class="form-grid">
                        <label class="field field--icon">
                            <svg class="field__icon" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First name" required>
                        </label>
                        <label class="field field--icon">
                            <svg class="field__icon" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last name" required>
                        </label>
                        <label class="field field--icon field--full">
                            <svg class="field__icon" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="M2 6l10 7 10-7"></path></svg>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                        </label>
                        <label class="field field--icon field--full field--textarea">
                            <svg class="field__icon" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            <textarea name="message" rows="3" placeholder="Your message" required>{{ old('message') }}</textarea>
                        </label>

                        <div class="field field--full field--recaptcha">
                            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" data-sitekey="{{ config('services.recaptcha.site_key') }}">
                        </div>
                    </div>

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

                    <button class="contact-submit" type="submit">
                        Send Message
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    </button>

                    <p class="contact-note">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        Your information is safe with us. We respect your privacy.
                    </p>
                </form>
            </div>

        </section>
        </div>
    </main>
    @include('footer.footer')
    <script src="{{ asset('js/pages/contact.js') }}"></script>
</body>
</html>