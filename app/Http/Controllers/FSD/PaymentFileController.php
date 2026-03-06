<?php

namespace App\Http\Controllers\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\FSD\PaymentFileStoreRequest;
use App\Models\Base\File;
use App\Models\FSD\PaymentFile;
use Inertia\Inertia;

class PaymentFileController extends Controller
{
    public function index(){
        return Inertia::render('fsd/payment-files/index', [
            'files' => fn() => PaymentFile::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('fsd/payment-files/create');
    }

    public function store(PaymentFileStoreRequest $request)
    {
        $fileName = $request->file('file')->getClientOriginalName();

        $file = File::factory()->create([
            'disk' => 'fsd',
            'path' => 'payment',
            'origin_name' => $fileName,
        ]);

        $request->file('file')->storeAs($file->path, $file->name, $file->disk);

        PaymentFile::create([
            'file_id' => $file->id,
        ]);

        return redirect()->route('fsd.payment-files.index')->with('succes', 'Запись успешно создана');
    }
}
