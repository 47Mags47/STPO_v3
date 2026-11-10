<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Base\User;

class UserApiController extends Controller
{
    public function index()
    {
        return User::getResource();
    }
}
