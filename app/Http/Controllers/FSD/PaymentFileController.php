<?php

namespace App\Http\Controllers\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\FSD\PaymentFileStoreRequest;
use App\Jobs\FSD\ReadPaymentFileJob;
use App\Models\Base\UploadFile;
use App\Models\FSD\PaymentFile;
use App\Models\FSD\SFRFile;
use Inertia\Inertia;

class PaymentFileController extends Controller
{
    public function index(SFRFile $sfrFile)
    {
        return Inertia::render('fsd/payment-files/index', [
            'files' => fn() => $sfrFile->paymentFiles->toResourceCollection(),
        ]);
    }

    public function create(SFRFile $sfrFile)
    {
        return Inertia::render('fsd/payment-files/create', [
            'sfrFile' => fn() => $sfrFile->toResource(),
        ]);
    }

    public function store(PaymentFileStoreRequest $request, SFRFile $sfrFile)
    {
        $uploadfile = UploadFile::whereKey($request->validated('upload_file_id'))->first();
        $uploadfile->move('fsd', 'payment');

        $paymentFile = PaymentFile::create([
            'file_id'       => $uploadfile->file->id,
            'sfr_file_id'   => $sfrFile->id,

            'date_start'    => $request->input('date_start'),
            'date_end'      => $request->input('date_end'),
        ]);

        $uploadfile->delete();

        ReadPaymentFileJob::dispatch($paymentFile);

        return redirect()->route('fsd.payment-files.index', ['sfrFile' => $sfrFile->id])->with('succes', 'Запись успешно создана');
    }
}
