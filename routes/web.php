<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\CategoryListingController;
use App\Http\Controllers\EmployerListingController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCommentController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\Employer\ApplicationController;
use App\Http\Controllers\Employer\ApplicationEmployerController;
use App\Http\Controllers\Employer\CommentEmployerController;
use App\Http\Controllers\Employer\DashboardController;
use App\Http\Controllers\Employer\JobController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Employer\JobEmployerController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [JobListingController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{jobPost}', [JobListingController::class, 'show'])->name('jobs.show');
// Route::post('/comments', [JobCommentController::class, 'store'])->name('comments.store');
Route::post('/comments', [JobCommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');
// Route::post('/applications', [JobApplicationController::class, 'store'])->name('applications.store');
Route::post('/applications', [JobApplicationController::class, 'store'])
    ->middleware('auth')
    ->name('applications.store');

// Optional: route for employers to create job posts (protected)
// Route::middleware(['auth'])->group(function () {
//     Route::resource('jobs', JobPostController::class)->except(['index','show']);
// });



Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::view('/admin/analytics', 'admin.analytics.index')->name('admin.analytics.index');
Route::view('/admin/comments', 'admin.comments.index')->name('admin.comments.index');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Route::view('/admin/users', 'admin.users.index')->name('admin.users.index');
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
Route::get('/admin/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

// ================= Public pages ===================
use App\Http\Controllers\EmployerProfileController;

Route::get('/companies/{employer}', [EmployerProfileController::class, 'show'])
    ->name('companies.show');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/categories', [CategoryListingController::class, 'index'])->name('public_categories.index');
Route::get('/employers', [EmployerListingController::class, 'index'])->name('public_employers.index');

// =================================================================
require __DIR__ . '/auth.php';

Route::get('/admin/posts', [JobPostController::class, 'index'])->name('admin.jobpost.index');
Route::get('/admin/posts/{post}', [JobPostController::class, 'show'])->name('admin.jobpost.show');
Route::get('/admin/posts/{post}/edit', [JobPostController::class, 'edit'])->name('admin.jobpost.edit');
Route::put('/admin/posts/{post}', [JobPostController::class, 'update'])->name('admin.jobpost.update');
Route::delete('/admin/posts/{post}', [JobPostController::class, 'destroy'])->name('admin.jobpost.destroy');

Route::get('/admin/analytics', [AnalyticController::class, 'index'])->name('admin.analytics.index');
Route::get('/admin/comments', [CommentController::class, 'index'])->name('admin.comments.index');
Route::get('/admin/comments/{comment}', [CommentController::class, 'show'])->name('admin.comments.show');
Route::delete('/admin/comments/{comment}', [CommentController::class, 'destroy'])->name('admin.comments.destroy');
Route::view('/admin/settings', 'admin.settings.index')->name('admin.settings.index');



Route::middleware(['auth', 'role:employer'])
    ->prefix('employer')->name('employer.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [App\Http\Controllers\Employer\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [App\Http\Controllers\Employer\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [App\Http\Controllers\Employer\ProfileController::class, 'destroy'])->name('profile.destroy');
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
        Route::get('comments', [CommentEmployerController::class, 'index'])->name('comments.index');
        Route::get('comments/{comment}', [CommentEmployerController::class, 'show'])->name('comments.show');
        Route::get('analytics', function () {
            return view('employer.analytics');
        })->name('analytics');
        Route::get('notifications', function () {
            return view('employer.notifications');
        })->name('notifications');

        Route::get('/applications/{application}/download', [ApplicationEmployerController::class, 'download'])
            ->name('applications.download');
    });
