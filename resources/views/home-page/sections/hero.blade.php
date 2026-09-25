<section class="hero-section" id="services">
    <video class="hero-video" autoplay muted loop playsinline poster="{{ asset('home-bg.mp4') }}">
        <source src="{{ asset('home-bg.mp4') }}" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-copy" data-reveal="up" data-reveal-repeat>
        <h1 class="hero-title">
            <span class="gold">AIZAP</span> CREATIVES<br>
            That <span class="gold">Builds Brands.</span>
        </h1>
        <p class="hero-sub">
            We create high-quality AI-generated videos, ads, and creative content that helps brands stand out, connect, and grow in the digital world.
        </p>
        <div class="hero-cta-group">
            <a href="{{ url('/portfolio') }}" class="btn btn-primary">View Our Work</a>
            <a href="{{ url('/contact') }}" class="btn btn-secondary">Book a Call</a>
        </div>
    </div>
</section>