<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobPostController;
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

// Employer routes (dashboard + jobs)
Route::middleware(['auth'])->group(function () {
    Route::prefix('employer')->name('employer.')->group(function () {
        Route::get('/dashboard', function () {
            return view('employer.dashboard');
        })->name('dashboard');

        // reuse profile edit view but named for employer panel
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');

        // Job posts resource routes for employers
        Route::resource('jobs', JobPostController::class);

        // placeholder routes used by layout links
        Route::get('applications', function () { return view('employer.applications.index'); })->name('applications.index');
        Route::get('comments', function () { return view('employer.comments.index'); })->name('comments.index');
        Route::get('analytics', function () { return view('employer.analytics'); })->name('analytics');
        Route::get('notifications', function () { return view('employer.notifications'); })->name('notifications');
    });
});
