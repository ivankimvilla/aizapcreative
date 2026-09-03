<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns json for ajax feedback submissions', function () {
    $response = $this->withHeaders([
        'Accept' => 'application/json',
        'X-Requested-With' => 'XMLHttpRequest',
    ])->post('/feedback', [
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'rating' => 5,
        'message' => 'Excellent work and a smooth experience.',
    ]);

    $response->assertStatus(201)
        ->assertJsonPath('feedback.name', 'Jane Doe')
        ->assertJsonPath('feedback.rating', 5)
        ->assertJsonPath('feedback.message', 'Excellent work and a smooth experience.');
});
