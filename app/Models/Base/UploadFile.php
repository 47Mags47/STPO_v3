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

    public string|null $StorageFileDisk = 'uploads';
    public string|null $StorageFilePath = 'files';

    public bool $deleteBase = false;
    public bool $deleteInStorage = false;

    ### Связи
    ##################################################
    public function chunks(): HasMany
    {
        return $this->hasMany(FileChunk::class, 'total_file_id')->orderBy('npp');
    }
}
