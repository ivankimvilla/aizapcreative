<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('records a public visit and shows it on the admin dashboard', function () {
    $this->get('/');
    $this->get('/contact');
    $this->get('/about-us');
    $this->get('/contact');

    $this->assertDatabaseHas('site_visits', [
        'url' => '/',
    ]);

    $dashboard = $this->get('/admin/dashboard');

    $dashboard->assertStatus(200);
    $dashboard->assertSee('Visitor activity');
    $dashboard->assertSee('Daily traffic');
    $dashboard->assertSee('/contact');
    $dashboard->assertSee('/about-us');
});
