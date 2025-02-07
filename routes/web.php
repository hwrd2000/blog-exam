<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::prefix('post')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('post.index');
        Route::post('/', [PostController::class, 'store'])->name('post.store');
        Route::get('/{id}', [PostController::class, 'show'])->name('post.show');
        Route::put('/{id}', [PostController::class, 'update'])->name('post.update');
        Route::delete('/{id}', [PostController::class, 'destroy'])->name('post.destroy');
    });
    
    Route::prefix('comment')->group(function () {
        Route::get('/', [CommentController::class, 'index'])->name('comment.index');
        Route::post('/', [CommentController::class, 'store'])->name('comment.store');
        Route::get('/{id}', [CommentController::class, 'show'])->name('comment.show');
        Route::put('/{id}', [CommentController::class, 'update'])->name('comment.update');
        Route::delete('/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
    });
});

require __DIR__.'/auth.php';
