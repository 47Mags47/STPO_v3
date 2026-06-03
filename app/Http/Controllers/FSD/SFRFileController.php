<?php

namespace App\Http\Controllers\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\FSD\SFRFileStoreRequest;
use App\Jobs\FSD\ReadSFRFileJob;
use App\Jobs\FSD\WriteSFRFileJob;
use App\Models\Base\UploadFile;
use App\Models\FSD\SFRFile;
use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

class SFRFileController extends Controller
{
    public function index()
    {
        return Inertia::render('fsd/sfr-files/index', [
            'files' => fn() => SFRFile::getResource('created_at', 'desc'),
        ]);
    }

    public function create()
    {
        return Inertia::render('fsd/sfr-files/create');
    }

    public function store(SFRFileStoreRequest $request)
    {
        $SFRFile = UploadFile::moveToModel($request->input('file_id'), SFRFile::class, $request->validated());

        ReadSFRFileJob::dispatch($SFRFile);

        return redirect()->route('fsd.sfr-files.index')->with('success', 'Запись успешно создана');
    }

    public function show(SFRFile $sfrFile)
    {
        WriteSFRFileJob::dispatch($sfrFile, Auth::id());
    }
}
