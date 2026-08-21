<?php

use App\Models\ProjectVideo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('stores featured projects and shows them on the homepage', function () {
    $this->actingAs(User::factory()->create());

    $coverPath = tempnam(sys_get_temp_dir(), 'cover');
    file_put_contents($coverPath, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAACklEQVR4nGMAAQABAAoABQABHoh1AAAAAElFTkSuQmCC'));

    $response = $this->post('/admin/projects', [
        'title' => 'Summer Campaign Teaser',
        'client' => 'Nova Retail',
        'category' => 'ai-commercial-ads',
        'feature_category' => 'ai-commercial-ads',
        'is_featured' => true,
        'cover_image' => new UploadedFile($coverPath, 'cover.png', 'image/png', null, true),
    ]);

    $response->assertRedirect(route('admin.projects'));

    $this->assertDatabaseHas('project_videos', [
        'title' => 'Summer Campaign Teaser',
        'client' => 'Nova Retail',
        'category' => 'ai-commercial-ads',
        'feature_category' => 'ai-commercial-ads',
        'is_featured' => true,
    ]);

    $homepage = $this->get('/');

    $homepage->assertStatus(200);
    $homepage->assertSee('Summer Campaign Teaser');
    $homepage->assertSee('Nova Retail');
});

it('allows uploading a project video without a cover image', function () {
    $this->actingAs(User::factory()->create());

    $response = $this->post('/admin/projects', [
        'title' => 'No Cover Video',
        'client' => 'Blue Canvas',
        'category' => 'explainer-videos',
        'feature_category' => 'explainer-videos',
        'cover_image' => null,
    ]);

    $response->assertRedirect(route('admin.projects'));

    $this->assertDatabaseHas('project_videos', [
        'title' => 'No Cover Video',
        'client' => 'Blue Canvas',
        'category' => 'explainer-videos',
        'feature_category' => 'explainer-videos',
        'cover_path' => null,
    ]);
});

it('uses the configured storage disk for project media URLs so deployment-safe storage can be used', function () {
    config(['filesystems.default' => 'public']);

    $video = ProjectVideo::make([
        'title' => 'Cloud Video',
        'client' => 'Cloud Studio',
        'category' => 'explainer-videos',
        'feature_category' => 'explainer-videos',
        'video_path' => 'project-videos/demo.mp4',
        'cover_path' => 'project-covers/demo.jpg',
    ]);

    expect($video->video_url)->toBe(Storage::disk('public')->url('project-videos/demo.mp4'));
    expect($video->cover_url)->toBe(Storage::disk('public')->url('project-covers/demo.jpg'));
});

it('returns JSON for ajax video uploads so the admin grid can update immediately', function () {
    $this->actingAs(User::factory()->create());

    $response = $this->withHeaders([
        'X-Requested-With' => 'XMLHttpRequest',
    ])->post('/admin/projects', [
        'title' => 'Ajax Upload Video',
        'client' => 'Quick Studio',
        'category' => 'ugc-style-ai-videos',
        'feature_category' => 'ugc-style-ai-videos',
    ]);

    $response->assertOk();
    $response->assertJsonPath('title', 'Ajax Upload Video');
    $response->assertJsonPath('client', 'Quick Studio');
    $this->assertDatabaseHas('project_videos', [
        'title' => 'Ajax Upload Video',
        'client' => 'Quick Studio',
        'category' => 'ugc-style-ai-videos',
    ]);
});

it('does not mark a project as featured unless the featured checkbox is checked', function () {
    $this->actingAs(User::factory()->create());

    $response = $this->post('/admin/projects', [
        'title' => 'Regular Category Video',
        'client' => 'Local Studio',
        'category' => 'explainer-videos',
        'feature_category' => 'explainer-videos',
        'is_featured' => 0,
    ]);

    $response->assertRedirect(route('admin.projects'));

    $this->assertDatabaseHas('project_videos', [
        'title' => 'Regular Category Video',
        'client' => 'Local Studio',
        'category' => 'explainer-videos',
        'feature_category' => 'explainer-videos',
        'is_featured' => false,
    ]);

    $homepage = $this->get('/');
    $homepage->assertDontSee('Regular Category Video');
});

it('shows only featured videos on the matching service page for that category', function () {
    ProjectVideo::create([
        'title' => 'Commercial Spot',
        'client' => 'Bright Labs',
        'category' => 'ai-commercial-ads',
        'feature_category' => 'ai-commercial-ads',
        'is_featured' => true,
        'video_path' => null,
        'cover_path' => null,
    ]);

    ProjectVideo::create([
        'title' => 'Hidden Internal Video',
        'client' => 'Silent Studio',
        'category' => 'ai-commercial-ads',
        'feature_category' => 'ai-commercial-ads',
        'is_featured' => false,
        'video_path' => null,
        'cover_path' => null,
    ]);

    $response = $this->get('/what-we-do/ai-commercial-ads');

    $response->assertStatus(200);
    $response->assertSee('Commercial Spot');
    $response->assertSee('Bright Labs');
    $response->assertDontSee('Hidden Internal Video');
});

it('renders a video player for portfolio items when a video is available', function () {
    ProjectVideo::create([
        'title' => 'Portfolio Reel',
        'client' => 'North Studio',
        'category' => 'explainer-videos',
        'feature_category' => 'explainer-videos',
        'is_featured' => true,
        'video_path' => 'project-videos/demo.mp4',
        'cover_path' => null,
    ]);

    $response = $this->get('/portfolio');

    $response->assertStatus(200);
    $response->assertSee('Portfolio Reel');
    $response->assertSee('<video', false);
});
