<?php

namespace App\Jobs\Base;

use App\Classes\FileModel;
use App\Models\Base\UploadFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\Storage;

class MoveUploadFileJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue;

    public $timeout = 999;

    public function __construct(
        public UploadFile $uploadFile,
        public FileModel $fileModel,
    ) {
        $this->onQueue('files');
    }

    public function middleware(): array
    {
        return [
            (new WithoutOverlapping("file:" . $this->uploadFile->file_id))->shared()
        ];
    }

    public function handle(): void
    {
        $this->fileModel->setStatus('moving');
        $this->fileModel->setDisabled();
        $this->fileModel = $this->fileModel->fresh();

        $oldPath = $this->uploadFile->getFullPath();

        $newPath = Storage::disk($this->fileModel::$storage_file_disk)->path(
            $this->fileModel::$storage_file_path !== ''
                ? $this->fileModel::$storage_file_path . '/' . $this->fileModel->name
                : $this->uploadFile->name
        );

        rename($oldPath, $newPath);

        $this->fileModel->file->update([
            'disk' => $this->fileModel::$storage_file_disk,
            'path' => $this->fileModel::$storage_file_path,
        ]);

        $this->fileModel->setStatus('ok');
        $this->fileModel->setDisabled(false);

        $this->uploadFile->forceDelete();
    }
}
