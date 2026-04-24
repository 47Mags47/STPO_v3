<?php

namespace App\Classes;

use App\Models\Base\File;
use App\Models\Base\FileStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class FileModel extends BaseModel
{
    ### Настройки
    ##################################################
    public static string|null $StorageFileDisk = null;
    public static string|null $StorageFilePath = null;

    public bool $createBase = true;
    public bool $createInStorage = true;

    public bool $deleteBase = true;
    public bool $deleteInStorage = true;

    public static function boot()
    {
        parent::boot(self::$StorageFileDisk);

        self::creating(function ($model) {
            // Создание базовой модели в БД
            if ($model->createBase and $model->file_id === null) {
                $originName = Str::random(40);

                if (request()->hasFile('file'))
                    $originName = request()->file('file')->getClientOriginalName();

                if (request()->has('origin_name'))
                    $originName = request()->input('origin_name');

                $storageFile = File::factory()->create([
                    'disk'          => $model::$StorageFileDisk ?? 'local',
                    'path'          => $model::$StorageFilePath ?? '',
                    'name'          => Str::random(40),
                    'origin_name'   => $originName,
                ]);

                $model->file_id = $storageFile->id;
            }

            // Создание физического файла
            if ($model->createInStorage and $model->file_id === null) {
                $storageFile = $model->createStorageFile();
                $model->file_id = $storageFile->id;
            }
        });

        self::deleted(function ($model) {
            if ($model->deleteInStorage and $model->file_id !== null)
                $model->file->deleteInStorage();

            if ($model->deleteBase and $model->file_id !== null)
                $model->file->delete();
        });
    }

    ### Методы
    ##################################################
    public static function getDisk(){
        return self::$StorageFileDisk;
    }

    public static function getPath(){
        return self::$StorageFilePath;
    }

    public function getLocalPath()
    {
        return $this->file->path !== ''
            ? $this->file->path . '/' . $this->file->name
            : $this->file->name;
    }

    public function getFullPath()
    {
        return Storage::disk($this->file->disk ?? 'local')->path($this->getLocalPath());
    }

    public function getContent()
    {
        return Storage::disk($this->file->disk ?? 'local')->get($this->getLocalPath());
    }

    public function setContent(string $content)
    {
        return Storage::disk($this->file->disk ?? 'local')->put($this->getLocalPath(), $content);
    }

    public function setStatus(string $code): self
    {
        // HACK Добавить проверку на существование статуса с таким кодом
        $this->file->update([
            'status_id' => FileStatus::byCode($code)->id
        ]);

        return $this;
    }

    public function move(?string $disk = 'local', ?string $path = '', ?string $name = null)
    {
        $newFileName = $name ?? $this->file->name;
        $newPath = Storage::disk($disk)->path($path . '/' . $newFileName);
        $result = rename($this->getFullPath(), $newPath);

        $this->file->update([
            'disk' => $disk,
            'path' => $path,
            'name' => $newFileName,
        ]);

        return $result;
    }

    public function copy(?string $disk = 'local', ?string $path = '', ?string $name = null){
        $name = $name ?? Str::random(40);

        $from = $this->getFullPath();
        $to = Storage::disk($disk)->path($path . '/' . $name);

        copy($from, $to);

        return File::create([
            'disk' => $disk,
            'path' => $path,
            'name' => $name,
            'origin_name' => $this->file->origin_name,
        ]);
    }

    ### Связи
    ##################################################
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
