<?php

use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn() => 'home page')->name('home');
Route::get('/dashboard', fn() => 'dashboard page')->name('dashboard');
Route::get('/login', fn() => Inertia::render('auth/login'))->name('login');

Route::resource('users',     UserController::class)->except('show');
