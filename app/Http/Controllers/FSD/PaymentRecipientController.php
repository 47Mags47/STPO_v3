<?php

namespace App\Http\Controllers\FSD;

use App\Http\Controllers\Controller;
use App\Models\FSD\Payment;
use Inertia\Inertia;

class PaymentRecipientController extends Controller
{
    public function index()
    {
        return Inertia::render('fsd/payment-recipients/index', [
            'recipients' => fn() => Payment::getResource(),
        ]);
    }
}
