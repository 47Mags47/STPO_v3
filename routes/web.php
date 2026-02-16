<?php

use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/test', function(){
    return Inertia::render('pages/test');
});

Route::resource('user', UserController::class)->only(['create', 'store']);
