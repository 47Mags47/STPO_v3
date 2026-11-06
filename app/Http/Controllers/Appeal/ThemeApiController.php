<?php

namespace App\Http\Controllers\Appeal;

use App\Http\Controllers\Controller;
use App\Models\Appeal\Theme;

class ThemeApiController extends Controller
{
    public function index()
    {
        return Theme::getResource();
    }
}
