<?php

namespace App\Jobs\FSD;

use App\Models\FSD\Payment;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class WriteSFRFileChunkJob implements ShouldQueue
{
    use Queueable, Batchable;

    public $paymentsGroupBySnils;
    public $transitsGroupBySnils;

    public function __construct(
        public array $lines,
        public $payments,
        public $transits,
        public $toFileCursor,
    ) {
        $this->paymentsGroupBySnils = $payments->groupBy('SNILS');
        $this->transitsGroupBySnils = $transits->groupBy('SNILS');
    }

    public function handle(): void
    {
        foreach ($this->lines as $recipientLine) {
            $this->writePayments($recipientLine, $this->paymentsGroupBySnils);
            $this->writeTransits($recipientLine, $this->transitsGroupBySnils);
        }
    }

    public function writeNullString($month)
    {
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

    public function writeTransits(string $recipientLine, $transitsGroupBySnils)
    {
        $snils = mb_substr($recipientLine, 1, 14);
        $periodDateStart = Carbon::make(mb_substr($recipientLine, 1184, 10));
        $periodDateEnd = Carbon::make(mb_substr($recipientLine, 1194, 10));
        $birth = Carbon::make(mb_substr($recipientLine, 150, 10));

        foreach ($periodDateStart->toPeriod($periodDateEnd)->month()->days(0) as $month) {
            if ($transitsGroupBySnils->has($snils)) {
                if ($birth->diff($month)->y >= 18) {
                    $counter = 0;
                    foreach ($transitsGroupBySnils[$snils] as $transit) {
                        if ($transit->date_start->toPeriod($transit->date_end)->contains($month)) {
                            $this->writeTransit($month, $transit);
                            $counter++;
                        }
                    }

                    if ($counter === 0)
                        $this->writeNullString($month);
                } else
                    $this->writeNullString($month);
            } else
                $this->writeNullString($month);
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

        if ($paymentsGroupBySnils->has($snils)) {
            foreach ($paymentsGroupBySnils[$snils] as $payment) {
                if ($payment->paymentFile->in_month->between($periodDateStart, $periodDateEnd))
                    $this->writePayment($payment);
            }
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
