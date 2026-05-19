<?php

namespace App\Jobs\FSD;

use App\Models\FSD\Payment;
use App\Models\FSD\SFRFile;
use App\Models\FSD\SFRFileResult;
use App\Models\FSD\TransitCategory;
use App\Models\FSD\TransitRecipient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;

class WriteSFRFileJob implements ShouldQueue
{
    use Queueable;

    private SFRFile $fromFile;
    private $fromFileCursor;
    private SFRFileResult $toFile;
    private $toFileCursor;

    private float $defaultEquivalent;


    public function __construct(public SFRFile $sfrFile)
    {
        $this->onQueue('SFR-FSD-WriteSFRFile');
    }

    public function handle(): void
    {

        $this->fromFile = $this->sfrFile;
        $this->fromFileCursor = fopen($this->fromFile->getFullPath(), 'r');

        $this->toFile = SFRFileResult::create();
        $this->toFileCursor = fopen($this->toFile->getFullPath(), 'w');

        $this->defaultEquivalent = TransitCategory::where('wp_category_id', null)->get()->first()
            ->equivalent->equivalent;


        $date_start = $this->sfrFile->date_start;
        $date_end = $this->sfrFile->date_end;

        $paymentsGroupBySnils = Payment::whereHas('paymentFile', fn($query) => $query->whereBetween('in_month', [$date_start, $date_end]))
            ->get()
            ->groupBy('SNILS');

        $transitsGroupBySnils = TransitRecipient::where('date_start', '<', $date_end)->where('date_end', '>', $date_start)
            ->get()
            ->groupBy('SNILS');

        while (!feof($this->fromFileCursor)) {
            $recipientLine = fgets($this->fromFileCursor);
            fwrite($this->toFileCursor, $recipientLine);

            // Проверяем, является ли строка записью типа О
            $recipientLine = mb_convert_encoding($recipientLine, 'UTF-8', 'CP-866');
            if (!preg_match("/^О[0-9]{3}-[0-9]{3}-[0-9]{3}.*$/", $recipientLine))
                continue;

            $periodDateStart = Carbon::make(mb_substr($recipientLine, 1184, 10));
            $periodDateEnd = Carbon::make(mb_substr($recipientLine, 1194, 10));

            foreach ($periodDateStart->toPeriod($periodDateEnd)->month()->days(0) as $month) {
                $snils = mb_substr($recipientLine, 1, 14);
                $birth = Carbon::make(mb_substr($recipientLine, 150, 10));

                // Проверяем, что снилс есть хотя бы в одном списке
                if (!$transitsGroupBySnils->has($snils) and !$paymentsGroupBySnils->has($snils)) {
                    $this->writeDefault($month, $birth);
                    continue;
                }

                // Пишем выплаты
                if ($paymentsGroupBySnils->has($snils))
                    foreach ($paymentsGroupBySnils[$snils] as $payment) {
                        if ($payment->paymentFile->in_month->between($periodDateStart, $periodDateEnd))
                            $this->writePayment($payment);
                    }

                // Пишем проезд
                if ($transitsGroupBySnils->has($snils))
                    foreach ($transitsGroupBySnils[$snils] as $transit) {
                        if ($transit->date_start->toPeriod($transit->date_end)->contains($month)) {
                            $this->writeTransit($month, $transit);
                        }
                    }
            }
        }

        fclose($this->fromFileCursor);
        fclose($this->toFileCursor);
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
            $payment->paymentFile->in_month->startOfMonth()->format('Y/m/d') .
            $payment->PaymentFile->type->pay_number .
            mb_str_pad($payment->PaymentFile->type->pay_code, 4) .
            mb_str_pad(number_format(0.00, 2, '.', ''), '10', '0', STR_PAD_LEFT) .
            mb_str_pad(number_format($payment->amount, 2, '.', ''), '10', '0', STR_PAD_LEFT) .
            $payment->paymentFile->in_month->startOfMonth()->format('Y/m/d') .
            $payment->paymentFile->in_month->endOfMonth()->format('Y/m/d') .
            "\n";

        fwrite($this->toFileCursor, mb_convert_encoding($line, 'CP-866', 'UTF-8'));
    }
}
