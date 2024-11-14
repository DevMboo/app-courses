<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\{CoursesController, ExportController, HomeController, LoginController, UsersController};
 
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'auth'])->name('auth');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::post('/export', [ExportController::class, 'export'])->name('export');

    Route::get('/courses', [CoursesController::class, 'index'])->name('courses');
    Route::post('/courses', [CoursesController::class, 'store'])->name('courses.store');

    Route::get('/courses/{id}/details/show', [CoursesController::class, 'show'])->name('courses.show');

    Route::get('/courses/{id}/details/edit', [CoursesController::class, 'edit'])->name('courses.edit');
    Route::post('/courses/{id}/details', [CoursesController::class, 'update'])->name('courses.update');

    Route::get('/users', [UsersController::class, 'index']);

    Route::get('/loggout', [LoginController::class, 'loggout'])->name('loggout');
});