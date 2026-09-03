<?php

it('uses full-page navigation for the primary site links so page CSS is loaded correctly', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('data-no-ajax', false);
    $response->assertSee('Home', false);
    $response->assertSee('About Us', false);
    $response->assertSee('Services', false);
    $response->assertSee('Portfolio', false);
    $response->assertSee('Pricing', false);
    $response->assertSee('Contact', false);
});
