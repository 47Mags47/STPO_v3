<?php

namespace App\Http\Controllers\Administrate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrate\TemplateStoreRequest;
use App\Http\Requests\Administrate\TemplateUpdateRequest;
use App\Models\Base\File;
use App\Models\Administrate\Template;
use App\Models\Base\TemplateStyle;
use App\Models\Base\TemplateType;
use Inertia\Inertia;

class TemplateController extends Controller
{
    public function index()
    {
        return Inertia::render('administrate/templates/index', [
            'templates' => fn() => Template::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('administrate/templates/create', [
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

        return redirect()->route('administrate.templates.index')->with('succes', 'Запись успешно создана');
    }

    public function edit(Template $template)
    {
        return Inertia::render('administrate/templates/edit', [
            'template' => fn() => $template,
            'templateTypes' => fn() => TemplateType::getResource(),
            'templateStyles' => fn() => TemplateStyle::getResource(),
        ]);
    }

    public function update(TemplateUpdateRequest $request, Template $template)
    {
        $template->update($request->validated());

        return redirect()->route('administrate.templates.index')->with('succes', 'Запись успешно обновлена');
    }

    public function destroy(Template $template)
    {
        $template->delete();

        return redirect()->route('administrate.templates.index')->with('succes', 'Запись удалена');
    }
}
