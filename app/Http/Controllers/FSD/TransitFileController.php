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
        foreach ($request->input('file_ids') as $uploadFileId) {
            $uploadfile = UploadFile::whereKey($uploadFileId)->first();

            $transitFile = $uploadfile->moveToModel(TransitFile::class, [
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
            ]);

            ReadTransitFileJob::dispatch($transitFile);
        }

        return redirect()->route('fsd.transit-files.index')->with('succes', 'Запись успешно создана');
    }
}
