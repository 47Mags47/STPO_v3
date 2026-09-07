<?php

namespace App\Console\Commands;

use App\Models\Base\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Clear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ### STORAGE
        ##################################################
        // Очистка локального хранилища
        $this->info('Очистка локального хранилища');
        $drivers = config('filesystems.disks');
        $drivers = array_filter($drivers, fn($driver) => $driver['driver'] === 'local');
        $drivers = array_filter($drivers, fn($driver) => $driver['driver'] === 'local');
        $drivers = array_filter($drivers, fn($driver) => str_starts_with($driver['root'], storage_path('app/private')));
        unset($drivers['local']);

        foreach ($drivers as $disk => $driver) {
            foreach (Storage::disk($disk)->allFiles() as $localFullPath) {
                if (str_contains($localFullPath, '.gitignore'))
                    continue;

                $pathInfo = pathinfo($localFullPath);

                $in_DB = File::where('disk', $disk)->where('path', $pathInfo['dirname'])->where('name', $pathInfo['basename'])->count() > 0;
                if ($in_DB)
                    continue;
                else
                    Storage::disk($disk)->delete($localFullPath);
            }
        }

        ### DB
        ##################################################
        $oldes = File::withTrashed()->where('deleted_at', '>', now()->minus($month = 1));
        $oldes->forceDelete();

        // Очистка Таблицы с файлами
        $this->info('Пометка для удаления несуществующих файлов');

        foreach (File::all() as $file) {
            if (!Storage::disk($file->disk)->exists($file->getLocalPath())) {
                $file->delete();
                continue;
            }
        }
    }
}
