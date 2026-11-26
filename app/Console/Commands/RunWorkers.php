<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

#[Signature('app:run-workers {--workers= : Переопределить число процессов для всех очередей}')]
#[Description('Запускает стандартный набор очередей')]
class RunWorkers extends Command
{
    private array $queues = [
        'default'  => ['processes' => 4],
        'SFR-FSD'  => ['processes' => 16],
        'files'    => ['processes' => 4],
    ];

    /** @var Process[] */
    private array $processes = [];

    public function handle(): void
    {
        $this->trap([SIGINT, SIGTERM], fn () => $this->stop());

        foreach ($this->queues as $queue => $config) {
            $count = $this->option('workers') ?? $config['processes'];

            for ($i = 1; $i <= $count; $i++) {
                $this->processes[] = new Process(
                    array_filter([
                        PHP_BINARY,
                        base_path('artisan'),
                        'queue:listen',
                        "--queue={$queue}",
                        '--tries=1',
                        '--timeout=300',
                        '--sleep=1',
                    ]),
                    base_path(),
                );

                $this->processes[array_key_last($this->processes)]->start();
            }

            $this->info("[{$queue}] запущено воркеров: {$count}");
        }

        $this->info('Всего воркеров: ' . count($this->processes) . '. Ctrl+C — остановить.');

        while (true) {
            foreach ($this->processes as $index => $process) {
                if ($process->isRunning()) {
                    continue;
                }

                // воркер умер — покажем, что он успел вывести, и перезапустим
                $this->error("Воркер #{$index} завершился с кодом {$process->getExitCode()}");
                $this->line($process->getIncrementalErrorOutput());
                $this->line($process->getIncrementalOutput());

                $process->start();
            }

            usleep(500_000);
        }
    }

    private function stop(): void
    {
        $this->info('Останавливаю воркеры...');

        foreach ($this->processes as $process) {
            if ($process->isRunning()) {
                $process->stop(10); // grace period 10 сек — дать джобам завершиться
            }
        }

        exit(0);
    }
}
