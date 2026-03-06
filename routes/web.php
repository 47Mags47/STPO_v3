<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/test', function () {
    return Inertia::render('test');
});

Route::get('/', fn() => 'home page')->name('home');
Route::get('/dashboard', fn() => 'dashboard page')->name('dashboard');
Route::get('/login', fn() => Inertia::render('auth/login'))->name('login');

Route::name('auth.')->group(function () {
    Route::resource('/users',                       App\Http\Controllers\Auth\UserController::class)->only(['create', 'store', 'edit', 'update']);
});

Route::name('administrate.')->group(function () {
    Route::resource('/users',                       App\Http\Controllers\Administrate\UserController::class)->only(['index', 'destroy']);
    Route::resource('/templates',                   App\Http\Controllers\Administrate\TemplateController::class)->except('show');
    Route::resource('/moduls',                      App\Http\Controllers\Administrate\ModulController::class)->except('show');
    Route::resource('/modul-groups',                App\Http\Controllers\Administrate\ModulGroupController::class)->except('show');
    Route::resource('/divisions',                   App\Http\Controllers\Administrate\DivisionController::class)->except('show');
});

Route::name('appeal.')->prefix('/appeal')->group(function () {
    Route::resource('/them-groups',                 App\Http\Controllers\Appeal\ThemGroupController::class)->except('show');
    Route::resource('/thems',                       App\Http\Controllers\Appeal\ThemController::class)->except('show');
    Route::resource('/appeals',                     App\Http\Controllers\Appeal\AppealController::class)->only(['index', 'create', 'store']);
});

Route::name('fsd.')->prefix('/fsd')->group(function () {
    Route::resource('/sfr-files',                   App\Http\Controllers\FSD\SFRFileController::class)->only(['index', 'create', 'store']);
    Route::resource('/sfr-files/{file}/recipients', App\Http\Controllers\FSD\RecipientController::class)->only(['index']);
    Route::resource('/payment-files',               App\Http\Controllers\FSD\PaymentFileController::class)->only(['index', 'create', 'store']);
});
