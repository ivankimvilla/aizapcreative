<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\BookingAdminController;
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
Route::post('/book-a-call', [\App\Http\Controllers\BookingController::class, 'store'])->name('book-a-call.store')->middleware('throttle:10,1');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login')->middleware('guest');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post')->middleware('guest');
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login')->middleware('guest');

Route::get('/admin/password/reset', [AdminAuthController::class, 'showLinkRequestForm'])->name('admin.password.request')->middleware('guest');
Route::post('/admin/password/email', [AdminAuthController::class, 'sendResetLinkEmail'])->name('admin.password.email')->middleware('guest');
Route::get('/admin/password/reset/{token}', [AdminAuthController::class, 'showResetForm'])->name('admin.password.reset')->middleware('guest');
Route::post('/admin/password/reset', [AdminAuthController::class, 'reset'])->name('admin.password.update')->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/change-password', [AdminAuthController::class, 'showChangePassword'])->name('admin.change-password');
    Route::post('/admin/change-password', [AdminAuthController::class, 'changePassword'])->name('admin.change-password.post');
    Route::post('/admin/change-email', [AdminAuthController::class, 'changeEmail'])->name('admin.change-email.post');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/traffic', [AdminDashboardController::class, 'traffic'])->name('admin.dashboard.traffic');
    Route::patch('/admin/notifications/{type}/{id}/read', [AdminNotificationController::class, 'markRead'])->name('admin.notifications.markRead');
    Route::post('/admin/notifications/mark-all-read', [AdminNotificationController::class, 'markAllRead'])->name('admin.notifications.markAllRead');
    Route::get('/admin/projects', [ProjectVideoController::class, 'index'])->name('admin.projects');
    Route::post('/admin/projects', [ProjectVideoController::class, 'store'])->name('admin.projects.store');
    Route::delete('/admin/projects', [ProjectVideoController::class, 'destroy'])->name('admin.projects.destroy');
    Route::get('/admin/messages', [ContactMessageController::class, 'index'])->name('admin.messages');
    Route::delete('/admin/messages', [ContactMessageController::class, 'destroy'])->name('admin.messages.destroy');
    Route::redirect('/admin/clients', '/admin/messages');
    // Bookings view removed — keep briefs route unavailable
    Route::redirect('/admin/briefs', '/admin/projects');
    Route::get('/admin/boards', [BookingAdminController::class, 'index'])->name('admin.boards');
    Route::delete('/admin/boards/bulk-delete', [BookingAdminController::class, 'bulkDestroy'])->name('admin.boards.bulk-destroy');
    Route::patch('/admin/boards/{booking}/confirm', [BookingAdminController::class, 'confirm'])->name('admin.boards.confirm');
    Route::patch('/admin/boards/{booking}/complete', [BookingAdminController::class, 'complete'])->name('admin.boards.complete');
    Route::patch('/admin/boards/{booking}/cancel', [BookingAdminController::class, 'cancel'])->name('admin.boards.cancel');
    Route::delete('/admin/boards/{booking}', [BookingAdminController::class, 'destroy'])->name('admin.boards.destroy');
});

Route::post('/feedback', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store')->middleware('throttle:10,1');
Route::post('/quote', [\App\Http\Controllers\QuoteController::class, 'store'])->name('quote.store')->middleware('throttle:10,1');

// Contact routes

Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store')->middleware('throttle:10,1');
