<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Base\DivisionController;
use App\Http\Controllers\Base\ModulController;
use App\Http\Controllers\Base\ModulGroupController;
use App\Http\Controllers\Base\TemplateController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/test', function () {
    return Inertia::render('pages/test');
});

Route::get('/', fn() => 'home page')->name('home');
Route::get('/dashboard', fn() => 'dashboard page')->name('dashboard');
Route::get('/login', fn() => Inertia::render('auth/login'))->name('login');

Route::resource('templates',    TemplateController::class)->except('show');
Route::resource('moduls',       ModulController::class)->except('show');
Route::resource('modul-groups', ModulGroupController::class)->except('show');
Route::resource('divisions',    DivisionController::class)->except('show');

Route::resource('users',        UserController::class)->except('show');
