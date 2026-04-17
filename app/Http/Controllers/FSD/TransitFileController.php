<?php

namespace App\Http\Controllers\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\FSD\TransitFileStoreReqouest;
use App\Jobs\FSD\ReadTransitFileJob;
use App\Models\Base\UploadFile;
use App\Models\FSD\TransitFile;
use Inertia\Inertia;

class TransitFileController extends Controller
{
    public function index()
    {
        return Inertia::render('fsd/transit-files/index', [
            'files' => fn() => TransitFile::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('fsd/transit-files/create');
    }

    public function store(TransitFileStoreReqouest $request)
    {
        $uploadfile = UploadFile::whereKey($request->validated('upload_file_id'))->first();
        $uploadfile->move('fsd', 'transit');

        $transitFile = TransitFile::create(['file_id' => $uploadfile->file->id]);
        $uploadfile->delete();

        ReadTransitFileJob::dispatch($transitFile);

        return redirect()->route('fsd.transit-files.index')->with('succes', 'Запись успешно создана');
    }
}
