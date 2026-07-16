<?php

namespace App\Http\Controllers\Administrate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrate\BankStoreRequest;
use App\Http\Requests\Administrate\BankUpdateRequest;
use App\Models\Administrate\Bank;
use Inertia\Inertia;

class BankController extends Controller
{
    public function index()
    {
        return Inertia::render('administrate/banks/index', [
            'banks' => fn() => Bank::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('administrate/banks/create');
    }

    public function store(BankStoreRequest $request)
    {
        Bank::create($request->validated());

        return redirect()->route('administrate.banks.index')->with('success', 'Запись успешно создана');
    }

    public function edit(Bank $bank)
    {
        return Inertia::render('administrate/banks/edit', [
            'bank' => fn() => $bank->toResource(),
        ]);
    }

    public function update(BankUpdateRequest $request, Bank $bank)
    {
        $bank->update($request->validated());

        return redirect()->route('administrate.banks.index')->with('success', 'Запись успешно обновлена');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
