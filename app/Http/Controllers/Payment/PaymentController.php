<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentStoreRequest;
use App\Http\Requests\Payment\PaymentUpdateRequest;
use App\Models\Payment\Payment;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index()
    {
        return Inertia::render('payment/payments/index', [
            'payments' => fn() => Payment::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('payment/payments/create');
    }

    public function store(PaymentStoreRequest $request)
    {
        Payment::create($request->validated());

        return redirect()->route('payment.payments.index')->with('succes', 'Запись успешно создана');
    }

    public function edit(Payment $payment)
    {
        return Inertia::render('payment/payments/edit', [
            'payment' => fn() => $payment->toResource(),
        ]);
    }

    public function update(PaymentUpdateRequest $request, Payment $payment)
    {
        $payment->update($request->validated());

        return redirect()->route('payment.payments.index')->with('succes', 'Запись успешно обновлена');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payment.events.index')->with('succes', 'Запись удалена');
    }
}
