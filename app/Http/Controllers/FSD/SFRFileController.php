<?php

namespace App\Http\Controllers\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\FSD\SFRFileStoreRequest;
use App\Jobs\FSD\ReadSFRFileJob;
use App\Jobs\FSD\WriteSFRFileJob;
use App\Models\Base\UploadFile;
use App\Models\FSD\SFRFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SFRFileController extends Controller
{
    public function index()
    {
        return Inertia::render('fsd/sfr-files/index', [
            'files' => fn() => SFRFile::getResource('created_at', 'desc'),
        ]);
    }

    public function create()
    {
        return Inertia::render('fsd/sfr-files/create');
    }

    public function store(SFRFileStoreRequest $request)
    {
        $uploadfile = UploadFile::whereKey($request->validated('upload_file_id'))->first();
        $uploadfile->move('fsd', 'sfr');

        $SFRFile = SFRFile::create([
            'file_id' => $uploadfile->file->id,
            'region_code' => substr($uploadfile->file->origin_name, 0, 3),
            'sign_code'      => substr($uploadfile->file->origin_name, 3, 1),
            'in_date'        => Carbon::create(substr(now()->format('YY'), 0, 3) . substr($uploadfile->file->origin_name, 4, 1), substr($uploadfile->file->origin_name, 5, 2)),
            'npp_for_month'  => substr($uploadfile->file->origin_name, 7, 1),
        ]);

        $uploadfile->delete();

        ReadSFRFileJob::dispatch($SFRFile);

        return redirect()->route('fsd.sfr-files.index')->with('succes', 'Запись успешно создана');
    }

    public function show(SFRFile $sfrFile)
    {
        WriteSFRFileJob::dispatch($sfrFile)->onQueue('test');

        // $payments = $sfrFile->payments;
        // $paymentsGroupBySnils = $payments->groupBy('SNILS');

        // $toFilePath = Storage::disk('fsd')->path('output' . '/' . Str::random(40));
        // $toFile = fopen($toFilePath, 'w');

        // $fromFile = fopen($sfrFile->getFullPath(), 'r');

        // while (!feof($fromFile)) {
        //     $recipientLine = fgets($fromFile);
        //     fwrite($toFile, $recipientLine);

        //     $recipientLine = mb_convert_encoding($recipientLine, 'UTF-8', 'CP-866');

        //     if (!preg_match("/^О[0-9]{3}-[0-9]{3}-[0-9]{3}.*$/", $recipientLine))
        //         continue;

        //     $snils = mb_substr($recipientLine, 1, 14);
        //     $periodDateStart = Carbon::make(mb_substr($recipientLine, 1184, 10));
        //     $periodDateEnd = Carbon::make(mb_substr($recipientLine, 1194, 10));

        //     if ($paymentsGroupBySnils->has($snils)) {
        //         foreach ($paymentsGroupBySnils[$snils] as $payment) {
        //             if (!$payment->paymentFile->in_month->between($periodDateStart, $periodDateEnd))
        //                 continue;

        //             $line =
        //                 'М' .
        //                 $payment->paymentFile->in_month->startOfMonth()->format('Y/m/d') .
        //                 $payment->PaymentFile->type->pay_number .
        //                 mb_str_pad($payment->PaymentFile->type->pay_code, 4) .
        //                 mb_str_pad(number_format(0.00, 2, '.', ''), '10', '0', STR_PAD_LEFT) .
        //                 mb_str_pad(number_format($payment->amount, 2, '.', ''), '10', '0', STR_PAD_LEFT) .
        //                 $payment->paymentFile->in_month->startOfMonth()->format('Y/m/d') .
        //                 $payment->paymentFile->in_month->endOfMonth()->format('Y/m/d') .
        //                 "\n";

        //             fwrite($toFile, mb_convert_encoding($line, 'CP-866', 'UTF-8'));
        //         }
        //     }

        //     foreach ($periodDateStart->toPeriod($periodDateEnd)->month()->days(0) as $month) {
        //         $age = Carbon::make(mb_substr($recipientLine, 150, 10))->diff($periodDateStart);
        //         if ($age->y < 18)
        //             continue;

        //         $line =
        //             'М' .
        //             $month->startOfMonth()->format('Y/m/d') .
        //             '3' .
        //             'ДЭР ' .
        //             mb_str_pad(number_format(0.00, 2, '.', ''), '10', '0', STR_PAD_LEFT) .
        //             mb_str_pad(number_format(88, 2, '.', ''), '10', '0', STR_PAD_LEFT) .
        //             $month->startOfMonth()->format('Y/m/d') .
        //             $month->endOfMonth()->format('Y/m/d') .
        //             "\n";

        //         fwrite($toFile, mb_convert_encoding($line, 'CP-866', 'UTF-8'));
        //     }
        // }
    }
}
