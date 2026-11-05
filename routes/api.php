<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->name('api.')->group(function () {
    Route::name('administrate.')->prefix('administrate')->group(function () {
        Route::resource('divisions', App\Http\Controllers\Administrate\DivisionApiController::class)->only('index');
        Route::resource('banks',     App\Http\Controllers\Administrate\BankApiController::class)->only('index');
        Route::resource('payments',  App\Http\Controllers\Administrate\PaymentApiController::class)->only('index');
    });

    Route::name('appeal.')->prefix('appeal')->group(function () {
        Route::resource('senders', App\Http\Controllers\Appeal\SendersApiController::class)->only('index');
        Route::resource('thems',   App\Http\Controllers\Appeal\ThemApiController::class)->only('index');
    });
});

