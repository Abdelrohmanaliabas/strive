<?php

use App\Http\Controllers\Employer\ApplicationController;
use App\Http\Controllers\Employer\CommentController;
use App\Http\Controllers\Employer\DashboardController;
use App\Http\Controllers\Employer\JobController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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

require __DIR__.'/auth.php';

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



Route::middleware(['auth', 'verified', 'role:employer'])
    ->prefix('employer')->name('employer.')->group(function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');

        Route::get('jobs', [JobController::class, 'index'])->name('jobs.index');
        Route::get('jobs/create', [JobController::class, 'create'])->name('jobs.create');
        Route::get('jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::get('jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

        Route::get('applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');

        Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
        Route::get('comments/{comment}', [CommentController::class, 'show'])->name('comments.show');
        Route::get('analytics', function () { return view('employer.analytics'); })->name('analytics');
        Route::get('notifications', function () { return view('employer.notifications'); })->name('notifications');
    });
