<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Base\DivisionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn() => 'home page')->name('home');
Route::get('/dashboard', fn() => 'dashboard page')->name('dashboard');
Route::get('/login', fn() => Inertia::render('auth/login'))->name('login');

Route::resource('divisions', DivisionController::class)->except('show');
Route::resource('users',     UserController::class)->except('show');
