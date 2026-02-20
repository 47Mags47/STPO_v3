<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Base\TemplateStoreRequest;
use App\Http\Requests\Base\TemplateUpdateRequest;
use App\Models\File;
use App\Models\Template;
use App\Models\TemplateStyle;
use App\Models\TemplateType;
use Inertia\Inertia;

class TemplateController extends Controller
{
    public function index()
    {
        return Inertia::render('base/templates/index', [
            'templates' => fn() => Template::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('base/templates/create', [
            'templateTypes' => fn() => TemplateType::getResource(),
            'templateStyles' => fn() => TemplateStyle::getResource(),
        ]);
    }

    public function store(TemplateStoreRequest $request)
    {
        $file = File::factory()->create([
            'disk' => 'templates',
            'path' => '',
            'origin_name' => $request->file('file')->getBasename(),
        ]);

        $request->file('file')->storeAs($file->path, $file->name, $file->disk);

        Template::create(array_merge($request->validated(), ['file_id' => $file->id]));

        return redirect()->route('templates.index')->with('succes', 'Запись успешно создана');
    }

    public function edit(Template $template)
    {
        return Inertia::render('base/templates/edit', [
            'template' => fn() => $template,
            'templateTypes' => fn() => TemplateType::getResource(),
            'templateStyles' => fn() => TemplateStyle::getResource(),
        ]);
    }

    public function update(TemplateUpdateRequest $request, Template $template)
    {
        $template->update($request->validated());

        return redirect()->route('templates.index')->with('succes', 'Запись успешно обновлена');
    }

    public function destroy(Template $template)
    {
        $template->delete();

        return redirect()->route('templates.index')->with('succes', 'Запись удалена');
    }
}
