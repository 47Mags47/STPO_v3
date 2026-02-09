<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/test', function(){
    return Inertia::render('pages/test');
});
