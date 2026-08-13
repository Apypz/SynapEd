<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ── Public routes ─────────────────────────────────────────────────────────────
Route::get('/',                [HomeController::class, 'index'])->name('home');
Route::get('/courses',         [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}',  [CourseController::class, 'show'])->name('courses.show');

// ── Authenticated routes ──────────────────────────────────────────────────────
// Note: 'verified' middleware intentionally omitted — User doesn't implement
// MustVerifyEmail and MAIL_MAILER=log, so verification never actually fires.
// Re-add once real mail delivery + MustVerifyEmail are both wired up together.
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard');

    // Course & Lesson Learning
    Route::get('/courses/{course}/learn',           [LessonController::class, 'show'])->name('learn');
    Route::get('/courses/{course}/learn/{lesson}',  [LessonController::class, 'show'])->name('learn.lesson');
    Route::post('/courses/{course}/lessons/{lesson}/complete', [LessonController::class, 'markComplete'])->name('lessons.complete');
    Route::post('/courses/{course}/lessons/{lesson}/quiz/submit', [LessonController::class, 'submitQuiz'])->name('lessons.quiz.submit');

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

    // Enrollment (all courses are free — no payment gate)
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('courses.enroll');

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
