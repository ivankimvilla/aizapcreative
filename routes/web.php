<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home-page');
});

Route::get('/about-us', function () {
    return view('pages.about-us');
});

Route::get('/services', function () {
    return redirect('/');
});

Route::get('/services/commercial-ads', function () {
    return view('services.commercial-ads');
});
Route::get('/what-we-do/ai-commercial-ads', function () {
    return view('services.commercial-ads');
});

Route::get('/services/product-ads', function () {
    return view('services.product-ads');
});
Route::get('/what-we-do/ai-product-ads', function () {
    return view('services.product-ads');
});

Route::get('/services/storytelling-drama', function () {
    return view('services.storytelling-drama');
});
Route::get('/what-we-do/ai-storytelling-drama', function () {
    return view('services.storytelling-drama');
});

Route::get('/services/movie-trailers', function () {
    return view('services.movie-trailer');
});
Route::get('/what-we-do/ai-movie-trailers', function () {
    return view('services.movie-trailer');
});

Route::get('/services/ugc-style-ai-videos', function () {
    return view('services.ugc-style-videos');
});
Route::get('/what-we-do/ugc-style-ai-videos', function () {
    return view('services.ugc-style-videos');
});

Route::get('/services/explainer-videos', function () {
    return view('services.explainer-videos');
});
Route::get('/what-we-do/explainer-videos', function () {
    return view('services.explainer-videos');
});

Route::get('/portfolio', function () {
    return view('pages.portfolio');
});

Route::get('/process', function () {
    return view('pages.process');
});

Route::get('/pricing', function () {
    return view('pages.pricing');
});

Route::get('/contact', function () {
    return view('pages.contact');
});

Route::get('/book-a-call', function () {
    return view('booking-calendar.booking-calendar');
});

Route::view('/admin/login', 'admin.login')->name('admin.login');
Route::view('/admin/reset-password', 'admin.reset-password')->name('admin.reset-password');
Route::view('/admin/change-password', 'admin.change-password')->name('admin.change-password');
Route::view('/admin/dashboard', 'admin.admin-dashboard.admin-dashboard')->name('admin.dashboard');
Route::view('/admin/projects', 'admin.pages.projects')->name('admin.projects');
Route::view('/admin/messages', 'admin.pages.messages')->name('admin.messages');
Route::redirect('/admin/clients', '/admin/messages');
// Bookings view removed — keep briefs route unavailable
Route::redirect('/admin/briefs', '/admin/projects');
Route::view('/admin/boards', 'admin.pages.bookings')->name('admin.boards');
Route::view('/admin/change-password', 'admin.change-password')->name('admin.change-password');