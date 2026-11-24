<?php

namespace App\Jobs\SFR\FSD;

use App\Models\SFR\FSD\Payment;
use App\Models\SFR\FSD\ResultFile;
use App\Models\SFR\FSD\TransitCategory;
use App\Models\SFR\FSD\TransitRecipient;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Carbon;

class WriteResultFileJob implements ShouldQueue
{
    use Queueable, Batchable;

    public $timeout = 1800;

    /** @var resource|null */
    private $fromFileCursor = null;

    /** @var resource|null */
    private $toFileCursor = null;

    private float $defaultEquivalent = 0.0;

    private static ?string $cp866LetterO = null;

    public function __construct(public ResultFile $resultFile)
    {
        $this->onQueue('SFR-FSD');

        $this->defaultEquivalent = TransitCategory::where('wp_category_id', null)->first()->equivalent->equivalent;
    }

    // public function middleware(): array
    // {
    //     return [
    //         (new WithoutOverlapping('file:' . $this->resultFile->file_id))->shared(),
    //         (new WithoutOverlapping('file:' . $this->resultFile->SFRFile->file_id))->shared()
    //     ];
    // }

    public function handle(): void
    {
        self::$cp866LetterO = mb_convert_encoding('О', 'CP-866', 'UTF-8');

        $this->openFiles();

        while (($rawLine = fgets($this->fromFileCursor)) !== false) {
            fwrite($this->toFileCursor, $rawLine);

            // Проверяем что строка типа О
            if (($rawLine[0]) !== self::$cp866LetterO)
                continue;

            $rawLine = mb_convert_encoding($rawLine, 'UTF-8', 'CP-866');

            // Проверяем формат строки
            if (!preg_match("/^О[0-9]{3}-[0-9]{3}-[0-9]{3} [0-9]{2}.*$/", $rawLine))
                continue;

            // Читаем и проверяем необходимые данные
            $birth          = $this->parseDate(mb_substr($rawLine, 150, 10));
            $periodStart    = $this->parseDate(mb_substr($rawLine, 1184, 10))->startOfMonth();
            $periodEnd      = $this->parseDate(mb_substr($rawLine, 1194, 10))->endOfMonth();
            $snils          = mb_substr($rawLine, 1, 14);

            if ($birth === null) {
                $this->resultFile->addError('Не удалось считать дату рождения: ' . mb_substr($rawLine, 150, 10));
                continue;
            }

            if ($periodStart === null) {
                $this->resultFile->addError('Не удалось считать дату начала периода: ' . mb_substr($rawLine, 1184, 10));
                continue;
            }

            if ($periodEnd === null) {
                $this->resultFile->addError('Не удалось считать дату конца периода: ' . mb_substr($rawLine, 1194, 10));
                continue;
            }

            if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{3} [0-9]{2}$/", $snils)) {
                $this->resultFile->addError('СНИЛС не соответсвует формату: ' . mb_substr($rawLine, 1, 14));
                continue;
            }

            // Получаем и пишем данные выплат
            $payments = Payment::query()
                ->with([
                    'paymentFile',
                    'ASPPaymentCategory.SFRCategory',
                    'financingType',
                ])
                ->where('SNILS', $snils)
                ->whereBetween('file_in_date', [$periodStart, $periodEnd])
                ->orderBy('file_in_date')
                ->orderBy('financing_type_id')
                ->get();

            foreach ($payments as $payment) {
                $this->writePayment($payment);
            }

            // получаем и пишем данные проезда
            foreach ($periodStart->toPeriod($periodEnd)->month()->days(0) as $month) {
                $neddle_month = $month->copy()->startOfMonth();

                $transits = TransitRecipient::query()
                    ->with('equivalent')
                    ->where('date_start', '<=', $neddle_month->format('Y-m-d'))
                    ->where('date_end', '>=', $neddle_month->format('Y-m-d'))
                    ->where('SNILS', $snils)
                    ->get();

                if (count($transits) > 0)
                    foreach ($transits as $transit) {
                        $this->writeTransit($neddle_month, $transit);
                    }
                else {
                    $this->writeDefault($neddle_month, $birth);
                }
            }

        }

        $this->closeFiles();
    }

    private function parseDate(string $value): ?Carbon
    {
        return Carbon::make($value);
    }

    public function openFiles()
    {
        // FROM
        $fromPath = $this->resultFile->SFRFile->fullPath;

        if (!is_file($fromPath)) {
            $this->resultFile->setStatus('error');
            $this->resultFile->addError('Ошибка чтения файла');
            throw new \RuntimeException('Исходный файл не найден: ' . $fromPath);
        }

        if (!is_readable($fromPath)) {
            $this->resultFile->setStatus('error');
            $this->resultFile->addError('Ошибка чтения файла');
            throw new \RuntimeException('Исходный файл недоступен для чтения: ' . $fromPath);
        }

        $from = @fopen($fromPath, 'rb');
        if ($from === false) {
            $this->resultFile->addError('Ошибка чтения файла');
            throw new \RuntimeException('Не удалось открыть исходный файл: ' . $fromPath);
        }
        $this->fromFileCursor = $from;


        // TARGET
        $targetPath = $this->resultFile->fullPath;
        $target = @fopen($targetPath, 'wb');
        if ($target === false) {
            $this->resultFile->addError('Ошибка записи файла');
            throw new \RuntimeException('Не удалось открыть файл результата для записи: ' . $targetPath);
        }

        $this->toFileCursor = $target;
    }

    public function closeFiles()
    {
        fclose($this->fromFileCursor);
        fclose($this->toFileCursor);

        $this->resultFile->setStatus('ok');
        $this->resultFile->SFRFile->setStatus('ok');
    }

    public function writeDefault(Carbon $month, Carbon $birth)
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

    private function writePayment(Payment $payment)
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
