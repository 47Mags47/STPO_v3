<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Base\User;
use Illuminate\support\Facades\Auth;


Route::get('/', fn() => redirect()->route('appeal.appeals.index'))->name('home');
Route::get('/dashboard', function () {
    $user = User::whereKey(2)->get()->first();
    Auth::login($user);
    return Inertia::render('dashboard');
})->name('dashboard');
Route::get('/login', fn() => Inertia::render('auth/login'))->name('login');

Route::get('/test', function () {
    return Inertia::render('test');
})->name('test');

Route::get('/show', fn() => Inertia::render('ProfileUserdata'));
Route::get('/edit', fn() => Inertia::render('ProfileUserdataEdit'));
Route::get('/settings', fn() => Inertia::render('ProfileSettings'));
Route::get('/admin', fn() => Inertia::render('ProfileAdmining'));


Route::name('auth.')->group(function () {
    Route::resource('/users', App\Http\Controllers\Auth\UserController::class)->only(['create', 'store', 'edit', 'update', 'show']);
});

Route::name('upload.')->prefix('/upload')->group(function () {
    Route::get('files/startUpload', [App\Http\Controllers\Base\UploadController::class, 'startUpload'])->name('startUpload');
    Route::post('files/{file}/chunks/{chunk}', [App\Http\Controllers\Base\UploadController::class, 'writeChunk'])->name('writeChunk');
});

Route::name('administrate.')->prefix('/administrate')->group(function () {
    Route::resource('/users', App\Http\Controllers\Administrate\UserController::class)->only(['index', 'destroy']);
    Route::resource('/templates', App\Http\Controllers\Administrate\TemplateController::class)->except('show');
    Route::resource('/moduls', App\Http\Controllers\Administrate\ModulController::class)->except('show');
    Route::resource('/modul-groups', App\Http\Controllers\Administrate\ModulGroupController::class)->except('show');
    Route::resource('/divisions', App\Http\Controllers\Administrate\DivisionController::class)->except('show');
});

Route::name('appeal.')->prefix('/appeal')->group(function () {
    Route::resource('/them-groups', App\Http\Controllers\Appeal\ThemGroupController::class)->except('show');
    Route::resource('/thems', App\Http\Controllers\Appeal\ThemController::class)->except('show');
    Route::resource('/appeals', App\Http\Controllers\Appeal\AppealController::class)->only(['index', 'create', 'store']);
    Route::resource('/appeals/{appeal}/messages', App\Http\Controllers\Appeal\MessageController::class)->except(['create', 'destroy']);
});

Route::name('fsd.')->prefix('/fsd')->group(function () {
    Route::resource('/sfr-files', App\Http\Controllers\FSD\SFRFileController::class)->only(['index', 'create', 'store']);
    Route::resource('/sfr-files/{sfrFile}/payment-files', App\Http\Controllers\FSD\PaymentFileController::class)->only(['index', 'create', 'store']);
});
