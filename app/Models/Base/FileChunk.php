<?php

namespace App\Models\Base;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileChunk extends FileModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'base__file_chunks';

    protected $fillable = [
        'total_file_id',
        'file_id',
        'uploaded',
        'npp',
    ];

    protected function casts(): array
    {
        return [
            'uploaded' => 'bool',
        ];
    }

    public string|null $StorageFileDisk = 'uploads';
    public string|null $StorageFilePath = 'chunks';

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
