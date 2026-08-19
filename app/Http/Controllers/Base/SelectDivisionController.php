<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SelectDivisionController extends Controller
{
    public function index()
    {
        $divisions = user()->divisions->toResourceCollection();

        return Inertia::render('SelectDivision', [
            'divisions' => fn() => $divisions
        ]);
    }
}
