<?php

namespace App\Http\Controllers\Administrate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrate\PaymentStoreRequest;
use App\Http\Requests\Administrate\PaymentUpdateRequest;
use App\Models\Administrate\Payment;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index()
    {
        return Inertia::render('administrate/payments/index', [
            'payments' => fn() => Payment::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('administrate/payments/create');
    }

    public function store(PaymentStoreRequest $request)
    {
        Payment::create($request->validated());

        return redirect()->route('administrate.payments.index')->with('success', 'Запись успешно создана');
    }

    public function edit(Payment $payment)
    {
        return Inertia::render('administrate/payments/edit', [
            'payment' => fn() => $payment->toResource(),
        ]);
    }

    public function update(PaymentUpdateRequest $request, Payment $payment)
    {
        $payment->update($request->validated());

        return redirect()->route('administrate.payments.index')->with('success', 'Запись успешно обновлена');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
