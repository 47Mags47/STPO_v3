<?php

namespace App\Http\Controllers\SFR\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\SFR\FSD\SFRFileStoreRequest;
use App\Jobs\SFR\FSD\ReadSFRFileJob;
use App\Models\Base\UploadFile;
use App\Models\SFR\FSD\SFRFile;
use Inertia\Inertia;

class SFRFileController extends Controller
{
    public function index()
    {
        return Inertia::render('sfr/fsd/sfr-files/index', [
            'files' => fn() => SFRFile::getResource('created_at', 'desc'),
        ]);
    }

    public function create()
    {
        return Inertia::render('sfr/fsd/sfr-files/create');
    }

    public function store(SFRFileStoreRequest $request)
    {
        $SFRFile = UploadFile::moveToModel($request->input('file_id'), SFRFile::class, $request->validated());

        ReadSFRFileJob::dispatch($SFRFile);

        return redirect()->route('sfr.fsd.sfr-files.index')->with('success', 'Запись успешно создана');
    }
}
