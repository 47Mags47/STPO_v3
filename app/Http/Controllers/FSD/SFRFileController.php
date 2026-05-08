<?php

namespace App\Http\Controllers\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\FSD\SFRFileStoreRequest;
use App\Jobs\FSD\ReadSFRFileJob;
use App\Jobs\FSD\WriteSFRFileJob;
use App\Models\Base\UploadFile;
use App\Models\FSD\SFRFile;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

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
        $uploadfile = UploadFile::whereKey($request->input('file_id'))->first();

        $SFRFile = $uploadfile->moveToModel(SFRFile::class, [
            'region_code'   => substr($uploadfile->file->origin_name, 0, 3),
            'sign_code'     => substr($uploadfile->file->origin_name, 3, 1),
            'in_date'       => Carbon::create(substr(now()->format('YY'), 0, 3) . substr($uploadfile->file->origin_name, 4, 1), substr($uploadfile->file->origin_name, 5, 2)),
            'npp_for_month' => substr($uploadfile->file->origin_name, 7, 1),
        ]);

        ReadSFRFileJob::dispatch($SFRFile);

        return redirect()->route('fsd.sfr-files.index')->with('succes', 'Запись успешно создана');
    }

    public function show(SFRFile $sfrFile)
    {
        WriteSFRFileJob::dispatch($sfrFile)->onQueue('SFR-FSD-WriteSFRFile');
    }
}
