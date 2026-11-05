<?php

namespace App\Http\Controllers\Appeal;

use App\Http\Controllers\Controller;
use App\Models\Appeal\Them;

class ThemApiController extends Controller
{
    public function index()
    {
        return Them::getResource();
    }
}
