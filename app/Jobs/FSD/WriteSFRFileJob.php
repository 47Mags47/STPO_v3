<?php

namespace App\Jobs\FSD;

use App\Models\FSD\Payment;
use App\Models\FSD\SFRFile;
use App\Models\FSD\SFRFileResult;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;

class WriteSFRFileJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 300;

    private $paymentsGroupBySnils;

    private SFRFile $fromFile;
    private $fromFileCursor;
    private SFRFileResult $toFile;
    private $toFileCursor;


    public function __construct(public SFRFile $sfrFile) {}

    public function handle(): void
    {
        $this->fromFile = $this->sfrFile;
        $this->fromFileCursor = fopen($this->fromFile->getFullPath(), 'r');

        $this->toFile = SFRFileResult::create();
        $this->toFileCursor = fopen($this->toFile->getFullPath(), 'w');

        $paymentsGroupBySnils = $this->sfrFile->payments->groupBy('SNILS');
        $transitsGroupBySnils = $this->sfrFile->transits->groupBy('SNILS');

        while (!feof($this->fromFileCursor)) {
            $recipientLine = fgets($this->fromFileCursor);
            fwrite($this->toFileCursor, $recipientLine);

            // Проверяем, является ли строка записью типа О
            $recipientLine = mb_convert_encoding($recipientLine, 'UTF-8', 'CP-866');
            if (!preg_match("/^О[0-9]{3}-[0-9]{3}-[0-9]{3}.*$/", $recipientLine))
                continue;

            // Проверяем, что снилс есть хотя бы в одном списке
            $snils = mb_substr($recipientLine, 1, 14);
            if (!$transitsGroupBySnils->has($snils) and !$paymentsGroupBySnils->has($snils))
                $this->writeNullString($recipientLine);

            // Пишем выплаты
            if ($paymentsGroupBySnils->has($snils))
                $this->writePayments($recipientLine, $paymentsGroupBySnils);

            // Пишем эквиваленты
            if ($transitsGroupBySnils->has($snils))
                $this->writeTransits($recipientLine, $transitsGroupBySnils);
        }

        fclose($this->fromFileCursor);
        fclose($this->toFileCursor);
    }

    public function writeNullString($recipientLine)
    {
        $periodDateStart = Carbon::make(mb_substr($recipientLine, 1184, 10));
        $periodDateEnd = Carbon::make(mb_substr($recipientLine, 1194, 10));

        foreach ($periodDateStart->toPeriod($periodDateEnd)->month()->days(0) as $month) {
            $line =
                'М' .
                $month->startOfMonth()->format('Y/m/d') .
                '3' .
                'ДЭР ' .
                mb_str_pad(number_format(00.00, 2, '.', ''), '10', '0', STR_PAD_LEFT) .
                mb_str_pad(number_format(00.00, 2, '.', ''), '10', '0', STR_PAD_LEFT) .
                $month->startOfMonth()->format('Y/m/d') .
                $month->endOfMonth()->format('Y/m/d') .
                "\n";

            fwrite($this->toFileCursor, mb_convert_encoding($line, 'CP-866', 'UTF-8'));
        }
    }

    public function writeTransits(string $recipientLine, $transitsGroupBySnils)
    {
        $snils = mb_substr($recipientLine, 1, 14);
        $periodDateStart = Carbon::make(mb_substr($recipientLine, 1184, 10));
        $periodDateEnd = Carbon::make(mb_substr($recipientLine, 1194, 10));
        $birth = Carbon::make(mb_substr($recipientLine, 150, 10));

        foreach ($periodDateStart->toPeriod($periodDateEnd)->month()->days(0) as $month) {
            if ($birth->diff($month)->y >= 18) {
                foreach ($transitsGroupBySnils[$snils] as $transit) {
                    if ($transit->date_start->toPeriod($transit->date_end)->contains($month)) {
                        $this->writeTransit($month, $transit);
                    }
                }
            } else
                $this->writeNullString($recipientLine);
        }
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

    public function writePayments(string $recipientLine, $paymentsGroupBySnils)
    {
        $snils = mb_substr($recipientLine, 1, 14);
        $periodDateStart = Carbon::make(mb_substr($recipientLine, 1184, 10));
        $periodDateEnd = Carbon::make(mb_substr($recipientLine, 1194, 10));

        foreach ($paymentsGroupBySnils[$snils] as $payment) {
            if ($payment->paymentFile->in_month->between($periodDateStart, $periodDateEnd))
                $this->writePayment($payment);
        }
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
