<?php

namespace App\Http\Controllers\SFR\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\SFR\FSD\TransitFileStoreReqouest;
use App\Jobs\SFR\FSD\ReadTransitFileJob;
use App\Models\Base\UploadFile;
use App\Models\SFR\FSD\TransitFile;
use Inertia\Inertia;

class TransitFileController extends Controller
{
    public function index()
    {
        return Inertia::render('sfr/fsd/transit-files/index', [
            'files' => fn() => TransitFile::getResource('created_at', 'desc'),
        ]);
    }

    public function create()
    {
        return Inertia::render('sfr/fsd/transit-files/create');
    }

    public function store(TransitFileStoreReqouest $request)
    {
        $transitFile = UploadFile::moveToModel($request->input('file_id'), TransitFile::class, $request->validated());

        ReadTransitFileJob::dispatch($transitFile);

        return redirect()->route('sfr.fsd.transit-files.index')->with('success', 'Запись успешно создана');
    }
}
