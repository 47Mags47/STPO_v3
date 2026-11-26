<?php

namespace App\Jobs\SFR\FSD;

use App\Models\Base\FilePart;
use App\Models\SFR\FSD\Payment;
use App\Models\SFR\FSD\ResultFile;
use App\Models\SFR\FSD\TransitCategory;
use App\Models\SFR\FSD\TransitRecipient;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;

class WriteResultFileChunkJob implements ShouldQueue
{
    use Queueable, Batchable;

    private $fromFileCursor;
    private $toFileCursor;
    private int $defaultEquivalent;

    public function __construct(
        private ResultFile $resultFile,
        private FilePart $filePart,
        private int $offset,
        private int $rowCount,
    ) {}

    public function handle(): void
    {
        $this->defaultEquivalent = TransitCategory::query()
            ->whereNull('wp_category_id')
            ->with('equivalent')
            ->first()
            ?->equivalent
            ?->equivalent ?? 0.00;

        $cp866LetterO = mb_convert_encoding('О', 'CP-866', 'UTF-8');
        $this->fromFileCursor = openFile($this->resultFile->SFRFile);
        $this->toFileCursor = openFile($this->filePart, 'wb');

        fseek($this->fromFileCursor, $this->offset);

        // Получаем данные из файла
        $persons = [];
        $errors = [];
        $linesRead = 0;
        while ($linesRead < $this->rowCount && ($rawLine = fgets($this->fromFileCursor)) !== false) {
            $linesRead++;

            // Проверяем формат строки
            if ($rawLine[0] !== $cp866LetterO)
                continue;

            $rawLine = mb_convert_encoding($rawLine, 'UTF-8', 'CP-866');

            // Получем данные
            $person = $this->getPerson($rawLine);
            if (count($person['errors']) > 0) {
                $errors = array_merge($errors, $person['errors']);
                continue;
            }

            $persons[$person['SNILS']] = $person;
        }

        // Получаем данные из БД
        $persons = $this->getDBData($persons);

        // Пишем строки
        $linesRead = 0;
        fseek($this->fromFileCursor, $this->offset);
        while ($linesRead < $this->rowCount && ($rawLine = fgets($this->fromFileCursor)) !== false) {
            $linesRead++;

            // Пишем строку
            fwrite($this->toFileCursor, $rawLine);

            // Проверяем формат строки
            if ($rawLine[0] !== $cp866LetterO)
                continue;

            // Получаем снилс
            $snils = mb_substr($rawLine, 1, 14);
            if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{3} [0-9]{2}$/", $snils))
                continue;

            // Пишем данные
            if (!array_key_exists($snils, $persons))
                continue;

            // Выплаты
            foreach ($persons[$snils]['payments'] as $payment) {
                if ($payment->file_in_date->between($persons[$snils]['period_start'], $persons[$snils]['period_end']))
                    $this->writePayment($payment);
            }

            // Проезд
            foreach ($persons[$snils]['period_start']->toPeriod($persons[$snils]['period_end'])->month() as $month) {
                $monthStart = $month->copy()->startOfMonth();

                $monthTransits = collect($persons[$snils]['transits'])->filter(
                    fn($transit) => $transit->date_start <= $monthStart && $transit->date_end >= $monthStart
                );

                foreach ($monthTransits as $transit) {
                    $this->writeTransit($month, $transit);
                }

                if ($monthTransits->isEmpty()) {
                    $this->writeDefault($month, $persons[$snils]['birth']);
                }
            }
        }
    }

    private function getDBData(array $persons): array
    {
        if (empty($persons))
            return array_merge($persons, [
                'payments' => [],
                'transits' => []
            ]);

        $snilsList = array_unique(array_column($persons, 'SNILS'));
        $minStart = min(array_column($persons, 'period_start'));
        $maxEnd = max(array_column($persons, 'period_end'));

        $payments = Payment::query()
            ->with(['paymentFile', 'ASPPaymentCategory.SFRCategory', 'financingType'])
            ->whereIn('SNILS', $snilsList)
            ->whereBetween('file_in_date', [$minStart, $maxEnd])
            ->orderBy('file_in_date')
            ->orderBy('financing_type_id')
            ->get()
            ->groupBy('SNILS');

        $transits = TransitRecipient::query()
            ->with('equivalent')
            ->whereIn('SNILS', $snilsList)
            ->where('date_end', '>=', $minStart->format('Y-m-d'))
            ->where('date_start', '<=', $maxEnd->format('Y-m-d'))
            ->get()
            ->groupBy('SNILS');

        foreach ($persons as $snils => $person) {
            $persons[$snils] = array_merge($persons[$snils], [
                'payments' => $payments->has($person['SNILS']) ? $payments[$person['SNILS']] : [],
                'transits' => $transits->has($person['SNILS']) ? $transits[$person['SNILS']] : [],
            ]);
        }

        return $persons;
    }

    private function getPerson(string $rawLine): array
    {
        $errors = [];

        // Читаем и проверяем необходимые данные
        $birth_string = mb_substr($rawLine, 150, 10);
        $birth = Carbon::make($birth_string);
        if ($birth === null)
            $errors[] = 'Не удалось считать дату рождения: ' . $birth_string;


        $period_start_string = mb_substr($rawLine, 1184, 10);
        $periodStart = Carbon::make($period_start_string);
        if ($periodStart === null) {
            $errors[] = 'Не удалось считать дату начала периода: ' . $period_start_string;
        } else
            $periodStart = $periodStart->startOfMonth();


        $period_end_string = mb_substr($rawLine, 1194, 10);
        $periodEnd = Carbon::make($period_end_string);
        if ($periodEnd === null) {
            $errors[] = 'Не удалось считать дату конца периода: ' . $period_end_string;
        } else
            $periodEnd = $periodEnd->endOfMonth();


        $snils = mb_substr($rawLine, 1, 14);
        if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{3} [0-9]{2}$/", $snils))
            $errors[] = 'СНИЛС не соответствует формату: ' . mb_substr($rawLine, 1, 14);


        $person = [
            'birth' => $birth,
            'period_start' => $periodStart,
            'period_end' => $periodEnd,
            'SNILS' => $snils,
            'errors' => $errors,
        ];

        return $person;
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
}
