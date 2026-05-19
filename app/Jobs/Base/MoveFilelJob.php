<?php

namespace App\Jobs\Base;

use App\Models\Base\File;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class MoveFilelJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public File $file,
        public string $disk,
        public string $path,
        public ?string $name = null
    )
    {
        $this->onQueue('files');
    }

    public function handle(): void
    {
        $this->file->update(['is_disabled' => true]);

        $oldPath = Storage::disk($this->file->disk)->path($this->file->path . '/' . $this->file->name);

        $newFileName = $this->name ?? $this->file->name;
        $newPath = Storage::disk($this->disk)->path($this->path . '/' . $newFileName);

        rename($oldPath, $newPath);

        $this->file->update([
            'disk' => $this->disk,
            'path' => $this->path,
            'name' => $newFileName,
        ]);

        $this->file->update(['is_disabled' => false]);
    }
}
