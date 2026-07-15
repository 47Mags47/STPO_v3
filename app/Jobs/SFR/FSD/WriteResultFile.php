<?php

namespace App\Jobs\SFR\FSD;

use App\Models\SFR\FSD\Payment;
use App\Models\SFR\FSD\TransitRecipient;
use App\Models\SFR\FSD\ResultFile;
use App\Models\SFR\FSD\TransitCategory;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class WriteResultFile implements ShouldQueue
{
    use Queueable, Batchable;

    public $timeout = 600;

    private $fromFileCursor;
    private $toFileCursor;
    private float $defaultEquivalent;

    public function __construct(public ResultFile $resultFile)
    {
        $this->onQueue('SFR-FSD');

        $this->defaultEquivalent = TransitCategory::where('wp_category_id', null)->get()->first()
            ->equivalent->equivalent;
    }

    public function handle(): void
    {
        Log::info('start');

        waitDisabledFile($this->resultFile->SFRFile);
        $this->resultFile->SFRFile->setDisabled();
        $this->resultFile->SFRFile->setStatus('reading');
        Log::info('SFRFile');

        $this->resultFile->setDisabled();
        $this->resultFile->setStatus('creating');
        $this->resultFile = $this->resultFile->fresh();
        Log::info('resultFile');

        $this->fromFileCursor = fopen($this->resultFile->SFRFile->getFullPath(), 'r');
        $this->toFileCursor = fopen($this->resultFile->getFullPath(), 'w');

        $date_start = $this->resultFile->SFRFile->date_start;
        $date_end = $this->resultFile->SFRFile->date_end;

        while (!feof($this->fromFileCursor)) {
            $recipientLine = fgets($this->fromFileCursor);
            fwrite($this->toFileCursor, $recipientLine);

            // Проверяем, является ли строка записью типа О
            $recipientLine = mb_convert_encoding($recipientLine, 'UTF-8', 'CP-866');
            if (!preg_match("/^О[0-9]{3}-[0-9]{3}-[0-9]{3}.*$/", $recipientLine))
                continue;

            $string_counter = 0; // Подсчет записаных строк
            $snils = mb_substr($recipientLine, 1, 14);

            // Пишем выплаты
            // HACK Вынести запрос за цикл по каждой строке
            $payments = Payment::query()
                ->with([
                    'paymentFile' => fn($query) => $query->orderBY('in_date'),
                    'ASPPaymentCategory.SFRCategory',
                    'financingType'
                ])
                ->where('SNILS', $snils)
                ->whereHas('paymentFile', fn($query) => $query->whereBetween('in_date', [$date_start, $date_end]))
                ->orderBy('financing_type_id')
                ->get();

            foreach ($payments as $payment) {
                $this->writePayment($payment);
                $string_counter++;
            }

            // Пишем Эквиваленты
            $periodDateStart = Carbon::make(mb_substr($recipientLine, 1184, 10));
            $periodDateEnd = Carbon::make(mb_substr($recipientLine, 1194, 10));
            $birth = Carbon::make(mb_substr($recipientLine, 150, 10));
            foreach ($periodDateStart->toPeriod($periodDateEnd)->month()->days(0) as $month) {
                // HACK Вынести запрос за цикл по каждой строке

                $transits = TransitRecipient::query()
                    ->with('equivalent')
                    ->where('SNILS', $snils)
                    ->where(fn($query) => $query->where('date_start', '<=', $month)->where('date_end', '>=', $month))
                    ->get();

                if (count($transits) > 0)
                    foreach ($transits as $transit) {
                        $this->writeTransit($month, $transit);
                        $string_counter++;
                    }
                else {
                    $this->writeDefault($month, $birth);
                    $string_counter++;
                }
            }
        }

        fclose($this->fromFileCursor);
        fclose($this->toFileCursor);

        $this->resultFile->setStatus('ok');
        $this->resultFile->setDisabled(false);

        $this->resultFile->SFRFile->setStatus('ok');
        $this->resultFile->SFRFile->setDisabled(false);
    }

    public function writeDefault($month, $birth)
    {
        $isAdult = $birth->diff($month)->y >= 18;

        $line =
            'М' .
            $month->startOfMonth()->format('Y/m/d') .
            '3' .
            'ДЭР ' .
            mb_str_pad(number_format($isAdult ? $this->defaultEquivalent : 00.00, 2, '.', ''), '10', '0', STR_PAD_LEFT) .
            mb_str_pad(number_format(00.00, 2, '.', ''), '10', '0', STR_PAD_LEFT) .
            $month->startOfMonth()->format('Y/m/d') .
            $month->endOfMonth()->format('Y/m/d') .
            "\n";

        fwrite($this->toFileCursor, mb_convert_encoding($line, 'CP-866', 'UTF-8'));
    }

    public function writeTransit($month, $transit)
    {
        $line =
            'М' .
            $month->startOfMonth()->format('Y/m/d') .
            '3' .
            'ДЭР ' .
            mb_str_pad(number_format($transit->equivalent->equivalent, 2, '.', ''), '10', '0', STR_PAD_LEFT) .
            mb_str_pad(number_format(00.00, 2, '.', ''), '10', '0', STR_PAD_LEFT) .
            $month->startOfMonth()->format('Y/m/d') .
            $month->endOfMonth()->format('Y/m/d') .
            "\n";

        fwrite($this->toFileCursor, mb_convert_encoding($line, 'CP-866', 'UTF-8'));
    }

    public function writePayment(Payment $payment)
    {
        $line =
            'М' .
            $payment->paymentFile->in_date->startOfMonth()->format('Y/m/d') .
            $payment->ASPPaymentCategory->SFRCategory->pay_number .
            mb_str_pad($payment->financingType->sfr_fsd_code, 4) .
            mb_str_pad(number_format(0.00, 2, '.', ''), '10', '0', STR_PAD_LEFT) .
            mb_str_pad(number_format($payment->amount, 2, '.', ''), '10', '0', STR_PAD_LEFT) .
            $payment->paymentFile->in_date->startOfMonth()->format('Y/m/d') .
            $payment->paymentFile->in_date->endOfMonth()->format('Y/m/d') .
            "\n";

        fwrite($this->toFileCursor, mb_convert_encoding($line, 'CP-866', 'UTF-8'));
    }
}
