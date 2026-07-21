<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Jobs\Payment\WriteRaportToBankJob;
use App\Models\Administrate\Bank;
use App\Models\Base\File;
use App\Models\Payment\Event;
use App\Models\Payment\RaportToBank;
use Inertia\Inertia;

class RaportToBankController extends Controller
{
    public function index(Event $event, Bank $bank){
        return Inertia::render('payment/raports/index', [
            'files' => fn() => $event->raportsToBank($bank)->get()->toResourceCollection(),
            'event' => fn() => $event->toResource(),
            'bank' => fn() => $bank->toResource(),
        ]);
    }

    public function store(Event $event, Bank $bank){
        $raport = File::createChildren(RaportToBank::class, [
            'bank_id' => $bank->id,
            'event_id' => $event->id,
            'origin_name' => 'Отчет по банку ' . $bank->name,
        ]);

        WriteRaportToBankJob::dispatch($raport);

        return redirect()->route('payment.raports.index', ['event' => $event->id, 'bank' => $bank->id])->with('success', 'Запущено формирование файла');
    }

    public function show(Event $event, Bank $bank, RaportToBank $raport) {
        return $raport->download();
    }
}
