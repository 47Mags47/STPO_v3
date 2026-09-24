<?php

namespace App\Http\Controllers\Veteran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RaportController extends Controller
{
    public function index() {
        return Inertia::render('veteran/raports/index');
    }
}
