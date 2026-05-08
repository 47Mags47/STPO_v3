<?php

namespace App\Models\Base;

use App\Classes\FileModel;
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

    public static string|null $StorageFileDisk = 'uploads';
    public static string|null $StorageFilePath = 'files';

    public bool $deleteBase = false;
    public bool $deleteInStorage = false;

    ### Связи
    ##################################################
    public function moveToModel(string $modelClass, array $attributes)
    {
        $this->move($modelClass::$StorageFileDisk, $modelClass::$StorageFilePath);

        $model = $modelClass::create(array_merge(
            $attributes,
            [
                'file_id' => $this->file->id
            ]
        ));

        $this->delete();

        return $model;
    }

    ### Связи
    ##################################################
    public function chunks(): HasMany
    {
        return $this->hasMany(FileChunk::class, 'upload_file_id')->orderBy('npp');
    }
}
