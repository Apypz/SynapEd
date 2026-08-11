<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ── Public routes ─────────────────────────────────────────────────────────────
Route::get('/',                [HomeController::class, 'index'])->name('home');
Route::get('/courses',         [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}',  [CourseController::class, 'show'])->name('courses.show');

// ── Authenticated routes ──────────────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard');

    // Course & Lesson Learning
    Route::get('/courses/{course}/learn',           [LessonController::class, 'show'])->name('learn');
    Route::get('/courses/{course}/learn/{lesson}',  [LessonController::class, 'show'])->name('learn.lesson');
    Route::post('/courses/{course}/lessons/{lesson}/complete', [LessonController::class, 'markComplete'])->name('lessons.complete');

    // Course CRUD (Educator & Admin)
    Route::post('/courses',               [CourseController::class, 'store'])->name('courses.store');
    Route::put('/courses/{course}',       [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}',    [CourseController::class, 'destroy'])->name('courses.destroy');

    // Lesson Management (Educator & Admin)
    Route::get('/courses/{course}/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('/courses/{course}/lessons',        [LessonController::class, 'store'])->name('lessons.store');
    Route::get('/lessons/{lesson}/edit',            [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/lessons/{lesson}',                 [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/lessons/{lesson}',              [LessonController::class, 'destroy'])->name('lessons.destroy');

    // Payment & Enrollment (Student & Admin)
    Route::post('/courses/{course}/enroll', [PaymentController::class, 'enroll'])->name('courses.enroll');
    Route::patch('/payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.update-status');

    // Admin User Management (Admin only)
    Route::get('/admin/users',        [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users',       [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // Profile Management
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
