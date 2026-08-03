<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aizap Creatives - Book a Call</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/booking-calendar/booking-calendar.css') }}">
</head>
<body class="booking-page">
    @include('header.header')

    <main class="booking-shell">

        <section id="booking" class="booking-widget">
            <div class="booking-widget__card">

                <aside class="booking-widget__sidebar">
                    <div class="booking-widget__brand">
                        <div class="booking-widget__logo">AC</div>
                        <span>Aizap Creatives</span>
                    </div>

                    <h2 class="booking-widget__title">Aizap Creative Strategy Session</h2>

                    <div class="booking-widget__meta">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="M12 7v5l3 3"></path>
                        </svg>
                        30 minutes
                    </div>

                    <p class="booking-widget__desc">
                        Schedule a free discovery call with us to talk through your project and how Aizap Creatives can help bring it to life.
                    </p>
                </aside>

                <div class="booking-widget__calendar">
                    <div class="calendar-toprow">
                        <button type="button" class="calendar-tz">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M2 12h20M12 2a15 15 0 0 1 0 20a15 15 0 0 1 0-20"></path>
                            </svg>
                            (+08:00) PST - Manila
                            <svg class="calendar-tz__chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 9l6 6l6-6"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="calendar-header">
                        <button type="button" class="calendar-nav">‹</button>
                        <div class="calendar-month">August</div>
                        <button type="button" class="calendar-nav">›</button>
                    </div>

                    <div class="calendar-days">
                        <span>Sun</span>
                        <span>Mon</span>
                        <span>Tue</span>
                        <span>Wed</span>
                        <span>Thu</span>
                        <span>Fri</span>
                        <span>Sat</span>
                    </div>

                    <div class="calendar-grid">
                        <button type="button" class="calendar-day calendar-day--disabled">26</button>
                        <button type="button" class="calendar-day calendar-day--disabled">27</button>
                        <button type="button" class="calendar-day calendar-day--disabled">28</button>
                        <button type="button" class="calendar-day calendar-day--disabled">29</button>
                        <button type="button" class="calendar-day calendar-day--disabled">30</button>
                        <button type="button" class="calendar-day calendar-day--disabled">31</button>
                        <button type="button" class="calendar-day">1</button>

                        <button type="button" class="calendar-day">2</button>
                        <button type="button" class="calendar-day calendar-day--active">3</button>
                        <button type="button" class="calendar-day">4</button>
                        <button type="button" class="calendar-day">5</button>
                        <button type="button" class="calendar-day">6</button>
                        <button type="button" class="calendar-day">7</button>
                        <button type="button" class="calendar-day">8</button>

                        <button type="button" class="calendar-day">9</button>
                        <button type="button" class="calendar-day">10</button>
                        <button type="button" class="calendar-day">11</button>
                        <button type="button" class="calendar-day">12</button>
                        <button type="button" class="calendar-day">13</button>
                        <button type="button" class="calendar-day">14</button>
                        <button type="button" class="calendar-day">15</button>

                        <button type="button" class="calendar-day">16</button>
                        <button type="button" class="calendar-day">17</button>
                        <button type="button" class="calendar-day">18</button>
                        <button type="button" class="calendar-day">19</button>
                        <button type="button" class="calendar-day">20</button>
                        <button type="button" class="calendar-day">21</button>
                        <button type="button" class="calendar-day">22</button>

                        <button type="button" class="calendar-day">23</button>
                        <button type="button" class="calendar-day">24</button>
                        <button type="button" class="calendar-day">25</button>
                        <button type="button" class="calendar-day">26</button>
                        <button type="button" class="calendar-day">27</button>
                        <button type="button" class="calendar-day">28</button>
                        <button type="button" class="calendar-day">29</button>

                        <button type="button" class="calendar-day">30</button>
                        <button type="button" class="calendar-day">31</button>
                        <button type="button" class="calendar-day calendar-day--disabled">1</button>
                        <button type="button" class="calendar-day calendar-day--disabled">2</button>
                        <button type="button" class="calendar-day calendar-day--disabled">3</button>
                        <button type="button" class="calendar-day calendar-day--disabled">4</button>
                        <button type="button" class="calendar-day calendar-day--disabled">5</button>
                    </div>
                </div>

                <div class="booking-widget__times">
                    <div class="times-date">Monday, August 3</div>
                    <div class="times-list">
                        <button type="button" class="time-slot time-slot--active">12:30 PM</button>
                        <button type="button" class="time-slot">1:00 PM</button>
                        <button type="button" class="time-slot">1:30 PM</button>
                        <button type="button" class="time-slot">2:00 PM</button>
                        <button type="button" class="time-slot">2:30 PM</button>
                        <button type="button" class="time-slot">3:00 PM</button>
                        <button type="button" class="time-slot">3:30 PM</button>
                        <button type="button" class="time-slot">4:00 PM</button>
                        <button type="button" class="time-slot">4:30 PM</button>
                        <button type="button" class="time-slot">5:00 PM</button>
                        <button type="button" class="time-slot">5:30 PM</button>
                        <button type="button" class="time-slot">6:00 PM</button>
                        <button type="button" class="time-slot">6:30 PM</button>
                        <button type="button" class="time-slot">7:00 PM</button>
                        <button type="button" class="time-slot">7:30 PM</button>
                        <button type="button" class="time-slot">8:00 PM</button>
                        <button type="button" class="time-slot">8:30 PM</button>
                        <button type="button" class="time-slot">9:00 PM</button>
                        <button type="button" class="time-slot">9:30 PM</button>
                        <button type="button" class="time-slot">10:00 PM</button>
                        <button type="button" class="time-slot">10:30 PM</button>
                    </div>
                </div>

            </div>
        </section>

        <section class="booking-form-section">
            <div class="section-heading">
                <div class="eyebrow">Confirm your call</div>
                <h2>Reservation details</h2>
            </div>

            <form class="booking-form" action="#" method="POST">
                <label class="field">
                    <span>Your Name</span>
                    <input type="text" name="name" placeholder="Your full name" required>
                </label>

                <label class="field">
                    <span>Your Email</span>
                    <input type="email" name="email" placeholder="you@example.com" required>
                </label>

                <label class="field">
                    <span>Company / Brand</span>
                    <input type="text" name="company" placeholder="Company or brand name">
                </label>

                <label class="field">
                    <span>Phone Number</span>
                    <input type="tel" name="phone" placeholder="+1 (555) 123-4567">
                </label>

                <label class="field field--full">
                    <span>Selected service</span>
                    <select name="service">
                        <option>AI Commercial Ads</option>
                        <option>AI Product Ads</option>
                        <option>AI Storytelling / Drama</option>
                        <option>AI Movie Trailers</option>
                        <option>UGC-style AI Videos</option>
                        <option>Explainer Videos</option>
                    </select>
                </label>

                <label class="field field--full">
                    <span>Tell us about your project</span>
                    <textarea name="message" rows="5" placeholder="Share a brief overview of your goals..."></textarea>
                </label>

                <button type="submit" class="booking-submit">Book Call</button>
            </form>

            <p class="booking-note">Once submitted, you will receive an email confirmation and a calendar invite for your selected time slot.</p>
        </section>

    </main>

    @include('footer.footer')
</body>
</html>