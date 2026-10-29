<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->name('api.')->group(function () {
    Route::name('administrate.')->prefix('administrate')->group(function () {
        Route::resource('divisions', App\Http\Controllers\Administrate\DivisionApiController::class)->only('index');
    });
});
