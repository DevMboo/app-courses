<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\{CoursesController, ExportController, HomeController, ShowcaseController, LoginController, UsersController};
 
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'auth'])->name('auth');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::post('/export', [ExportController::class, 'export'])->name('export');

    // Courses routes
    Route::get('/courses{search?}', [CoursesController::class, 'index'])->name('courses');
    Route::post('/courses', [CoursesController::class, 'store'])->name('courses.store');
    Route::get('/courses/{id}/details/show', [CoursesController::class, 'show'])->name('courses.show');
    Route::get('/courses/{id}/details/edit', [CoursesController::class, 'edit'])->name('courses.edit');
    Route::post('/courses/{id}/details', [CoursesController::class, 'update'])->name('courses.update');

    // Users routes
    Route::get('/users{search?}', [UsersController::class, 'index'])->name('users');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/details/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::post('/users/{id}/details', [UsersController::class, 'update'])->name('users.update');

    // Showcase routes
    Route::get('/showcase{search?}', [ShowcaseController::class, 'index'])->name('showcase');

    Route::get('/loggout', [LoginController::class, 'loggout'])->name('loggout');

    Route::get('/download/{path}', function ($path) {
        return Storage::disk('public')->download($path);
    })->name('download.file');
    

});