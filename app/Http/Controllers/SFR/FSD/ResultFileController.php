<?php

namespace App\Http\Controllers\SFR\FSD;

use App\Http\Controllers\Controller;
use App\Jobs\SFR\FSD\WriteResultFile;
use App\Models\Base\File;
use App\Models\Base\FileStatus;
use App\Models\SFR\FSD\ResultFile;
use App\Models\SFR\FSD\SFRFile;
use Inertia\Inertia;

class ResultFileController extends Controller
{
    public function index(SFRFile $SFRFile){
        return Inertia::render('sfr/fsd/result-files/index', [
            'SFRFile' => fn() => $SFRFile->toResource(),
            'files' => fn() => $SFRFile->resultFiles->toResourceCollection()
        ]);
    }

    public function store(SFRFile $SFRFile){
        $resultFile = File::createChildren(ResultFile::class, [
            'sfr_file_id'   => $SFRFile->id,
            'status_id'     => FileStatus::byCode('creating')->id,
            'origin_name'   => $SFRFile->origin_name
        ]);

        WriteResultFile::dispatch($resultFile);

        return redirect()->route('sfr.fsd.result-files.index', ['SFRFile' => $SFRFile])->with('success', 'Формирование файла запущено');
    }

    public function show(SFRFile $SFRFile, ResultFile $resultFile) {
        return $resultFile->download();
    }
}
