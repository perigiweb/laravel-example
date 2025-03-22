<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormResponseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/register', [AuthController::class, 'register'])
    ->name('register');

Route::post('/register', [AuthController::class, 'store'])
    ->name('register.post');

Route::get('/registered', [AuthController::class, 'registered'])
    ->name('registered');

Route::get('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::middleware('auth')->prefix('/me')->group(function(){
    Route::get('/', [UserController::class, 'me'])->name('user.me');
    Route::get('/post', [PostController::class, 'me'])->name('post.me');
});

Route::get('/post/{slug}.html', [PostController::class, 'showBySlug'])
    ->where('slug', '[a-z0-9_-]+')
    ->name('view.post');
Route::resource('post', PostController::class)->only(['index']);

Route::middleware('auth')->prefix('/dash')->group(function(){
    Route::get('/', HomeController::class)->name('dash');

    Route::delete('/user', [UserController::class, 'destroy'])->middleware(EnsureIsAdmin::class);
    Route::resource('user', UserController::class)->middleware(EnsureIsAdmin::class);

    Route::resource('form', FormController::class);
    Route::resource('response', FormResponseController::class);

    Route::resource('post', PostController::class)->except(['index', 'show']);
});