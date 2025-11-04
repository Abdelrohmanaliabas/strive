<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::view('/admin/users', 'admin.users.index')->name('admin.users.index');
Route::view('/admin/analytics', 'admin.analytics.index')->name('admin.analytics.index');
Route::view('/admin/comments', 'admin.comments.index')->name('admin.comments.index');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
