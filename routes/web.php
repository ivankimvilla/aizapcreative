<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProjectVideoController;
use App\Models\Feedback;
use App\Models\ProjectVideo;
use Illuminate\Support\Facades\Route;

$servicePage = function (string $category, string $view) {
    return function () use ($category, $view) {
        $videos = ProjectVideo::query()
            ->where(function ($query) use ($category) {
                $query->where('feature_category', $category)
                    ->orWhere('category', $category);
            })
            ->latest()
            ->get();

        return view($view, compact('videos'));
    };
};

Route::get('/', function () {
    $featuredProjects = ProjectVideo::where('is_featured', true)->latest()->take(5)->get();
    $feedbackItems = Feedback::latest()->get();
    $feedbackCount = Feedback::count();
    $feedbackAverage = Feedback::avg('rating');

    return view('home-page', compact('featuredProjects', 'feedbackItems', 'feedbackCount', 'feedbackAverage'));
})->name('home');

Route::get('/about-us', function () {
    return view('pages.about-us');
});

Route::get('/services', function () {
    return redirect('/');
});

Route::get('/services/commercial-ads', $servicePage('ai-commercial-ads', 'services.commercial-ads'));
Route::get('/what-we-do/ai-commercial-ads', $servicePage('ai-commercial-ads', 'services.commercial-ads'));

Route::get('/services/product-ads', $servicePage('ai-product-ads', 'services.product-ads'));
Route::get('/what-we-do/ai-product-ads', $servicePage('ai-product-ads', 'services.product-ads'));

Route::get('/services/storytelling-drama', $servicePage('ai-storytelling-drama', 'services.storytelling-drama'));
Route::get('/what-we-do/ai-storytelling-drama', $servicePage('ai-storytelling-drama', 'services.storytelling-drama'));

Route::get('/services/movie-trailers', $servicePage('ai-movie-trailers', 'services.movie-trailer'));
Route::get('/what-we-do/ai-movie-trailers', $servicePage('ai-movie-trailers', 'services.movie-trailer'));

Route::get('/services/ugc-style-ai-videos', $servicePage('ugc-style-ai-videos', 'services.ugc-style-videos'));
Route::get('/what-we-do/ugc-style-ai-videos', $servicePage('ugc-style-ai-videos', 'services.ugc-style-videos'));

Route::get('/services/explainer-videos', $servicePage('explainer-videos', 'services.explainer-videos'));
Route::get('/what-we-do/explainer-videos', $servicePage('explainer-videos', 'services.explainer-videos'));

Route::get('/portfolio', function () {
    $videos = ProjectVideo::latest()->get();

    return view('pages.portfolio', compact('videos'));
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

Route::get('/book-a-call', [\App\Http\Controllers\BookingController::class, 'index'])->name('book-a-call');
Route::get('/book-a-call/availability', [\App\Http\Controllers\BookingController::class, 'availability'])->name('book-a-call.availability');
Route::post('/book-a-call', [\App\Http\Controllers\BookingController::class, 'store'])->name('book-a-call.store');

Route::view('/admin/login', 'admin.login')->name('admin.login');
Route::view('/admin/reset-password', 'admin.reset-password')->name('admin.reset-password');
Route::view('/admin/change-password', 'admin.change-password')->name('admin.change-password');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/projects', [ProjectVideoController::class, 'index'])->name('admin.projects');
Route::post('/admin/projects', [ProjectVideoController::class, 'store'])->name('admin.projects.store');
Route::delete('/admin/projects', [ProjectVideoController::class, 'destroy'])->name('admin.projects.destroy');
Route::post('/feedback', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');

// Contact routes

Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store')->middleware('throttle:10,1');
Route::get('/admin/messages', [ContactMessageController::class, 'index'])->name('admin.messages');
Route::redirect('/admin/clients', '/admin/messages');
// Bookings view removed — keep briefs route unavailable
Route::redirect('/admin/briefs', '/admin/projects');
Route::view('/admin/boards', 'admin.pages.bookings')->name('admin.boards');
Route::view('/admin/change-password', 'admin.change-password')->name('admin.change-password');