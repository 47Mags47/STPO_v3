<?php

namespace App\Http\Controllers\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\FSD\PaymentFileStoreRequest;
use App\Jobs\FSD\ReadPaymentFileJob;
use App\Models\Base\UploadFile;
use App\Models\FSD\PaymentFile;
use App\Models\FSD\PaymentType;
use Inertia\Inertia;

class PaymentFileController extends Controller
{
    public function index()
    {
        return Inertia::render('fsd/payment-files/index', [
            'files' => fn() => PaymentFile::getResource('created_at', 'desc'),
        ]);
    }

    public function create()
    {
        return Inertia::render('fsd/payment-files/create', [
            'types' => PaymentType::getResource(),
        ]);
    }

    public function store(PaymentFileStoreRequest $request)
    {
        $uploadfile = UploadFile::whereKey($request->validated('upload_file_id'))->first();
        $uploadfile->move('fsd', 'payment');

        $paymentFile = PaymentFile::create([
            'in_month'      => $request->input('in_month'),
            'file_id'       => $uploadfile->file->id,
            'type_id'       => $request->input('type_id'),
        ]);

        $uploadfile->delete();

        ReadPaymentFileJob::dispatch($paymentFile);

        return redirect()->route('fsd.payment-files.index')->with('succes', 'Запись успешно создана');
    }
}
