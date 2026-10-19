<?php

namespace App\Models\Base;

use App\Classes\FileModel;
use App\Jobs\Base\MoveUploadFileJob;
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
    public static string|null $storage_file_path = 'files';
    public static bool $deleteInStorage = false;

    ### Методы
    ##################################################
    public static function moveToModel(
        string $uploadFileId,
        string $modelClass,
        ?array $attributes = []
    ): FileModel {
        $uploadFile = UploadFile::find((int) $uploadFileId);

        if ($uploadFile === null)
            abort(404);

        if (!(new $modelClass() instanceof FileModel))
            abort(404);

        $model = $modelClass::create(array_merge($attributes, [
            'file_id'       => $uploadFile->file->id,
        ]));

        // HACK Переделать этот кусок
        // Когда вызываешь этот метод, выполняеться job, который должен блокировать файл
        // Но если есть еще один job, блокирующий файл, падает очередность выполнения
        // MoveUploadFileJob::dispatch($uploadFile, $model);

        $job = new MoveUploadFileJob($uploadFile, $model);
        $job->handle();

        return $model;
    }

    ### Связи
    ##################################################
    public function chunks(): HasMany
    {
        return $this->hasMany(FileChunk::class, 'upload_file_id')->orderBy('npp');
    }
}
