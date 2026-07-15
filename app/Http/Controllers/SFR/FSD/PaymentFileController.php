<?php

namespace App\Http\Controllers\SFR\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\SFR\FSD\PaymentFileStoreRequest;
use App\Jobs\SFR\FSD\ReadPaymentFileJob;
use App\Models\Base\UploadFile;
use App\Models\SFR\FSD\PaymentFile;
use Inertia\Inertia;

class PaymentFileController extends Controller
{
    public function index()
    {
        return Inertia::render('sfr/fsd/payment-files/index', [
            'files' => fn() => PaymentFile::getResource('created_at', 'desc'),
        ]);
    }

    public function create()
    {
        return Inertia::render('sfr/fsd/payment-files/create');
    }

    public function store(PaymentFileStoreRequest $request)
    {
        foreach ($request->input('file_ids') as $uploadFileId) {
            $paymentFile = UploadFile::moveToModel($uploadFileId, PaymentFile::class, array_merge($request->validated(), [
                // HACK поправить на реальное id
                'division_id' => 1
            ]));

            ReadPaymentFileJob::dispatch($paymentFile);
        }

        return redirect()->route('sfr.fsd.payment-files.index')->with('success', 'Запись успешно создана');
    }

    public function destroy(PaymentFile $paymentFile)
    {
        $paymentFile->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
