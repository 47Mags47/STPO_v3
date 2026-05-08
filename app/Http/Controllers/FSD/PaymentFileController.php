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
        foreach ($request->input('file_ids') as $uploadFileId) {
            $uploadfile = UploadFile::whereKey($uploadFileId)->first();

            if (PaymentFile::checkExist($uploadfile->file->origin_name, $request->input('type_id'), $request->input('in_month'))) {
                $file_name = $uploadfile->file->origin_name;
                return back()->withErrors([$file_name => 'Этот файл уже загружен']);
            }

            $paymentFile = $uploadfile->moveToModel(PaymentFile::class, $request->validated());

            ReadPaymentFileJob::dispatch($paymentFile)->onQueue('SFR-FSD-ReadPaymentFile');
        }

        return redirect()->route('fsd.payment-files.index')->with('succes', 'Запись успешно создана');
    }

    public function destroy(PaymentFile $paymentFile)
    {
        $paymentFile->delete();

        return back()->with('succes', 'Запись удалена');
    }
}
