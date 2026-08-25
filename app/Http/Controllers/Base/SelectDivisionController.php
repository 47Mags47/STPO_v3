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

    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'division_id' => ['required', 'integer'],
            ],
            [
                'division_id.required' => 'Необходимо выбрать организацию'
            ]
        );

        $division_id = $data['division_id'];

        $request->session()->put('current_division_id', $division_id);

        return redirect()->route('dashboard');
    }
}
