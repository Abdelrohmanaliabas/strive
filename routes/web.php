<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\CategoryListingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Employer\ApplicationEmployerController;
use App\Http\Controllers\Employer\CommentEmployerController;
use App\Http\Controllers\Employer\DashboardController;
use App\Http\Controllers\Employer\JobEmployerController;
use App\Http\Controllers\Employer\ProfileController as EmployerProfileController;
use App\Http\Controllers\EmployerListingController;
use App\Http\Controllers\EmployerProfileController as PublicEmployerProfileController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCommentController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialLiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// ================= Public pages ===================
Route::get('/', [JobListingController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{jobPost}', [JobListingController::class, 'show'])->name('jobs.show');
Route::get('/companies/{employer}', [PublicEmployerProfileController::class, 'show'])->name('companies.show');
Route::get('/categories', [CategoryListingController::class, 'index'])->name('public_categories.index');
Route::get('/employers', [EmployerListingController::class, 'index'])->name('public_employers.index');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactStore'])->name('contact.store');

// ================= Authenticated general features ===================
Route::middleware('auth')->group(function () {
    Route::post('/comments', [JobCommentController::class, 'store'])->name('comments.store');
    Route::post('/applications', [JobApplicationController::class, 'store'])->name('applications.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notification routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/page', function () {
            return view('notifications.index');
        })->name('page');
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/count', [NotificationController::class, 'count'])->name('count');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
    });
});

// ================= Social auth ===================
Route::prefix('auth/linkedin')
    ->name('auth.linkedin.')
    ->controller(SocialLiteController::class)
    ->group(function () {
        Route::get('/redirect', 'redirect')->name('redirect');
        Route::get('/callback', 'callback')->name('callback');
    });

// ================= Admin ===================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::view('/settings', 'admin.settings.index')->name('settings.index');

        Route::controller(UserController::class)
            ->prefix('users')
            ->name('users.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{user}', 'show')->name('show');
                Route::get('/{user}/edit', 'edit')->name('edit');
                Route::put('/{user}', 'update')->name('update');
                Route::delete('/{user}', 'destroy')->name('destroy');
            });

        Route::controller(JobPostController::class)
            ->prefix('posts')
            ->name('jobpost.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{post}', 'show')->name('show');
                Route::get('/{post}/edit', 'edit')->name('edit');
                Route::put('/{post}', 'update')->name('update');
                Route::delete('/{post}', 'destroy')->name('destroy');
            });

        Route::controller(CommentController::class)
            ->prefix('comments')
            ->name('comments.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{comment}', 'show')->name('show');
                Route::delete('/{comment}', 'destroy')->name('destroy');
            });

        Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications');
        Route::get('/analytics', [AnalyticController::class, 'index'])->name('analytics.index');
    });

// ================= Employer ===================
Route::middleware(['auth', 'role:employer'])
    ->prefix('employer')
    ->name('employer.')
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [EmployerProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [EmployerProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [EmployerProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('jobs', [JobEmployerController::class, 'index'])->name('jobs.index');
        Route::get('jobs/create', [JobEmployerController::class, 'create'])->name('jobs.create');
        Route::get('jobs/{job}/edit', [JobEmployerController::class, 'edit'])->name('jobs.edit');
        Route::get('jobs/{job}', [JobEmployerController::class, 'show'])->name('jobs.show');
        Route::post('jobs', [JobEmployerController::class, 'store'])->name('jobs.store');
        Route::put('jobs/{job}', [JobEmployerController::class, 'update'])->name('jobs.update');
        Route::delete('jobs/{job}', [JobEmployerController::class, 'destroy'])->name('jobs.destroy');

        Route::get('applications', [ApplicationEmployerController::class, 'index'])->name('applications.index');
        Route::get('applications/{application}', [ApplicationEmployerController::class, 'show'])->name('applications.show');
        Route::patch('applications/{application}/status', [ApplicationEmployerController::class, 'updateStatus'])->name('applications.update-status');
        Route::get('/applications/{application}/download', [ApplicationEmployerController::class, 'download'])->name('applications.download');
        Route::get('applications/{application}/preview', [ApplicationEmployerController::class, 'preview'])->name('applications.preview');

        Route::get('comments', [CommentEmployerController::class, 'index'])->name('comments.index');
        Route::get('comments/{comment}', [CommentEmployerController::class, 'show'])->name('comments.show');
        Route::get('jobs/{job}/comments', [CommentEmployerController::class, 'forJob'])->name('jobs.comments');
        Route::get('candidates/{user}', [CommentEmployerController::class, 'showUser'])->name('candidates.show');

        Route::view('analytics', 'employer.analytics')->name('analytics');
        Route::view('notifications', 'employer.notifications')->name('notifications');
    });

require __DIR__ . '/auth.php';
