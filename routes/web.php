<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ── Public routes ─────────────────────────────────────────────────────────────
Route::get('/',                [HomeController::class, 'index'])->name('home');
Route::get('/courses',         [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}',  [CourseController::class, 'show'])->name('courses.show');

// ── Authenticated routes ──────────────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/courses/{course}/learn',           [LessonController::class, 'show'])->name('learn');
    Route::get('/courses/{course}/learn/{lesson}',  [LessonController::class, 'show'])->name('learn.lesson');

    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
