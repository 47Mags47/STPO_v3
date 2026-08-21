<?php

namespace App\Http\Controllers\Administrate;

use App\Http\Controllers\Controller;
use App\Models\Administrate\Template;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TemplateController extends Controller
{
    public function index()
    {
        return Inertia::render('administrate/templates/index', [
            'templates' => Template::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('administrate/templates/create');
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(Template $template)
    {
        //
    }

    public function update(Request $request, Template $template)
    {
        //
    }

    public function destroy(Template $template)
    {
        $template->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
