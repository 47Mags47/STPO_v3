<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\BankStoreRequest;
use App\Http\Requests\Payment\BankUpdateRequest;
use App\Models\Payment\Bank;
use Inertia\Inertia;

class BankController extends Controller
{
    public function index()
    {
        return Inertia::render('payment/banks/index', [
            'banks' => fn() => Bank::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('payment/banks/create');
    }

    public function store(BankStoreRequest $request)
    {
        Bank::create($request->validated());

        return redirect()->route('payment.banks.index')->with('succes', 'Запись успешно создана');
    }

    public function edit(Bank $bank)
    {
        return Inertia::render('payment/banks/edit', [
            'bank' => fn() => $bank->toResource(),
        ]);
    }

    public function update(BankUpdateRequest $request, Bank $bank)
    {
        $bank->update($request->validated());

        return redirect()->route('payment.banks.index')->with('succes', 'Запись успешно обновлена');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();

        return redirect()->route('payment.banks.index')->with('succes', 'Запись удалена');
    }
}
