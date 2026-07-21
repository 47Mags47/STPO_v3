<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment\Event;
use App\Models\Payment\PaymentFile;
use Inertia\Inertia;

class RecipientController extends Controller
{
    public function index(Event $event, PaymentFile $paymentFile)
    {
        return Inertia::render('payment/recipients/index', [
            'recipients' => fn() => $paymentFile->recipients()->paginate(50)->toResourceCollection()
        ]);
    }
}
