<?php

namespace App\Jobs\SFR\FSD;

use App\Models\Base\FileStatus;
use App\Models\SFR\FSD\Payment;
use App\Models\SFR\FSD\ResultFile;
use App\Models\SFR\FSD\TransitCategory;
use App\Models\SFR\FSD\TransitRecipient;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Carbon;

class WriteResultFile implements ShouldQueue
{
    use Queueable, Batchable;

    public $timeout = 1800;

    private const WRITE_BUFFER_SIZE = 1048576; // 1 MiB

    /** @var resource|null */
    private $fromFileCursor = null;

    /** @var resource|null */
    private $toFileCursor = null;

    private string $writeBuffer = '';

    private float $defaultEquivalent = 0.0;

    private static ?string $cp866LetterO = null;

    public function __construct(public ResultFile $resultFile)
    {
        $this->onQueue('SFR-FSD');
    }

    public function middleware(): array
    {
        return [
            (new WithoutOverlapping('file:' . $this->resultFile->file_id))->shared(),
            (new WithoutOverlapping('file:' . $this->resultFile->SFRFile->file_id))->shared(),
        ];
    }

    public function handle(): void
    {
        $sfrFile = $this->resultFile->SFRFile;

        $sfrFile->setStatus('reading');
        $this->resultFile->setStatus('creating');

        try {
            $this->defaultEquivalent = $this->resolveDefaultEquivalent();

            if (!$this->openFiles()) {
                $this->markAsFailed();
                return;
            }

            $this->processFile();

            $sfrFile->setStatus('ok');
            $this->resultFile->setStatus('ok');
        } catch (\Throwable $e) {
            report($e);
            $this->markAsFailed($e);

            throw $e;
        } finally {
            $this->closeFiles();
        }
    }

    public function failed(?\Throwable $e): void
    {
        $this->markAsFailed($e);
    }

    /**
     * Открывает исходный файл на чтение и файл результата на запись.
     *
     * Проверки:
     *  - исходный файл существует;
     *  - исходный файл доступен для чтения;
     *  - каталог результата существует или создаётся;
     *  - каталог результата доступен для записи;
     *  - оба fopen() вернули ресурс, а не false.
     */
    private function openFiles(): bool
    {
        $sourcePath = $this->resultFile->SFRFile->fullPath;
        $targetPath = $this->resultFile->fullPath;

        if (!is_file($sourcePath)) {
            $this->resultFile->addError('Исходный файл не найден: ' . $sourcePath);
            return false;
        }

        if (!is_readable($sourcePath)) {
            $this->resultFile->addError('Исходный файл недоступен для чтения: ' . $sourcePath);
            return false;
        }

        $source = @fopen($sourcePath, 'rb');
        if ($source === false) {
            $this->resultFile->addError('Не удалось открыть исходный файл: ' . $sourcePath);
            return false;
        }

        $targetDirectory = dirname($targetPath);

        if (!is_dir($targetDirectory) && !@mkdir($targetDirectory, 0775, true) && !is_dir($targetDirectory)) {
            fclose($source);
            $this->resultFile->addError('Не удалось создать каталог для файла результата: ' . $targetDirectory);
            return false;
        }

        if (!is_writable($targetDirectory)) {
            fclose($source);
            $this->resultFile->addError('Каталог для файла результата недоступен для записи: ' . $targetDirectory);
            return false;
        }

        $target = @fopen($targetPath, 'wb');
        if ($target === false) {
            fclose($source);
            $this->resultFile->addError('Не удалось открыть файл результата для записи: ' . $targetPath);
            return false;
        }

        $this->fromFileCursor = $source;
        $this->toFileCursor = $target;

        return true;
    }

    /**
     * Сбрасывает буфер и закрывает только реально открытые дескрипторы.
     * Статус "ok" здесь не ставится: он выставляется только после успешной обработки.
     */
    private function closeFiles(): void
    {
        $this->flush();

        if (is_resource($this->toFileCursor)) {
            fclose($this->toFileCursor);
        }
        $this->toFileCursor = null;

        if (is_resource($this->fromFileCursor)) {
            fclose($this->fromFileCursor);
        }
        $this->fromFileCursor = null;
    }

    private function processFile(): void
    {
        while (($rawLine = fgets($this->fromFileCursor)) !== false) {
            $this->write($rawLine);

            $recipient = $this->parseRecipient($rawLine);

            if ($recipient === null) {
                continue;
            }

            $this->processRecipient($recipient);
        }
    }

    private function parseRecipient(string $rawLine): ?array
    {
        self::$cp866LetterO ??= mb_convert_encoding('О', 'CP-866', 'UTF-8');

        if (($rawLine[0] ?? '') !== self::$cp866LetterO) {
            return null;
        }

        if (!preg_match('/^\d{3}-\d{3}-\d{3}/', substr($rawLine, 1, 11))) {
            return null;
        }

        $birth = $this->parseDate(substr($rawLine, 150, 10));
        $periodStart = $this->parseDate(substr($rawLine, 1184, 10));
        $periodEnd = $this->parseDate(substr($rawLine, 1194, 10));

        if ($birth === null || $periodStart === null || $periodEnd === null) {
            $this->resultFile->addError('Не удалось разобрать даты в строке получателя: ' . substr($rawLine, 0, 20));
            return null;
        }

        return [
            'snils' => substr($rawLine, 1, 14),
            'birth' => $birth,
            'periodStart' => $periodStart,
            'periodEnd' => $periodEnd,
        ];
    }

