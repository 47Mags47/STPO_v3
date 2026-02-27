<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Base\DivisionController;
use App\Http\Controllers\Base\ModulController;
use App\Http\Controllers\Base\ModulGroupController;
use App\Http\Controllers\Base\TemplateController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/test', function () {
    return Inertia::render('test');
});

Route::get('/', fn() => 'home page')->name('home');
Route::get('/dashboard', fn() => 'dashboard page')->name('dashboard');
Route::get('/login', fn() => Inertia::render('auth/login'))->name('login');

Route::resource('/templates',    TemplateController::class)->except('show');
Route::resource('/moduls',       ModulController::class)->except('show');
Route::resource('/modul-groups', ModulGroupController::class)->except('show');
Route::resource('/divisions',    DivisionController::class)->except('show');
Route::resource('/users',        UserController::class)->except('show');

Route::name('appeal.')->prefix('/appeal')->group(function () {
    Route::resource('/them-groups',      App\Http\Controllers\Appeal\ThemGroupController::class)->except('show');
    Route::resource('/thems',            App\Http\Controllers\Appeal\ThemController::class)->except('show');
    Route::resource('/appeals',          App\Http\Controllers\Appeal\AppealController::class)->only(['index', 'create', 'store']);
});
