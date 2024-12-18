<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{CoursesController, ExportController, DashboardController, HomeController, ShowcaseController, LoginController, PaymentController, UsersController};
 
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'auth'])->name('auth');

Route::middleware('auth')->group(function () {
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard{search?}', [DashboardController::class, 'index'])->name('dashboard');
    
        Route::post('/export', [ExportController::class, 'export'])->name('export');
    
        // Courses routes
        Route::get('/courses{search?}', [CoursesController::class, 'index'])->name('courses');
        Route::post('/courses', [CoursesController::class, 'store'])->name('courses.store');
        Route::get('/courses/{id}/details/edit', [CoursesController::class, 'edit'])->name('courses.edit');
        Route::post('/courses/{id}/details', [CoursesController::class, 'update'])->name('courses.update');
        Route::get('/courses/{id}/details/show', [CoursesController::class, 'show'])->name('courses.show');
        Route::post('/courses/{id}/destroy', [CoursesController::class, 'destroy'])->name('courses.destroy');

        // Users routes
        Route::get('/users{search?}', [UsersController::class, 'index'])->name('users');
        Route::post('/users', [UsersController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/details/edit', [UsersController::class, 'edit'])->name('users.edit');
        Route::post('/users/{id}/details', [UsersController::class, 'update'])->name('users.update');
        Route::post('/users/{id}/destroy', [UsersController::class, 'destroy'])->name('users.destroy');
        
        Route::get('/download/{path}', function ($path) {
            return Storage::disk('public')->download($path);
        })->name('download.file');
    });

    // Payment routes
    Route::get('/payment{search?}', [PaymentController::class, 'index'])->name('payment');
    Route::get('/payment/{id}/details/edit', [PaymentController::class, 'edit'])->name('payment.edit');
    Route::post('/payment/{id}/details', [PaymentController::class, 'update'])->name('payment.update');
    Route::post('/payment/{id}/destroy', [PaymentController::class, 'destroy'])->name('payment.destroy');
    
    // Showcase routes
    Route::get('/showcase{search?}', [ShowcaseController::class, 'index'])->name('showcase');
    Route::post('/showcase/{id}', [ShowcaseController::class, 'store'])->name('showcase.store');
    Route::get('/showcase/{id}/details/show', [ShowcaseController::class, 'show'])->name('showcase.show');
    
    Route::get('/loggout', [LoginController::class, 'loggout'])->name('loggout');
    

});