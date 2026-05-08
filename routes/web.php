<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/test', fn() => Inertia::render('test'));

Route::get('/', fn() => redirect()->route('fsd.sfr-files.index'))->name('home');
Route::get('/dashboard', fn() => 'dashboard page')->name('dashboard');
Route::get('/login', fn() => Inertia::render('auth/login'))->name('login');
Route::post('/login', [App\Http\Controllers\Auth\UserController::class, 'login'])->name('auth.users.login');
Route::post('/users/create', [App\Http\Controllers\Auth\UserController::class, 'store'])->name('auth.users.store');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('verification.success');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::get('/email/confirmed', fn() => Inertia::render('emailConfirmed'))->middleware(['auth'])->name('verification.success');

Route::name('auth.')->group(function () {
    Route::resource('/users', App\Http\Controllers\Auth\UserController::class)->only(['create', 'store', 'edit', 'update', 'show']);
});

Route::name('upload.')->prefix('/upload')->group(function () {
    Route::post('files/startUpload',                            [App\Http\Controllers\Base\UploadController::class, 'startUpload'])->name('startUpload');
    Route::post('chunks/{chunk}',                               [App\Http\Controllers\Base\UploadController::class, 'writeChunk'])->name('writeChunk');
});

Route::name('administrate.')->prefix('/administrate')->group(function () {
    Route::resource('/users',                                   App\Http\Controllers\Administrate\UserController::class)->only(['index', 'destroy']);
    Route::resource('/templates',                               App\Http\Controllers\Administrate\TemplateController::class)->except('show');
    Route::resource('/moduls',                                  App\Http\Controllers\Administrate\ModulController::class)->except('show');
    Route::resource('/modul-groups',                            App\Http\Controllers\Administrate\ModulGroupController::class)->except('show');
    Route::resource('/divisions',                               App\Http\Controllers\Administrate\DivisionController::class)->except('show');
});

Route::name('appeal.')->prefix('/appeal')->group(function () {
    Route::resource('/them-groups',                             App\Http\Controllers\Appeal\ThemGroupController::class)->except('show');
    Route::resource('/thems',                                   App\Http\Controllers\Appeal\ThemController::class)->except('show');
    Route::resource('/appeals',                                 App\Http\Controllers\Appeal\AppealController::class)->only(['index', 'create', 'store']);
    Route::resource('/appeals/{appeal}/messages',               App\Http\Controllers\Appeal\MessageController::class)->except(['create', 'destroy']);
});

Route::name('fsd.')->prefix('/fsd')->group(function () {
    Route::resource('/sfr-files',                               App\Http\Controllers\FSD\SFRFileController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('/payment-files',                           App\Http\Controllers\FSD\PaymentFileController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('/transit-equivalents',                     App\Http\Controllers\FSD\TransitEquivalentController::class)->only(['index', 'create', 'store']);
    Route::resource('/transit-files',                           App\Http\Controllers\FSD\TransitFileController::class)->only(['index', 'create', 'store']);
});
