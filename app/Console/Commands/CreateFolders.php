<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateFolders extends Command
{
    protected $signature = 'app:create-folders';
    protected $description = 'Создать каталоги для работы приложения';

    public function handle()
    {
        foreach (config('filesystems.disks') as $name => $props) {
            if ($props['driver'] === 'local') {
                $fullPath = $props['root'];

                if (!file_exists($fullPath)) {
                    $this->line('Создание каталога ' . $fullPath);

                    mkdir($fullPath, 0755, true);
                    exec('sudo chmod 775 ' . $fullPath . '; sudo chown $USER:www-data ' . $fullPath);
                }
            }
        }
    }
}
