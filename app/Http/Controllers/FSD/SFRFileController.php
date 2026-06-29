<?php

namespace App\Http\Controllers\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\FSD\SFRFileStoreRequest;
use App\Jobs\Base\SendNotificationJob;
use App\Jobs\FSD\ReadSFRFileJob;
use App\Jobs\FSD\WriteSFRFileJob;
use App\Models\Base\File;
use App\Models\Base\UploadFile;
use App\Models\FSD\SFRFile;
use App\Models\FSD\SFRFileResult;
use Inertia\Inertia;
use Illuminate\Support\Facades\Bus;

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
        $resulFile = File::createChildren(SFRFileResult::class, [
            'sfr_file_id' => $sfrFile->id,
            'origin_name' => $sfrFile->origin_name . ' (сформирован ' . now()->format('Y_m_d_H_i_s') . ')'
        ]);

        Bus::batch([
            new WriteSFRFileJob($resulFile),
            new SendNotificationJob(
                user()->id,
                'file_generated',
                'Файл ' . $resulFile->origin_name . ' готов к загрузке',
                [
                    'file_id' => $resulFile->file->id,
                ]
            ),
        ])->dispatch();
    }
}
