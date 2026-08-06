<?php

it('renders the reCAPTCHA widget on the contact page', function () {
    $response = $this->get('/contact');

    $response->assertOk();
    $response->assertSee('https://www.google.com/recaptcha/enterprise.js', false);
    $response->assertSee('name="g-recaptcha-response"', false);
    $response->assertSee('data-sitekey="6LeoNnctAAAAAKR5jGB0E8YWYZe7eJWvC9iIQpxc"', false);
});
