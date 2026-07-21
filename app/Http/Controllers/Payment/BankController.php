<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payment\BankResource;
use App\Models\Administrate\Bank;
use App\Models\Payment\Event;
use Inertia\Inertia;

class BankController extends Controller
{
    public function index(Event $event)
    {
        return Inertia::render('payment/banks/index', [
            'event' => fn() => $event->toResource(),
            'banks' => fn() => BankResource::collection(
                Bank::whereIn('id', $event->paymentFiles()->select('bank_id')->pluck('bank_id')->unique())->get()
            )
        ]);
    }
}
