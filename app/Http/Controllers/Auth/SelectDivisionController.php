<?php

namespace App\Http\Controllers\Auth;

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

    public function store(Request $request)
    {
        $request->session()->put('current_division_id', $request->input('division_id'));

        return redirect()->route('dashboard');
    }
}
