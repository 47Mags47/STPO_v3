<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentFileStoreRequest;
use App\Jobs\Payment\ReadpaymentFileJob;
use App\Models\Administrate\Bank;
use App\Models\Base\UploadFile;
use App\Models\Payment\Event;
use App\Models\Payment\PaymentFile;
use Inertia\Inertia;

class PaymentFileController extends Controller
{
    public function index(Event $event)
    {
        return Inertia::render('payment/payment-files/index', [
            'files' => fn() => $event->paymentFiles->toResourceCollection(),
            'event' => fn() => $event->toResource(),
        ]);
    }

    public function create(Event $event)
    {
        return Inertia::render('payment/payment-files/create', [
            'event' => fn() => $event->toResource(),
            'banks' => fn() => Bank::all()->toResourceCollection(),
        ]);
    }

    public function store(PaymentFileStoreRequest $request, Event $event)
    {
        foreach ($request->input('file_ids') as $uploadFileId) {
            $paymentFile = UploadFile::moveToModel($uploadFileId, PaymentFile::class, array_merge($request->validated(), [
                'division_id' => 1,
                'event_id' => $event->id
            ]));

            ReadpaymentFileJob::dispatch($paymentFile);
        }

        return redirect()->route('payment.payment-files.index', ['event' => $event->id])->with('success', 'Запись успешно создана');
    }

    public function destroy(Event $event, PaymentFile $paymentFile){
        $paymentFile->delete();

        return redirect()->route('payment.payment-files.index', ['event' => $event->id])->with('success', 'Запись удалена');
    }
}
