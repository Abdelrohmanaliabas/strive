<?php

use App\Http\Controllers\Employer\ApplicationController;
use App\Http\Controllers\Employer\CommentController;
use App\Http\Controllers\Employer\DashboardController;
use App\Http\Controllers\Employer\JobController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified', 'role:employer'])
    ->prefix('employer')
    ->name('employer.')
    ->group(function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');

        Route::get('jobs', [JobController::class, 'index'])->name('jobs.index');
        Route::get('jobs/create', [JobController::class, 'create'])->name('jobs.create');
        Route::get('jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::get('jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

        Route::get('applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');

        Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
        Route::get('comments/{comment}', [CommentController::class, 'show'])->name('comments.show');
    });
