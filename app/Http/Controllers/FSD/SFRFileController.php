<?php

namespace App\Http\Controllers\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\FSD\SFRFileStoreRequest;
use App\Models\Base\File;
use App\Models\FSD\SFRFile;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class SFRFileController extends Controller
{
    public function index(){
        return Inertia::render('fsd/sfr-files/index', [
            'files' => fn() => SFRFile::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('fsd/sfr-files/create');
    }

    public function store(SFRFileStoreRequest $request)
    {
        $fileName = $request->file('file')->getClientOriginalName();

        $file = File::factory()->create([
            'disk' => 'fsd',
            'path' => 'sfr',
            'origin_name' => $fileName,
        ]);

        $request->file('file')->storeAs($file->path, $file->name, $file->disk);

        SFRFile::create([
            'file_id' => $file->id,
            'region_code' => substr($fileName, 0, 3),
            'sign_code'      => substr($fileName, 3, 1),
            'in_date'        => Carbon::create('202' . substr($fileName, 4, 1), substr($fileName, 5, 2)),
            'npp_for_month'  => substr($fileName, 7, 1),
        ]);

        return redirect()->route('fsd.sfr-files.index')->with('succes', 'Запись успешно создана');
    }
}