    private function parseDate(string $value): ?Carbon
    {
        $value = trim($value);

        if ($value === '') {
            return null;
        }

        try {
            $date = Carbon::make($value);
        } catch (\Throwable) {
            return null;
        }

        return $date instanceof Carbon ? $date : null;
    }

    private function processRecipient(array $recipient): void
    {
        $snils = $recipient['snils'];
        $birth = $recipient['birth'];
        $periodStart = $recipient['periodStart'];
        $periodEnd = $recipient['periodEnd'];

        $payments = Payment::query()
            ->with([
                'paymentFile',
                'ASPPaymentCategory.SFRCategory',
                'financingType',
            ])
            ->where('SNILS', $snils)
            ->whereHas('paymentFile', fn ($query) => $query->whereBetween('in_date', [$periodStart, $periodEnd]))
            ->orderBy('financing_type_id')
            ->get();

        foreach ($payments as $payment) {
            $this->writePayment($payment);
        }

        for ($month = $periodStart->copy()->startOfMonth(); $month->lte($periodEnd); $month->addMonthNoOverflow()) {
            $monthStart = $month->copy();

            $transits = TransitRecipient::query()
                ->with('equivalent')
                ->where('SNILS', $snils)
                ->where(fn ($query) => $query->where('date_start', '<=', $monthStart)->where('date_end', '>=', $monthStart))
                ->get();

            if ($transits->isNotEmpty()) {
                foreach ($transits as $transit) {
                    $this->writeTransit($monthStart, $transit);
                }
            } else {
                $this->writeDefault($monthStart, $birth);
            }
        }
    }

    private function resolveDefaultEquivalent(): float
    {
        $category = TransitCategory::query()
            ->whereNull('wp_category_id')
            ->with('equivalent')
            ->first();

        return (float) ($category?->equivalent?->equivalent ?? 0.0);
    }

    private function writeDefault(Carbon $month, Carbon $birth): void
    {
        $isAdult = $birth->diff($month)->y >= 18;

        $line = 'М'
            . $month->format('Y/m/d')
            . '3'
            . 'ДЭР '
            . str_pad(number_format($isAdult ? $this->defaultEquivalent : 0.0, 2, '.', ''), 10, '0', STR_PAD_LEFT)
            . str_pad(number_format(0.00, 2, '.', ''), 10, '0', STR_PAD_LEFT)
            . $month->format('Y/m/d')
            . $month->copy()->endOfMonth()->format('Y/m/d')
            . "\n";

        $this->write($this->toCp866($line));
    }

    private function writeTransit(Carbon $month, TransitRecipient $transit): void
    {
        $line = 'М'
            . $month->format('Y/m/d')
            . '3'
            . 'ДЭР '
            . str_pad(number_format((float) $transit->equivalent->equivalent, 2, '.', ''), 10, '0', STR_PAD_LEFT)
            . str_pad(number_format(0.00, 2, '.', ''), 10, '0', STR_PAD_LEFT)
            . $month->format('Y/m/d')
            . $month->copy()->endOfMonth()->format('Y/m/d')
            . "\n";

        $this->write($this->toCp866($line));
    }

    private function writePayment(Payment $payment): void
    {
        $inDate = $payment->paymentFile->in_date;

        $line = 'М'
            . $inDate->copy()->startOfMonth()->format('Y/m/d')
            . $payment->ASPPaymentCategory->SFRCategory->pay_number
            . str_pad((string) $payment->financingType->sfr_fsd_code, 4)
            . str_pad(number_format(0.00, 2, '.', ''), 10, '0', STR_PAD_LEFT)
            . str_pad(number_format((float) $payment->amount, 2, '.', ''), 10, '0', STR_PAD_LEFT)
            . $inDate->copy()->startOfMonth()->format('Y/m/d')
            . $inDate->copy()->endOfMonth()->format('Y/m/d')
            . "\n";

        $this->write($this->toCp866($line));
    }

    private function toCp866(string $line): string
    {
        return mb_convert_encoding($line, 'CP-866', 'UTF-8');
    }

    private function write(string $chunk): void
    {
        $this->writeBuffer .= $chunk;

        if (strlen($this->writeBuffer) >= self::WRITE_BUFFER_SIZE) {
            $this->flush();
        }
    }

    private function flush(): void
    {
        if ($this->writeBuffer === '') {
            return;
        }

        if (!is_resource($this->toFileCursor)) {
            $this->writeBuffer = '';
            return;
        }

        $length = strlen($this->writeBuffer);
        $offset = 0;

        while ($offset < $length) {
            $written = fwrite($this->toFileCursor, substr($this->writeBuffer, $offset));

            if ($written === false || $written === 0) {
                $this->resultFile->addError('Не удалось записать данные в файл результата');
                break;
            }

            $offset += $written;
        }

        $this->writeBuffer = '';
    }

    private function markAsFailed(?\Throwable $e = null): void
    {
        if ($e !== null) {
            $this->resultFile->addError($e->getMessage());
        }

        $errorStatus = FileStatus::firstOrCreate(
            ['code' => 'error'],
            ['name' => 'Ошибка']
        );

        $this->resultFile->setStatus($errorStatus);
        $this->resultFile->SFRFile->setStatus($errorStatus);
    }
}
