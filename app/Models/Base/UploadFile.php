<?php

namespace App\Models\Base;

use App\Classes\FileModel;
use App\Jobs\Base\MoveFilelJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UploadFile extends FileModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'base__file_uploads';

    protected $fillable = [
        'file_id',
        'totalChunks',
    ];

    public static string|null $storage_file_disk = 'uploads';
    public static string|null $StorageFilePath = 'files';

    public bool $deleteBase = false;
    public bool $deleteInStorage = false;

    ### Методы
    ##################################################
    public static function moveToModel(
        string $uploadFileId,
        string $modelClass,
        ?array $attributes = []
    ) {
        $uploadFile = UploadFile::whereKey($uploadFileId)->first();

        if ($uploadFile === null)
            abort(503);

        if (!(new $modelClass() instanceof FileModel))
            abort(503);

        $model = $modelClass::create(array_merge($attributes ?? [], ['file_id' => $uploadFile->file->id]));

        MoveFilelJob::dispatch($uploadFile->file, $modelClass::$storage_file_disk, $modelClass::$storage_file_path);

        return $model;
    }

    ### Связи
    ##################################################
    public function chunks(): HasMany
    {
        return $this->hasMany(FileChunk::class, 'upload_file_id')->orderBy('npp');
    }
}
